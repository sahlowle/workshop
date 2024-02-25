<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendInvoice;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Guarantee;
use App\Models\Item;
use App\Models\Road;
use App\Models\User;
use App\Models\Order;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function unpaid(Request $request)
    {
        $data['data'] = Order::unpaid()->has('activeCustomer')->latest()->paginate(10)->withQueryString();

        $data['title'] = trans('Payment alert (orders)');

        return view('admin.orders.unpaid',$data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('search_text')) {
            $search_text = $request->search_text;

            $columns = ['reference_no','address','maintenance_device','brand','order_phone_number'];

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

            $parse = true;
            try {
                $date = @Carbon::parse($request->date_from);
                $date = @Carbon::parse($request->date_to);
            } catch (InvalidFormatException $ex) {
                $parse = false;
            }

            if ($parse) {
                $date_from = $request->date('date_from');
                $date_to = $request->date('date_to');
                $query
                ->whereDate('visit_time', '>=', $date_from)
                ->whereDate('visit_time', '<=', $date_to);
            }
        }

        if ($request->filled('type')) {
            $query->whereType($request->type);
        }

        if ($request->filled('status') && $request->integer('status') != -1) {
            $query->whereStatus($request->status);
        }

        $data['data'] = $query->with('customer','driver')->latest('visit_time')->paginate(10)->withQueryString();

        $data['title'] = trans('All Orders');

        return view('admin.orders.index',$data);
    }

    public function today(Request $request)
    {
        $query = Order::query();

        $query->whereDate('created_at', Carbon::today());


        if ($request->filled('search_text')) {
            $search_text = $request->search_text;

            $columns = ['reference_no','address','maintenance_device','brand','order_phone_number'];

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

            $parse = true;
            try {
                $date = @Carbon::parse($request->date_from);
                $date = @Carbon::parse($request->date_to);
            } catch (InvalidFormatException $ex) {
                $parse = false;
            }

            if ($parse) {
                $date_from = $request->date('date_from');
                $date_to = $request->date('date_to');
                $query
               ->whereDate('visit_time', '>=', $date_from)
               ->whereDate('visit_time', '<=', $date_to);
            }
        }

        if ($request->filled('type')) {
            $query->whereType($request->type);
        }

        if ($request->filled('status') && $request->integer('status') != -1) {
            $query->whereStatus($request->status);
        }

        $data['data'] = $query->with('customer')->latest('visit_time')->paginate(10)->withQueryString();

        $data['title'] = trans('Today Orders');

        return view('admin.orders.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = trans('Add New Order');

        $data['customers'] = Customer::select('name','company_name','phone','id')->get()->pluck('unique_name','id');

        $data['customers']->prepend(trans('Select..'),'');

        $data['roads'] = Road::pluck('reference_no','id');

        $data['roads']->prepend(trans('Select..'),'');

        return view('admin.orders.create',$data);
    }

    public function createDropOffOrder()
    {
        $data['title'] = trans('Add Drop Off Order');

        $data['orders'] = Order::select('reference_no','id')->pickup()
        ->where('status', 3)->pluck('reference_no','reference_no');

        $data['orders']->prepend(trans('Select..'),'');

        return view('admin.orders.create-drop-off',$data);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'status' => 'required|numeric|max:4',

            'visit_date' => 'required',
            'visit_time' => 'required',
            'problem_summary' => 'required|string|max:250',
            'address' => 'required|string',
            'customer_id' => 'required|exists:customers,id',

            'order_phone_number' => 'nullable|string|min:12|max:20',
            'floor_number' => 'nullable|string|max:20',
            'apartment_number' => 'nullable|string|max:20',
            'maintenance_device' => 'required|string|max:120',
            'brand' => 'required|string|max:50',
            'additional_info' => 'nullable|string|max:400',
            // 'road_id' => 'required|exists:roads,id',
            'lat' => 'required|string|max:100',
            'lng' => 'required|string|max:100',

            'city' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:100',
            'zone_area' => 'nullable|string|max:100',
        ]);

        $visit_time = $request->date('visit_date')->format('Y-m-d'). ' ' . $request->input('visit_time');

        $validated['visit_time'] = $visit_time;

        Order::create($validated);

        $address_data = $request->only(['address','order_phone_number','zone_area','city','postal_code','lat','lng']);

        if ($request->filled(['address','lat','lng','postal_code'])) {
            Customer::find($request->customer_id)->update(array_filter($address_data));
        }

        $message = trans('Successful Added');

        notify()->success($message); 
        
        return redirect()->route('orders.index');
    }

    public function addDropOffOrder(Request $request,$id)
    {
        $validated = $request->validate([
            'with_route' => 'required|boolean',
            'visit_date' => 'required',
            'visit_time' => 'required',
            'guarantee_id' => 'required',
            'phone' => 'nullable|size:12',
            'telephone' => 'nullable|min:7',
        ]);

        $visit_time = $request->date('visit_date')->startOfDay()->addHours($request->integer('visit_time'))->format('Y-m-d H:i');

        $order =  Order::pickup()->findOrFail($id);

        
        if ($order->items->isEmpty()) {
            return redirect()->back()->withErrors('This order does not have prices');
        }

        $first_visit = Order::where('pickup_order_ref',$order->reference_no)->get();

        if ($first_visit->isNotEmpty()) {
           return redirect()->back()->withErrors('This reference number is already exists as Dop-Off order');
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
                'visit_time' => $visit_time,
                'driver_id' => $driver_id,
                'pickup_order_ref' => $order->reference_no,
                'status' => is_null($driver_id) ? 1 : 2,
                'driver_id' => $driver_id,
                'road_id' => $new_road->id,
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
                'information' => $request->information,
                'guarantee_id' => $request->guarantee_id,
            ]);

            $new_order->save();

            if (count($pickupAddress) > 0) {
                $new_order->pickupAddress()->create($pickupAddress);
            }
        }

        $order->update(['status'=> 4]);

        $message = trans('Successful Added');
        
        notify()->success($message); 
        
        return redirect()->route('orders.today');
    }

    public function storeDropOffOrder(Request $request)
    {
        $validated = $request->validate([
            'reference_no' => 'required|exists:orders,reference_no',
            'with_route' => 'required|boolean',
            'visit_date' => 'required',
            'visit_time' => 'required',
        ]);

        $visit_time = $request->date('visit_date')->startOfDay()->addHours($request->integer('visit_time'))->format('Y-m-d H:i');

        $reference_no = $request->reference_no;

        $order =  Order::pickup()->where('reference_no',$reference_no)->firstOrFail();

        $first_visit = Order::where('pickup_order_ref',$order->reference_no)->get();

        if ($first_visit->isNotEmpty()) {
           return redirect()->back()->withErrors('This reference number is already exists as Dop-Off order');
        }

        if ($request->with_route) {
            $new_road = $order->road->replicate()->fill([
                'status' => 2,
            ]);

            $new_road->save();

            $new_order = $order->replicate()->fill([
                'visit_time' => $visit_time,
                'pickup_order_ref' => $order->reference_no,
                'road_id' => $new_road->id,
                'status' => 1,
                'type' => 3,
                'is_paid' => false,
            ]);

            $new_order->save();
        } else {
            $new_order = $order->replicate()->fill([
                'visit_time' => $visit_time,
                'pickup_order_ref' => $order->reference_no,
                'road_id' => null,
                'status' => 1,
                'type' => 3,
                'is_paid' => false,
            ]);

            $new_order->save();
        }


        $message = trans('Successful Added');
        
        notify()->success($message); 
        
        return redirect()->route('orders.today');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['order'] =  Order::with(['files','dropOrder','pickupAddress','customer','items','devices','questions','payments','guarantee'])->findOrFail($id);
        // return $data['order']->dropOrder->id;
        $data['title'] = trans('Order Details');
        $data['guarantees'] = Guarantee::select('id','name')->get();
        $data['questions'] = Question::get();
        $data['devices'] = Device::get();

        return view('admin.orders.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['order'] = Order::findOrFail($id);

        $data['title'] = trans('Edit Order');

        $data['customers'] = Customer::select('name','phone','id')->get()->pluck('unique_name','id');

        $data['customers']->prepend(trans('Select..'),'');

        $data['roads'] = Road::pluck('reference_no','id');

        $data['roads']->prepend(trans('Select..'),'');

        $data['guarantees'] = Guarantee::get()->pluck('name','id');
        $data['guarantees']->prepend(trans('Select..'),'');

        return view('admin.orders.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'visit_date' => 'required',
            'visit_time' => 'required',
            'status' => 'nullable|numeric|max:4',
            'problem_summary' => 'nullable|string|max:250',
            'address' => 'nullable|string',
            'customer_id' => 'nullable|exists:customers,id',

            'block_no' => 'nullable|string|max:20',
            'order_phone_number' => 'nullable|string|min:12|max:20',
            'floor_number' => 'nullable|string|max:20',
            'apartment_number' => 'nullable|string|max:20',
            'maintenance_device' => 'nullable|string|max:120',
            'brand' => 'nullable|string|max:50',
            'additional_info' => 'nullable|string|max:400',
            'amount' => 'nullable|numeric',
            // 'road_id' => 'required|exists:roads,id',
            'lat' => 'nullable|string|max:100',
            'lng' => 'nullable|string|max:100',
            'guarantee_id' => 'nullable',

            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:100',
            'zone_area' => 'nullable|string|max:100',
        ]);

        $visit_time = $request->date('visit_date')->format('Y-m-d'). ' ' . $request->input('visit_time');

        $validated['visit_time'] = $visit_time;

        $order->update($validated);

        $message = trans('Successful Updated');

        notify()->success($message);

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // $order->delete();

        if ($order->status == 0) {
            $message = trans('Successful updated');

            notify()->success($message);
    
            return redirect()->back();
        }

        $order->update([
            'status'=> 0
        ]);

        if ($order->type == 3) {
            $pickupOrder = Order::where('reference_no',$order->pickup_order_ref)->first();
            $pickupOrder->update([ 'status'=> 3 ]);
            //
            $order->update([ 'pickup_order_ref'=> null ]);
        }

        // $message = trans('Successful Delete');
        $message = trans('Successful updated');

        notify()->success($message);

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | Add Payment
    |--------------------------------------------------------------------------
    */
    public function addPayment(Request $request,$id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'payment_way' => 'required|numeric',
        ]);

        $order =  Order::findOrFail($id);

        $validated['paid_amount'] = $order->paid_amount + $request->amount;
        $validated['is_paid'] = true;
        
        $data = $validated;

        $order->update($data);

        $order->payments()->create([
            'paid_amount' => $request->amount,
            'payment_way' => $request->payment_way,
        ]);

        if ($order->type == 3) {
            $pickupOrder = Order::where('reference_no',$order->pickup_order_ref)->first();

            $pickupOrder->update([
                'is_paid' => true,
                'paid_amount' => $pickupOrder->total,
            ]);
        }

        
        $message = trans('Successful Added');

        notify()->success($message);

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | Add Item
    |--------------------------------------------------------------------------
    */
    public function addItem(Request $request,$id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:120',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $order =  Order::findOrFail($id);

        $data = $validated;

        $order->items()->create($data);

        $items = $order->items()->get();

        $subtotal = $items->sum('sub_total');
        $vat = $subtotal * 0.19;
        $total = $subtotal + $vat;

        $data['subtotal'] = $subtotal;
        $data['vat'] = $vat;
        $data['total'] = $total;

        $order->update($data);
        
        $message = trans('Successful Added');

        notify()->success($message);

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Report
    |--------------------------------------------------------------------------
    */
    public function deleteItem(Request $request,$id)
    {
        $item =  Item::findOrFail($id);

        $order= Order::find($item->order_id);

        $item->delete();

        $items = $order->items()->get();

        $subtotal = $items->sum('price');
        $vat = $subtotal * 0.19;
        $total = $subtotal + $vat;

        $data['subtotal'] = $subtotal;
        $data['vat'] = $vat;
        $data['total'] = $total;

        $order->update($data);

        $message = trans('Successful Deleted');

        notify()->success($message);

        return redirect()->back();
    }

    public function sendInvoice($id)
    {
        $order = Order::findOrFail($id);

        $order->load('customer');

        $blade = "reports.pickup";
        if ($order->type == 3) {
            $blade = "reports.drop-off";
         }

        Mail::to($order->customer->email)->send(new SendInvoice($order,$blade));

        $message = trans('Successful Sent');

        notify()->success($message);

        return redirect()->route('orders.index');
    }

    // public function printPdf($id)
    // {
    //     $order = Order::findOrFail($id);

    //     $order->driver = $order->road?->driver;

    //     $pdf = Pdf::loadView('report.index',['order'=> $order]);
        
    //     return $pdf->stream('invoice.pdf');
    // }


    public function printPdf($id)
    {
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return redirect()->back()->withErrors('Not Found');
        }

        if (is_null($order->road)) {
            return redirect()->back()->withErrors("This order doesn't have a route");
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

        if ($order->type == 3 ) {
            return view('reports.drop-off',$data);
        } 

        // abort(404);

    

        // Browsershot::url("https://nulljungle.com")->setNodeBinary('C:\Program Files\nodejs\node.exe')->save('example.pdf');

        return "ddd";

        $pdf = Pdf::loadView('reports.invoice',['order'=> $order]);
        
    }
}
