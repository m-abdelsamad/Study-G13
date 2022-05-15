<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Validator;

class MailerController extends Controller
{
    //
    public function sendEmail(Request $request){
        
        $validateForm = Validator::make($request->all(), [
            'name' => ['required' , 'string'],
            'email' => ['required' , 'email'],
            'message' => ['required', 'string'],
        ]);


        $details = [
            'from' => $request->email,
            'title' => "Message From ". $request->name,
            'body' => $request->message,
        ];     


        Mail::to("study.plus013@gmail.com")->send(new TestMail($details));
        return view('welcome');
        //return "Email sent";
    }
}
