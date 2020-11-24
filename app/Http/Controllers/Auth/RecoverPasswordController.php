<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\Email\EmailController;
use App\Models\RecoverPassword\PasswordResetToken;
use App\Models\User;
use \Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class RecoverPasswordController extends Controller
{
    /**
     * Client side request for password reset
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function RequestPasswordReset(Request $request) {
        $UserEmail = $request->input('Email');
        $UserExists = User::where('email', '=', $UserEmail)->exists();
        if($UserExists) {
            $User = User::where('email', '=', $UserEmail)->first();
            $banned = $User->IsActive === 1 ? false : true;
            if(!$banned) {
                $CreatedAt = date("Y-m-d H:i:s", time());
                $token__ = md5('C_&_F_' . $User->email . $CreatedAt);
                try {
                    PasswordResetToken::updateOrCreate(
                        ['EmailAddress' => $UserEmail],
                        ['Token' => $token__, 'CreatedAt' => $CreatedAt]
                    );
                    //
                    //
                    // Here send an email to the email address of the company user
                    // Username: $company_username
                    // Password: $new_password
                    //
                    //
                    try {
                        $APP_URL = config('app.url');
                        EmailController::AppSendEmail($UserEmail, "Password Reset Action", '<h3>Reset your account password</h3> <div>Click the link below to create a new password: <p> <a href="' . $APP_URL . '/recover/password/new/' . $token__ . '">' . $APP_URL . '/password/change/' . $token__ . '</a> </p> </div>');
                        //Successful
                        return response()->json([
                            'success' => true,
                            'message' => 'Password Reset token generated and sent to the user\'s email address!',
                        ],200);
                    } catch (Exception $e) {
                        return response()->json([
                            'success' => false,
                            'error_code' => 'MAIL_ERROR',
                            'message' => 'Failed to send email to the user! ' . $e->getMessage(),
                        ],200);
                    }
                } catch (Exception $e) {
                    return response()->json([
                        'success' => false,
                        'error_code' => 'QUERY_ERROR',
                        'message' => 'Failed to generate token for this account!' . $e->getMessage(),
                    ],200);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'error_code' => 'USER_BANNED',
                    'message' => 'You have been banned from accessing your account!',
                ],200);
            }
        } else {
            return response()->json([
                'success' => false,
                'error_code' => 'USER_NOT_FOUND',
                'message' => 'This email address doesn\'t match any account!',
            ],200);
        }
    }
    /**
     * Show the new password form page
     * @param Request $request
     * @param $Token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function NewPasswordPage(Request $request, $Token) {
        $PasswordResetToken = PasswordResetToken::where('Token', '=', $Token);
        if($PasswordResetToken->exists()) {
            return view('PasswordReset.NewPassword')->with(['PasswordResetToken' => $Token]);
        }
        return abort(401);
    }

    /**
     * Change the user password
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function UpdateUserPassword(Request $request, $Token) {
        $Password = $request->input('NewPassword');
        $Token = PasswordResetToken::where('Token', '=', $Token);
        if($Token->exists()) {
            $UserEmail = $Token->first()->EmailAddress;
            $new_password = Hash::make($Password);
            try {
                User::where('email', '=', $UserEmail)->update([
                    "password"  => $new_password
                ]);
                PasswordResetToken::where('EmailAddress', '=', $UserEmail)->delete();
                return view("PasswordReset.Result")->with('success', true);
            } catch (Exception $e) {
                return view("PasswordReset.Result")->with('success', false);
            }
        }
        return abort(401);
    }
}
