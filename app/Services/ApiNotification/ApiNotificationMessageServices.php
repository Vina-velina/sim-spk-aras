<?php

namespace App\Services\ApiNotification;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Throwable;
use DeyanArdi\GanadevNotif\GanadevApi;

/**
 * Created by Deyan Ardi 2022.
 * API Services Message connect to http://sv1.notif.ganadev.com.
 */
class ApiNotificationMessageServices
{

    // Write message and send message here
    public function generateLinkResetPassword(string $email)
    {
        DB::beginTransaction();
        try {
            $token = Uuid::uuid6()->toString();
            DB::table('password_resets')->where('email', $email)->delete();
            $link = url(route('reset.password.getEmail', ['token' => $token, 'email' => $email]));
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
            DB::commit();

            return $link;
        } catch (Throwable $th) {
            DB::rollBack();

            return false;
        }
    }

    public function resetPasswordByEmail(string $email, string $name, string $link)
    {
        $judul = 'Reset Password Notification';
        $message = view('emails.securityResetPassword', compact('link', 'name'))->render();
        $send_email = GanadevApi::sendMailMessage($email, $judul, $message);
        if ($send_email['status'] != 200) {
            return false;
        }

        return true;
    }

    public function updateNewPassword(string $token, string $email, string $password)
    {
        DB::beginTransaction();
        try {
            $reset = DB::table('password_resets')->where('token', $token)->where('email', $email)->first();
            if (!empty($reset)) {
                $expired = Carbon::parse($reset->created_at)->addMinutes(30)->format('Y-m-d H:i:s');
                $now = Carbon::now()->format('Y-m-d H:i:s');
                if ($now <= $expired) {
                    $update = User::where('email', $email)->update(['password' => Hash::make($password)]);
                    DB::table('password_resets')->where(['email' => $email])->delete();
                    DB::commit();

                    return 200;
                }
                DB::rollBack();

                return 401;
            }
            DB::rollBack();

            return 400;
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th);

            return 500;
        }
    }
}
