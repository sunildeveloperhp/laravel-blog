<x-layout title="Forgot password">
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Forgot your password?</h1>
        <p class="text-gray-600 mb-8">Enter your email and we'll send you a link to choose a new password.</p>

        <form action="{{ route('password.email') }}" method="POST"
              class="bg-white rounded-lg border border-gray-200 p-8 space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Email me a reset link
            </button>

            <p class="text-center text-sm">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Back to log in</a>
            </p>
        </form>
    </div>
</x-layout>