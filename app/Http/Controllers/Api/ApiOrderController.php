<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddFilesRequest;
use App\Http\Requests\Api\AddPaymentFileRequest;
use App\Http\Requests\Api\AddReportRequest;
use App\Http\Requests\Api\DeleteFilesRequest;
use App\Http\Requests\Api\DeleteReportRequest;
use App\Http\Requests\Api\StoreDropOffOrderRequest;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Requests\Api\StorePickupOrderRequest;
use App\Http\Requests\Api\UpdateOrderRequest;
use App\Mail\SendInvoice;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Guarantee;
use App\Models\Item;
use App\Models\Order;
use App\Models\Question;
use App\Models\User;
use App\Services\TimeSlot;
use App\Traits\FileSaveTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;

class ApiOrderController extends Controller
{
    use FileSaveTrait;
    
    /*
    |--------------------------------------------------------------------------
    | get list
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('without_route')) {
            $query->whereDoesntHave('road');
            $query->has('activeCustomer');
            $query->where('status',1);
        }

        if ($request->filled('today')) {
            $query->whereDate('created_at', Carbon::today());
        }

        if ($request->filled('search_text')) {
            $search_text = $request->search_text;

            $columns = ['reference_no','maintenance_device','brand','amount','order_phone_number'];

            foreach($columns as $key => $column){
                if ($key == 0) {
                    $query->where($column, 'LIKE', '%' . $search_text . '%');
                } else{
                    $query->orWhere($column, 'LIKE', '%' . $search_text . '%');
                }
            }

            $query->orWhereRelation('customer','name','LIKE', '%' . $search_text . '%');
            $query->orWhereRelation('driver','name','LIKE', '%' . $search_text . '%');
            $query->orWhereRelation('driver','phone','LIKE', '%' . $search_text . '%');
        }

        if ($request->filled(['date_from','date_to'])) {

            $date_from = $request->date('date_from');
            $date_to = $request->date('date_to');

            $query
           ->whereDate('visit_time', '>=', $date_from)
           ->whereDate('visit_time', '<=', $date_to);
        }

        $per_page = $request->filled('per_page') ? $request->per_page : 10;
        
        $data = $query->with('customer')->latest('id')->paginate($per_page);
        
        $message = trans('Successful Retrieved');
        
        return $this->sendResponse(true,$data,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | add new
    |--------------------------------------------------------------------------
    */
    public function store(StoreOrderRequest $request)
    {

        $customer = Customer::find($request->customer_id);

        if (is_null($customer)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $data = $request->validated();

        $data['status'] = 1; // pending

        $order = Order::create($data);

        $address_data = $request->only(['address','part_of_building','zone_area','city','postal_code','lat','lng']);

        if ($request->filled(['address','lat','lng','postal_code'])) {
            $customer->update(array_filter($address_data));
        }

        $message = trans('Successful Added');

        return $this->sendResponse(true,$order->fresh(),$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | add store pickup order
    |--------------------------------------------------------------------------
    */
    public function storePickupOrder(StorePickupOrderRequest $request,$id)
    {
        $order =  Order::find($id);

        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $data = $request->validated();


        if ($request->filled('items')){

            // $order->items()->delete();

            foreach ($request->items as $key => $item) {
                $order->items()->create([
                    'title' => $item['title'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

            }
        }

        $items = $order->items;

        $subtotal = $items->sum('sub_total');
        $vat = $subtotal * 0.19;
        $total = $subtotal + $vat;

        $data['subtotal'] = $subtotal;
        $data['vat'] = $vat;
        $data['total'] = $total;
        $data['is_pickup'] = true;


        $order->update($data);

        if ($request->filled('devices')) {
            $order->devices()->sync($request->devices);
        }

        if ($request->filled('questions')) {
            $order->questions()->sync($request->questions);
        }

        if ($request->filled('paid_amount')){
                $order->payments()->create([
                    'paid_amount' => $request->paid_amount,
                    'payment_way' => $request->payment_way,
                    'payment_id' => $request->payment_id,
                ]);

                $order->increment('paid_amount',$request->paid_amount);
        }

        $message = trans('Successful Added');

        return $this->sendResponse(true,$order->fresh(),$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | add new drop off
    |--------------------------------------------------------------------------
    */
    public function storeDropOffOrder(StoreDropOffOrderRequest $request)
    {
        $reference_no = $request->reference_no;

        $visit_time = $request->visit_time;

        $order =  Order::pickup()->where('reference_no',$reference_no)->first();

        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Order Not Pickup'),404);
        }

        $first_visit = Order::where('pickup_order_ref',$order->reference_no)->get();

        if ($first_visit->isNotEmpty()) {
            return $this->sendResponse(false,[],trans('This reference number is already exists as Dop-Off order'),404);
        }

        if ($order->items->isEmpty()) {
            return $this->sendResponse(false,[],trans('This order does not have prices'),404);
        }
        
        if ($order->status != 3) {
            return $this->sendResponse(false,[],trans('Sorry, Pickup orders must be finished first'),401);
        }

        $pickupAddress = $request->only(['company_name','name','address','postal_code','phone','telephone','part_of_building']);

        if ($request->with_route) { // with new route

            $driver_id = getAvailableDrivers() ? getAvailableDrivers()->first(): null;

            $new_road = $order->road->replicate()->fill([
                'status' => is_null($driver_id) ? 1 : 2,
                'driver_id' => $driver_id
            ]);

            $new_road->save();

            $new_order = $order->replicate()->fill([
                'driver_id' => $driver_id,
                'visit_time' => $visit_time,
                'pickup_order_ref' => $order->reference_no,
                'road_id' => $new_road->id,
                'status' => is_null($driver_id) ? 1 : 2,
                'type' => 3,
                'is_paid' => false,
                'information' => $request->information,
                'guarantee_id' => $request->guarantee_id,
            ]);

            $new_order->save();

            if (count($pickupAddress) > 0) {
                $new_order->pickupAddress()->create($pickupAddress);
            }

        } else {
            $new_order = $order->replicate()->fill([
                'visit_time' => $visit_time,
                'pickup_order_ref' => $order->reference_no,
                'road_id' => null,
                'driver_id' => null,
                'status' => 1,
                'type' => 3,
                'is_paid' => false,
                'guarantee_id' => $request->guarantee_id,
                'information' => $request->information,
            ]);

            $new_order->save();

            if (count($pickupAddress) > 0) {
                $new_order->pickupAddress()->create($pickupAddress);
            }
        }

        $order->update(['status'=> 4]);

        $message = trans('Successful Added');

        return $this->sendResponse(true,[],$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | show item
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $order =  Order::find($id);

        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        if ($order->type == 3) {
            
            $pickupOrder = Order::with(['files','customer','items','devices','questions','payments','pickupAddress'])
            ->where('reference_no',$order->pickup_order_ref)
            ->first();

            $data = collect($order);

            $data['files'] = $pickupOrder?->files;
            $data['customer'] = $pickupOrder?->customer;
            $data['items'] = $pickupOrder?->items;
            $data['devices'] = $pickupOrder?->devices;
            $data['questions'] = $pickupOrder?->questions;
            $data['payments'] = $pickupOrder?->payments;
            $data['guarantee'] = $order->guarantee;
            $data['pickupAddress'] = $order->pickupAddress;

            $message = trans('Successful Retrieved');
            return $this->sendResponse(true,$data,$message,200);
        }
        
        $order->load(['files','customer','items','devices','questions','payments','pickupAddress']);

        $message = trans('Successful Retrieved');

        return $this->sendResponse(true,$order,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | update item
    |--------------------------------------------------------------------------
    */
    public function update(UpdateOrderRequest $request, $id)
    {
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        } 

        $type = (int) $order->type;

        $status = $request->integer('status');

        if ($order->type != 3 && ($status== 4)) {
            if ($order->items->isEmpty()) {
                return $this->sendResponse(false,[],trans('No prices added'),401);
            }
        }

        if ($request->filled('status') && $request->integer('status') == 4 && $type != 1 ) {
            
            if (! $order->is_paid &&  $order->payment_way != 3) {
                return $this->sendResponse(false,[],trans('Pay Order First'),401);
            }

        }


        $data = $request->validated();

        $order->update($data);


        if ($request->filled('items')){

            $order->items()->delete();

            foreach ($request->items as $key => $item) {
                $order->items()->create([
                    'title' => $item['title'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

            }

            $items = Item::where('order_id',$order->id)->get();

            $subtotal = $items->sum('sub_total');
            $vat = $subtotal * 0.19;
            $total = $subtotal + $vat;
    
            $data['subtotal'] = $subtotal;
            $data['vat'] = $vat;
            $data['total'] = $total;
    
    
            $order->update($data);
        }

        $order = $order->fresh();


        if ($request->filled('payment_way') && $order->type == 3) {

            if ($request->integer('payment_way') != 3) {
           
               $total = $order->total - $order->paid_amount;

                $order->payments()->create([
                'paid_amount' => $total,
                'payment_way' => $request->payment_way,
                'payment_id' => $request->payment_id,
                ]);

                $order->update([
                'is_paid' => true,
                'paid_amount' => $order->total,
                ]);

               $pickupOrder = Order::where('reference_no',$order->pickup_order_ref)->first();

               $pickupOrder->update([
                'is_paid' => true,
                'paid_amount' => $pickupOrder->total,
               ]);

            } else{
                $order->update([
                    'is_paid' => false
                ]);
            }
            
        }
        elseif($request->filled('payment_way')) {

            if ($request->integer('payment_way') != 3) {

            if ($request->filled('paid_amount')) {
                $paid_amount = $request->float('paid_amount');
            } else {
                $paid_amount = $order->total - $order->paid_amount;
            }

            $is_paid = ($order->paid_amount + $paid_amount) == $order->total? true: false;    

            $order->payments()->create([
                'paid_amount' => $paid_amount,
                'payment_way' => $request->payment_way,
                'payment_id' => $request->payment_id,
            ]);

            $order->update([
                'is_paid' => $is_paid,
                'paid_amount' => $order->paid_amount + $paid_amount,
            ]);
        } else{
            $order->update([
                'is_paid' => false
            ]);
        }
        }
    
        $message = trans('Successful Updated');

        return $this->sendResponse(true,$order,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | cancel order
    |--------------------------------------------------------------------------
    */
    public function cancelOrder($id)
    {
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }
        

        $order->update([ 'status'=> 0 ]);
    
        $message = trans('Successful Updated');

        return $this->sendResponse(true,$order,$message,200);

    }

    /*
    |--------------------------------------------------------------------------
    | delete item
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $order =  Order::find($id);

        return $this->sendResponse(false,[],trans('Not Found'),404);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }
        
        // $order->files()->delete();

        $order->delete();
    
        $message = trans('Successful Delete');

        return $this->sendResponse(true,$order,$message,200);

    }


    /*
    |--------------------------------------------------------------------------
    | send Invoice
    |--------------------------------------------------------------------------
    */
    public function sendInvoice($id)
    {
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }
        
        $order->load(['road.driver','driver','customer','items']);

        $order->driver = $order->road->driver;

        $blade = "reports.pickup";
        if ($order->type == 3) {
           $blade = "reports.drop-off";
        }

        Mail::to($order->customer->email)->send(new SendInvoice($order,$blade));

        $message = trans('Successful Sent');

        return $this->sendResponse(true,$order,$message,200);

    }

    public function printPdf($id)
    { 
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        if (is_null($order->road)) {
            return $this->sendResponse(false,[],trans("This order doesn't have a route "),404);
        }

        $order->load(['customer','driver','files','customer','items','devices','questions','payments']);

        $order->driver = $order->road->driver;

         $data['order'] = $order;

        $data['devices'] = Device::all();
        $data['questions'] = Question::all();
        $data['guarantees'] = Guarantee::all();

        // return $order;

        if ( $order->type == 1 || $order->type == 2) {
            return view('reports.pickup',$data);
        } 

        if ($order->type == 2 ) {
            return view('reports.drop-off',$data);
        } 

        abort(404);

    

        // Browsershot::url("https://nulljungle.com")->setNodeBinary('C:\Program Files\nodejs\node.exe')->save('example.pdf');

        return "ddd";

        $pdf = Pdf::loadView('reports.invoice',['order'=> $order]);
        
        return $pdf->stream('invoice.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | Add Payment File
    |--------------------------------------------------------------------------
    */
    public function addPaymentFile(AddPaymentFileRequest $request,$id)
    {
        $order =  Order::find($id);
        
        if (is_null($order) ) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        if ($request->hasFile('payment_file')) {
            
            $file = $request->file('payment_file');
            $path = $this->uploadFile('payment_files',$file);
            
            $order->update([
                'payment_file' => $path,
            ]);

        } 

        return $this->sendResponse(true,$order->files,trans("Files Added Successfully"),200);
    }

    /*
    |--------------------------------------------------------------------------
    | Add Item
    |--------------------------------------------------------------------------
    */
    public function addItem(AddReportRequest $request,$id)
    {
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $data = $request->validated();

        $report = $order->items()->create($data);

        $items = Item::where('order_id',$order->id)->get();

        $subtotal = $items->sum('sub_total');
        $vat = $subtotal * 0.19;
        $total = $subtotal + $vat;

        $data['subtotal'] = $subtotal;
        $data['vat'] = $vat;
        $data['total'] = $total;


        $order->update($data);

        return $this->sendResponse(true,$report,trans("Report Added Successfully"),200);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Report
    |--------------------------------------------------------------------------
    */
    public function deleteItem(DeleteReportRequest $request,$id)
    {
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $report = $order->items()->find($request->item_id);

        $report->delete();

        $items = Item::where('order_id',$order->id)->get();

        $subtotal = $items->sum('price');
        $vat = $subtotal * 0.19;
        $total = $subtotal + $vat;

        $data['subtotal'] = $subtotal;
        $data['vat'] = $vat;
        $data['total'] = $total;


        $order->update($data);

        return $this->sendResponse(true,$report,trans("Report Deleted Successfully"),200);
    }

    /*
    |--------------------------------------------------------------------------
    | Add Files
    |--------------------------------------------------------------------------
    */
    public function addFiles(AddFilesRequest $request,$id)
    {
        $order =  Order::find($id);
        
        if (is_null($order) || ! $request->hasFile('files') ) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $orderFile = [];

        if ($request->hasFile('files')) {
            
            $files = $request->file('files');

            foreach ($files as $file) {
                $path = $this->uploadFile('order_files',$file);
                
                $orderFile = $order->files()->create([
                    'file_name' => basename($path),
                    'path_name' => $path,
                ]);

            }
        } 

        return $this->sendResponse(true,$orderFile,trans("Files Added Successfully"),200);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Files
    |--------------------------------------------------------------------------
    */
    public function deleteOrderFile(DeleteFilesRequest $request,$id)
    {
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $file = $order->files()->find($request->file_id);

        $this->deleteFile($file->path_name);

        $file->delete();

        return $this->sendResponse(true,$file,"Files Deleted Successfully",200);
    }

    /*
    |--------------------------------------------------------------------------
    | getAvailableTime 
    |--------------------------------------------------------------------------
    */
    public function getAvailableTime(Request $request)
    {
        $selected_date = $request->date('selected_date');
        
        // $exclude_dates = Order::whereDate('visit_time','>=', $selected_date->toDateString())
        // ->pluck('visit_time');

        // $exclude_dates = $exclude_dates->toArray();

        $data = [];

        $orders = Order::select(['visit_time',DB::raw('count(*) as total')])
        ->whereDate('visit_time','>=', $selected_date->toDateString())
        ->groupBy('visit_time')
        ->get();

        
        if ($orders->isNotEmpty()) {
            $driver_count = User::drivers()->count();

            $orders = $orders->filter(function ($item) use($driver_count) {
                return $item->total >= $driver_count;
            });

        }


        $exclude_dates = [];

        if ($orders) {
            $exclude_dates = $orders->pluck('visit_time')->toArray();
        }

        

        $start_hour = 8;

        $minute = 0;
        
        if ($selected_date->isToday()) {
            $current_hour = now()->hour;

            if ($current_hour <= 18 && $current_hour >= 8) {
                $start_hour = $current_hour;
                $minute = now()->minute;

                if ($minute <= 15) {
                    $minute = 15;
                }
                elseif ($minute <= 30) {
                    $minute = 30;
                }
                elseif ($minute <= 45){
                    $minute = 45;
                }
                elseif ($minute <= 59) {
                    $minute = 0;
                    $start_hour += 1;
                }
            }
            elseif($current_hour < 8){
                $start_hour = 8;
            }
            else {
                return $this->sendResponse(true,$data,"Available time retrieved  Successfully",200);
            }
        } elseif ($selected_date->isPast()) {
            return $this->sendResponse(true,$data,"Available time retrieved  Successfully",200);
        }

        $start_date = $selected_date->startOfDay()
        ->addHours($start_hour)
        ->addMinutes($minute)
        ->format('Y-m-d H:i');

        $end_hour = 18 - $start_hour;
        
        $end_date = $selected_date
        ->addHours($end_hour)
        ->startOfHour()
        ->format('Y-m-d H:i');
        
        $data = TimeSlot::create(
            $start_date,
            $end_date, 
            15, 
            'H:i',
            $exclude_dates
        );

        return $this->sendResponse(true,$data,"Available time retrieved  Successfully",200);
    }

    public function getAvailableTimeOld(Request $request)
    {
        $exclude_dates = Order::whereDate('visit_time','>=', Carbon::today()->toDateString())->pluck('visit_time')->toArray();
        
        $currentDate =Carbon::yesterday();

        $data = [];
        $x = 0;

        while($x == 0) {

            $currentDate = $currentDate->addDay();
            $start_date = $currentDate->startOfDay()->format('Y-m-d H:i');
            $end_date = $currentDate->endOfDay()->format('Y-m-d H:i');

            $data = TimeSlot::create(
                $start_date,
                $end_date, 
                60, 
                'Y-m-d H:i',
                $exclude_dates
            );

            if ($data->isNotEmpty()) {
                $x =1;
            }        
          }

        return $this->sendResponse(true,$data,"Available time retrieved  Successfully",200);
    }
}
