<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Post: ') . Str::limit($post->title, 50) }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.blog.posts.edit', $post) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Post
                </a>
                <a href="{{ route('admin.blog.posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Posts
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Post Content -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $post->title }}</h1>
                            
                            @if($post->featured_image)
                                <div class="mb-6">
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg">
                                </div>
                            @endif

                            @if($post->excerpt)
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Excerpt</h3>
                                    <p class="text-gray-700 dark:text-gray-300 italic">{{ $post->excerpt }}</p>
                                </div>
                            @endif

                            <div class="prose dark:prose-invert max-w-none">
                                {!! nl2br(e($post->content)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- SEO Information -->
                    @if($post->meta_title || $post->meta_description || $post->og_title || $post->og_description)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">SEO Information</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($post->meta_title || $post->meta_description)
                                        <div>
                                            <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Tags</h4>
                                            @if($post->meta_title)
                                                <div class="mb-2">
                                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Title:</span>
                                                    <p class="text-sm">{{ $post->meta_title }}</p>
                                                </div>
                                            @endif
                                            @if($post->meta_description)
                                                <div>
                                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Description:</span>
                                                    <p class="text-sm">{{ $post->meta_description }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if($post->og_title || $post->og_description)
                                        <div>
                                            <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Open Graph</h4>
                                            @if($post->og_title)
                                                <div class="mb-2">
                                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">OG Title:</span>
                                                    <p class="text-sm">{{ $post->og_title }}</p>
                                                </div>
                                            @endif
                                            @if($post->og_description)
                                                <div class="mb-2">
                                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">OG Description:</span>
                                                    <p class="text-sm">{{ $post->og_description }}</p>
                                                </div>
                                            @endif
                                            @if($post->og_image)
                                                <div>
                                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">OG Image:</span>
                                                    <img src="{{ asset('storage/' . $post->og_image) }}" alt="OG Image" class="mt-1 w-32 h-20 object-cover rounded">
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Comments -->
                    @if($post->comments->count() > 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Comments ({{ $post->comments->count() }})</h3>
                                    <a href="{{ route('admin.blog.comments.index', ['post' => $post->id]) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                        Manage All Comments
                                    </a>
                                </div>
                                
                                <div class="space-y-4">
                                    @foreach($post->comments->take(5) as $comment)
                                        <div class="border-b pb-4 last:border-b-0">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <span class="font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $comment->author_name ?: ($comment->user->name ?? 'Anonymous') }}
                                                    </span>
                                                    @if($comment->status === 'approved')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                                            Approved
                                                        </span>
                                                    @elseif($comment->status === 'pending')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">
                                                            Spam
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->format('M j, Y') }}</span>
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300">{{ Str::limit($comment->content, 200) }}</p>
                                            <div class="mt-2 flex space-x-2">
                                                <a href="{{ route('admin.blog.comments.edit', $comment) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                                    Edit
                                                </a>
                                                @if($comment->status !== 'approved')
                                                    <form action="{{ route('admin.blog.comments.approve', $comment) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900 text-sm">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if($post->comments->count() > 5)
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('admin.blog.comments.index', ['post' => $post->id]) }}" class="text-blue-600 hover:text-blue-900">
                                            View All {{ $post->comments->count() }} Comments
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Post Details -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Post Details</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                                    @if($post->status === 'published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                            Published
                                        </span>
                                    @elseif($post->status === 'draft')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 ml-2">
                                            Draft
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                            Scheduled
                                        </span>
                                    @endif
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Author:</span>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $post->author->name }}</p>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Category:</span>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $post->category->name }}</p>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Slug:</span>
                                    <p class="text-gray-900 dark:text-gray-100 text-sm">{{ $post->slug }}</p>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Views:</span>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $post->views ?? 0 }}</p>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Comments:</span>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $post->comments->count() }}</p>
                                </div>
                                
                                @if($post->published_at)
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Published:</span>
                                        <p class="text-gray-900 dark:text-gray-100">{{ $post->published_at->format('M j, Y \a\t g:i A') }}</p>
                                    </div>
                                @endif
                                
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Created:</span>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $post->created_at->format('M j, Y \a\t g:i A') }}</p>
                                </div>
                                
                                @if($post->updated_at->ne($post->created_at))
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Last Updated:</span>
                                        <p class="text-gray-900 dark:text-gray-100">{{ $post->updated_at->format('M j, Y \a\t g:i A') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($post->tags->count() > 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tags</h3>
                                
                                <div class="flex flex-wrap gap-2">
                                    @foreach($post->tags as $tag)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: {{ $tag->color }};">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                            
                            <div class="space-y-3">
                                <a href="{{ route('admin.blog.posts.edit', $post) }}" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block text-center">
                                    Edit Post
                                </a>
                                
                                <form action="{{ route('admin.blog.posts.destroy', $post) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded">
                                        Delete Post
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
