<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCustomerRequest;
use App\Http\Requests\Api\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ApiCustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | get list
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search_text')) {
            $search_text = $request->search_text;
            $columns = ['name','phone','email','zone_area'];

            foreach($columns as $key => $column){
                if ($key == 0) {
                    $query->where($column, 'LIKE', '%' . $search_text . '%');
                } else{
                    $query->orWhere($column, 'LIKE', '%' . $search_text . '%');
                }
            }
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
    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

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
    public function update(UpdateCustomerRequest $request, $id)
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
