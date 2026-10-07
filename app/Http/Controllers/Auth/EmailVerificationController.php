<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    // "Please verify your email" page
    public function notice(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard.posts.index');
        }

        return view('auth.verify-email');
    }

    // The link inside the email lands here
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();   // sets email_verified_at to now

        return redirect()
            ->route('dashboard.posts.index')
            ->with('success', 'Thanks! Your email has been verified.');
    }

    // "Resend the email" button
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard.posts.index');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A new verification link has been sent to your email address.');
    }
}
