<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreDriverRequest;
use App\Http\Requests\Api\UpdateDriverRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class ApiCustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | get list
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Customer::query()->drivers();

        $per_page = $request->filled('per_page') ? $request->per_page : 10;
        
        $data = $query->paginate($per_page);

        $message = trans('Successful Retrieved');
        
        return $this->paginationResponse(true,$data,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | add new
    |--------------------------------------------------------------------------
    */
    public function store(StoreDriverRequest $request)
    {
        $data = $request->validated();

        $data['type'] = 2;

        $user = Customer::create($data);

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
        $data =  Customer::find($id);
        
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
    public function update(UpdateDriverRequest $request, $id)
    {
        $user =  Customer::find($id);
        
        if (is_null($user)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $data = $request->validated();

        $user->update($data);
    
        $message = trans('Successful Updated');

        return $this->sendResponse(true,$user,$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | delete item
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $user =  Customer::find($id);
        
        if (is_null($user)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $user->delete();
    
        $message = trans('Successful Delete');

        return $this->sendResponse(true,$user,$message,200);

    }
}
