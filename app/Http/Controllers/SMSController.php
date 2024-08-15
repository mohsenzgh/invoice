<?php
namespace App\Http\Controllers;

use Ghasedaksms\GhasedaksmsLaravel\GhasedaksmsFacade;

use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);
        
        $phone = $request->phone;
        $verificationCode = rand(1000, 9999); // تولید کد چهار رقمی
        $template = "invoice";
        $user = new \App\Models\User();
        $user->id = '09364868653';
        $user->notify(new \App\Notifications\SendOtpToUser());
        // $notifiable = [
        //     'mobile' => $phone,
        //     'verificationCode' => $verificationCode,
        // ];
       
        // $request->notify(new \App\Notifications\SendOtpToUser());
        
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|numeric'
        ]);

        $phone = $request->phone;
        $code = $request->code;

        // بررسی کد تأیید
        if (session('verification_code') == $code && session('phone') == $phone) {
            // پاک کردن کد تأیید از session
            session()->forget(['verification_code', 'phone']);
            return response()->json(['message' => 'Phone number verified.']);
        } else {
            return response()->json(['message' => 'Invalid verification code.'], 400);
        }
    }
}
