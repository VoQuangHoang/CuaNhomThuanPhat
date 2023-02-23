<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contacts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('contact list')){
            $contact = Contacts::all();
            return view('admin.contact.list', compact('contact'));
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
        if(auth()->user()->can('contact edit')){
            $data = Contacts::findOrFail($id);
            $data->update(['status' => 1]);
            $message = 'test';
            event(new \App\Events\TestPush($message));

            return back()->with('success', 'Cập nhật thành công');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->can('contact delete')){
            Contacts::destroy($id);
            return back()->with('success', 'Xóa thành công');
        }
        abort(406);
    }

    public function postMultiDel(Request $request)
    {
        if(auth()->user()->can('contact delete')){
        if(!empty($request->chkItem)){

            foreach ($request->chkItem as $id) {
                Contacts::destroy($id);
            }

            return back()->with('success', 'Xóa thành công');
        }
        return back()->with('error', 'Bạn chưa chọn dữ liệu để xóa.');
        }
        abort(406);
    }
}
