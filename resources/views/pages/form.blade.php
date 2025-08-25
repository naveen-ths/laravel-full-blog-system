<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($page) ? __('Edit Page') : __('Create New Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ isset($page) ? route('pages.update', $page) : route('pages.store') }}" method="POST" class="space-y-6">
                        @csrf
                        @if(isset($page))
                            @method('PUT')
                        @endif

                        <!-- Basic Information -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Basic Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title *</label>
                                    <input type="text" name="title" id="title" required
                                           value="{{ old('title', $page->title ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                </div>

                                <div>
                                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                                    <input type="text" name="slug" id="slug"
                                           value="{{ old('slug', $page->slug ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Leave empty to auto-generate from title</p>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Excerpt</label>
                                    <textarea name="excerpt" id="excerpt" rows="3"
                                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">{{ old('excerpt', $page->excerpt ?? '') }}</textarea>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content *</label>
                                    <textarea name="content" id="content" rows="12" required
                                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">{{ old('content', $page->content ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Publishing Options -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Publishing Options</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status *</label>
                                    <select name="status" id="status" required
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                        <option value="draft" {{ old('status', $page->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ old('status', $page->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="private" {{ old('status', $page->status ?? '') === 'private' ? 'selected' : '' }}>Private</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                                    <input type="number" name="sort_order" id="sort_order" min="0"
                                           value="{{ old('sort_order', $page->sort_order ?? 0) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                </div>

                                <div>
                                    <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Publish Date</label>
                                    <input type="datetime-local" name="published_at" id="published_at"
                                           value="{{ old('published_at', $page && $page->published_at ? $page->published_at->format('Y-m-d\TH:i') : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                </div>

                                <div class="md:col-span-3">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                               {{ old('is_featured', $page->is_featured ?? false) ? 'checked' : '' }}
                                               class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                        <label for="is_featured" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Featured Page</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">SEO Settings</h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title" maxlength="255"
                                           value="{{ old('meta_title', $page->meta_title ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                </div>

                                <div>
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="3" maxlength="500"
                                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                                </div>

                                <div>
                                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Keywords</label>
                                    <input type="text" name="meta_keywords" id="meta_keywords"
                                           value="{{ old('meta_keywords', $page->meta_keywords ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Separate keywords with commas</p>
                                </div>

                                <div>
                                    <label for="canonical_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Canonical URL</label>
                                    <input type="url" name="canonical_url" id="canonical_url"
                                           value="{{ old('canonical_url', $page->canonical_url ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Featured Image</h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Featured Image URL</label>
                                    <input type="url" name="featured_image" id="featured_image"
                                           value="{{ old('featured_image', $page->featured_image ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="featured_image_alt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alt Text</label>
                                        <input type="text" name="featured_image_alt" id="featured_image_alt"
                                               value="{{ old('featured_image_alt', $page->featured_image_alt ?? '') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                    </div>

                                    <div>
                                        <label for="featured_image_caption" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Caption</label>
                                        <input type="text" name="featured_image_caption" id="featured_image_caption"
                                               value="{{ old('featured_image_caption', $page->featured_image_caption ?? '') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Banner Image -->
                        <div class="pb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Banner Image</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="banner_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Image URL</label>
                                    <input type="url" name="banner_image" id="banner_image"
                                           value="{{ old('banner_image', $page->banner_image ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                </div>

                                <div>
                                    <label for="banner_image_alt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Banner Alt Text</label>
                                    <input type="text" name="banner_image_alt" id="banner_image_alt"
                                           value="{{ old('banner_image_alt', $page->banner_image_alt ?? '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('pages.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ isset($page) ? 'Update Page' : 'Create Page' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            const slugField = document.getElementById('slug');
            if (!slugField.value || slugField.dataset.manual !== 'true') {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
                slugField.value = slug;
            }
        });

        // Mark slug as manually edited
        document.getElementById('slug').addEventListener('input', function() {
            this.dataset.manual = 'true';
        });
    </script>
    @endpush
</x-app-layout>
