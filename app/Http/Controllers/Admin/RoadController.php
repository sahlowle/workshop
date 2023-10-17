<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Road;
use App\Models\User;
use Illuminate\Http\Request;

class RoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Road::query();

        if ($request->filled('reference_no')) {
            $query->where('reference_no',$request->reference_no);
        }

        $data['data'] = $query->with('driver')->latest('id')->paginate(10);

        $data['title'] = trans('Routes');

        return view('admin.roads.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = trans('Add New Route');

        $data['orders'] = Order::latest('id')->whereNull('road_id')->get();

        $data['drivers'] = User::drivers()->select('name','id')->pluck('name','id');

        $data['drivers']->prepend(trans('Select..'),'');

        return view('admin.roads.create',$data);
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
            'description' => 'required|string|min:3|max:250',
            'driver_id' => 'nullable|exists:users,id',
            'orders' => 'required|array',
        ]);

        $road = Road::create($validated);

        Order::whereIn('id',$request->orders)->update(['road_id' => $road->id]);

        $status = (int)$road->status;
        if ($status == 2) {
            changeOrderStatus($road->id,2);
        }

        $message = trans('Successful Added');

        notify()->success($message);

        return redirect()->route('roads.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['road'] = Road::with(['driver','orders'])->findOrFail($id);

        $data['title'] = trans('Routes Details');

        // return $data;

        return view('admin.roads.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['road'] = Road::findOrFail($id);

        $myOrders = $data['road']->orders()->pluck('id');

        $data['myOrders'] = $myOrders;

        $data['orders'] = Order::latest('id')->whereNull('road_id')->orWhere('road_id',$id)->get();

        $data['title'] = trans('Edit Route');

        $data['drivers'] = User::drivers()->select('name','id')->pluck('name','id');

        $data['drivers']->prepend(trans('Select..'),'');

        return view('admin.roads.edit',$data);
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
        $road = Road::findOrFail($id);

        $validated = $request->validate([
            'description' => 'nullable|string|min:3|max:250',
            'driver_id' => 'nullable|exists:users,id',
            'orders' => 'required|array',
        ]);

        $road->orders()->update(['road_id'=>null]);

        $road->update($validated);

        if ($request->filled('orders')) {
            Order::whereIn('id',$request->orders)->update(['road_id' => $road->id]);
        }
        
        $status = (int)$road->status;
        if ($status == 2) {
            changeOrderStatus($road->id,2);
        }


        $message = trans('Successful Updated');

        notify()->success($message);


        return redirect()->route('roads.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $road = Road::findOrFail($id);

        $road->orders()->update(['road_id'=>null]);
        
        $road->delete();

        $message = trans('Successful Delete');

        notify()->success($message);

        return redirect()->route('roads.index');
    }
}
