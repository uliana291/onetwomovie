<?php namespace App\Http\Middleware;

use App\Helper;
use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Support\Facades\Auth;

class BeforeMiddleware
{

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $request->user()->id;
            view()->share('unread', Helper::checkUnreadMessages($request));
        }
        view()->share('breadcrumb', 'home');
        return $next($request);

    }
}