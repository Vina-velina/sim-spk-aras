<?php

namespace App\Services\Kriteria;

use App\Helpers\FormatDateToIndonesia;
use App\Models\KriteriaPenilaian;
use App\Models\Periode;
use App\Models\SubKriteriaPenilaian;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KriteriaDatatableServices
{
    public function datatable(Request $request)
    {
        $query = KriteriaPenilaian::query();

        if (isset($request->id_periode)) {
            $query->where('id_periode', $request->id_periode);
        }

        $query->orderBy('updated_at', 'DESC');

        return DataTables::of($query->get())
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $element = '';
                $element .= '<form id="delete-' . $item->id . '" action="' . route('admin.master-data.kriteria.delete', [$item->id_periode, $item->id]) . '" method="POST"> ';
                $element .= csrf_field();
                $element .= method_field('DELETE');
                $element .= '<div class="btn-icon-list">';
                $element .= '<a href="' . route('admin.master-data.kriteria.edit', [$item->id_periode, $item->id]) . '" class="btn btn-sm btn-warning btn-icon mr-2" id=""><i class="typcn text-white typcn-edit"></i></a>';
                $element .= '<button type="button" onclick ="alertConfirm(this)" data-id ="' . $item->id . '" class="btn btn-sm btn-danger btn-icon">
                                <i class="typcn typcn-trash text-white"></i>
                            </button>';
                $element .= '</div>';
                $element .= '</form>';

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
                $toggle .= '<div class="main-toggle ' . $query . '" onclick="changeStatusKriteria(this)" data-url_update="' . route('admin.master-data.kriteria.update.status', $item->id) . '">';
                $toggle .= '<span></span>';
                $toggle .= '</div>';
                $toggle .= '</div>';

                return $toggle;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function sub_datatable(Request $request)
    {
        $query = SubKriteriaPenilaian::query()->with('kriteriaPenilaian');

        if (isset($request->id_kriteria)) {
            $query->where('id_kriteria', $request->id_kriteria);
        }

        $query->orderBy('updated_at', 'DESC');

        return DataTables::of($query->get())
            ->addIndexColumn()
            ->addColumn('action', function ($subKriteria) {
                $element = '';
                $element .= '<form id="delete-' . $subKriteria->id . '" action="' . route('admin.master-data.sub-kriteria.delete', [$subKriteria->kriteriaPenilaian->id_periode, $subKriteria->id]) . '" method="POST"> ';
                $element .= csrf_field();
                $element .= method_field('DELETE');
                $element .= '<div class="btn-icon-list">';
                $element .= '<a href="' . route('admin.master-data.sub-kriteria.edit', [$subKriteria->kriteriaPenilaian->id, $subKriteria->id]) . '" class="btn btn-sm btn-warning btn-icon mr-2" id=""><i class="typcn text-white typcn-edit"></i></a>';
                $element .= '<button type="button" onclick ="alertConfirm(this)" data-id ="' . $subKriteria->id . '" class="btn btn-sm btn-danger btn-icon">
                            <i class="typcn typcn-trash text-white"></i>
                        </button>';
                $element .= '</div>';
                $element .= '</form>';

                return $element;
            })
            ->addColumn('created_at', function ($subKriteria) {
                return FormatDateToIndonesia::getIndonesiaDate($subKriteria->created_at);
                // return $subKriteria;
            })
            ->make(true);
    }

    public function periodeDataTable(Request $request)
    {
        $query = Periode::query();

        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        $query->orderBy('updated_at', 'DESC');

        return DataTables::of($query->get())
            ->addColumn('action', function ($item) {
                $element = '';
                $element .= '<div class="btn-icon-list">';
                $element .= '<a href="' . route('admin.master-data.kriteria.kriteria', $item->id) . '" class="btn btn-sm btn-warning btn-icon mr-2" id=""><i class="typcn text-white typcn-edit"></i></a>';
                $element .= '</div>';

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
