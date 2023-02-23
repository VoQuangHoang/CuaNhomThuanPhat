<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('checkLevel', ['except' => ['edit','update']]);
        // $this->middleware(['role:Quản trị viên|Biên tập viên']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('user list'))
        {
            $data = User::with('roles')->get();
            return view('admin.users.list', compact('data'));
        }
        abort(406);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('user add')){
            $roles = Role::all();
            return view('admin.users.add', compact('roles'));
        }
        abort(406);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if(auth()->user()->can('user add')){
            $user = new User;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->active = $request->active == 1 ? 1 : 0;
            $user->image = $request->image;
            $user->save();
            $user->assignRole($request->role_id);
            return redirect()->route('users.index')->with('success', 'Thêm mới tài khoản thành công');
        }
        abort(406);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->hasRole('Quản trị viên') || auth()->user()->id == $id && auth()->user()->can('user edit')){
            $data = User::findOrFail($id);
            
            $roles = Role::all();
            
            if($data){
                $userData = $data->toArray();
                $userData['role'] = [];

                if($data->roles()->get()){
                    $dataRole = $data->roles()->get();
                    if(count($dataRole)){
                        $userData['role'] = $dataRole[0]->id;
                    }
                }
                
            }
            return view('admin.users.edit', compact('data','roles','userData'));
        }
        abort(406);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        if(auth()->user()->hasRole('Quản trị viên') || auth()->user()->id == $id && auth()->user()->can('user edit')){
            $user = User::find($id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->active = $request->active == 1 ? 1 : 0;
            if ($request->input('password')) {
                $this->validate($request,
                [
                    'repassword' => 'same:password'
                ],
                [
                    'repassword.same' => 'Mật khẩu không trùng khớp!'
                ]);
                $pass = $request->input('password');
                $user->password = Hash::make($pass);
            }

            $user->image = $request->image;

            $user->save();
            if($request->role_id){
                if($user->roles()->get()) {
                    $dataRole = $user->roles()->get();
                    if(count($dataRole)){
                        $user->removeRole($dataRole[0]->id);
                    }
                }

                $user->assignRole($request->role_id);
            }

            return redirect()->back()->with('success','Cập nhật tài khoản thành công');
        }
        abort(406);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->hasRole('Quản trị viên') || auth()->user()->id == $id && auth()->user()->can('user delete')){
            $user = User::findOrFail($id);
            $user->destroy($id);
            return back()->with('success', 'Xóa tài khoản thành công');
        }
        abort(406);
    }
}
