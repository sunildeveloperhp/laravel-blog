<x-layout title="Tags">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin panel</h1>

    @include('admin._nav')

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.tags.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
            + New tag
        </a>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Slug</th>
                    <th class="px-4 py-3 font-medium">Posts</th>
                    <th class="px-4 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($tags as $tag)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900">
                            <a href="{{ route('tags.show', $tag) }}" class="hover:text-blue-600">#{{ $tag->name }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $tag->slug }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $tag->posts_count }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="text-blue-600 hover:underline">Edit</a>

                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline ml-4"
                                  onsubmit="return confirm('Delete this tag? It will be removed from {{ $tag->posts_count }} {{ Str::plural('post', $tag->posts_count) }}.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">No tags yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>