<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MA_login;

class User_session
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
        if(! $request->session()->has('user.id')) {
            return Redirect("/"); 
        }
        $data = MA_login::where("id", $request->session()->get('user.id'))->first();
        if(! $data)
        {
            $request->session()->flush();
            return Redirect("/");
            
        }
        return $next($request);
    }
}
