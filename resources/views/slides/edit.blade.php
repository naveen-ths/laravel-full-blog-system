<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Slide: ') . $slide->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.slides.show', $slide) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    View
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
                    
                    <form method="POST" action="{{ route('admin.slides.update', $slide) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        @include('slides.form')

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('admin.slides.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Slide
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
