<?php

namespace App\Services\Debitur;

use App\Models\Debitur;
use App\Models\KriteriaPenilaian;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DebiturDatatableServices
{
    public function datatable(Request $request)
    {
        $query = Debitur::query();

        if (isset($request->is_aktif)) {
            if ($request->is_aktif != 'semua') {
                $query->where('status', $request->is_aktif);
            }
        }

        if (isset($request->id_periode)) {
            $query->whereIn('id', function ($subquery) use ($request) {
                $subquery->select('id_debitur')
                    ->from('user_periodes')
                    ->where('id_periode', $request->id_periode);
            });
        }

        $query->orderBy('updated_at', 'DESC');

        return DataTables::of($query->get())
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                // Berfungsi untuk menampilkan kolom aksi di data debitur
                $element = '';
                $element .= '<form id="delete-'.$item->id.'" action="'.route('admin.master-data.debitur.delete', $item->id).'" method="POST"> ';
                $element .= csrf_field();
                $element .= method_field('DELETE');
                $element .= '<div class="btn-icon-list">';
                // Ini berfungsi untuk menampilkan modal detail
                $element .= '<a data-url_detail='.route('admin.master-data.debitur.detail', $item->id).' onclick="detailDebitur(this)" class="btn btn-info btn-sm btn-icon mr-2" style="color:white"><i class="typcn typcn-eye"></i></a>';
                // Ini berfungsi untuk menampilkan modal update
                $element .= '<a href="'.route('admin.master-data.debitur.edit', $item->id).'" class="btn btn-sm btn-warning btn-icon mr-2" id=""><i class="typcn text-white typcn-edit"></i></a>';
                // Berfungsi untuk mensubmit delete form
                $element .= '<button type="button" onclick ="alertConfirm(this)" data-id ="'.$item->id.'" class="btn btn-sm btn-danger btn-icon">
                                <i class="typcn typcn-trash text-white"></i>
                            </button>';
                $element .= '</div>';
                $element .= '</form>';

                return $element;
            })
            ->addColumn('action_penilaian', function ($item) use ($request) {
                // Ini berfungs untuk menampilkan kolom aksi di penialaian
                $element = '';

                $element .= '<div class="btn-icon-list">';

                if (isset($request->id_periode)) {
                    $status = 'edit';
                    $kriteria_periode = KriteriaPenilaian::where('id_periode', $request->id_periode)->where('status', 'aktif')->get();
                    foreach ($kriteria_periode as $kriteria) {
                        $find = Penilaian::where('id_periode', $request->id_periode)->where('id_debitur', $item->id)->where('id_kriteria', $kriteria->id)->first();
                        if (! isset($find)) {
                            $status = 'create';
                            break;
                        }
                    }

                    if ($status == 'edit') {
                        $element .= '<a href="'.route('admin.penilaian.detail-penilaian.add-penilaian', [$request->id_periode, $item->id]).'" class="btn btn-sm btn-warning btn-icon mr-2" ><i class="typcn text-white typcn-edit"></i></a>';
                    } else {
                        $element .= '<a href="'.route('admin.penilaian.detail-penilaian.add-penilaian', [$request->id_periode, $item->id]).'" class="btn btn-sm btn-primary btn-icon mr-2" id="add-nilai-alternatif-'.$item->id.'"><i class="typcn typcn-plus"></i></a>';
                    }
                }

                $element .= '</div>';

                return $element;
            })
            ->addColumn('status', function ($item) {
                // Menampilkan kolom status
                if ($item->status == 'aktif') {
                    $query = 'on';
                } else {
                    $query = ' ';
                }
                $toggle = '';
                $toggle .= '<div class="main-toggle-group-demo">';
                $toggle .= '<div class="main-toggle '.$query.'" onclick="changeStatusDebitur(this)" data-url_update="'.route('admin.master-data.debitur.update.status', $item->id).'">';
                $toggle .= '<span></span>';
                $toggle .= '</div>';
                $toggle .= '</div>';

                return $toggle;
            })
            ->rawColumns(['action', 'status', 'action_penilaian'])
            ->make(true);
    }
}
