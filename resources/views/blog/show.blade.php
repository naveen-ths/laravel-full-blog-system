<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: false }" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $post->meta_title ?? $post->title }} - {{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ $post->meta_description ?? $post->excerpt }}">
    
    @if($post->meta_keywords)
        <meta name="keywords" content="{{ $post->meta_keywords }}">
    @endif

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $post->og_title ?? $post->title }}">
    <meta property="og:description" content="{{ $post->og_description ?? $post->excerpt }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('blog.show', $post->slug) }}">
    @if($post->og_image)
        <meta property="og:image" content="{{ asset('storage/' . $post->og_image) }}">
    @elseif($post->featured_image)
        <meta property="og:image" content="{{ asset('storage/' . $post->featured_image) }}">
    @endif

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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex text-sm" aria-label="Breadcrumb">
                <a href="/" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">Blog</a>
                @if($post->category)
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">{{ $post->category->name }}</a>
                @endif
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $post->title }}</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <article class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Featured Image -->
            @if($post->featured_image)
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-64 sm:h-80 object-cover">
                </div>
            @endif

            <div class="p-8">
                <!-- Category Badge -->
                @if($post->category)
                    <div class="mb-4">
                        <a href="{{ route('blog.category', $post->category->slug) }}" 
                           class="inline-block px-3 py-1 text-sm font-medium rounded-full hover:opacity-80"
                           style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }}">
                            {{ $post->category->name }}
                        </a>
                    </div>
                @endif

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                    {{ $post->title }}
                </h1>

                <!-- Meta Info -->
                <div class="flex items-center text-gray-600 dark:text-gray-400 mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mr-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        By {{ $post->author->name }}
                    </div>
                    <div class="flex items-center mr-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $post->published_at->format('F j, Y') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-1"></path>
                        </svg>
                        {{ $post->approvedComments->count() }} 
                        {{ Str::plural('Comment', $post->approvedComments->count()) }}
                    </div>
                </div>

                <!-- Content -->
                <div class="prose prose-lg max-w-none dark:prose-invert">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" 
                                   class="inline-block px-3 py-1 text-sm rounded-full hover:opacity-80"
                                   style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </article>

        <!-- Comments Section -->
        <div class="mt-12">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-8">
                    Comments ({{ $post->approvedComments->count() }})
                </h2>

                <!-- Comment Form -->
                <div class="mb-12">
                    <div id="comment-success-message" class="hidden mb-6 p-4 bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                        <!-- Success message will be inserted here -->
                    </div>

                    <div id="comment-error-message" class="hidden mb-6 p-4 bg-red-50 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg">
                        <!-- Error message will be inserted here -->
                    </div>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="comment-form" action="{{ route('blog.comments.store', $post->slug) }}" method="POST" class="space-y-6">
                        @csrf
                        
                        @guest
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="author_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Name *
                                    </label>
                                    <input type="text" id="author_name" name="author_name" value="{{ old('author_name') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100 @error('author_name') @enderror">
                                    <div class="error-message text-sm text-red-600 dark:text-red-400 mt-1 hidden"></div>
                                    @error('author_name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="author_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Email *
                                    </label>
                                    <input type="email" id="author_email" name="author_email" value="{{ old('author_email') }}" required
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100 @error('author_email') @enderror">
                                    <div class="error-message text-sm text-red-600 dark:text-red-400 mt-1 hidden"></div>
                                    @error('author_email')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endguest

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Comment *
                            </label>
                            <textarea id="content" name="content" rows="4" required
                                      placeholder="Share your thoughts..."
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100 @error('content') @enderror">{{ old('content') }}</textarea>
                            <div class="error-message text-sm text-red-600 dark:text-red-400 mt-1 hidden"></div>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" id="submit-comment" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="submit-text">Post Comment</span>
                                <span class="loading-text hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Posting...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Comments List -->
                @if($post->approvedComments->count() > 0)
                    <div class="space-y-8">
                        @foreach($post->approvedComments->whereNull('parent_id') as $comment)
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-8 last:border-b-0">
                                <!-- Comment -->
                                <div class="flex space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                            <span class="text-gray-600 dark:text-gray-300 font-medium">
                                                {{ substr($comment->author_name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $comment->author_name }}</h4>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {{ $comment->content }}
                                        </p>
                                        
                                        <!-- Reply Button -->
                                        <button onclick="toggleReplyForm({{ $comment->id }})" 
                                                class="mt-3 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            Reply
                                        </button>

                                        <!-- Reply Form (Hidden by default) -->
                                        <div id="reply-form-{{ $comment->id }}" class="hidden mt-4">
                                            <div class="reply-success-message hidden mb-4 p-3 bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-300 rounded">
                                                <!-- Success message will be inserted here -->
                                            </div>
                                            <div class="reply-error-message hidden mb-4 p-3 bg-red-50 dark:bg-red-900 text-red-700 dark:text-red-300 rounded">
                                                <!-- Error message will be inserted here -->
                                            </div>
                                            
                                            <form class="reply-form space-y-4" data-comment-id="{{ $comment->id }}" action="{{ route('blog.comments.store', $post->slug) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                
                                                @guest
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <input type="text" name="author_name" placeholder="Your name" required
                                                                   class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                                            <div class="error-message text-sm text-red-600 dark:text-red-400 mt-1 hidden"></div>
                                                        </div>
                                                        <div>
                                                            <input type="email" name="author_email" placeholder="Your email" required
                                                                   class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100">
                                                            <div class="error-message text-sm text-red-600 dark:text-red-400 mt-1 hidden"></div>
                                                        </div>
                                                    </div>
                                                @endguest
                                                
                                                <div>
                                                    <textarea name="content" rows="3" placeholder="Write a reply..." required
                                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-100"></textarea>
                                                    <div class="error-message text-sm text-red-600 dark:text-red-400 mt-1 hidden"></div>
                                                </div>
                                                
                                                <div class="flex space-x-3">
                                                    <button type="submit" class="reply-submit px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                                        <span class="submit-text">Post Reply</span>
                                                        <span class="loading-text hidden">
                                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                            </svg>
                                                            Posting...
                                                        </span>
                                                    </button>
                                                    <button type="button" onclick="toggleReplyForm({{ $comment->id }})" 
                                                            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-400 dark:hover:bg-gray-500">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Replies -->
                                        @if($comment->replies->count() > 0)
                                            <div class="mt-6 space-y-6 ml-8">
                                                @foreach($comment->replies as $reply)
                                                    <div class="flex space-x-4">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                                <span class="text-gray-600 dark:text-gray-300 text-sm font-medium">
                                                                    {{ substr($reply->author_name, 0, 1) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="flex items-center space-x-2 mb-2">
                                                                <h5 class="font-medium text-gray-900 dark:text-gray-100">{{ $reply->author_name }}</h5>
                                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                                    {{ $reply->created_at->diffForHumans() }}
                                                                </span>
                                                            </div>
                                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                                {{ $reply->content }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 mb-4">
                            <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No comments yet</h3>
                        <p class="text-gray-600 dark:text-gray-400">Be the first to share your thoughts!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-8">Related Posts</h2>
                <div class="grid gap-8 md:grid-cols-3">
                    @foreach($relatedPosts as $relatedPost)
                        <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            @if($relatedPost->featured_image)
                                <div class="aspect-w-16 aspect-h-9">
                                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                                         alt="{{ $relatedPost->title }}" 
                                         class="w-full h-32 object-cover rounded-t-lg">
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 line-clamp-2">
                                    <a href="{{ route('blog.show', $relatedPost->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ $relatedPost->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $relatedPost->published_at->format('M j, Y') }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-600 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }

        // AJAX Comment Submission
        document.addEventListener('DOMContentLoaded', function() {
            // Main comment form
            const commentForm = document.getElementById('comment-form');
            if (commentForm) {
                commentForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitComment(this, false);
                });
            }

            // Reply forms
            const replyForms = document.querySelectorAll('.reply-form');
            replyForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitComment(this, true);
                });
            });
        });

        function submitComment(form, isReply = false) {
            const submitButton = form.querySelector(isReply ? '.reply-submit' : '#submit-comment');
            const submitText = submitButton.querySelector('.submit-text');
            const loadingText = submitButton.querySelector('.loading-text');
            
            // Clear previous errors
            clearErrors(form);
            
            // Show loading state
            submitButton.disabled = true;
            submitText.classList.add('hidden');
            loadingText.classList.remove('hidden');

            // Prepare form data
            const formData = new FormData(form);
            
            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                   document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccess(form, data.message, isReply);
                    form.reset();
                    if (isReply) {
                        const commentId = form.dataset.commentId;
                        toggleReplyForm(commentId);
                    }
                } else {
                    showErrors(form, data.errors || { general: ['An error occurred. Please try again.'] });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrors(form, { general: ['An unexpected error occurred. Please try again.'] });
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitText.classList.remove('hidden');
                loadingText.classList.add('hidden');
            });
        }

        function showSuccess(form, message, isReply = false) {
            const messageContainer = isReply ? 
                form.querySelector('.reply-success-message') : 
                document.getElementById('comment-success-message');
            
            messageContainer.textContent = message;
            messageContainer.classList.remove('hidden');
            
            // Scroll to message
            messageContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Hide success message after 5 seconds
            setTimeout(() => {
                messageContainer.classList.add('hidden');
            }, 5000);
        }

        function showErrors(form, errors) {
            const errorContainer = form.querySelector('.reply-error-message') || 
                                 document.getElementById('comment-error-message');
            
            // Show general error message
            if (errors.general) {
                errorContainer.innerHTML = errors.general.join('<br>');
                errorContainer.classList.remove('hidden');
            }
            
            // Show field-specific errors
            Object.keys(errors).forEach(field => {
                if (field === 'general') return;
                
                const input = form.querySelector(`[name="${field}"]`);
                const errorDiv = input?.parentElement.querySelector('.error-message');
                
                if (input && errorDiv) {
                    input.classList.add('border-red-500');
                    input.classList.remove('border-gray-300');
                    errorDiv.textContent = errors[field][0];
                    errorDiv.classList.remove('hidden');
                }
            });
        }

        function clearErrors(form) {
            // Hide error containers
            const errorContainers = [
                form.querySelector('.reply-error-message'),
                document.getElementById('comment-error-message')
            ].filter(Boolean);
            
            errorContainers.forEach(container => {
                container.classList.add('hidden');
            });
            
            // Clear field errors
            const inputs = form.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
                input.classList.add('border-gray-300');
                const errorDiv = input.parentElement.querySelector('.error-message');
                if (errorDiv) {
                    errorDiv.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
