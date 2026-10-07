<x-layout title="New tag">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin panel</h1>

    @include('admin._nav')

    <form action="{{ route('admin.tags.store') }}" method="POST"
          class="max-w-md bg-white rounded-lg border border-gray-200 p-8 space-y-6">
        @csrf

        <h2 class="text-lg font-semibold text-gray-900">New tag</h2>

        @include('admin.tags._form')

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">Create</button>
            <a href="{{ route('admin.tags.index') }}" class="text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</x-layout>