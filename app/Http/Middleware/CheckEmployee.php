<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class CheckEmployee
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
        
        if (Auth::guard('employee')->check()){
            $user = Auth::guard('employee')->user();
            if ($user->is_admin) {
                return Redirect::route('admin.employees', 0);
            } else if ($user->is_division_head)
                return Redirect::route('head_employees');
        } else {
            return Redirect::route('employee.login');
        }
        return $next($request);
    }
}