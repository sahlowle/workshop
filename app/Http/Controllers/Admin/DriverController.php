<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = User::query()->drivers();

        if ($request->filled('search_text')) {
            $search_text = $request->search_text;
            $columns = ['name','phone'];

            foreach($columns as $key => $column){
                if ($key == 0) {
                    $query->where($column, 'LIKE', '%' . $search_text . '%');
                } else{
                    $query->orWhere($column, 'LIKE', '%' . $search_text . '%');
                }
            }
        }
        $data['users'] = $query->withCount('roads')->paginate(10)->withQueryString();

        $data['title'] = trans('Technician');

        return view('admin.drivers.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = trans('Add New Technician');

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
            'name' => 'required|string',
            // 'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required|unique:users|min:12|max:20'
        ]);

        
        $validated['type'] = 2;

        // $password = Str::random(8);
        // $validated['password'] = $password;

        $user = User::create($validated);

        // $user->notify(new NewPassword($password));

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

        $data['title'] = trans('Edit Technician');

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
            'name' => 'nullable|string',
            // 'email' => 'nullable|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|min:12|max:20|unique:users,phone,'.$id,
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

    public function mapLocation()
    {

        $users = User::drivers()->select('lat','lng','name')->whereNotNull(['lat','lng'])->get();

        $data['title'] = trans('Technician Locations');
        $data['users'] = $users;

        return view('admin.drivers.map-location',$data);
    }
}
