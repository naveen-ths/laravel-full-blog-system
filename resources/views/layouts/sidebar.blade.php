<aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 hidden md:flex flex-col">
    <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
    </div>
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-bold text-gray-700 dark:text-gray-200 tracking-wide uppercase">Admin Panel</h2>
    </div>
    <nav class="mt-2 flex-1">
        <ul class="space-y-1">
            <li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Dashboard</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('pages.index')" :active="request()->routeIs('pages.*')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Manage Pages</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('admin.slides.index')" :active="request()->routeIs('admin.slides.*')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Manage Slides</span>
                </x-nav-link>
            </li>
            @role('superadmin')
            <li>
                <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Manage Users</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Manage Roles</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('admin.permissions.index')" :active="request()->routeIs('admin.permissions.*')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Manage Permissions</span>
                </x-nav-link>
            </li>
            <!-- Blog Management Section -->
            <li class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4">
                <div class="px-4 py-2">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Blog Management</h3>
                </div>
            </li>
            <li>
                <x-nav-link :href="route('admin.blog.posts.index')" :active="request()->routeIs('admin.blog.posts.*')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Blog Posts</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('admin.blog.categories.index')" :active="request()->routeIs('admin.blog.categories.*')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Categories</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('admin.blog.tags.index')" :active="request()->routeIs('admin.blog.tags.*')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Tags</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('admin.blog.comments.index')" :active="request()->routeIs('admin.blog.comments.*')" class="flex items-center px-4 py-2 rounded-lg transition-colors hover:bg-blue-50 dark:hover:bg-gray-700">
                    <span class="ml-2">Comments</span>
                </x-nav-link>
            </li>
            @endrole
        </ul>
    </nav>
</aside>
