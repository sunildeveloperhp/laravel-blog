<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Events\CommentApproved;

class CommentController extends Controller
{
    // Pending comments by default, or approved ones with ?status=approved
    public function index(Request $request)
    {
        $status = $request->query('status') === 'approved' ? 'approved' : 'pending';

        $comments = Comment::with(['user', 'post'])
            ->when(
                $status === 'approved',
                fn ($query) => $query->approved(),
                fn ($query) => $query->pending(),
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.comments.index', [
            'comments' => $comments,
            'status' => $status,
            'pendingCount' => Comment::pending()->count(),
        ]);
    }

    // Make a pending comment public
    public function approve(Comment $comment)
    {
        $comment->approved_at = now();
        $comment->save();

        CommentApproved::dispatch($comment);

        return back()->with('success', 'Comment by ' . $comment->user->name . ' was approved.');
    }

    // Reject / remove a comment
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment was deleted.');
    }
}
