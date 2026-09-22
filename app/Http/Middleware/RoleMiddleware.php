<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *  @param \Closure $next
     *  @param mixed ...$roles
     */
  public function handle(Request $request, Closure $next, ...$roles): Response
    {
        //cek user jika belum login
        if(!$request->user()) {
            return redirect()->route('login')
            ->witherrors ([
                'auth' => 'silahkan login terlebih dahulu.'
        ]);
            }

            // ambil role user
        $userRole = $request->user()->role->name ?? null;

        //jika role user tidalk sesuai route yang diminta
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
