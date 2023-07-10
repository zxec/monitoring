<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Status
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty(auth()->user()->status->id) || auth()->user()->status->id !== 1) {
            return redirect()->route('articles.index');
        }
        return $next($request);
    }
}
