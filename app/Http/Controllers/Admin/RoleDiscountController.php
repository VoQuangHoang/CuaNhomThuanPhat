<?php

namespace App\Http\Controllers\Admin;

use App\Models\RoleDiscount;
use Illuminate\Http\Request;
use App\Models\CustomerDiscount;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Role::get();
        $roleDiscound = CustomerDiscount::orderBy('level', 'asc')->get();
        return view('admin.roles.discount', compact('roleDiscound'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, 
            [
                'name' => 'required|unique:customer_discount',
                'discount' => 'required',
                'level' => 'required',
            ], 
            [
                'name.unique' => 'Đã thêm chiết khấu cho vai trò này'
            ]
        );
        $input = $request->all();
        CustomerDiscount::create($input);
        return back()->with('success', 'Thêm thành công');
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
        //
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
        CustomerDiscount::find($id)->update($request->all());
        return back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CustomerDiscount::destroy($id);
        return back()->with('success', 'Xóa thành công');
    }
}
