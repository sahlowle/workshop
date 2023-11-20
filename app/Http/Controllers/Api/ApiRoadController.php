<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreRoadRequest;
use App\Http\Requests\Api\UpdateRoadRequest;
use App\Models\Order;
use App\Models\Road;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ApiRoadController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | get list
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Road::query();

        $user = $request->user();
        

        if ($user->hasRole('driver')) {
            $query->where('driver_id',$user->id);
        }

        if ($request->filled('today')) {
            $query->whereDate('created_at', Carbon::today());
        }

        if ($request->filled('search_text')) {
            $search_text = $request->search_text;
            $columns = ['description','reference_no'];

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

            $date_from = $request->date('date_from');
            $date_to = $request->date('date_to');

            $query
            ->whereDate('created_at', '>=', $date_from)
            ->whereDate('created_at', '<=', $date_to);
        }

        $per_page = $request->filled('per_page') ? $request->per_page : 10;
        
        $data = $query->with(['driver'])->latest('id')->paginate($per_page);

        $message = trans('Successful Retrieved');
        
        return $this->sendResponse(true,$data,$message,200);
    }

    /*
    |---------------------------------------------------f-----------------------
    | add new
    |--------------------------------------------------------------------------
    */
    public function store(StoreRoadRequest $request)
    {
        $data = $request->validated();

        if ($request->isNotFilled('driver_id')) {
            $driver_id = getAvailableDrivers()->first();
            $data['driver_id'] = $driver_id ? $driver_id : null;
        }

        $road = Road::create($data);

        Order::whereIn('id',$request->orders_ids)->update([
            'road_id' => $road->id,
            'driver_id' => $road->driver_id,
        ]);

        $status = (int)$road->status;

        if ($status == 2) {
            changeOrderStatus($road->id,2);
        }

        $message = trans('Successful Added');

        return $this->sendResponse(true,$road,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | show item
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $data = Road::with(['driver','orders.customer'])->find($id);
        
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
    public function update(UpdateRoadRequest $request, $id)
    {
        $road = Road::find($id);
        
        if (is_null($road)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $data = $request->validated();

        $road->update($data);

        if ($request->filled('orders_ids')) {

            $road->orders()->where('status','!=',3)->update([ 'status' => 1 ]);

            $road->orders()->update([
                'road_id' => null,
                'driver_id' => null,
            ]);

            Order::whereIn('id',$request->orders_ids)->update([
                'road_id' => $road->id,
                'driver_id' => $road->driver_id,
            ]); 
        }

        $status = (int)$road->status;
        if ($status == 2) {
            changeOrderStatus($road->id,2);
        }
    
        $message = trans('Successful Updated');

        return $this->sendResponse(true,$road,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | delete item
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $road = Road::find($id);
        
        if (is_null($road)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $road->delete();
    
        $message = trans('Successful Delete');

        return $this->sendResponse(true,$road,$message,200);

    }
}
