<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Comment') }}
            </h2>
            <a href="{{ route('admin.blog.comments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Comments
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Comment Context -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Comment on:</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-medium">{{ $comment->post->title }}</p>
                        @if($comment->parent)
                            <div class="mt-3 p-3 bg-white dark:bg-gray-600 rounded border-l-4 border-blue-500">
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Replying to:</p>
                                <p class="text-sm">{{ Str::limit($comment->parent->content, 100) }}</p>
                                <p class="text-xs text-gray-500 mt-1">by {{ $comment->parent->author_name ?: ($comment->parent->user->name ?? 'Anonymous') }}</p>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('admin.blog.comments.update', $comment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-6">
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Comment Content <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="content" 
                                              id="content" 
                                              rows="8"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                              required>{{ old('content', $comment->content) }}</textarea>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if(!$comment->user_id)
                                    <!-- Guest Author Info -->
                                    <div class="border-t pt-6">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Author Information</h3>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="author_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Author Name
                                                </label>
                                                <input type="text" 
                                                       name="author_name" 
                                                       id="author_name" 
                                                       value="{{ old('author_name', $comment->author_name) }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                @error('author_name')
                                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="author_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Author Email
                                                </label>
                                                <input type="email" 
                                                       name="author_email" 
                                                       id="author_email" 
                                                       value="{{ old('author_email', $comment->author_email) }}"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                                @error('author_email')
                                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label for="author_website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Author Website
                                            </label>
                                            <input type="url" 
                                                   name="author_website" 
                                                   id="author_website" 
                                                   value="{{ old('author_website', $comment->author_website) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            @error('author_website')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @else
                                    <!-- Registered User Info -->
                                    <div class="border-t pt-6">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Author Information</h3>
                                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium">
                                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-blue-900 dark:text-blue-100">{{ $comment->user->name }}</p>
                                                    <p class="text-sm text-blue-700 dark:text-blue-300">{{ $comment->user->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Sidebar -->
                            <div class="space-y-6">
                                <!-- Status -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Status</h3>
                                    
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Comment Status <span class="text-red-500">*</span>
                                        </label>
                                        <select name="status" 
                                                id="status"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                required>
                                            <option value="pending" {{ old('status', $comment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ old('status', $comment->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="spam" {{ old('status', $comment->status) === 'spam' ? 'selected' : '' }}>Spam</option>
                                        </select>
                                        @error('status')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mt-6 flex flex-col space-y-3">
                                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Update Comment
                                        </button>
                                        <a href="{{ route('admin.blog.comments.index') }}" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                                            Cancel
                                        </a>
                                    </div>
                                </div>

                                <!-- Comment Details -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Details</h3>
                                    
                                    <div class="space-y-3 text-sm">
                                        <div>
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Posted:</span>
                                            <span class="text-gray-600 dark:text-gray-400">{{ $comment->created_at->format('M j, Y \a\t g:i A') }}</span>
                                        </div>
                                        
                                        @if($comment->updated_at->ne($comment->created_at))
                                            <div>
                                                <span class="font-medium text-gray-700 dark:text-gray-300">Last Modified:</span>
                                                <span class="text-gray-600 dark:text-gray-400">{{ $comment->updated_at->format('M j, Y \a\t g:i A') }}</span>
                                            </div>
                                        @endif

                                        <div>
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Current Status:</span>
                                            @if($comment->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-1">
                                                    Approved
                                                </span>
                                            @elseif($comment->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-1">
                                                    Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-1">
                                                    Spam
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                                    
                                    <div class="space-y-2">
                                        @if($comment->status !== 'approved')
                                            <form action="{{ route('admin.blog.comments.approve', $comment) }}" method="POST" class="w-full">
                                                @csrf
                                                <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                    Approve
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($comment->status !== 'spam')
                                            <form action="{{ route('admin.blog.comments.spam', $comment) }}" method="POST" class="w-full">
                                                @csrf
                                                <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                    Mark as Spam
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.blog.comments.destroy', $comment) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded text-sm">
                                                Delete Comment
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
