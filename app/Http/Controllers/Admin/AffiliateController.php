<?php

namespace App\Http\Controllers\Admin;

use App\Models\AffSale;
use App\Models\AffRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AffiliateController extends Controller
{
    public function index(){
        $data = AffSale::orderBy('created_at', 'DESC')->get();
        return view('admin.aff.list', compact('data'));
    }

    public function listRequest(){
        $data = AffRequest::orderBy('created_at', 'DESC')->get();
        return view('admin.aff.list_request', compact('data'));
    }

    public function process(Request $request, $id)
    {
        $aff_request = AffRequest::where('id', $id)->where('status', 0)->first();
        if ($aff_request) {
            $aff_request->status = 1;
            $aff_request->save();
            return redirect()->back()->with('success', 'Xử lý thành công');
        } else {
            return redirect()->back()->with('error', 'Không tồn tại yêu cầu hoặc có lỗi');
        }

        
    }
}
