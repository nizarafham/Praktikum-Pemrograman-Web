<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    $user = $request->session()->get('user');

    if (!isset($user['is_login']) || !$user['is_login']) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    return $next($request);
}

}
