<x-admin-layout title="All Posts">

    <form method="GET" action="{{ route('admin.posts.index') }}" class="flex gap-3 mb-6">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by title or excerpt..."
               class="flex-1 rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">Search</button>
    </form>

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3 font-medium">Title</th>
                    <th class="px-4 py-3 font-medium">Author</th>
                    <th class="px-4 py-3 font-medium">Category</th>
                    <th class="px-4 py-3 font-medium">Published</th>
                    <th class="px-4 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($posts as $post)
                    <tr>
                        <td class="px-4 py-3">
                            <a href="{{ route('posts.show', $post) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $post->user->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $post->category->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $post->published_at?->format('j M Y') }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            @can('update', $post)
                                <a href="{{ route('dashboard.posts.edit', $post) }}" class="text-blue-600 hover:underline">Edit</a>
                            @endcan

                            @can('delete', $post)
                                <form action="{{ route('dashboard.posts.destroy', $post) }}" method="POST" class="inline ml-4"
                                      onsubmit="return confirm('Delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">No posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</x-admin-layout>