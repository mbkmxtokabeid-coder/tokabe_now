<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('lang') && in_array($request->get('lang'), ['id', 'en'])) {
            $lang = $request->get('lang');
            session()->put('locale', $lang);
            app()->setLocale($lang);
        } elseif (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        } elseif ($request->cookie('locale') && in_array($request->cookie('locale'), ['id', 'en'])) {
            app()->setLocale($request->cookie('locale'));
        } elseif ($request->cookie('lang') && in_array($request->cookie('lang'), ['id', 'en'])) {
            app()->setLocale($request->cookie('lang'));
        } else {
            app()->setLocale('id'); // Default to Indonesian
        }

        return $next($request);
    }
}
