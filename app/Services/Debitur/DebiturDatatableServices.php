<?php

namespace App\Services\Debitur;

use App\Models\Debitur;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DebiturDatatableServices
{
    public function datatable(Request $request)
    {
        $query = Debitur::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $element = '';
                $element .= '<form id="delete" action="'.route('admin.master-data.debitur.delete', $item->id).'" method="POST"> ';
                $element .= csrf_field();
                $element .= method_field('DELETE');
                $element .= '<div class="btn-icon-list">';
                $element .= '<a data-id='.$item->id.' class="btn btn-indigo btn-icon mr-2" style="color:white"><i class="fa fa-eye"></i></a>';
                $element .= '<a href="'.route('admin.master-data.debitur.edit', $item->id).'" class="btn btn-warning btn-icon mr-2" id=""><i class="fa fa-edit"></i></a>';
                $element .= '<button type="submit" class="btn btn-danger btn-icon">
                                <i class="fa fa-trash"></i>
                            </button>';
                $element .= '</div>';
                $element .= '</form>';

                return $element;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
