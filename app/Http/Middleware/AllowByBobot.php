<?php

namespace App\Http\Middleware;

use App\Models\KriteriaPenilaian;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllowByBobot
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
            $check = KriteriaPenilaian::where('id_periode', $id_periode)->where('status', 'aktif')->get();
            $total_bobot = $check->sum('bobot_kriteria');
            if ($total_bobot == 100) {
                return $next($request);
            }

            return to_route('admin.penilaian.index')->with('error', 'Total Bobot Kriteria Pada Kriteria Periode Ini Belum Mencapai 100%, Harap Ubah Di Pengaturan Terlebih Dahulu');
        }
    }
}
