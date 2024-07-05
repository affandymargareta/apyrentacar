<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

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

            if (in_array('auth:admin', $request->route()->middleware())) {

                return redirect(route('admin.login'))->with(['success' => 'Product Baru Ditambahkan']);

            } elseif (in_array('auth:seller', $request->route()->middleware())){

                return redirect(route('members.login'))->with(['success' => 'Product Baru Ditambahkan']);

            } else {
                    return redirect(route('login'))->with(['success' => 'Product Baru Ditambahkan']);
            }


            return route('login');
        }
    }
}
