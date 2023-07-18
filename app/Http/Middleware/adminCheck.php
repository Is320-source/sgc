<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminCheck
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
        // dd('test');
        if ($request->user() != NULL):
            if ($request->user()->type >= '2' ) {
              $request->session()->flash('alert-danger', 'Não tens permissão de estar na página requisitada.');
              return redirect()->back();
            } elseif ($request->user()->status != 0){
                Auth::logout();
                $request->session()->flash('alert-danger', 'Sua conta foi desactivada, entre em contacto com o gerente.');
                return redirect()->route('login');
            } elseif ($request->user()->type <= '2' && $request->user()->first_login == '1' && \Route::currentRouteName() != 'dashboard.show.user' && \Route::currentRouteName() != 'dashboard.password.user') {
                $request->session()->flash('alert-danger', 'Primeiro deves alterar a sua senha de acesso.');
                return redirect()->route('dashboard.show.user', $request->user()->id);
            }
        endif;

        return $next($request);
    }
}
