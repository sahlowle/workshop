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
use App\Models\Order;
use App\Services\TimeSlot;
use App\Traits\FileSaveTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

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
        }

        if ($request->filled(['date_from','date_to'])) {

            $date_from = $request->date('date_from');
            $date_to = $request->date('date_to');

            $query
            ->whereDate('created_at', '>=', $date_from)
            ->whereDate('created_at', '<=', $date_to);
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
        $data = $request->validated();

        $data['status'] = 1; // pending

        $order = Order::create($data);

        $address_data = $request->only(['address','phone','zone_area','city','postal_code']);

        Customer::find($request->customer_id)->update(array_filter($address_data));

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

        $items = $order->items;

        $subtotal = $items->sum('price');
        $vat = $subtotal * 0.19;
        $total = $subtotal + $vat;

        $data['subtotal'] = $subtotal;
        $data['vat'] = $vat;
        $data['total'] = $total;


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

        $first_visit = Order::where('pickup_order_ref',$order->reference_id)->get();

        if ($first_visit->isNotEmpty()) {
            return $this->sendResponse(false,[],trans('This reference number is already exists as Dop-Off order'),404);
        }

        
        if ($order->status != 3) {
            return $this->sendResponse(false,[],trans('Sorry, Pickup orders must be finished first'),401);
        }

        if ($request->with_route) {
            $new_road = $order->road->replicate()->fill([
                'status' => 2,
            ]);

            $new_road->save();

            $new_order = $order->replicate()->fill([
                'visit_time' => $visit_time,
                'pickup_order_ref' => $order->reference_id,
                'road_id' => $new_road->id,
                'status' => 1,
                'type' => 3,
                'is_paid' => false,
            ]);

            $new_order->save();
        } else {
            $new_order = $order->replicate()->fill([
                'visit_time' => $visit_time,
                'pickup_order_ref' => $order->reference_id,
                'road_id' => null,
                'status' => 1,
                'type' => 3,
                'is_paid' => false,
            ]);

            $new_order->save();
        }

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
        $data =  Order::with(['files','customer','items','devices','questions'])->find($id);
        
        if (is_null($data)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $message = trans('Successful Retrieved');

        return $this->sendResponse(true,$data,$message,200);
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

        if ($request->filled('status') && $request->integer('status') == 3 && $type != 1) {
            
            if (! $order->is_paid &&  $request->payment_way != 3) {
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
        }
    
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

        Mail::to($order->customer->email)->send(new SendInvoice($order));

        $message = trans('Successful Sent');

        return $this->sendResponse(true,$order,$message,200);

    }

    public function printPdf($id)
    {
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $order->driver = $order->road->driver;

        $pdf = Pdf::loadView('items.index',['order'=> $order]);
        
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

        if ($request->hasFile('files')) {
            
            $files = $request->file('files');

            foreach ($files as $file) {
                $path = $this->uploadFile('order_files',$file);
                
                $order->files()->create([
                    'file_name' => basename($path),
                    'path_name' => $path,
                ]);

            }
        } 

        return $this->sendResponse(true,$order->files,trans("Files Added Successfully"),200);
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
        
        $exclude_dates = Order::whereDate('visit_time','>=', $selected_date->toDateString())->pluck('visit_time')->toArray();

        $data = [];

        $start_hour = 8;

        

        if ($selected_date->isToday()) {
            $current_hour = now()->hour;
            if ($current_hour <= 18) {
                $start_hour = $current_hour;
            } else {
                return $this->sendResponse(true,$data,"Available time retrieved  Successfully",200);
            }
        } elseif ($selected_date->isPast()) {
            return $this->sendResponse(true,$data,"Available time retrieved  Successfully",200);
        }

        $end_hour = 18 - $start_hour;

        $start_date = $selected_date->startOfDay()->addHours($start_hour)->format('Y-m-d H:i');
        $end_date = $selected_date->addHours($end_hour)->format('Y-m-d H:i');
        
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
