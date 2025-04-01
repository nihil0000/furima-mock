<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    private function getRedirectRoute()
    {
        return session()->pull('after_verified', 'product.index');
    }

    // Verify the email
    public function verify(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route($this->getRedirectRoute());
        }

        return redirect()->route($this->getRedirectRoute());
    }

    // Resend email
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('product.index');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', '認証メールを再送しました！');
    }
}
