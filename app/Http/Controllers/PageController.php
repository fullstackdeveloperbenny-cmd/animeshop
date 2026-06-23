<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Shop\ContactMessageRequest;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContactMessage(ContactMessageRequest $request)
    {
        $validated = $request->validated();

        Mail::to('admin@animeshop.test')->send(
            new ContactMessageMail($validated['name'], $validated['email'], $validated['message'])
        );

        return redirect()->back()->with('success', 'Je bericht is succesvol verzonden. We nemen zo snel mogelijk contact met je op!');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function returns()
    {
        return view('pages.returns');
    }
}
