<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use App\Models\User;
use App\Support\BlogCache;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    // Home page with the 3 latest published posts
    public function home()
    {
        return view('pages.home', ['posts' => BlogCache::homePosts()]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    // Email the contact form to every admin
    public function sendContact(ContactRequest $request)
    {
        $data = $request->validated();

        $admins = User::where('role', Role::Admin)->get();

        Mail::to($admins)->queue(new ContactMessage(
            $data['name'],
            $data['email'],
            $data['message'],
        ));

        return back()->with('success', 'Thanks, '.$data['name'].'! Your message has been sent. We will reply to '.$data['email'].'.');
    }
}
