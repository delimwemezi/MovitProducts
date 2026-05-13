<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelpController extends Controller
{
    public function index()
    {
        return view('help');
    }

    public function send(Request $request)
    {
        $name    = $request->name;
        $email   = $request->email;
        $message = $request->message;

        Mail::raw(
            "Name: $name\nEmail: $email\n\nMessage:\n$message",
            function ($mail) use ($name, $email) {
                $mail->to('delfinusideusdedith@gmail.com')
                     ->subject("New Message from $name — Movit Help Center")
                     ->replyTo($email, $name);
            }
        );

        return redirect('/help')->with('success', 'Your message has been sent!');
    }
}