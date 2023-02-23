<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apps;
use App\Models\Blogs;
use App\Models\Games;
use App\Models\Contact;
use App\Models\Products;
use App\Models\WidgetApp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = \App\Models\Products::latest()->get();
        $orders = \App\Models\Orders::latest()->get();
        $users = \App\Models\User::all();
        $contacts = \App\Models\Contacts::all();
        return view('admin.home', compact( 'products', 'orders', 'users', 'contacts'));
    }

    public function getLayOut(Request $request)
    {
    	$index = $request->index;
    	$type = $request->type;
        if(view()->exists('admin.repeater.row-'.$type) && $type == 'bonus'){
            $bonusProduct = Products::where('bonus', 1)->latest()->get();
		    return view('admin.repeater.row-'.$type, compact('index', 'bonusProduct'))->render();
        }
    	if(view()->exists('admin.repeater.row-'.$type)){
		    return view('admin.repeater.row-'.$type, compact('index'))->render();
		}

		return 'Error';
    }

    public function sendTest(Request $request){
        $message = $request->query->get('message', 'Hey guys!');
        event(new \App\Events\TestPush($message));
        return "Message \" $message \" has been sent.";
    }
}
