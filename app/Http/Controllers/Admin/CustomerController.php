<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerDiscount;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('customer list')){
            $data = Customer::all();
            $cus_role = CustomerDiscount::orderBy('level', 'asc')->get();
            return view('admin.customer.list', compact('data', 'cus_role'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(auth()->user()->can('customer view')){
            $data = Customer::find($id);
            $member = Customer::where('created_id', $data->id)->orderBy('created_at', 'DESC')->get();
            $orderByMonth = $data->AllMonth();
            $orderMonth1 = $data->BetweenMonth(1,3);
            $orderMonth2 = $data->BetweenMonth(4,6);
            $orderMonth3 = $data->BetweenMonth(7,9);
            $orderMonth4 = $data->BetweenMonth(10,12);
            $orderYear = $data->ByYear();
            return view('admin.customer.view', compact('data', 'orderByMonth', 'orderMonth1', 'orderMonth2', 'orderMonth3', 'orderMonth4','orderYear','member'));
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
        $data = Customer::find($id);
        $data->update([ 'customer_role_id' => $request->customer_role_id]);
        return back()->with('success', 'Cập nhật vai trò người dùng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
