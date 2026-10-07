<x-layout :title="$categoryName">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Category: {{ $categoryName }}</h1>

    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <p class="text-gray-500">No posts in this category yet.</p>
        @endforelse
    </div>
</x-layout>