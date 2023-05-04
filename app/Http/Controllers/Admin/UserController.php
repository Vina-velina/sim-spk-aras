<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Services\User\UserCommandServices;
use App\Services\User\UserDatatableServices;
use App\Services\User\UserQueryServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $userQueryServices;

    protected $userCommandServices;

    protected $userDatatableServices;

    public function __construct(
        UserQueryServices $userQueryServices,
        UserDatatableServices $userDatatableServices,
        UserCommandServices $userCommandServices
    ) {
        $this->userQueryServices = $userQueryServices;
        $this->userDatatableServices = $userDatatableServices;
        $this->userCommandServices = $userCommandServices;
    }

    public function index()
    {
        return view('admin.pages.master-data.user.index');
    }

    public function create()
    {
        return view('admin.pages.master-data.user.create');
    }

    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->userCommandServices->store($request);
            DB::commit();

            return redirect()->route('admin.master-data.user.index')->with('success', 'Berhasil menambahkan data user');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();

            return redirect()->route('admin.master-data.user.index')->with('error', 'Gagal menambahkan data user');
        }
    }

    public function edit(string $id)
    {
        $user = $this->userQueryServices->findById($id);

        return view('admin.pages.master-data.user.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $this->userCommandServices->update($request, $id);
            DB::commit();

            return redirect()->route('admin.master-data.user.index')->with('success', 'Berhasil mengubah data user');
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->route('admin.master-data.user.index')->with('error', 'Gagal mengubah data user');
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $this->userCommandServices->destroy($id);
            DB::commit();

            return redirect()->route('admin.master-data.user.index')->with('success', 'Berhasil menghapus data user');
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->route('admin.master-data.user.index')->with('error', 'Gagal menghapus data user');
        }
    }

    public function datatable(Request $request)
    {
        return $this->userDatatableServices->datatable($request);
    }
}
