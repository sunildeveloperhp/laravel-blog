<x-layout title="Edit tag">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin panel</h1>

    @include('admin._nav')

    <form action="{{ route('admin.tags.update', $tag) }}" method="POST"
          class="max-w-md bg-white rounded-lg border border-gray-200 p-8 space-y-6">
        @csrf
        @method('PUT')

        <h2 class="text-lg font-semibold text-gray-900">Edit tag</h2>

        @include('admin.tags._form')

        <p class="text-xs text-gray-500">The URL stays <code>/tags/{{ $tag->slug }}</code> even if you rename it.</p>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Save</button>
            <a href="{{ route('admin.tags.index') }}" class="text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</x-layout>