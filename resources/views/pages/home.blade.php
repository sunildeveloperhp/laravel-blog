<x-layout>
    <section class="mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-3">Welcome to {{ config('app.name') }}</h1>
        <p class="text-lg text-gray-600">Tutorials and notes on Laravel, PHP and web development.</p>
    </section>

    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Latest posts</h2>

    <div class="grid gap-6 md:grid-cols-3">
        @foreach ($posts as $post)
            <x-post-card :post="$post" />
        @endforeach
    </div>

    <div class="mt-8">
        <a href="{{ route('posts.index') }}" class="text-blue-600 font-medium hover:underline">
            View all posts &rarr;
        </a>
    </div>
</x-layout>