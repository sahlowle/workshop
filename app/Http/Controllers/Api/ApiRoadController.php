<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreRoadRequest;
use App\Http\Requests\Api\UpdateRoadRequest;
use App\Models\Order;
use App\Models\Road;
use Illuminate\Http\Request;

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

        $per_page = $request->filled('per_page') ? $request->per_page : 10;
        
        $data = $query->latest('id')->paginate($per_page);

        $message = trans('Successful Retrieved');
        
        return $this->sendResponse(true,$data,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | add new
    |--------------------------------------------------------------------------
    */
    public function store(StoreRoadRequest $request)
    {
        $data = $request->validated();

        $road = Road::create($data);

        Order::whereIn('id',$request->orders_ids)->update(['road_id' => $road->id]);

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
        $data = Road::with(['orders'])->find($id);
        
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

            $road->orders()->update([ 'road_id' => null ]);

            Order::whereIn('id',$request->orders_ids)->update(['road_id' => $road->id]);
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
