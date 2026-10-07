@props(['title' => null])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title . ' | ' . config('app.name') : config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <header class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">
                {{ config('app.name') }}
            </a>

            <nav class="flex items-center gap-6 text-sm font-medium">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
                <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index', 'posts.show')">Posts</x-nav-link>
                <x-nav-link :href="route('about')" :active="request()->routeIs('about')">About</x-nav-link>
                <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">Contact</x-nav-link>

                <a href="{{ route('posts.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Write a post
                </a>
            </nav>
        </div>
    </header>

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 py-10">
        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-5xl mx-auto px-4 py-6 text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </footer>

</body>
</html>