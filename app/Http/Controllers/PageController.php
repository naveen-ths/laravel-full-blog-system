<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Page::with(['author', 'updatedBy']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->where('is_featured', $request->boolean('featured'));
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%");
            });
        }

        $pages = $query->orderBy('sort_order')
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);

        return view('pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.create', ['page' => null]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|in:draft,published,private',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'meta_robots' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'featured_image' => 'nullable|string',
            'featured_image_alt' => 'nullable|string',
            'featured_image_caption' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'banner_image_alt' => 'nullable|string',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set author
        $validated['author_id'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        // Handle published_at
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $page = Page::create($validated);

        return redirect()->route('pages.show', $page)
                        ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $page->load(['author', 'updatedBy']);
        
        return view('pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('pages')->ignore($page->id)],
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'status' => 'required|in:draft,published,private',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'meta_robots' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'featured_image' => 'nullable|string',
            'featured_image_alt' => 'nullable|string',
            'featured_image_caption' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'banner_image_alt' => 'nullable|string',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set updated by
        $validated['updated_by'] = Auth::id();

        // Handle published_at
        if ($validated['status'] === 'published' && empty($validated['published_at']) && $page->status !== 'published') {
            $validated['published_at'] = now();
        }

        $page->update($validated);

        return redirect()->route('pages.show', $page)
                        ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('pages.index')
                        ->with('success', 'Page deleted successfully.');
    }

    /**
     * Display the specified page by slug (public view).
     */
    public function showBySlug(string $slug)
    {
        $page = Page::where('slug', $slug)
                   ->where('status', 'published')
                   ->where(function ($query) {
                       $query->whereNull('published_at')
                             ->orWhere('published_at', '<=', now());
                   })
                   ->firstOrFail();

        return view('pages.public', compact('page'));
    }

    /**
     * Get featured pages.
     */
    public function featured()
    {
        $pages = Page::featured()
                    ->published()
                    ->orderBy('sort_order')
                    ->get();

        return view('pages.featured', compact('pages'));
    }
}
