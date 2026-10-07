<x-layout title="Edit Post">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit post</h1>

        <form action="{{ route('dashboard.posts.update', $post) }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-lg border border-gray-200 p-8 space-y-6">
            @csrf
            @method('PUT')

            @include('dashboard.posts._form')

            <div class="flex items-center gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    Update post
                </button>
                <a href="{{ route('dashboard.posts.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</x-layout>