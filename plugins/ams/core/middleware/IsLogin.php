<?php namespace Ams\Core\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class IsLogin
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
        if(!\Session::get('userLogin')) {
            return \Redirect::to('/?callback='.$request->url());
        }

        return $next($request);
    }
}
