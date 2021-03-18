<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
          if( substr($request->getRequestUri(), 0, 6) == "/arnet" ){
            $result = substr($request->getRequestUri(), 12, 6);
          } else {
            $result = substr($request->getRequestUri(), 0, 6);
          }
          switch ($result) {
            case '/admin':
              $login = 'admin/login';
              break;
            default:
              $login = 'login';
              break;
          }
            return route($login);
        }
    }
}
