<x-layout :title="$post->title">
    <article class="max-w-3xl mx-auto bg-white rounded-lg border border-gray-200 p-8">
        <a href="{{ route('categories.show', $post->category->slug) }}"
           class="text-xs font-semibold uppercase tracking-wide text-blue-600 hover:underline">
            {{ $post->category->name }}
        </a>

        <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-3">{{ $post->title }}</h1>

        <p class="text-sm text-gray-500 mb-8">
            By {{ $post->user->name }} &middot; {{ $post->published_at?->format('j M Y') }}
        </p>

        <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $post->body }}</div>
    </article>

    <div class="max-w-3xl mx-auto mt-6">
        <a href="{{ route('posts.index') }}" class="text-blue-600 font-medium hover:underline">
            &larr; Back to all posts
        </a>
    </div>
</x-layout>