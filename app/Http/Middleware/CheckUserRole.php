<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $roles = array_slice(func_get_args(), 2); // [worker, admin, accountant]

        $user = \Auth::user();

        if (!$user) {
            return redirect()->to('/login');
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        return redirect()->to('/');
    }
}
