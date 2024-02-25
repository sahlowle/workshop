<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Road;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
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

        if ($request->filled('search_text')) {
            $search_text = $request->search_text;
            $columns = ['reference_no'];

            foreach($columns as $key => $column){
                if ($key == 0) {
                    $query->where($column, 'LIKE', '%' . $search_text . '%');
                } else{
                    $query->orWhere($column, 'LIKE', '%' . $search_text . '%');
                }
            }

            $query->orWhereRelation('driver','name','LIKE', '%' . $search_text . '%');
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
                ->whereDate('created_at', '>=', $date_from)
                ->whereDate('created_at', '<=', $date_to);
            }
        }
        
        if ($request->filled('status')) {
            $query->whereStatus($request->status);
        }

        $data['data'] = $query->with('driver')->latest('id')->paginate(10)->withQueryString();

        $data['title'] = trans('All Routes');

        return view('admin.roads.index',$data);
    }

    public function today(Request $request)
    {
        $query = Road::query();

        $query->whereDate('created_at', Carbon::today());

        if ($request->filled('search_text')) {
            $search_text = $request->search_text;
            $columns = ['reference_no'];

            foreach($columns as $key => $column){
                if ($key == 0) {
                    $query->where($column, 'LIKE', '%' . $search_text . '%');
                } else{
                    $query->orWhere($column, 'LIKE', '%' . $search_text . '%');
                }
            }

            $query->orWhereRelation('driver','name','LIKE', '%' . $search_text . '%');
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
                ->whereDate('created_at', '>=', $date_from)
                ->whereDate('created_at', '<=', $date_to);
            }
        }

        
        if ($request->filled('status')) {
            $query->whereStatus($request->status);
        }


        $data['data'] = $query->with('driver')->latest('id')->paginate(10)->withQueryString();

        $data['title'] = trans('Today Routes');

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

        $data['orders'] = Order::doesntHave('road')
        ->has('activeCustomer')
        ->where('status',1)
        ->latest('id')->get();

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
      
            'driver_id' => 'nullable|exists:users,id',
            'orders' => 'required|array',
        ]);

        $orders = Order::whereIn('id',$request->orders)->orderBy('visit_time')->get();

        $times = $orders->pluck('visit_time');

        $current_time = $times->first();

        foreach ($times as $key => $item) {

            if ($key == 0) {
                continue;
            }

            if ($item->diffInMinutes($current_time) < 60) {
                return redirect()->back()->withErrors(trans('You cannot add more than one order at the same hour in one route'));
            }

            $current_time = $item;
        }

        if ($request->isNotFilled('driver_id')) {

            $driver_id = getAvailableDrivers() ? getAvailableDrivers()->first(): null;
            // $driver_id = getAvailableDrivers()->first();
            $validated['driver_id'] = $driver_id;
        }

        $road = Road::create($validated);



        Order::whereIn('id',$request->orders)->update([
            'road_id' => $road->id,
            'driver_id' => $road->driver_id,
        ]);

        $status = (int)$road->status;

        if ($status == 2) {
            changeOrderStatusToAssigned($road->id);
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
        $data['road'] = Road::with(['driver','orders'=>['customer','driver']])->findOrFail($id);

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

        abort_if($data['road']->status == 3,401);

        $myOrders = $data['road']->orders()->pluck('id');

        $data['myOrders'] = $myOrders;

        $data['orders'] = Order::doesntHave('road')
        ->has('activeCustomer')
        ->where('status',1)
        ->orWhereIn('id',$myOrders)->latest('id')->get();

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

        abort_if($road->status == 3,401);

        $validated = $request->validate([
            'driver_id' => 'nullable|exists:users,id',
            'orders' => 'required|array',
        ]);

        $orders = Order::whereIn('id',$request->orders)->orderBy('visit_time')->get();

        $times = $orders->pluck('visit_time');

        $current_time = $times->first();

        foreach ($times as $key => $item) {

            if ($key == 0) {
                continue;
            }

            if ($item->diffInMinutes($current_time) < 60) {
                return redirect()->back()->withErrors(trans('You cannot add more than one order at the same hour in one route'));
            }

            $current_time = $item;
        }

        $road->orders()->update(['road_id'=>null]);

        $road->update($validated);

        if ($request->filled('orders')) {

            $new_orders = $request->orders;


            if ($road->orders->isNotEmpty()) {
                $exist_orders = $road->orders->pluck('id');

                $out_orders = $exist_orders->diff($new_orders)->toArray();

                Order::whereIn('id',$out_orders)->update([
                    'status' => 1
                ]); 

            }

            $road->orders()->update([
                'road_id' => null,
                'driver_id' => null,
            ]);

            Order::whereIn('id',$new_orders)->update([
                'road_id' => $road->id,
                'driver_id' => $road->driver_id,
            ]); 
        }
        
        $status = (int)$road->status;
        if ($status == 2) {
            changeOrderStatusToAssigned($road->id);
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

        return redirect()->back();
    }
}
