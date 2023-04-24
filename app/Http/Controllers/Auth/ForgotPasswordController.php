<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthForgotPasswordEmailRequest;
use App\Http\Requests\Auth\AuthResetPasswordRequest;
use App\Services\ApiNotification\ApiNotificationMessageServices;
use App\Services\User\UserQueryServices;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected $apiNotificationMessageServices;

    protected $userQueryServices;

    public function __construct(
        ApiNotificationMessageServices $apiNotificationMessageServices,
        UserQueryServices $userQueryServices,
    ) {
        $this->apiNotificationMessageServices = $apiNotificationMessageServices;
        $this->userQueryServices = $userQueryServices;
    }

    public function forgetPasswordStore(AuthForgotPasswordEmailRequest $request)
    {
        try {
            DB::beginTransaction();
            $find = $this->userQueryServices->findByEmail($request->email);
            if (! empty($find)) {
                $link = $this->apiNotificationMessageServices->generateLinkResetPassword($find->email);
                if (! $link) {
                    return redirect()->back()->with('error', 'Gagal Generate Link Ganti Kata Sandi');
                }
                $send_email = $this->apiNotificationMessageServices->resetPasswordByEmail($find->email, $find->name, $link);
                if ($send_email) {
                    DB::commit();

                    return to_route('login')->with('success', 'Email untuk reset kata sandi dikirim');
                }
                DB::rollBack();

                return redirect()->back()->with('error', 'Pengiriman Email Gagal Dilakukan');
            }
            DB::rollBack();

            return redirect()->back()->with('error', 'Akun dengan Email tersebut tidak ditemukan');
        } catch (Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function forgetPasswordEmailView()
    {
        return view('auth.passwords.email');
    }

    public function resetPassword(Request $request, $token)
    {
        if (! empty($token) && ! empty($request->email)) {
            $reset = DB::table('password_resets')->where('token', $token)->where('email', $request->email)->first();
            if (! empty($reset)) {
                $expired = Carbon::parse($reset->created_at)->addMinutes(30)->format('Y-m-d H:i:s');
                $now = Carbon::now()->format('Y-m-d H:i:s');
                if ($now >= $expired) {
                    DB::table('password_resets')->where('email', $request->email)->delete();

                    return redirect(route('login'))->with('error', 'Link telah kedaluwarsa');
                }

                return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
            }

            return redirect(route('login'))->with('error', 'Permintaan Reset Kata Sandi dengan Email tersebut tidak ditemukan');
        }

        return abort(403, 'Invalid Signature');
    }

    public function resetPasswordStore(AuthResetPasswordRequest $request)
    {
        try {
            $find = $this->userQueryServices->findByEmail($request->email);
            $resetPassword = $this->apiNotificationMessageServices->updateNewPassword($request->token, $find->email, $request->password);
            if ($resetPassword == 200) {
                return redirect(route('login'))->with('success', 'Kata Sandi Berhasil diperbaharui');
            } elseif ($resetPassword == 400) {
                return redirect(route('login'))->with('error', 'Permintaan Ganti Kata Sandi dengan Email tersebut tidak ditemukan');
            } elseif ($resetPassword == 401) {
                return redirect(route('login'))->with('error', 'Link telah kedaluwarsa');
            } else {
                return redirect()->back()->with('error', 'Terjadi Kesalahan');
            }
        } catch (Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
