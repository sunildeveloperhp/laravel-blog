<x-layout title="Too many requests">
    <div class="max-w-md mx-auto text-center py-16">
        <p class="text-6xl font-bold text-gray-300 mb-4">429</p>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Slow down a little</h1>
        <p class="text-gray-600 mb-8">
            You've made too many attempts in a short time. Please wait a minute and try again.
        </p>
        <a href="{{ url()->previous() }}" class="text-blue-600 font-medium hover:underline">&larr; Go back</a>
    </div>
</x-layout>