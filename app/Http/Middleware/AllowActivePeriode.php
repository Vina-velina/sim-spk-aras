<?php

namespace App\Http\Middleware;

use App\Models\Periode;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllowActivePeriode
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
        if (Auth::check()) {
            $id_periode = $request->route('id_periode');
            $check = Periode::where('id', $id_periode)->where('status', 'aktif')->first();
            if ($check) {
                return $next($request);
            }

            return abort(404);
        }
    }
}
