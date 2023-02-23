<?php

namespace App\Http\Controllers\Admin;

use Mail;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Trails\MailTrait;
use App\Http\Controllers\Controller;
use App\Services\ViettelPostService;
use Spatie\Permission\Models\Role;

class SettingsController extends Controller
{
    use MailTrait;

    protected $viettelPost;

    public function __construct(ViettelPostService $viettelPost)
    {
        $this->middleware(['role:Quản trị viên']);
        $this->viettelPost = $viettelPost;
    }

    public function getGeneralConfig()
    {
        $data = Settings::where('type', 'general')->first();

        $content = json_decode($data->content);

        return view('admin.settings.general', compact('content'));
    }

    public function postGeneralConfig(Request $request)
    {
        $options = Settings::where('type', 'general')->first();
        
        $options->content = !empty($request->content) ? json_encode($request->content) : null;
        
        $options->save();

        return back()->with('success', 'Cập nhật thành công');
    }

    public function cssJsConfig()
    {
        $data = Settings::where('type', 'css-js-config')->first();

        $content = json_decode($data->content);

        return view('admin.settings.css_js_config', compact('content'));
    }

    public function postCssJsConfig(Request $request)
    {
        $data = Settings::where('type', 'css-js-config')->first();
        
        $data->content = !empty($request->content) ? json_encode($request->content) : null;
        
        $data->save();
        
        return back()->with('success', 'Cập nhật thành công');
    }

    public function getMailConfig()
    {
        $data = Settings::where('type', 'smtp-config')->first();

        $content = json_decode($data->content);

        return view('admin.settings.mail_config', compact('content'));   
    }

    public function postMailConfig(Request $request)
    {
        $content = Settings::where('type', 'smtp-config')->first();

        $content->content = !empty($request->content) ? json_encode($request->content) : null;

        $content->save();

        return back()->with('success', 'Cập nhật thành công');
    }

    public function getViettelPostConfig()
    {
        $data = Settings::where('type', 'viettel-post')->first();

        $content = json_decode($data->content);

        $login = ['login_id' => $content->login_id, 'password' => $content->password ];

        $userViettel = $this->viettelPost->login($login);

        $viettelStore = $this->viettelPost->getStore($userViettel);

        $store = $viettelStore['data'][0];
        
        return view('admin.settings.viettel_post', compact('content', 'store'));
    }

    public function postViettelPostConfig(Request $request)
    {
        $data = $request->content;
        $login =  $this->viettelPost->login($data);

        if($login['status'] == '200'){
            $store = $this->viettelPost->getStore($login);
           
            $options = Settings::where('type', 'viettel-post')->first();
            $data['default_store'] = $store['data'][0]['groupaddressId'];
            $data['city_id'] = $store['data'][0]['provinceId'];
            $data['district_id'] = $store['data'][0]['districtId'];
            $options->content = !empty($request->content) ? json_encode($data) : null;
            $options->save();
            return back()->with('success', 'Đăng nhập thành công');
        }
        return back()->with('error', 'Đăng nhập thất bại. Vui lòng thử lại');
    }

    public function postSendTestEmail(Request $request)
    {
        $this->initMailConfig();

        $contact['email'] = $request->smtp_email;
        $contact['title'] = $request->smtp_title;
        $contact['smtp_message'] = $request->smtp_message;

        Mail::to($contact['email'])->send(new SendTestMail($contact));
    
        return back()->with('success', 'Gửi mail thành công (test)');
    }

    public function getAffiliate()
    {
        $data = Settings::where('type', 'affiliate')->first();

        $content = json_decode($data->content);

        return view('admin.settings.affiliate', compact('content'));
    }

    public function postAffiliate(Request $request)
    {
        $options = Settings::where('type', 'affiliate')->first();
        
        $options->content = !empty($request->content) ? json_encode($request->content) : null;
        
        $options->save();

        return back()->with('success', 'Cập nhật thành công');
    }
}
