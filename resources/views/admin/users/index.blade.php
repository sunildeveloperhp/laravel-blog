<x-admin-layout title="All Users">
    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Email</th>
                    <th class="px-4 py-3 font-medium">Posts</th>
                    <th class="px-4 py-3 font-medium">Verified</th>
                    <th class="px-4 py-3 font-medium">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-3">
                            <a href="{{ route('authors.show', $user) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->posts_count }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->hasVerifiedEmail() ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3">
                            @if ($user->is(auth()->user()))
                                <span class="text-gray-700">{{ $user->role->label() }}</span>
                                <span class="text-xs text-gray-400">(you)</span>
                            @else
                                <form action="{{ route('admin.users.role', $user) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="rounded-md border border-gray-300 px-2 py-1 bg-white">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->value }}" @selected($user->role === $role)>
                                                {{ $role->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="text-blue-600 hover:underline">Save</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</x-admin-layout>