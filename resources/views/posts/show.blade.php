<x-layout :title="$post->title">
    <article class="max-w-3xl mx-auto bg-white rounded-lg border border-gray-200 overflow-hidden">
        @if ($post->featured_image_url)
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                 class="w-full max-h-[28rem] object-cover">
        @endif

        <div class="p-8">
            <a href="{{ route('categories.show', $post->category) }}"
               class="text-xs font-semibold uppercase tracking-wide text-blue-600 hover:underline">
                {{ $post->category->name }}
            </a>

            <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-3">{{ $post->title }}</h1>

            <p class="text-sm text-gray-500 mb-8">
                By {{ $post->user->name }} &middot; {{ $post->published_at?->format('j M Y') }}
            </p>

            <div class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $post->body }}</div>

            @if ($post->tags->isNotEmpty())
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag) }}"
                           class="text-xs bg-gray-100 text-gray-700 px-3 py-1 rounded-full hover:bg-blue-50 hover:text-blue-700">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </article>

    <div class="max-w-3xl mx-auto mt-6">
        <a href="{{ route('posts.index') }}" class="text-blue-600 font-medium hover:underline">
            &larr; Back to all posts
        </a>
    </div>
</x-layout>