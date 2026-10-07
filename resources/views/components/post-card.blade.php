@props(['post'])

<article class="bg-white rounded-lg border border-gray-200 p-6 hover:shadow-md transition">
    <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
        <a href="{{ route('categories.show', $post->category->slug) }}"
           class="font-semibold uppercase tracking-wide text-blue-600 hover:underline">
            {{ $post->category->name }}
        </a>
        <span>&middot;</span>
        <span>{{ $post->published_at?->format('j M Y') }}</span>
    </div>

    <h2 class="text-xl font-semibold text-gray-900 mb-2">
        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">
            {{ $post->title }}
        </a>
    </h2>

    <p class="text-gray-600">{{ $post->excerpt }}</p>

    <p class="text-sm text-gray-500 mt-4">By {{ $post->user->name }}</p>
</article>