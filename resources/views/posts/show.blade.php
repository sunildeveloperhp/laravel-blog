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

            @can('update', $post)
                <a href="{{ route('dashboard.posts.edit', $post) }}"
                   class="float-right text-sm bg-gray-100 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-200">
                    Edit this post
                </a>
            @endcan

            <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-3">{{ $post->title }}</h1>

            <p class="text-sm text-gray-500 mb-8">
                By <a href="{{ route('authors.show', $post->user) }}" class="hover:text-blue-600 hover:underline">{{ $post->user->name }}</a>
                &middot; {{ $post->published_at?->format('j M Y') }}
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

    {{-- Comments --}}
    <section id="comments" class="max-w-3xl mx-auto mt-10">
        <h2 class="text-xl font-bold text-gray-900 mb-4">
            Comments ({{ $comments->whereNotNull('approved_at')->count() }})
        </h2>

        @if (session('comment_status'))
            <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('comment_status') }}
            </div>
        @endif

        <div class="space-y-4 mb-8">
            @forelse ($comments as $comment)
                <div @class([
                    'rounded-lg border p-5',
                    'bg-white border-gray-200' => $comment->isApproved(),
                    'bg-amber-50 border-amber-200' => ! $comment->isApproved(),
                ])>
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                        <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>

                    <p class="text-gray-700 whitespace-pre-line">{{ $comment->body }}</p>

                    @unless ($comment->isApproved())
                        <p class="mt-2 text-xs font-medium text-amber-700">Waiting for approval. Only you can see this.</p>
                    @endunless
                </div>
            @empty
                <p class="text-gray-500">No comments yet. Be the first to share your thoughts.</p>
            @endforelse
        </div>

        @auth
            @if (auth()->user()->hasVerifiedEmail())
                <form action="{{ route('comments.store', $post) }}" method="POST"
                      class="bg-white rounded-lg border border-gray-200 p-6 space-y-4">
                    @csrf

                    <label for="body" class="block text-sm font-medium text-gray-700">Leave a comment</label>
                    <textarea id="body" name="body" rows="4" required maxlength="1000"
                              @class([
                                  'w-full rounded-md border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500',
                                  'border-red-500' => $errors->has('body'),
                                  'border-gray-300' => ! $errors->has('body'),
                              ])>{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">
                        Post comment
                    </button>
                </form>
            @else
                <p class="text-gray-600">
                    <a href="{{ route('verification.notice') }}" class="text-blue-600 hover:underline">Verify your email</a>
                    to join the conversation.
                </p>
            @endif
        @else
            <p class="text-gray-600">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
                or
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">create an account</a>
                to leave a comment.
            </p>
        @endauth
    </section>

    <div class="max-w-3xl mx-auto mt-10">
        <a href="{{ route('posts.index') }}" class="text-blue-600 font-medium hover:underline">
            &larr; Back to all posts
        </a>
    </div>
</x-layout>