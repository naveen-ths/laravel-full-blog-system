<!-- Topbar (desktop & mobile) -->
<header
  class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between h-16 px-4">
  <div class="flex items-center gap-4">
    <button @click="open = !open" class="md:hidden text-gray-500 dark:text-gray-400 focus:outline-none">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
    <!-- Logo removed from topbar -->
  </div>
  <div class="relative" x-data="{ open: false }">
    <button @click="open = !open"
      class="flex items-center space-x-2 focus:outline-none px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
      <span class="inline-block h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-700"></span>
      <span class="hidden md:block text-gray-800 dark:text-gray-200 font-medium">{{ Auth::user()->name }}</span>
      <svg class="w-4 h-4 ml-1 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>
    <div x-show="open" @click.away="open = false"
      class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded shadow-lg z-50"
      style="display: none;">
      <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
        <div class="font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
      </div>
      <a href="{{ route('profile.edit') }}"
        class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
          class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Log
          Out</button>
      </form>
    </div>
  </div>
</header>
