<x-layout title="Not allowed">
    <div class="max-w-md mx-auto text-center py-16">
        <p class="text-6xl font-bold text-gray-300 mb-4">403</p>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">You can't do that</h1>
        <p class="text-gray-600 mb-8">You don't have permission to access this page.</p>
        <a href="{{ route('home') }}" class="text-blue-600 font-medium hover:underline">&larr; Back to the home page</a>
    </div>
</x-layout>