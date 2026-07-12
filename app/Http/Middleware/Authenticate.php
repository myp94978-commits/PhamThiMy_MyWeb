<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
