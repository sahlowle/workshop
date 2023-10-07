<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Requests\Api\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class ApiOrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | get list
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Order::query();

        $per_page = $request->filled('per_page') ? $request->per_page : 10;
        
        $data = $query->latest('id')->paginate($per_page);

        $message = trans('Successful Retrieved');
        
        return $this->paginationResponse(true,$data,$message,200);
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

        $user = Order::create($data);

        $message = trans('Successful Added');

        return $this->sendResponse(true,$user,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | show item
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $data =  Order::with('customer')->find($id);
        
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

        $data = $request->validated();

        $order->update($data);
    
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

        $order->delete();
    
        $message = trans('Successful Delete');

        return $this->sendResponse(true,$order,$message,200);

    }
}
