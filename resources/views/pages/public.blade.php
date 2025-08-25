<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->seo_title }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $page->seo_description }}">
    @if($page->meta_keywords)
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif
    <meta name="robots" content="{{ $page->meta_robots ?? 'index,follow' }}">
    
    @if($page->canonical_url)
        <link rel="canonical" href="{{ $page->canonical_url }}">
    @endif
    
    <!-- Open Graph Meta Tags -->
    @if($page->og_data)
        <meta property="og:title" content="{{ $page->og_data['title'] ?? $page->title }}">
        <meta property="og:description" content="{{ $page->og_data['description'] ?? $page->seo_description }}">
        <meta property="og:type" content="{{ $page->og_data['type'] ?? 'article' }}">
        <meta property="og:url" content="{{ $page->url }}">
        @if(isset($page->og_data['image']))
            <meta property="og:image" content="{{ $page->og_data['image'] }}">
        @elseif($page->featured_image)
            <meta property="og:image" content="{{ $page->featured_image }}">
        @endif
    @endif
    
    <!-- Twitter Card Meta Tags -->
    @if($page->twitter_data)
        <meta name="twitter:card" content="{{ $page->twitter_data['card'] ?? 'summary' }}">
        <meta name="twitter:title" content="{{ $page->twitter_data['title'] ?? $page->title }}">
        <meta name="twitter:description" content="{{ $page->twitter_data['description'] ?? $page->seo_description }}">
        @if(isset($page->twitter_data['image']))
            <meta name="twitter:image" content="{{ $page->twitter_data['image'] }}">
        @elseif($page->featured_image)
            <meta name="twitter:image" content="{{ $page->featured_image }}">
        @endif
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Structured Data -->
    @if($page->schema_markup)
        <script type="application/ld+json">
            {!! $page->schema_markup !!}
        </script>
    @endif
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
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Banner Image -->
        @if($page->banner_image)
            <div class="mb-8">
                <img src="{{ $page->banner_image }}" 
                     alt="{{ $page->banner_image_alt ?? 'Banner image' }}" 
                     class="w-full h-64 object-cover rounded-lg shadow-md">
            </div>
        @endif

        <!-- Page Header -->
        <header class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $page->title }}</h1>
            
            @if($page->excerpt)
                <p class="text-xl text-gray-600 dark:text-gray-400 leading-relaxed">{{ $page->excerpt }}</p>
            @endif

            <!-- Featured Badge -->
            @if($page->is_featured)
                <div class="mt-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        ⭐ Featured Page
                    </span>
                </div>
            @endif

            <!-- Meta Information -->
            <div class="mt-6 flex items-center text-sm text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700 pb-6">
                @if($page->author)
                    <span>By {{ $page->author->name }}</span>
                @endif
                @if($page->published_at)
                    <span class="mx-2">•</span>
                    <time datetime="{{ $page->published_at->toISOString() }}">
                        {{ $page->published_at->format('F j, Y') }}
                    </time>
                @endif
                @if($page->updated_at && $page->updated_at != $page->created_at)
                    <span class="mx-2">•</span>
                    <span>Updated {{ $page->updated_at->format('F j, Y') }}</span>
                @endif
            </div>
        </header>

        <!-- Featured Image -->
        @if($page->featured_image)
            <div class="mb-8">
                <figure>
                    <img src="{{ $page->featured_image }}" 
                         alt="{{ $page->featured_image_alt ?? $page->title }}" 
                         class="w-full h-auto rounded-lg shadow-md">
                    @if($page->featured_image_caption)
                        <figcaption class="mt-3 text-sm text-gray-600 dark:text-gray-400 italic text-center">
                            {{ $page->featured_image_caption }}
                        </figcaption>
                    @endif
                </figure>
            </div>
        @endif

        <!-- Page Content -->
        <article class="prose prose-lg max-w-none dark:prose-invert prose-gray">
            {!! $page->content !!}
        </article>
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
