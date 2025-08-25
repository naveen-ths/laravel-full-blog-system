<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Slide: ') . $slide->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.slides.edit', $slide) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.slides.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Slides
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Slide Preview -->
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Slide Preview</h3>
                        <div class="relative">
                            <img src="{{ $slide->image_url }}" alt="{{ $slide->image_alt }}" class="w-full h-64 object-cover rounded">
                            @if($slide->link_url && $slide->link_text)
                                <div class="absolute bottom-4 left-4">
                                    <span class="bg-black bg-opacity-50 text-white px-4 py-2 rounded">
                                        {{ $slide->link_text }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Slide Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold border-b pb-2">Basic Information</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $slide->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $slide->description ?: 'No description provided' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Image Alt Text</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $slide->image_alt ?: 'No alt text provided' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                                <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $slide->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($slide->status) }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Sort Order</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $slide->sort_order }}</p>
                            </div>
                        </div>

                        <!-- Link Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold border-b pb-2">Link Information</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Link URL</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    @if($slide->link_url)
                                        <a href="{{ $slide->link_url }}" target="{{ $slide->link_target }}" class="text-blue-600 hover:text-blue-800 underline">
                                            {{ $slide->link_url }}
                                        </a>
                                    @else
                                        No link URL provided
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Link Text</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $slide->link_text ?: 'No link text provided' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Open in New Tab</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $slide->link_new_tab ? 'Yes' : 'No' }}</p>
                            </div>

                            <!-- Timestamps -->
                            <div class="pt-4 border-t">
                                <h4 class="text-md font-medium mb-2">Timestamps</h4>
                                <div class="space-y-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $slide->created_at->format('F j, Y g:i A') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $slide->updated_at->format('F j, Y g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <form method="POST" action="{{ route('admin.slides.destroy', $slide) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
                                        onclick="return confirm('Are you sure you want to delete this slide?')">
                                    Delete Slide
                                </button>
                            </form>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.slides.edit', $slide) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit Slide
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
