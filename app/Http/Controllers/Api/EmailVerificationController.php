<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmailVerificationRequest;
use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;


class EmailVerificationController extends Controller
{

    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }
    public function verifyCode(EmailVerificationRequest $request)
    {
        $otpValidation = $this->otp->validate($request->email, $request->otp);

        // check otp validation
        if (!$otpValidation->status) {
            return response()->json([
                'error' => 'Invalid OTP code.'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'error' => 'User not found.'
            ], 404);
        }
        // update user email verified
        $user->update([
            'email_verified_at' => now()
        ]);

        return response()->json([
            'message' => 'Email verified successfully'
        ], 200);
    }
}
