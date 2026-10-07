<x-layout title="Log in">
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Log in</h1>
        <p class="text-gray-600 mb-8">
            New here?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Create an account</a>
        </p>

        <form action="{{ route('login') }}" method="POST"
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

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot your password?</a>
                </div>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="remember" value="1" class="rounded border-gray-300">
                Remember me
            </label>

            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Log in
            </button>
        </form>
    </div>
</x-layout>