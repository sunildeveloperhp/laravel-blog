<x-layout title="All Posts">
    <div class="flex items-baseline justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900">All Posts</h1>

        <p class="text-sm text-gray-500">
            @if ($posts->count() === 1)
                1 post
            @else
                {{ $posts->count() }} posts
            @endif
        </p>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <p class="text-gray-500">No posts yet.</p>
        @endforelse
    </div>
</x-layout>