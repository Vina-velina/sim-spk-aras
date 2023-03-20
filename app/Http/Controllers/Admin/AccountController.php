<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountPasswordRequest;
use App\Http\Requests\Account\AccountUpdateRequest;
use App\Services\Account\AccountCommandServices;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    protected $accountCommandServices;

    public function __construct(AccountCommandServices $accountCommandServices)
    {
        $this->accountCommandServices = $accountCommandServices;
    }

    public function index()
    {
        return view('admin.pages.account.index');
    }

    public function update(AccountUpdateRequest $request)
    {
        try {
            $this->accountCommandServices->update($request);
            return redirect()->route('admin.account.index')->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('admin.account.index')->with('error', 'Data gagal diperbarui');
        }
    }

    public function editPassword()
    {
        return view('admin.pages.account.change_password');
    }

    public function updatePassword(AccountPasswordRequest $request)
    {
        try {
            if (password_verify($request->password, Auth::user()->password)) {
                if (!password_verify($request->password_baru, Auth::user()->password)) {
                    $this->accountCommandServices->updatePassword($request);
                    return redirect()->route('admin.home')->with('success', 'Data berhasil diperbarui');
                } else {
                    return redirect()->route('admin.account.change-password')->with('error', 'Password baru tidak boleh sama dengan password lama');
                }
            } else {
                return redirect()->route('admin.account.change-password')->with('error', 'Password lama tidak sesuai');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.account.change-password')->with('error', 'Data gagal diperbarui');
        }
    }
}
