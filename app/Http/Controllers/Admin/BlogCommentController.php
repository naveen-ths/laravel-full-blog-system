<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BlogComment::with(['post', 'user']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by post
        if ($request->filled('post')) {
            $query->where('post_id', $request->post);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('author_email', 'like', "%{$search}%");
            });
        }

        $comments = $query->latest()->paginate(15);
        $posts = BlogPost::all();

        return view('admin.blog.comments.index', compact('comments', 'posts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogComment $comment)
    {
        $comment->load(['post', 'user', 'parent', 'replies.user']);
        
        return view('admin.blog.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogComment $comment)
    {
        return view('admin.blog.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogComment $comment)
    {
        $request->validate([
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'author_email' => 'nullable|email|max:255',
            'author_website' => 'nullable|url|max:255',
            'status' => 'required|in:pending,approved,spam',
        ]);

        $comment->update($request->all());

        return redirect()->route('admin.blog.comments.index')
            ->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogComment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.blog.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }

    /**
     * Approve a comment
     */
    public function approve(BlogComment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('success', 'Comment approved successfully.');
    }

    /**
     * Mark comment as spam
     */
    public function spam(BlogComment $comment)
    {
        $comment->update(['status' => 'spam']);

        return back()->with('success', 'Comment marked as spam.');
    }

    /**
     * Set comment as pending
     */
    public function pending(BlogComment $comment)
    {
        $comment->update(['status' => 'pending']);

        return back()->with('success', 'Comment set to pending.');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'comments' => 'required|array',
            'comments.*' => 'exists:blog_comments,id',
            'action' => 'required|in:approve,spam,pending,delete',
        ]);

        $comments = BlogComment::whereIn('id', $request->comments);

        switch ($request->action) {
            case 'approve':
                $comments->update(['status' => 'approved']);
                $message = 'Comments approved successfully.';
                break;
            case 'spam':
                $comments->update(['status' => 'spam']);
                $message = 'Comments marked as spam.';
                break;
            case 'pending':
                $comments->update(['status' => 'pending']);
                $message = 'Comments set to pending.';
                break;
            case 'delete':
                $comments->delete();
                $message = 'Comments deleted successfully.';
                break;
        }

        return back()->with('success', $message);
    }
}
