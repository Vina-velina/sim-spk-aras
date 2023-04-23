<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserDatatableServices
{
    public function datatable(Request $request)
    {
        $query = User::query();

        $query->orderBy('updated_at', 'DESC');

        return DataTables::of($query->get())
            ->addIndexColumn()
            ->addColumn('action', function ($item) {
                $element = '';
                $element .= '<form id="delete-' . $item->id . '" action="' . route('admin.master-data.user.delete', $item->id) . '" method="POST"> ';
                $element .= csrf_field();
                $element .= method_field('DELETE');
                $element .= '<div class="btn-icon-list">';
                $element .= '<a href="' . route('admin.master-data.user.edit', $item->id) . '" class="btn btn-sm btn-warning btn-icon mr-2" id=""><i class="typcn text-white typcn-edit"></i></a>';
                $element .= '<button type="button" onclick ="alertConfirm(this)" data-id ="' . $item->id . '" class="btn btn-sm btn-danger btn-icon">
                                <i class="typcn typcn-trash text-white"></i>
                            </button>';
                $element .= '</div>';
                $element .= '</form>';

                return $element;
            })
            ->addColumn('role', function ($item) {
                $element = '';
                if ($item->role_user == 'super_admin') {
                    $element .= '<span class="badge badge-pill badge-success">Super Admin</span>';
                } elseif ($item->role_user == 'admin') {
                    $element .= '<span class="badge badge-pill badge-primary">Admin</span>';
                } else {
                    $element .= '<span class="badge badge-pill badge-secondary">Tidak Diketahui</span>';
                }

                return $element;
            })
            ->addColumn('profil', function ($item) {

                $element = '';
                if (isset($item->foto_profil)) {
                    $element .= '<img style="width:40px; height:40px; object-fit: cover; object-position: center;" src="' . asset('storage/foto-user/' . $item->foto_profil) . '" alt="Foto User" style="object-fit: cover;height: 200px;width: 200px;" class="rounded-circle" id="fotoUser">';
                } else {
                    $element .= '<img style="width:40px; height:40px; object-fit: cover; object-position: center;" src="https://ui-avatars.com/api/?name=' . $item->name . '&background=5174ff&color=fff" alt="Foto User" style="object-fit: cover;height: 200px;width: 200px;" class="rounded-circle" id="fotoUser">';
                }

                return $element;
            })
            ->rawColumns(['action', 'role', 'profil'])
            ->make(true);
    }
}
