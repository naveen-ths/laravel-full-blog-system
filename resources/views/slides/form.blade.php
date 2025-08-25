<div class="space-y-6">
    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slide Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $slide->name ?? '') }}" required
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
        <textarea name="description" id="description" rows="3"
                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">{{ old('description', $slide->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Current Image (for edit) -->
    @if(isset($slide) && $slide->image)
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Image</label>
            <div class="mt-1">
                <img src="{{ $slide->image_url }}" alt="{{ $slide->image_alt }}" class="h-32 w-48 object-cover rounded">
            </div>
        </div>
    @endif

    <!-- Image Upload -->
    <div>
        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Slide Image {{ isset($slide) ? '(leave empty to keep current)' : '' }}
        </label>
        <input type="file" name="image" id="image" accept="image/*" {{ !isset($slide) ? 'required' : '' }}
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
        <p class="mt-1 text-sm text-gray-500">Accepted formats: JPEG, PNG, JPG, GIF, WebP. Max size: 2MB</p>
        @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Image Alt Text -->
    <div>
        <label for="image_alt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Image Alt Text</label>
        <input type="text" name="image_alt" id="image_alt" value="{{ old('image_alt', $slide->image_alt ?? '') }}"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
        @error('image_alt')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Link Section -->
    <div class="border-t pt-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Link Settings (Optional)</h3>
        
        <!-- Link URL -->
        <div class="mb-4">
            <label for="link_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link URL</label>
            <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $slide->link_url ?? '') }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
            @error('link_url')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Link Text -->
        <div class="mb-4">
            <label for="link_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link Text</label>
            <input type="text" name="link_text" id="link_text" value="{{ old('link_text', $slide->link_text ?? '') }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
            @error('link_text')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Open in New Tab -->
        <div>
            <div class="flex items-center">
                <input type="checkbox" name="link_new_tab" id="link_new_tab" value="1" 
                       {{ old('link_new_tab', $slide->link_new_tab ?? false) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="link_new_tab" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                    Open link in new tab
                </label>
            </div>
            @error('link_new_tab')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Status and Sort Order -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
            <select name="status" id="status" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                <option value="active" {{ old('status', $slide->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $slide->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Sort Order -->
        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $slide->sort_order ?? 0) }}" min="0" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
            @error('sort_order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
