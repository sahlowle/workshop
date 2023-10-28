<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
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
    // available language in template array
    $availLocale = ['en','de'];
    $session_locale = session()->get('locale');

    if ($request->is('api/*')) {
      session()->put('locale', 'en');
      app()->setLocale('en');
    }
    else if(session()->has('locale') && in_array($session_locale,$availLocale)){
      app()->setLocale($session_locale);
    }

    return $next($request);
  }
}
