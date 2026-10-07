<x-layout :title="$user->name">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Posts by {{ $user->name }}</h1>
    <p class="text-sm text-gray-500 mb-8">{{ $posts->total() }} {{ Str::plural('post', $posts->total()) }}</p>

    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <p class="text-gray-500">{{ $user->name }} hasn't published any posts yet.</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
</x-layout>