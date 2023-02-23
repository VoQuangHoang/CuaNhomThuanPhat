<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payments;
use App\Models\LogPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $type = array('momo','vnpay');
    
    public function index(Request $request)
    {
        $data['type'] = $request->type;

        if(!in_array($data['type'],$this->type)){
            return abort(404);
        }

        $data['data'] = Payments::where('type',$data['type'])->first();

        return view('admin.payments.'.$data['type'],$data);
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
        $type  = $request->type;

        if ($type=='vnpay') {

            $data = Payments::where('type',$type)->first();

            if($data){

                $data->payment_name = $request->payment_name;
                $data->url_pay = $request->url_pay;
                $data->vnp_TmnCode = $request->vnp_TmnCode;
                $data->vnp_HashSecret = $request->vnp_HashSecret;
                $data->status = $request->status == 1 ? 1 : 0;
                $data->save();
            }else{
                $payment = new Payments();
                $payment->payment_name = $request->payment_name;
                $payment->type = 'vnpay';
                $payment->status = $request->status == 1 ? 1 : 0;
                $payment->url_pay = $request->url_pay;
                $payment->vnp_TmnCode = $request->vnp_TmnCode;
                $payment->vnp_HashSecret = $request->vnp_HashSecret;
                $payment->save();
            }
        }

        return redirect()->back()->with('success', 'Lưu thông tin thành công');
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
        //
    }

    public function logPaymentVnpay()
    {
        $data = LogPayment::where('type_payment', 'vnpay')->orderBy('created_at', 'DESC')->get();
        return view('admin.payments.log_vnpay', compact('data'));
    }

    public function deleteLogPaymentVnpay($id){
        LogPayment::destroy($id);
        return back()->with('success', 'Xóa lịch sử giao dịch thành công');
    }
}
