<?php

namespace App\Http\Controllers\Admin;

// use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // if(auth()->user()->can('role list'))
        // {
            $data = Role::get();

            return view('admin.roles.list',compact('data'));
        // }
        // abort(406);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::all()->toArray();

        $oldPer = old('permission') ? old('permission') : [];

        return view('admin.roles.create', compact('permission', 'oldPer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $roleName = $request->name;
            $role = Role::create(['name' => $roleName]);
            if(!empty($request->permission))
            {
                foreach ($request->permission as $key => $permission) {
                    $role->givePermissionTo($permission);
                }
            }
            if($role){
                return redirect()->route('roles.index')->with('success', 'Thêm mới vai trò thành công');
            }

            return $role;

        } catch (Throwable $e) {
            return $this->exception($e);
        }
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
        $dataEditRole = Role::find($id);
        
        if(!empty($dataEditRole)) {
            $guard_name = $dataEditRole->guard_name;

            $pers = $dataEditRole->permissions()->where('guard_name',$guard_name)->get();

            $dataEditRole['permission'] = $pers ? $pers->pluck('id')->toArray() : [];

            $Permission = Permission::where('guard_name',$guard_name)->get()->toArray();

            return view('admin.roles.edit', compact('Permission', 'dataEditRole'));

        } else {

            return redirect()->route('roles.index');

        }
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
        if(empty($request->permission)){
            return back()->with('error', 'Thêm mới vai trò thành công');
        }
        $dataEditRole = Role::find($id);

        $guard_name = $dataEditRole->guard_name;

        $Permissions = Permission::where('guard_name',$guard_name)->get()->toArray();

        foreach ($Permissions as $key => $value) {
            $dataEditRole->revokePermissionTo($value);
        }

        foreach ($request->permission as $key => $permission) {
            $dataEditRole->givePermissionTo($permission);
        }

        if($request->name){
            $dataEditRole->name = $request->name;
        }

        $dataEditRole->save();

        return back()->with('success', 'Cập nhập phân quyền thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Permissions = Permission::all()->pluck('name')->toArray();

        $dataEditRole = Role::find($id);

        foreach ($Permissions as $key => $value) {

            $dataEditRole->revokePermissionTo($value);

        }

        if($dataEditRole->delete()){
            return back()->with('success', 'Xóa vai trò và phân quyền thành công!');
        }
    }

    public function addPermission(Request $request)
    {
        $permission = Permission::create(['name' => $request->name]);

        return back();
    }
}
