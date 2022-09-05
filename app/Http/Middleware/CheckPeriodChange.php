<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckPeriodChange
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
        $hoje = date('Y-m-d');                     

        if (auth()->user()->roles[0]->data_inicio <= $hoje and auth()->user()->roles[0]->data_fim >= $hoje || auth()->user()->roles[0]->id == 1) {            
            return $next($request);
        }
        
        return response()->json(['Erro' => true, 'errors' => ['Autorização'=> ['Você não está no periodo de edição']]], 401);
    }
}
