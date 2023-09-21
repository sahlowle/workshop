<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = User::drivers()->paginate(10);

        $data['title'] = trans('Drivers');

        return view('admin.drivers.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = trans('Add New Driver');

        return view('admin.drivers.create',$data);
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
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|unique:users',
            'address' => 'required|string|min:6',
            'national_id' => 'required|string|min:10',
        ]);

        $validated['type'] = 2;

        User::create($validated);

        $message = trans('Successful Added');

        notify()->success($message);


        return redirect()->route('drivers.index');
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
        $data['user'] = User::findOrFail($id);

        $data['title'] = trans('Edit Driver');

        return view('admin.drivers.edit',$data);
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
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|unique:users',
            'address' => 'nullable|string|min:6',
            'national_id' => 'nullable|string|min:10',
        ]);


        $user->update($validated);

        $message = trans('Successful Updated');

        notify()->success($message);


        return redirect()->route('drivers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        $message = trans('Successful Delete');

        notify()->success($message);

        return redirect()->route('drivers.index');
    }
}
