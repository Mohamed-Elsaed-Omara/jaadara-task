<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        // get user
        $user =  auth()->user();
        // validate otp
        $request->validate([
            'otp' => ['required', 'numeric', 'digits:6'],
        ]);

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found.']);
        }

        // check otp validation
        $otpVerification = (new Otp)->validate($user->email, $request->otp);

        if(!$otpVerification->status) {
            return redirect()->back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // update user email verified
        $user->update(['email_verified_at' => now()]);

        return redirect()->route('posts.index')->with('status', 'Email verified successfully.');
    }
}
