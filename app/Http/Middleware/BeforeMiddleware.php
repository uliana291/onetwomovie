<?php namespace App\Http\Middleware;

use App\Helper;
use Closure;
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
        $url = $request->path();
        view()->share('url', $url);
        return $next($request);

    }
}