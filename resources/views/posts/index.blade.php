<x-layout title="All Posts">
    <div class="flex items-baseline justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">All Posts</h1>
        <p class="text-sm text-gray-500">{{ $posts->total() }} {{ Str::plural('post', $posts->total()) }}</p>
    </div>

    {{-- Search and filter form. GET puts the values in the URL, so results can be bookmarked and shared. --}}
    <form method="GET" action="{{ route('posts.index') }}" class="flex flex-col sm:flex-row gap-3 mb-8">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search posts..."
               class="flex-1 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <select name="category"
                class="rounded-md border border-gray-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">Search</button>

        @if (request()->filled('q') || request()->filled('category'))
            <a href="{{ route('posts.index') }}" class="self-center text-sm text-gray-600 hover:underline">Clear</a>
        @endif
    </form>

    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <p class="text-gray-500">No posts match your search.</p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $posts->links() }}
    </div>
</x-layout>