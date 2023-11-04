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
    $availLocale = ['en','de'];
    $session_locale = session()->get('locale');

    if ($request->is('api/*')) {
      $locale = $request->header('Accept-Language', 'en');

      session()->put('locale', $locale);
      app()->setLocale($locale);
    }
    else if(session()->has('locale') && in_array($session_locale,$availLocale)){
      app()->setLocale($session_locale);
    }

    return $next($request);
  }
}
