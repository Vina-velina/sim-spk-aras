<?php

namespace App\Services\Periode;

use App\Helpers\FormatDateToIndonesia;
use App\Models\Periode;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PeriodeDatatableServices
{
    public function datatable(Request $request)
    {
        $query = Periode::query();

        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addColumn('action', function ($item) {
                $element = '';
                $element .= '<form id="delete-' . $item->id . '" action="' . route('admin.master-data.periode.delete', $item->id) . '" method="POST"> ';
                $element .= csrf_field();
                $element .= method_field('DELETE');
                $element .= '<div class="btn-icon-list">';
                $element .= '<a data-url_detail=' . route('admin.master-data.periode.detail', $item->id) . ' onclick="detailPeriode(this)" class="btn btn-info btn-sm btn-icon mr-2" style="color:white"><i class="typcn typcn-eye"></i></a>';
                $element .= '<a href="' . route('admin.master-data.periode.edit', $item->id) . '" class="btn btn-sm btn-warning btn-icon mr-2" id=""><i class="typcn text-white typcn-edit"></i></a>';
                $element .= '<button type="button" onclick ="alertConfirm(this)" data-id ="' . $item->id . '" class="btn btn-sm btn-danger btn-icon">
                            <i class="typcn typcn-trash text-white"></i>
                        </button>';
                $element .= '</div>';
                $element .= '</form>';

                return $element;
            })
            ->addColumn('action_penilaian', function ($item) {
                $element = '';
                $element .= '<div class="btn-icon-list">';
                $element .= '<a href="' . route('admin.penilaian.detail-penilaian', $item->id) . '" class="btn btn-sm btn-info btn-icon mr-2" id=""><i class="typcn text-white typcn-eye"></i></a>';
                $element .= '</div>';

                return $element;
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 'aktif') {
                    $query = 'on';
                } else {
                    $query = ' ';
                }
                $toggle = '';
                $toggle .= '<div class="main-toggle-group-demo">';
                $toggle .= '<div class="main-toggle ' . $query . '" onclick="changeStatusPeriode(this)" data-url_update="' . route('admin.master-data.periode.update.status', $item->id) . '">';
                $toggle .= '<span></span>';
                $toggle .= '</div>';
                $toggle .= '</div>';

                return $toggle;
            })
            ->addColumn('tgl_penilaian', function ($item) {
                $element = FormatDateToIndonesia::getIndonesiaDate($item->tgl_awal_penilaian) . ' s/d ' . FormatDateToIndonesia::getIndonesiaDate($item->tgl_akhir_penilaian);
                return $element;
            })
            ->addColumn('tgl_awal_penilaian', function ($item) {
                return FormatDateToIndonesia::getIndonesiaDate($item->tgl_awal_penilaian);
            })
            ->addColumn('tgl_akhir_penilaian', function ($item) {
                return FormatDateToIndonesia::getIndonesiaDate($item->tgl_akhir_penilaian);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'action_penilaian'])
            ->make(true);
    }
}