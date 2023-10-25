<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreDriverRequest;
use App\Http\Requests\Api\UpdateDriverLocationRequest;
use App\Http\Requests\Api\UpdateDriverRequest;
use App\Models\User;
use App\Notifications\NewPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ApiDriverController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | get list
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = User::query()->drivers();

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
    public function store(StoreDriverRequest $request)
    {
        $data = $request->validated();

        // $password = Str::password(8); // this feature in laravel 10
        
        $password = Str::random(8);

        $data['type'] = 2;
        $data['password'] = $password;

        $user = User::create($data);

        $user->notify(new NewPassword($password));

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
        $data =  User::drivers()->find($id);
        
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
        $user =  User::drivers()->find($id);
        
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
        $user =  User::drivers()->find($id);
        
        if (is_null($user)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $user->delete();
    
        $message = trans('Successful Delete');

        return $this->sendResponse(true,$user,$message,200);

    }

    /*
    |--------------------------------------------------------------------------
    | update location
    |--------------------------------------------------------------------------
    */
    public function updateLocation(UpdateDriverLocationRequest $request)
    {
        $user =  $request->user();

        $data = $request->validated();

        $user->update($data);
    
        $message = trans('Successful Updated');

        return $this->sendResponse(true,$user,$message,200);

    }
}
