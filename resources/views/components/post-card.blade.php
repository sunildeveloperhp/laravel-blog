@props(['post'])

<article class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition">
    <a href="{{ route('posts.show', $post) }}" class="block">
        @if ($post->featured_image_url)
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                 class="w-full h-48 object-cover" loading="lazy">
        @else
            <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-sm font-semibold uppercase tracking-wide text-gray-400">
                {{ $post->category->name }}
            </div>
        @endif
    </a>

    <div class="p-6">
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
            <a href="{{ route('categories.show', $post->category) }}"
               class="font-semibold uppercase tracking-wide text-blue-600 hover:underline">
                {{ $post->category->name }}
            </a>
            <span>&middot;</span>
            <span>{{ $post->published_at?->format('j M Y') }}</span>
        </div>

        <h2 class="text-xl font-semibold text-gray-900 mb-2">
            <a href="{{ route('posts.show', $post) }}" class="hover:text-blue-600">
                {{ $post->title }}
            </a>
        </h2>

        <p class="text-gray-600">{{ $post->excerpt }}</p>

                <p class="text-sm text-gray-500 mt-4">
            By <a href="{{ route('authors.show', $post->user) }}" class="hover:text-blue-600 hover:underline">{{ $post->user->name }}</a>
        </p>
    </div>
</article>