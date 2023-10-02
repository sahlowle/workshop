<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAdminRequest;
use App\Http\Requests\Api\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ApiAdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | get list
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = User::query()->admins();

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
    public function store(StoreAdminRequest $request)
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | show item
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $data =  User::admins()->find($id);
        
        if (is_null($data)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | update item
    |--------------------------------------------------------------------------
    */
    public function update(UpdateAdminRequest $request, $id)
    {
        $data =  User::admins()->find($id);
        
        if (is_null($data)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | delete item
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $data =  User::admins()->find($id);
        
        if (is_null($data)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }
        
    }
}
