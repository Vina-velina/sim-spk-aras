<?php

namespace App\Services\HasilRekapan;

use App\Models\DebiturTerpilih;
use App\Models\RekomendasiDebitur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HasilRekapanDatatableService
{
    public function datatableRekomendasi(Request $request)
    {
        $query = RekomendasiDebitur::query();

        if (isset($request->id_periode)) {
            $query->where('id_periode', $request->id_periode);
        }

        $query->orderBy('nilai_aras', 'DESC');

        return DataTables::of($query->get())
            ->addColumn('nama_debitur', function ($item) {
                return $item->debitur->nama;
            })
            ->addColumn('alamat_debitur', function ($item) {
                return $item->debitur->alamat;
            })
            ->make(true);
    }

    public function datatableTerpilih(Request $request)
    {
        $query = DebiturTerpilih::query();

        if (isset($request->id_periode)) {
            $query->where('id_periode', $request->id_periode);
        }

        $query->orderBy('nilai_aras', 'DESC');

        return DataTables::of($query->get())
            ->addIndexColumn()
            ->addColumn('nama_debitur', function ($item) {
                return $item->debitur->nama;
            })
            ->addColumn('alamat_debitur', function ($item) {
                return $item->debitur->alamat;
            })
            ->addColumn('action', function ($item) use ($request) {
                $element = '';
                if (Auth::user()->role_user == 'super_admin') {
                    if ($item->status != 'publish') {
                        $element .= '<form id="delete-'.$item->id.'" action="'.route('admin.rekapan-spk.detail.delete-terpilih', [$request->id_periode, $item->id]).'" method="POST"> ';
                        $element .= csrf_field();
                        $element .= method_field('DELETE');
                        $element .= '<div class="btn-icon-list">';
                        $element .= '<button type="button" onclick ="alertConfirm(this)" data-id ="'.$item->id.'" class="btn btn-sm btn-danger btn-icon">
                                <i class="typcn typcn-trash text-white"></i>
                            </button>';
                        $element .= '</div>';
                        $element .= '</form>';
                    } else {
                        $element .= '--';
                    }
                } else {
                    $element .= '--';
                }

                return $element;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
