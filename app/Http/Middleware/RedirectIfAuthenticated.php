<?php
namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request [the current request instance]
     * @param \Closure                 $next    [closure instance]
     * @param string|null              $guard   [optional guard name]
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
        case 'admin':
            if (Auth::guard($guard)->check()) {
                return redirect()->route('admin.dashboard');
            }

            break;

        default:
            if (Auth::guard($guard)->check()) {
                return redirect()->route('user.dashboard');
            }

            break;
        }

        return $next($request);
    }
}
