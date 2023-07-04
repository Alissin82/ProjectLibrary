<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ContactUs;

class ContactController extends Controller{

    public function show(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('contactus');
    }

    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string'
        ]);
        $contactus = new ContactUs();
        $contactus->name = $request->input('name');
        $contactus->email = $request->input('email');
        $contactus->message = $request->input('message');
        $contactus->save();

        return back()->with('success', 'پیام شما با موفقیت ارسال شد.');
    }
}
