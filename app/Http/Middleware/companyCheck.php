<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class companyCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        if ($request->user() != NULL):

            if ($request->user()->type != '1') {

              $request->session()->flash('alert-danger', 'Não tens permissão de estar na página requisitada.');
              return redirect()->back();

            } elseif ($request->user()->type == '1' && $request->user()->first_login == '1' && \Route::currentRouteName() != 'profile.user.company' && \Route::currentRouteName() != 'password.user.company') {
                $request->session()->flash('alert-danger', 'Primeiro deves alterar a sua senha de acesso.');
                return redirect()->route('profile.user.company', $request->user()->id);
            }

        endif;

        return $next($request);
    }
}
