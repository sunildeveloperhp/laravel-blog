<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    // Home page with the 3 latest published posts
    public function home()
    {
        $posts = Post::with(['category', 'user'])
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.home', ['posts' => $posts]);
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

        Mail::to($admins)->send(new ContactMessage(
            $data['name'],
            $data['email'],
            $data['message'],
        ));

        return back()->with('success', 'Thanks, '.$data['name'].'! Your message has been sent. We will reply to '.$data['email'].'.');
    }
}
