<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountPasswordRequest;
use App\Http\Requests\Account\AccountUpdateRequest;
use App\Services\Account\AccountCommandServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    protected $accountCommandServices;

    public function __construct(AccountCommandServices $accountCommandServices)
    {
        $this->accountCommandServices = $accountCommandServices;
    }

    public function editProfil()
    {
        return view('admin.pages.account.index');
    }

    public function updateProfil(AccountUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->accountCommandServices->update($request);
            DB::commit();

            return to_route('admin.account.index')->with('success', 'Data Berhasil Diperbaharui');
        } catch (\Throwable $th) {
            DB::rollBack();

            return to_route('admin.account.index')->with('error', $th->getMessage());
        }
    }

    public function editPassword()
    {
        return view('admin.pages.account.change_password');
    }

    public function updatePassword(AccountPasswordRequest $request)
    {
        try {
            if (isset($request->password_baru)) {
                if (Hash::check($request->password, Auth::user()->password)) {
                    if (! Hash::check($request->password_baru, Auth::user()->password)) {
                        DB::beginTransaction();
                        $this->accountCommandServices->updatePassword($request);
                        DB::commit();

                        return to_route('admin.home')->with('success', 'Data Berhasil Diperbaharui');
                    } else {
                        return to_route('admin.account.change-password')->with('error', 'Password Baru Tidak Boleh Sama Dengan Password Lama');
                    }
                } else {
                    return to_route('admin.account.change-password')->with('error', 'Password Lama Tidak Sesuai');
                }
            } else {
                return to_route('admin.account.change-password')->with('success', 'Tidak Ada Data Yang Diperbaharui');
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            return to_route('admin.account.change-password')->with('error', $th->getMessage());
        }
    }
}
