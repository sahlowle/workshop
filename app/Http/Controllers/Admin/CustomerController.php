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
    public function index()
    {
        $data['users'] = Customer::paginate(10);

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
            'phone' => 'required|unique:customers',
            'address' => 'required|string|min:6',
            'zone_area' => 'required|string|min:10',
        ]);

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
    public function show($id)
    {
        //
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
            'phone' => 'nullable|string|min:9|max:10',
            'address' => 'nullable|string|min:6',
            'zone_area' => 'nullable|string|max:30',
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

        $message = trans('Successful Delete');

        notify()->success($message);

        return redirect()->route('customers.index');
    }
}
