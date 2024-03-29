<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return $this->success('Email Already Verified.', 422);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->success('Email Verification Successful.');
    }

    public function sendVerificationMail() 
    {
        if(auth()->user()->hasVerifiedEmail()){
            return $this->message('Your Email has been Verified.', 422);
        }

        auth()->user()->sendEmailVerificationNotification();
        
        return $this->success("Email verification link sent to your email.", 200);
    }
}
