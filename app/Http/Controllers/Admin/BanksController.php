<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BanksController extends Controller
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
        if(auth()->user()->can('bank list')){
            $data = Banks::all();
            return view('admin.banks.list', compact('data'));
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
        if(auth()->user()->can('bank add')){
            return view('admin.banks.create');
        }
        abort(406);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->can('bank add')){
            $data = $request->all();
            $data['status'] = $request->status == 1 ? 1 : 0;
            Banks::create($data);
            flash('Thêm mới thành công.')->success()->important();
            return redirect()->route('banks.index');
        }
        abort(406);
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
        if(auth()->user()->can('bank edit')){
            $data = Banks::findOrFail($id);
            return view('admin.banks.edit', compact('data'));
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
    public function update(Request $request, $id)
    {
        if(auth()->user()->can('bank edit')){
            $data = $request->all();
            $data['status'] = $request->status == 1 ? 1 : 0;
            Banks::findOrFail($id)->update($data);
            flash('Cập nhật thông tin thành công.')->success()->important();
            return redirect()->route('banks.index');
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
        if(auth()->user()->can('bank delete')){
            Banks::destroy($id);
            return redirect()->route('banks.index');
        }
        abort(406);
    }
}
