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
    $lang_locale = $request->lang;



    // Locale is enabled and allowed to be change
    if (session()->has('locale') && in_array($session_locale,$availLocale)) {
      // Set the Laravel locale
      app()->setLocale($session_locale);
    } 
    else if($request->filled('lang') && in_array($lang_locale,$availLocale)) {
      // Set the Laravel locale
      app()->setLocale($lang_locale);
    }
    return $next($request);
  }
}
