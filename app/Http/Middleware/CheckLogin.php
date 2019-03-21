<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty($_COOKIE['xnn_token']) || empty($_COOKIE['xnn_uid'])){
            echo '请先登录';exit;
        }
        $token = $_COOKIE['xnn_token'];
        $key = 'token:' . $_COOKIE['xnn_uid'];
        $r_token = Redis::get($key);
        if($r_token != $token){
            echo 'token无效';exit;
        }
        return $next($request);
    }
}
