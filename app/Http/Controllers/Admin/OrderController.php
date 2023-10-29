<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Road;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
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

            $columns = ['reference_no','maintenance_device','brand','amount'];

            foreach($columns as $key => $column){
                if ($key == 0) {
                    $query->where($column, 'LIKE', '%' . $search_text . '%');
                } else{
                    $query->orWhere($column, 'LIKE', '%' . $search_text . '%');
                }
            }
        }
        if ($request->filled(['date_from','date_to'])) {

            $date_from = $request->date('date_from');
            $date_to = $request->date('date_to');

            $query
            ->whereDate('created_at', '>=', $date_from)
            ->whereDate('created_at', '<=', $date_to);
        }

        $data['data'] = $query->with('customer')->latest('id')->paginate(10)->withQueryString();

        $data['title'] = trans('Orders');

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

        $data['customers'] = Customer::select('name','id')->pluck('name','id');

        $data['customers']->prepend(trans('Select..'),'');

        $data['roads'] = Road::pluck('reference_no','id');

        $data['roads']->prepend(trans('Select..'),'');

        return view('admin.orders.create',$data);
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
            'status' => 'required|numeric|max:4',
            'description' => 'required|string|min:5|max:250',
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
        ]);

        // return $request->all();

        Order::create($validated);

        $message = trans('Successful Added');

       notify()->success($message); 

        return redirect()->route('orders.index');
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

        $data['customers'] = Customer::select('name','id')->pluck('name','id');

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
            'status' => 'nullable|numeric|max:4',
            'description' => 'nullable|string|min:5|max:250',
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
        ]);

        // return $validated;

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
        $user = Road::findOrFail($id);

        $user->delete();

        $message = trans('Successful Delete');

        notify()->success($message);

        return redirect()->route('orders.index');
    }
}
