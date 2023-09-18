<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Road;
use App\Models\User;
use Illuminate\Http\Request;

class RoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Road::query();

        if ($request->filled('reference_no')) {
            $query->where('reference_no',$request->reference_no);
        }

        $data['data'] = $query->with('driver')->latest('id')->paginate(10);

        $data['title'] = trans('Routes');

        return view('admin.roads.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = trans('Add New Route');

        $data['drivers'] = User::drivers()->pluck('name','id');

        $data['drivers']->prepend(trans('Select..'),'');

        return view('admin.roads.create',$data);
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
            'driver_id' => 'required|exists:users,id',
        ]);


        Road::create($validated);

        $message = trans('Successful Added');

        notify()->success($message);


        return redirect()->route('roads.index');
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
        $data['road'] = Road::findOrFail($id);

        $data['title'] = trans('Edit Route');

        $data['drivers'] = User::drivers()->pluck('name','id');

        $data['drivers']->prepend(trans('Select..'),'');

        return view('admin.roads.edit',$data);
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
        $road = Road::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|min:9|max:10',
            'address' => 'nullable|string|min:6',
            'national_id' => 'nullable|string|min:10',
        ]);


        $road->update($validated);

        $message = trans('Successful Updated');

        notify()->success($message);


        return redirect()->route('roads.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Road::findOrFail($id);

        $user->delete();

        $message = trans('Successful Delete');

        notify()->success($message);

        return redirect()->route('roads.index');
    }
}
