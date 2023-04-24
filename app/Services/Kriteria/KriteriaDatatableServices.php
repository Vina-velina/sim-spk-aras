<?php

namespace App\Services\Kriteria;

use App\Helpers\FormatDateToIndonesia;
use App\Models\KriteriaPenilaian;
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
                $element .= '<form id="delete-'.$item->id.'" action="'.route('admin.master-data.kriteria.delete', [$item->id_periode, $item->id]).'" method="POST"> ';
                $element .= csrf_field();
                $element .= method_field('DELETE');
                $element .= '<div class="btn-icon-list">';
                $element .= '<a href="'.route('admin.master-data.kriteria.edit', [$item->id_periode, $item->id]).'" class="btn btn-sm btn-warning btn-icon mr-2" id=""><i class="typcn text-white typcn-edit"></i></a>';
                $element .= '<button type="button" onclick ="alertConfirm(this)" data-id ="'.$item->id.'" class="btn btn-sm btn-danger btn-icon">
                                <i class="typcn typcn-trash text-white"></i>
                            </button>';
                $element .= '</div>';
                $element .= '</form>';

                return $element;
            })
            ->addColumn('nama_kriteria', function ($item) {
                return $item->masterKriteriaPenilaian->nama_kriteria;
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 'aktif') {
                    $query = 'on';
                } else {
                    $query = ' ';
                }
                $toggle = '';
                $toggle .= '<div class="main-toggle-group-demo">';
                $toggle .= '<div class="main-toggle '.$query.'" onclick="changeStatusKriteria(this)" data-url_update="'.route('admin.master-data.kriteria.update.status', [$item->id_periode, $item->id]).'">';
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
            ->addColumn('action', function ($subKriteria) use ($request) {
                $element = '';
                $element .= '<form id="delete-'.$subKriteria->id.'" action="'.route('admin.master-data.sub-kriteria.delete', [$request->id_periode, $request->id_kriteria, $subKriteria->id]).'" method="POST"> ';
                $element .= csrf_field();
                $element .= method_field('DELETE');
                $element .= '<div class="btn-icon-list">';
                $element .= '<a href="'.route('admin.master-data.sub-kriteria.edit', [$request->id_periode, $request->id_kriteria, $subKriteria->id]).'" class="btn btn-sm btn-warning btn-icon mr-2" id=""><i class="typcn text-white typcn-edit"></i></a>';
                $element .= '<button type="button" onclick ="alertConfirm(this)" data-id ="'.$subKriteria->id.'" class="btn btn-sm btn-danger btn-icon">
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
}
