<x-layout title="Verify your email">
    <div class="max-w-md mx-auto bg-white rounded-lg border border-gray-200 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Verify your email</h1>

        <p class="text-gray-700 mb-6">
            We sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
            Click the link in that email to start writing posts.
        </p>

        <form action="{{ route('verification.send') }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Resend verification email
            </button>
        </form>

        <p class="text-sm text-gray-500">
            Wrong email address?
            <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline">Change it in your profile</a>.
        </p>
    </div>
</x-layout>