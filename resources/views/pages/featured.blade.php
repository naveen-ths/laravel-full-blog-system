<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Featured Pages - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Discover our featured pages with the most important content and updates.">
    <meta name="robots" content="index,follow">
    
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
                    <a href="/featured-pages" class="text-gray-900 dark:text-gray-100 font-medium">Featured Pages</a>
                    <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Blog</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">Featured Pages</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Discover our most important content and featured articles, carefully selected for you.
            </p>
        </header>

        <!-- Featured Pages Grid -->
        @if($pages->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($pages as $page)
                    <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Featured Image -->
                        @if($page->featured_image)
                            <div class="aspect-w-16 aspect-h-9">
                                <img src="{{ $page->featured_image }}" 
                                     alt="{{ $page->featured_image_alt ?? $page->title }}" 
                                     class="w-full h-48 object-cover">
                            </div>
                        @endif

                        <div class="p-6">
                            <!-- Featured Badge -->
                            <div class="flex items-center justify-between mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    ⭐ Featured
                                </span>
                                @if($page->published_at)
                                    <time class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $page->published_at->format('M j, Y') }}
                                    </time>
                                @endif
                            </div>

                            <!-- Title -->
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">
                                <a href="{{ route('pages.public', $page->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                    {{ $page->title }}
                                </a>
                            </h2>

                            <!-- Excerpt -->
                            @if($page->excerpt)
                                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                    {{ $page->excerpt }}
                                </p>
                            @endif

                            <!-- Author and Read More -->
                            <div class="flex items-center justify-between">
                                @if($page->author)
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        By {{ $page->author->name }}
                                    </span>
                                @endif
                                <a href="{{ route('pages.public', $page->slug) }}" 
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                    Read More
                                    <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <!-- No Featured Pages -->
            <div class="text-center py-12">
                <div class="text-gray-500 dark:text-gray-400 mb-4">
                    <svg class="mx-auto h-16 w-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-2">No Featured Pages Yet</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    There are currently no featured pages to display. Check back later for updates!
                </p>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-16">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-500 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
