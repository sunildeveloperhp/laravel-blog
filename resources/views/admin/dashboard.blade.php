<x-admin-layout title="Admin">

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        @foreach ($stats as $label => $count)
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <p class="text-sm text-gray-500">{{ $label }}</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $count }}</p>
            </div>
        @endforeach
    </div>

    <h2 class="text-lg font-semibold text-gray-900 mb-3">Newest users</h2>

    <div class="bg-white rounded-lg border border-gray-200 divide-y divide-gray-200">
        @foreach ($latestUsers as $user)
            <div class="px-4 py-3 flex items-center justify-between text-sm">
                <span class="text-gray-900">
                    {{ $user->name }} <span class="text-gray-500">({{ $user->email }})</span>
                </span>
                <span class="text-gray-500">
                    {{ $user->role->label() }} &middot; joined {{ $user->created_at->diffForHumans() }}
                </span>
            </div>
        @endforeach
    </div>
</x-admin-layout>