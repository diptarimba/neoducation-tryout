<?php

namespace App\Http\Middleware;

use App\Models\RoleHome;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $roleHome = Cache::remember('role-home', now()->addHours(24), function () {
            $dataRaw = RoleHome::get();
            $data = $dataRaw->pluck('home', 'name')->toArray();
            return $data;
        });
        $auth = Auth()->user()->getRoleNames()[0] ?? null;

        if ($auth) {
            return redirect()->route($roleHome[$auth]);
        }

        return $next($request);
    }
}
