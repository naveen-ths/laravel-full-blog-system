<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Blog Post') }}
            </h2>
            <a href="{{ route('admin.blog.posts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Posts
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.blog.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Main Content -->
                            <div class="lg:col-span-2 space-y-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Title <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="title" 
                                           id="title" 
                                           value="{{ old('title', $post->title) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                           required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Slug
                                        <span class="text-gray-500 text-xs">(Leave blank to auto-generate)</span>
                                    </label>
                                    <input type="text" 
                                           name="slug" 
                                           id="slug" 
                                           value="{{ old('slug', $post->slug) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @error('slug')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Excerpt
                                    </label>
                                    <textarea name="excerpt" 
                                              id="excerpt" 
                                              rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('excerpt', $post->excerpt) }}</textarea>
                                    @error('excerpt')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Content <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="content" 
                                              id="content" 
                                              rows="15"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                              required>{{ old('content', $post->content) }}</textarea>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- SEO Section -->
                                <div class="border-t pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">SEO Settings</h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Meta Title
                                            </label>
                                            <input type="text" 
                                                   name="meta_title" 
                                                   id="meta_title" 
                                                   value="{{ old('meta_title', $post->meta_title) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            @error('meta_title')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Meta Description
                                            </label>
                                            <textarea name="meta_description" 
                                                      id="meta_description" 
                                                      rows="2"
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('meta_description', $post->meta_description) }}</textarea>
                                            @error('meta_description')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="og_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Open Graph Title
                                            </label>
                                            <input type="text" 
                                                   name="og_title" 
                                                   id="og_title" 
                                                   value="{{ old('og_title', $post->og_title) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            @error('og_title')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="og_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Open Graph Description
                                            </label>
                                            <textarea name="og_description" 
                                                      id="og_description" 
                                                      rows="2"
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('og_description', $post->og_description) }}</textarea>
                                            @error('og_description')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="space-y-6">
                                <!-- Publish Options -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Publish</h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Status <span class="text-red-500">*</span>
                                            </label>
                                            <select name="status" 
                                                    id="status"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                    required>
                                                <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="scheduled" {{ old('status', $post->status) === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                            </select>
                                            @error('status')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div id="published-at-field" style="display: {{ old('status', $post->status) === 'scheduled' ? 'block' : 'none' }};">
                                            <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Publish Date
                                            </label>
                                            <input type="datetime-local" 
                                                   name="published_at" 
                                                   id="published_at" 
                                                   value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            @error('published_at')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mt-6 flex flex-col space-y-3">
                                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Update Post
                                        </button>
                                        <a href="{{ route('admin.blog.posts.index') }}" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                                            Cancel
                                        </a>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Category</h3>
                                    
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Category <span class="text-red-500">*</span>
                                        </label>
                                        <select name="category_id" 
                                                id="category_id"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tags</h3>
                                    
                                    <div class="space-y-2">
                                        @foreach($tags as $tag)
                                            <label class="flex items-center">
                                                <input type="checkbox" 
                                                       name="tags[]" 
                                                       value="{{ $tag->id }}"
                                                       {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                                                       class="rounded mr-2">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium text-white mr-2" style="background-color: {{ $tag->color }};">
                                                    {{ $tag->name }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('tags')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Featured Image -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Featured Image</h3>
                                    
                                    @if($post->featured_image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Current featured image" class="max-w-full h-32 object-cover rounded">
                                            <p class="text-sm text-gray-500 mt-1">Current featured image</p>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <input type="file" 
                                               name="featured_image" 
                                               id="featured_image"
                                               accept="image/*"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('featured_image')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Open Graph Image -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Open Graph Image</h3>
                                    
                                    @if($post->og_image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $post->og_image) }}" alt="Current OG image" class="max-w-full h-32 object-cover rounded">
                                            <p class="text-sm text-gray-500 mt-1">Current OG image</p>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <input type="file" 
                                               name="og_image" 
                                               id="og_image"
                                               accept="image/*"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        @error('og_image')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function(e) {
            const slug = document.getElementById('slug');
            if (!slug.value || slug.value === slug.defaultValue) {
                slug.value = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });

        // Show/hide published date field based on status
        document.getElementById('status').addEventListener('change', function() {
            const publishedAtField = document.getElementById('published-at-field');
            if (this.value === 'scheduled') {
                publishedAtField.style.display = 'block';
            } else {
                publishedAtField.style.display = 'none';
            }
        });
    </script>
    @endpush
</x-app-layout>
