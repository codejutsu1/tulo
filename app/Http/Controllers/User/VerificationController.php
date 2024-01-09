<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {  
        $request->fulfill();
        
        //redirect to a page
        return $this->success('Email Verification Successful');
    }

    public function sendVerificationMail() 
    {
        Mail::to(auth()->user())->send(new EmailVerification(auth()->user()));
        
        return $this->success("Email verification link sent to your email.", 200);
    }
}
