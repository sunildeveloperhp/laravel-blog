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
                <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.*')">Posts</x-nav-link>
                <x-nav-link :href="route('about')" :active="request()->routeIs('about')">About</x-nav-link>
                <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">Contact</x-nav-link>

                @auth
                    <x-nav-link :href="route('dashboard.posts.index')" :active="request()->routeIs('dashboard.*')">Dashboard</x-nav-link>

                    @can('access-admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">Admin</x-nav-link>
                    @endcan

                    @can('create', App\Models\Post::class)
                        <a href="{{ route('dashboard.posts.create') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Write a post
                        </a>
                    @endcan

                    <span class="text-gray-400">|</span>

                    @php
                        $unreadCount = auth()->user()->unreadNotifications()->count();
                    @endphp
                    <a href="{{ route('notifications.index') }}" class="relative text-lg leading-none" title="Notifications">
                        🔔
                        @if ($unreadCount > 0)
                            <span class="absolute -top-2 -right-3 rounded-full bg-red-600 text-white text-[10px] font-semibold px-1.5 py-0.5">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </a>

                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">{{ auth()->user()->name }}</x-nav-link>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">Log out</button>
                    </form>
                @endauth

                @guest
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">Log in</x-nav-link>

                    <a href="{{ route('register') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Register
                    </a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 py-10">
        @if (session('success'))
            <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-5xl mx-auto px-4 py-6 text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </footer>

</body>
</html>