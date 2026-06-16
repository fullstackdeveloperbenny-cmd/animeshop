<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function sendContactMessage(\App\Http\Requests\Shop\ContactMessageRequest $request)
    {
        $validated = $request->validated();

        \Illuminate\Support\Facades\Mail::to('admin@animashop.test')->send(
            new \App\Mail\ContactMessageMail($validated['name'], $validated['email'], $validated['message'])
        );

        return redirect()->back()->with('success', 'Je bericht is succesvol verzonden. We nemen zo snel mogelijk contact met je op!');
    }
}
