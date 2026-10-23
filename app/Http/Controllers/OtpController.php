<?php

namespace App\Http\Controllers;

use App\Mail\SendOTPEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    private const MAX_ATTEMPTS = 5;

    private function generateOTP(): string
    {
        return (string) random_int(100000, 999999);
    }

    public function showRequestForm()
    {
        return view('request-otp');
    }

    public function send(Request $request)
    {
        $request->validate(
            ['email' => ['required', 'email', 'exists:users,email']],
            [
                'email.required' => 'Please enter your email.',
                'email.exists'   => 'That email is not registered.',
            ]
        );

        $otp = $this->generateOTP();

        session([
            'otp'          => Hash::make($otp),
            'otp_expiry'   => now()->addMinutes(5),
            'otp_attempts' => 0,
            'otp_email'    => $request->email,
        ]);

        Mail::to($request->email)->send(new SendOTPEmail($otp));

        return redirect()->route('otp.verify.form')
            ->with('success', 'OTP sent! Check your email.');
    }

    public function showVerifyForm()
    {
        if (!session('otp_email')) {
            return redirect()->route('otp.request');
        }

        return view('verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate(
            ['otp' => ['required', 'digits:6']],
            [
                'otp.required' => 'Please enter the OTP.',
                'otp.digits'   => 'The OTP must contain exactly six digits.',
            ]
        );

        $hash     = session('otp');
        $expiry   = session('otp_expiry');
        $attempts = session('otp_attempts', 0);

        // too many tries -> kill the OTP, force a new request
        if ($attempts >= self::MAX_ATTEMPTS) {
            session()->forget(['otp', 'otp_expiry', 'otp_attempts', 'otp_email']);

            return redirect()->route('otp.request')
                ->withErrors(['email' => 'Too many attempts. Please request a new OTP.']);
        }

        if ($hash && $expiry && now()->lt($expiry) && Hash::check($request->otp, $hash)) {
            session()->forget(['otp', 'otp_expiry', 'otp_attempts', 'otp_email']);
            session()->regenerate();
            session(['otp_verified' => true]);

            return redirect('/home')->with('success', 'OTP verified successfully!');
        }

        session()->increment('otp_attempts');

        return back()->withErrors(['otp' => 'The OTP is incorrect or has expired.']);
    }

    public function home()
    {
        if (!session('otp_verified')) {
            return redirect()->route('otp.request');
        }

        return view('home');
    }

    public function logout()
    {
        session()->flush();

        return redirect()->route('otp.request');
    }
}