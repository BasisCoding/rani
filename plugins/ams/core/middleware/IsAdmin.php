<?php namespace Ams\Core\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

use Ams\User\Models\User as UserModels;

class IsAdmin
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
        $user = \Session::get('userLogin');
        $user = UserModels::find($user);

        if(!$user->is_admin) {
            return \Redirect::to('dashboard');
        }

        return $next($request);
    }
}
