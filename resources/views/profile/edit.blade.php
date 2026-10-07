<x-layout title="Your profile">
    <div class="max-w-2xl mx-auto space-y-8">
                <div class="flex items-center gap-3">
            <h1 class="text-3xl font-bold text-gray-900">Your profile</h1>
            <span class="text-xs font-semibold uppercase tracking-wide bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                {{ $user->role->label() }}
            </span>
        </div>  

        {{-- Name and email --}}
        <form action="{{ route('profile.update') }}" method="POST"
              class="bg-white rounded-lg border border-gray-200 p-8 space-y-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-semibold text-gray-900">Profile information</h2>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if ($user->hasVerifiedEmail())
                    <p class="mt-1 text-xs text-green-700">Verified</p>
                @else
                    <p class="mt-1 text-xs text-amber-700">Not verified yet. Changing your email sends a new verification link.</p>
                @endif
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Save profile
            </button>
        </form>

        {{-- Password --}}
        <form action="{{ route('profile.password') }}" method="POST"
              class="bg-white rounded-lg border border-gray-200 p-8 space-y-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-semibold text-gray-900">Change password</h2>

            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current password</label>
                <input type="password" id="current_password" name="current_password" required autocomplete="current-password"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New password</label>
                <input type="password" id="password" name="password" required autocomplete="new-password"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm new password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Change password
            </button>
        </form>
    </div>
</x-layout>