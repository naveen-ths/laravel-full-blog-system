<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tag: ') . $tag->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.blog.tags.edit', $tag) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Tag
                </a>
                <a href="{{ route('admin.blog.tags.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Tags
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Tag Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tag Details</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Name:</span>
                                    <div class="flex items-center mt-1">
                                        @if($tag->color)
                                            <div class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $tag->color }};"></div>
                                        @endif
                                        <p class="text-gray-900 dark:text-gray-100">{{ $tag->name }}</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Slug:</span>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $tag->slug }}</p>
                                </div>
                                
                                @if($tag->color)
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Color:</span>
                                        <div class="flex items-center mt-1">
                                            <div class="w-8 h-8 rounded-md mr-3" style="background-color: {{ $tag->color }};"></div>
                                            <span class="text-gray-900 dark:text-gray-100">{{ $tag->color }}</span>
                                        </div>
                                    </div>
                                @endif
                                
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Total Posts:</span>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $tag->posts->count() }}</p>
                                </div>
                                
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Created:</span>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $tag->created_at->format('M j, Y \a\t g:i A') }}</p>
                                </div>
                                
                                @if($tag->updated_at->ne($tag->created_at))
                                    <div>
                                        <span class="font-medium text-gray-700 dark:text-gray-300">Last Updated:</span>
                                        <p class="text-gray-900 dark:text-gray-100">{{ $tag->updated_at->format('M j, Y \a\t g:i A') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Posts with this Tag</h3>
                            </div>
                            
                            @if($tag->posts->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Title
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Category
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Author
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Published
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($tag->posts as $post)
                                                <tr>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                            {{ Str::limit($post->title, 40) }}
                                                        </div>
                                                        @if($post->excerpt)
                                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                                {{ Str::limit($post->excerpt, 60) }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $post->category->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                        {{ $post->author->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if($post->status === 'published')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                Published
                                                            </span>
                                                        @elseif($post->status === 'draft')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                Draft
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                Scheduled
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                        @if($post->published_at)
                                                            {{ $post->published_at->format('M j, Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('admin.blog.posts.show', $post) }}" class="text-indigo-600 hover:text-indigo-900">
                                                                View
                                                            </a>
                                                            <a href="{{ route('admin.blog.posts.edit', $post) }}" class="text-blue-600 hover:text-blue-900">
                                                                Edit
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500 dark:text-gray-400">No posts found with this tag.</p>
                                    <a href="{{ route('admin.blog.posts.create') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-900">
                                        Create your first post
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
