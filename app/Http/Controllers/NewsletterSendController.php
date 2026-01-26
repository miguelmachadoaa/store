<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Mail\NewsletterEmail;
use Illuminate\Support\Facades\Mail;

class NewsletterSendController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        foreach (Newsletter::all() as $subscriber) {
            Mail::to($subscriber->email)->send(new NewsletterEmail($request->content));
        }

        return back()->with('success', 'Newsletter enviado a todos los suscriptores.');
    }

    public function form()
    {
        return view('admin.newsletters.send');
    }
}
