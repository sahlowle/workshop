<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search_text')) {
            $search_text = $request->search_text;
            $columns = ['name','phone','email','address','city','postal_code'];

            foreach($columns as $key => $column){
                if ($key == 0) {
                    $query->where($column, 'LIKE', '%' . $search_text . '%');
                } else{
                    $query->orWhere($column, 'LIKE', '%' . $search_text . '%');
                }
            }
        }

        $data['users'] = $query->withTrashed()->paginate(10)->withQueryString();

        $data['title'] = trans('Customers');

        return view('admin.customers.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = trans('Add New Customer');

        return view('admin.customers.create',$data);
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
            'name' => 'required|string|min:3',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'required|unique:customers|min:12|max:20',
            'address' => 'required|string|max:100',
            'zone_area' => 'required|string|max:30',
            'postal_code' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:30',
            'lat' => 'nullable|string|max:100',
            'lng' => 'nullable|string|max:100',
        ]);

        // return $request->all();

        $validated['type'] = 2;

        Customer::create($validated);

        $message = trans('Successful Added');

        notify()->success($message);


        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->ajax()){
            return Customer::findOrFail($id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['user'] = Customer::findOrFail($id);

        $data['title'] = trans('Edit Customer');

        return view('admin.customers.edit',$data);
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
        $user = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|email|unique:customers,email,'.$id,
            'phone' => 'nullable|min:12|max:20|unique:customers,phone,'.$id,
            'address' => 'nullable|string|max:100',
            'zone_area' => 'nullable|string|max:30',
            'postal_code' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:30',
            'lat' => 'nullable|string|max:100',
            'lng' => 'nullable|string|max:100',
        ]);


        $user->update($validated);

        $message = trans('Successful Updated');

        notify()->success($message);


        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Customer::findOrFail($id);

        $user->delete();

        $message = trans('Successful Disabled');

        notify()->success($message);

        return redirect()->route('customers.index');
    }

    public function reStore($id)
    {
        $user = Customer::withTrashed()->findOrFail($id);

        $user->restore();

        $message = trans('Successful Enabled');

        notify()->success($message);

        return redirect()->route('customers.index');
    }
}
