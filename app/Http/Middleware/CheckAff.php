<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::guard('customer')->check()){
            return redirect()->route('home.register')->with('error', 'Đăng ký để tham gia Dotiva Affiliate');
        }

        if(Auth::guard('customer')->user()->is_aff != 1){
            return redirect()->route('home.customer.info')->with('warning', 'Chưa tham gia Dotiva Affiliate, vui lòng gửi yêu cầu tham gia');
        }
        return $next($request);
    }
}
