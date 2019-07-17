<?php

namespace App\Http\Middleware;

use Closure;

class Timeupdate
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
        // 业务逻辑
        // 9点到17点可以访问
        $a = '9:00:00';
        $b = '17:00:00';
        // 转化为时间戳
        $c = strtotime($a);
        $d = strtotime($b);

        if (time() >= $d || time() <=$c){
            echo ("<script>alert('请在9:00-17:00之内修改');location='/admin/list'</script>");
        }
        return $next($request);
    }
}
