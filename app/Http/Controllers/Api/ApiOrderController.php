<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddFilesRequest;
use App\Http\Requests\Api\AddPaymentFileRequest;
use App\Http\Requests\Api\DeleteFilesRequest;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Requests\Api\UpdateOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Traits\FileSaveTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ApiOrderController extends Controller
{
    use FileSaveTrait;
    
    /*
    |--------------------------------------------------------------------------
    | get list
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('without_route')) {
            $query->whereDoesntHave('road');
            $query->has('activeCustomer');
        }

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
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        $data['status'] = 1; // pending

        $order = Order::create($data);

        $message = trans('Successful Added');

        return $this->sendResponse(true,$order->fresh(),$message,200);
    }

    /*
    |--------------------------------------------------------------------------
    | show item
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $data =  Order::with(['files','customer'])->find($id);
        
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
        
        // $order->files()->delete();

        $order->delete();
    
        $message = trans('Successful Delete');

        return $this->sendResponse(true,$order,$message,200);

    }

    /*
    |--------------------------------------------------------------------------
    | Add Payment File
    |--------------------------------------------------------------------------
    */
    public function addPaymentFile(AddPaymentFileRequest $request,$id)
    {
        $order =  Order::find($id);
        
        if (is_null($order) ) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        if ($request->hasFile('payment_file')) {
            
            $file = $request->file('payment_file');
            $path = $this->uploadFile('payment_files',$file);
            
            $order->update([
                'payment_file' => $path,
            ]);

        } 

        return $this->sendResponse(true,$order->files,trans("Files Added Successfully"),200);
    }
    /*
    |--------------------------------------------------------------------------
    | Add Files
    |--------------------------------------------------------------------------
    */
    public function addFiles(AddFilesRequest $request,$id)
    {
        $order =  Order::find($id);
        
        if (is_null($order) || ! $request->hasFile('files') ) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        if ($request->hasFile('files')) {
            
            $files = $request->file('files');

            foreach ($files as $file) {
                $path = $this->uploadFile('order_files',$file);
                
                $order->files()->create([
                    'file_name' => basename($path),
                    'path_name' => $path,
                ]);

            }
        } 

        return $this->sendResponse(true,$order->files,trans("Files Added Successfully"),200);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Files
    |--------------------------------------------------------------------------
    */
    public function deleteOrderFile(DeleteFilesRequest $request,$id)
    {
        $order =  Order::find($id);
        
        if (is_null($order)) {
            return $this->sendResponse(false,[],trans('Not Found'),404);
        }

        $file = $order->files()->find($request->file_id);

        $this->deleteFile($file->path_name);

        $file->delete();

        return $this->sendResponse(true,$file,"Files Deleted Successfully",200);
    }
}
