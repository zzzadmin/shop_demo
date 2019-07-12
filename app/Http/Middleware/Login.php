<?php

namespace App\Http\Middleware;

use Closure;
class Login
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
        // 前置
        // echo 111;
        $result = $request->session()->has('username');
        // dd($result);
        if($result){
            echo "登陆成功！";
        }

        $response = $next($request);
        // 后置
        echo 2222;
        return $response;
        // return $next($request);
    }
}
