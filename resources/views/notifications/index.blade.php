<x-layout title="Notifications">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>

            @if (auth()->user()->unreadNotifications()->exists())
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:underline">Mark all as read</button>
                </form>
            @endif
        </div>

        <div class="space-y-3">
            @forelse ($notifications as $notification)
                <a href="{{ route('notifications.read', $notification->id) }}"
                   @class([
                       'block rounded-lg border p-4 hover:shadow-sm transition',
                       'bg-blue-50 border-blue-200' => $notification->unread(),
                       'bg-white border-gray-200' => $notification->read(),
                   ])>
                    <div class="flex items-center justify-between text-sm mb-1">
                        <span class="text-gray-900">
                            <strong>{{ $notification->data['commenter_name'] }}</strong>
                            commented on
                            <strong>{{ $notification->data['post_title'] }}</strong>
                        </span>
                        <span class="text-gray-500 whitespace-nowrap ml-4">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-600">"{{ $notification->data['excerpt'] }}"</p>
                </a>
            @empty
                <p class="text-gray-500">No notifications yet.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</x-layout>