<?php

namespace App\Http\Middleware;

use Closure;

class LevelControl
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
        //用户如果没有登录，那么$request中就不会有user(),所以$user会为null,
        //如果用户登录了，我们就可以拿到user()的信息。
        $user = $request->user();

        if($user &&$user->name == 'Zhuang RuiYong' )
        {
            return $next($request);
        }
        dd('权限不足');
    }
}
