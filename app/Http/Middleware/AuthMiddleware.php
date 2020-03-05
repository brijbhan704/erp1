<?php

namespace App\Http\Middleware;
use Illuminate\Http\Response;
use Closure;
use Auth; 

class AuthMiddleware
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
        $userRole = Auth::user()->getRoleNames();
        //echo $userRole; die;
        if($userRole[0] === 'User')
        {   //echo '3'; die;
            return new Response(view('unauthorized'));
        }
        return $next($request);
    }
}
