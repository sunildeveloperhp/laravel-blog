<x-layout title="Manage Posts">
    <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
            My Posts <span class="text-lg font-normal text-gray-500">({{ $posts->total() }})</span>
        </h1>

                @can('create', App\Models\Post::class)
            <a href="{{ route('dashboard.posts.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                + New post
            </a>
        @endcan
    </div>



        @cannot('create', App\Models\Post::class)
        <div class="mb-6 rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            Your account is a <strong>Reader</strong> account, so you can't write posts right now.
            Contact the site admin if you think this is a mistake.
        </div>
    @endcannot
    

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3 font-medium">Title</th>
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
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">No posts yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>