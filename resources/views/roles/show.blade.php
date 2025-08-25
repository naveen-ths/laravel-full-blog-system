<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Role Details') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $role->name }}</h3>
                </div>
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Permissions</h4>
                    <div class="flex flex-wrap gap-2">
                        @forelse($role->permissions as $permission)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $permission->name }}</span>
                        @empty
                            <span class="text-gray-500">No permissions assigned.</span>
                        @endforelse
                    </div>
                </div>
                <div class="mb-4">
                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Users with this Role</h4>
                    <ul class="list-disc pl-5">
                        @forelse($role->users as $user)
                            <li class="text-gray-800 dark:text-gray-100">{{ $user->name }} <span class="text-xs text-gray-400">({{ $user->email }})</span></li>
                        @empty
                            <li class="text-gray-500">No users assigned.</li>
                        @endforelse
                    </ul>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('admin.roles.edit', $role) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                    <a href="{{ route('admin.roles.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
