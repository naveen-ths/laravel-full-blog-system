<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $page->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('pages.edit', $page) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Edit Page
                </a>
                @if($page->status === 'published')
                    <a href="{{ route('pages.public', $page->slug) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        View Live
                    </a>
                @endif
                <a href="{{ route('pages.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Page Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Page Information</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Title:</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug:</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->slug }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status:</dt>
                                    <dd class="text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($page->status === 'published') bg-green-100 text-green-800 
                                            @elseif($page->status === 'draft') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($page->status) }}
                                        </span>
                                        @if($page->is_featured)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">
                                                Featured
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sort Order:</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->sort_order }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Publishing Details</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Author:</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->author->name ?? 'Unknown' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated By:</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->updatedBy->name ?? 'Unknown' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created:</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->created_at->format('M d, Y g:i A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated:</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->updated_at->format('M d, Y g:i A') }}</dd>
                                </div>
                                @if($page->published_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Published:</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->published_at->format('M d, Y g:i A') }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Excerpt -->
                    @if($page->excerpt)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Excerpt</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-gray-700 dark:text-gray-300">{{ $page->excerpt }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Featured Image -->
                    @if($page->featured_image)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Featured Image</h3>
                            <div class="max-w-2xl">
                                <img src="{{ $page->featured_image }}" 
                                     alt="{{ $page->featured_image_alt ?? $page->title }}" 
                                     class="w-full h-auto rounded-lg shadow-md">
                                @if($page->featured_image_caption)
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 italic">{{ $page->featured_image_caption }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Content</h3>
                        <div class="prose max-w-none dark:prose-invert bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                            {!! $page->content !!}
                        </div>
                    </div>

                    <!-- SEO Information -->
                    @if($page->meta_title || $page->meta_description || $page->meta_keywords)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">SEO Information</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg space-y-3">
                                @if($page->meta_title)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Meta Title:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->meta_title }}</dd>
                                    </div>
                                @endif
                                @if($page->meta_description)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Meta Description:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->meta_description }}</dd>
                                    </div>
                                @endif
                                @if($page->meta_keywords)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Meta Keywords:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $page->meta_keywords }}</dd>
                                    </div>
                                @endif
                                @if($page->canonical_url)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Canonical URL:</dt>
                                        <dd class="text-sm text-gray-900 dark:text-gray-100">
                                            <a href="{{ $page->canonical_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ $page->canonical_url }}
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Banner Image -->
                    @if($page->banner_image)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Banner Image</h3>
                            <div class="max-w-4xl">
                                <img src="{{ $page->banner_image }}" 
                                     alt="{{ $page->banner_image_alt ?? 'Banner image' }}" 
                                     class="w-full h-auto rounded-lg shadow-md">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
