<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->user_role == "admin") {
            if(Auth::user()->user_role == 'admin' || Auth::user()->user_role == 'staff') {
                return $next($request);
            }else{
                return redirect()->route('index');
            }
        }
        else{
            session(['link' => url()->current()]);
            return redirect()->route('login');
        }

        return $next($request);
    }
}
