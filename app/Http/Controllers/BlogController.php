<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'author', 'tags'])
            ->where('status', 'published')
            ->where('published_at', '<=', now());

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by tag
        if ($request->has('tag') && $request->tag) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(12);
        
        $categories = BlogCategory::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->where('status', 'published')
                      ->where('published_at', '<=', now());
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        $tags = BlogTag::withCount(['posts' => function ($query) {
                $query->where('status', 'published')
                      ->where('published_at', '<=', now());
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('blog.index', compact('posts', 'categories', 'tags'));
    }

    public function category(Request $request, BlogCategory $category)
    {
        // Check if category is active
        if (!$category->is_active) {
            abort(404);
        }

        $query = BlogPost::with(['category', 'author', 'tags'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('category_id', $category->id);

        // Search within category
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(12);
        
        // Get all active categories for sidebar
        $categories = BlogCategory::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->where('status', 'published')
                      ->where('published_at', '<=', now());
            }])
            ->having('posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get tags used in this category
        $tags = BlogTag::whereHas('posts', function ($query) use ($category) {
                $query->where('status', 'published')
                      ->where('published_at', '<=', now())
                      ->where('category_id', $category->id);
            })
            ->withCount(['posts' => function ($query) use ($category) {
                $query->where('status', 'published')
                      ->where('published_at', '<=', now())
                      ->where('category_id', $category->id);
            }])
            ->orderBy('name')
            ->get();

        return view('blog.category', compact('posts', 'categories', 'tags', 'category'));
    }

    public function show(BlogPost $post)
    {
        // Check if post is published and published date is in the past
        if ($post->status !== 'published' || $post->published_at > now()) {
            abort(404);
        }

        // Load relationships
        $post->load(['category', 'author', 'tags', 'approvedComments.user', 'approvedComments.replies.user']);

        // Get related posts
        $relatedPosts = BlogPost::where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function storeComment(Request $request, BlogPost $post)
    {
        $rules = [
            'content' => 'required|min:10|max:1000',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ];

        // Add name and email validation for guest users
        if (!Auth::check()) {
            $rules['author_name'] = 'required|max:255';
            $rules['author_email'] = 'required|email|max:255';
        }

        try {
            $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $comment = new BlogComment([
            'content' => $request->content,
            'blog_post_id' => $post->id,
            'status' => 'pending', // Comments need approval
        ]);

        if (Auth::check()) {
            $comment->user_id = Auth::id();
            $comment->author_name = Auth::user()->name;
            $comment->author_email = Auth::user()->email;
        } else {
            $comment->author_name = $request->author_name;
            $comment->author_email = $request->author_email;
        }

        if ($request->parent_id) {
            $comment->parent_id = $request->parent_id;
        }

        $comment->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your comment has been submitted and is awaiting approval.',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'author_name' => $comment->author_name,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'status' => $comment->status,
                ]
            ]);
        }

        return back()->with('success', 'Your comment has been submitted and is awaiting approval.');
    }
}
