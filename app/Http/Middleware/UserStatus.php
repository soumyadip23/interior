<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserStatus
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
        $user = Auth::user();
        $user_approve = $user->is_approve;
        $user_block = $user->is_block;
        if($user_approve == 1 && $user_block==0)
        {
            return $next($request);
        }
        elseif($user_approve==0){
            auth()->logout();
            return redirect()->back()->with('verify_error','User not approved');
        }elseif($user_block==1){
            auth()->logout();
            return redirect()->back()->with('verify_error','User is blocked');
        }
    }   
}
