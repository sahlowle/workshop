<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendInvoice;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Road;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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

            $columns = ['reference_no','address','maintenance_device','brand','amount','order_phone_number'];

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

        $data['data'] = $query->with('customer')->latest('visit_time')->paginate(10)->withQueryString();

        $data['title'] = trans('All Orders');

        return view('admin.orders.index',$data);
    }

    public function today(Request $request)
    {
        $query = Order::query();

        $query->whereDate('created_at', Carbon::today());


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

        $data['data'] = $query->with('customer')->latest('id')->paginate(10)->withQueryString();

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

        $data['customers'] = Customer::select('name','phone','id')->get()->pluck('unique_name','id');

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'status' => 'required|numeric|max:4',

            'visit_date' => 'required',
            'visit_time' => 'required',
            'problem_summary' => 'required|string|min:2|max:250',
            'address' => 'required|string|min:3',
            'customer_id' => 'required|exists:customers,id',

            'block_no' => 'nullable|string|max:20',
            'order_phone_number' => 'required|string|min:12|max:20',
            'floor_number' => 'nullable|string|max:20',
            'apartment_number' => 'nullable|string|max:20',
            'maintenance_device' => 'required|string|max:120',
            'brand' => 'required|string|max:50',
            'additional_info' => 'nullable|string|max:400',
            'amount' => 'nullable|numeric',
            // 'road_id' => 'required|exists:roads,id',
            'lat' => 'required|string|max:100',
            'lng' => 'required|string|max:100',

            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:100',
            'zone_area' => 'nullable|string|max:100',
        ]);

        $visit_time = $request->date('visit_date')->format('Y-m-d'). ' ' . $request->input('visit_time');

        $validated['visit_time'] = $visit_time;

        Order::create($validated);

        $address_data = $request->only(['address','phone','zone_area','city','postal_code']);

        Customer::find($request->customer_id)->update(array_filter($address_data));

        $message = trans('Successful Added');

        notify()->success($message); 
        
        return redirect()->route('orders.index');
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
        $data['order'] = Order::with(['road.driver','customer','files'])->findOrFail($id);

        $data['title'] = trans('Order Details');

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
            'problem_summary' => 'nullable|string|min:5|max:250',
            'address' => 'nullable|string|min:3',
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

        $order->delete();

        $message = trans('Successful Delete');

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

        $item = $order->items()->create($data);

        
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

        $item->delete();

        $message = trans('Successful Deleted');

        notify()->success($message);

        return redirect()->back();
    }

    public function sendInvoice($id)
    {
        $order = Order::findOrFail($id);

        $order->load('customer');

        Mail::to($order->customer->email)->send(new SendInvoice($order));

        $message = trans('Successful Sent');

        notify()->success($message);

        return redirect()->route('orders.index');
    }

    public function printPdf($id)
    {
        $order = Order::findOrFail($id);

        $order->driver = $order->road?->driver;

        $pdf = Pdf::loadView('items.index',['order'=> $order]);
        
        return $pdf->stream('invoice.pdf');
    }
}
