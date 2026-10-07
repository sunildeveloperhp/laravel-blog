<x-layout title="Contact">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Contact</h1>
        <p class="text-gray-600 mb-8">Have a question or a topic you want covered? Send us a message.</p>

        <form action="{{ route('contact.send') }}" method="POST"
              class="bg-white rounded-lg border border-gray-200 p-8 space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your name</label>
                <input type="text" id="name" name="name" required maxlength="100" autocomplete="name"
                       value="{{ old('name', auth()->user()?->name) }}"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Your email</label>
                <input type="email" id="email" name="email" required maxlength="255" autocomplete="email"
                       value="{{ old('email', auth()->user()?->email) }}"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea id="message" name="message" rows="6" required maxlength="2000"
                          class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Send message
            </button>
        </form>
    </div>
</x-layout>