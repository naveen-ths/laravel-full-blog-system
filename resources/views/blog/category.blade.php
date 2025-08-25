<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->name }} - Blog - {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Browse all {{ $category->name }} blog posts. {{ $category->description }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Home</a>
                    <a href="/featured-pages" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Featured Pages</a>
                    <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Blog</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex text-sm" aria-label="Breadcrumb">
                <a href="/" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Blog</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $category->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Category Header -->
    <div class="bg-white dark:bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <!-- Category Badge -->
                <div class="mb-4">
                    <span class="inline-block px-4 py-2 text-lg font-medium rounded-full"
                          style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                        {{ $category->name }}
                    </span>
                </div>
                
                <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    {{ $category->name }} Articles
                </h1>
                
                @if($category->description)
                    <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-4">
                        {{ $category->description }}
                    </p>
                @endif
                
                <p class="text-gray-500 dark:text-gray-400">
                    {{ $posts->total() }} {{ Str::plural('article', $posts->total()) }} in this category
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content Area -->
            <div class="flex-1">
                <!-- Search -->
                <div class="mb-8">
                    <form method="GET" action="{{ route('blog.category', $category->slug) }}" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search in {{ $category->name }}..." 
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                                Search
                            </button>
                            @if(request('search'))
                                <a href="{{ route('blog.category', $category->slug) }}" 
                                   class="px-6 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Blog Posts Grid -->
                @if($posts->count() > 0)
                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($posts as $post)
                            <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                                @if($post->featured_image)
                                    <div class="aspect-w-16 aspect-h-9">
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                             alt="{{ $post->title }}" 
                                             class="w-full h-48 object-cover rounded-t-lg">
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <!-- Title -->
                                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3 line-clamp-2">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                            {{ $post->title }}
                                        </a>
                                    </h2>

                                    <!-- Excerpt -->
                                    @if($post->excerpt)
                                        <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                            {{ $post->excerpt }}
                                        </p>
                                    @endif

                                    <!-- Meta Info -->
                                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <span>By {{ $post->author->name }}</span>
                                        </div>
                                        <div>
                                            {{ $post->published_at->format('M j, Y') }}
                                        </div>
                                    </div>

                                    <!-- Tags -->
                                    @if($post->tags->count() > 0)
                                        <div class="mt-4 flex flex-wrap gap-2">
                                            @foreach($post->tags->take(3) as $tag)
                                                <span class="inline-block px-2 py-1 text-xs rounded"
                                                      style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-2">
                            @if(request('search'))
                                No articles found for "{{ request('search') }}"
                            @else
                                No articles in {{ $category->name }} yet
                            @endif
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            @if(request('search'))
                                Try adjusting your search or 
                                <a href="{{ route('blog.category', $category->slug) }}" class="text-blue-600 hover:text-blue-800">browse all {{ $category->name }} articles</a>
                            @else
                                Check back later for new content or 
                                <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-800">browse all blog posts</a>
                            @endif
                        </p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:w-80">
                <!-- Back to All Posts -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                    <a href="{{ route('blog.index') }}" 
                       class="flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to All Blog Posts
                    </a>
                </div>

                <!-- Other Categories -->
                @if($categories->where('id', '!=', $category->id)->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Other Categories</h3>
                        <div class="space-y-2">
                            @foreach($categories->where('id', '!=', $category->id) as $otherCategory)
                                <a href="{{ route('blog.category', $otherCategory->slug) }}" 
                                   class="flex items-center justify-between p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $otherCategory->name }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                        {{ $otherCategory->posts_count }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Category Stats -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Category Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Total Articles</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $posts->total() }}</span>
                        </div>
                        @if($tags->count() > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Tags Used</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $tags->count() }}</span>
                            </div>
                        @endif
                        @if($posts->total() > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Latest Post</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $posts->first()->published_at->diffForHumans() }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tags in this Category -->
                @if($tags->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tags in {{ $category->name }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" 
                                   class="inline-block px-3 py-1 text-sm rounded-full hover:opacity-80"
                                   style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                    {{ $tag->name }} ({{ $tag->posts_count }})
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
