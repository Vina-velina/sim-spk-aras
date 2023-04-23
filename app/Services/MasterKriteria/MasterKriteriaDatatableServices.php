<?php

namespace App\Services\MasterKriteria;

use App\Helpers\FormatDateToIndonesia;
use App\Models\MasterKriteriaPenilaian;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MasterKriteriaDatatableServices
{
    public function datatable(Request $request)
    {
        $query = MasterKriteriaPenilaian::query();

        return DataTables::of($query->get())
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $element = '';
                $element .= '<form id="delete-' . $item->id . '" action="' . route('admin.master-data.master-kategori.delete', $item->id) . '" method="POST"> ';
                $element .= csrf_field();
                $element .= method_field('DELETE');
                $element .= '<div class="btn-icon-list">';
                $element .= '<a data-url_detail=' . route('admin.master-data.master-kategori.detail', $item->id) . ' onclick="detailMasterKriteria(this)" class="btn btn-info btn-sm btn-icon mr-2" style="color:white"><i class="typcn typcn-eye"></i></a>';
                $element .= '<a href="' . route('admin.master-data.master-kategori.edit', $item->id) . '" class="btn btn-sm btn-warning btn-icon mr-2" id=""><i class="typcn text-white typcn-edit"></i></a>';
                $element .= '<button type="button" onclick ="alertConfirm(this)" data-id ="' . $item->id . '" class="btn btn-sm btn-danger btn-icon">
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
            ->addColumn('updated_at', function ($subKriteria) {
                return FormatDateToIndonesia::getIndonesiaDate($subKriteria->updated_at);
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
