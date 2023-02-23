<?php

namespace App\Http\Controllers\Frontend;

use App\Models\AffClick;
use App\Models\Customer;
use App\Models\Settings;
use App\Models\AffRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\Pages\PagesRepository;
use App\Http\Requests\Frontend\AffiliateRequest;

class AffController extends Controller
{
    protected $pages;

    public function __construct(PagesRepository $pages){
        $this->pages = $pages;
    }
    
    public function index(Request $request)
    {
        if ($request->aff) {
            if (!Auth::guard('customer')->user() || (Auth::guard('customer')->user() && Auth::guard('customer')->user()->aff_id != $request->aff)) {
                Cookie::queue('affId',$request->aff, 60);
                $customer = Customer::where('aff_id',$request->aff)->first();
                if ($customer) {
                    $aff_click = AffClick::where('aff_id', $request->aff)->first();
                    if ($aff_click) {
                        $aff_click->click_count++;
                        $aff_click->save();
                    } else {
                        AffClick::create([
                            'aff_id' => $request->aff,
                            'click_count' => 1
                        ]);
                    }
                }
            }
        }
        if ($request->url) {
            return redirect($request->url);
        }

        return redirect()->route('home.index');
    }

    public function get(Request $request)
    {
        dd(Cookie::get('affId'));
    }

    public function getAffiliatePage(Request $request)
    {
        // $get_rank = $this->getRank();
        $dataSeo = $this->pages->getDataByType('affiliate');
        $this->pages->createSeo($dataSeo);
        $customer = auth('customer')->user();
        $aff_sales = $customer->aff_sales()->orderBy('created_at', 'DESC')->paginate(5);
        $aff_click = $customer->aff_click->click_count ?? 0;
        $percent_click = $aff_click > 0 ? number_format(($customer->aff_sales()->where('type', 1)->count()/$aff_click)*100): 0;
        return view('frontend.pages.affiliate', compact('aff_sales','aff_click','percent_click'));
        
    }

    public function registerAffiliate() {
        Auth::guard('customer')->user()->update(['is_aff' => 1, 'aff_id' => time().uniqid(true)]);
        return back()->with('success', 'Đã đăng ký Affiliate thành công');
    }

    public function affiliateRequest()
    {
        $dataSeo = $this->pages->getDataByType('affiliate');
        $this->pages->createSeo($dataSeo);
        return view('frontend.pages.affiliate_request');
    }

    public function affiliatePostRequest(AffiliateRequest $request)
    {
        try {
            $dataPost = $request->all();
            $user = Auth::guard('customer')->user();
            $amount_avaliable = $user->aff_sales()->where('status',1)->where('withdraw',0)->sum('aff_amount');
            $options = Settings::where('type', 'affiliate')->first();
            $aff_setting = json_decode($options->content);
            // dd($aff_setting->limit);
            if ($amount_avaliable <= $aff_setting->limit) {
                return back()->withInput()->with('error', 'Số tiền cần rút phải từ ' . number_format( $aff_setting->limit).' ₫');
            }
            DB::beginTransaction();
            if ($dataPost['request_type'] == 'to_balance') {
                $user->total_aff_amount += $amount_avaliable;
                $user->current_aff_amount += $amount_avaliable;
                $user->save();
    
            } elseif ($dataPost['request_type'] == 'bank_tranfer') {
                AffRequest::create([
                    'aff_id' => $user->aff_id,
                    'amount' => $amount_avaliable,
                    'bank_name' => $request->bank_name,
                    'bank_number' => $request->bank_number,
                    'holder_name' => $request->holder_name,
                    'status' => 0,
                ]);
            }
            $aff_sales = $user->aff_sales()->where('status',1)->where('withdraw',0)->get();
            foreach ($aff_sales as $aff) {
                $aff->withdraw = 1;
                $aff->save();
            }
            DB::commit();
            return back()->with('success', 'Gửi yêu cầu thành công. Yêu cầu thực hiện rút tiền của bạn sẽ được xử lý trong vòng 48h. Xin trân trọng cảm ơn!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại hoặc liên hệ Dotiva để xử lý!');
        }
    }
}
