<x-layout title="Comments">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin panel</h1>

    @include('admin._nav')

    <div class="flex gap-4 mb-6 text-sm font-medium">
        <a href="{{ route('admin.comments.index') }}"
           @class(['pb-1 border-b-2', 'border-blue-600 text-blue-600' => $status === 'pending', 'border-transparent text-gray-500 hover:text-gray-900' => $status !== 'pending'])>
            Pending ({{ $pendingCount }})
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}"
           @class(['pb-1 border-b-2', 'border-blue-600 text-blue-600' => $status === 'approved', 'border-transparent text-gray-500 hover:text-gray-900' => $status !== 'approved'])>
            Approved
        </a>
    </div>

    <div class="space-y-4">
        @forelse ($comments as $comment)
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                <div class="flex flex-wrap items-center justify-between gap-2 text-sm mb-2">
                    <span>
                        <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                        <span class="text-gray-500">on</span>
                        <a href="{{ route('posts.show', $comment->post) }}#comments" class="text-blue-600 hover:underline">
                            {{ Str::limit($comment->post->title, 50) }}
                        </a>
                        @if ($comment->post->trashed())
                            <span class="text-xs text-red-600">(post in trash)</span>
                        @endif
                    </span>
                    <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>

                <p class="text-gray-700 whitespace-pre-line mb-4">{{ $comment->body }}</p>

                <div class="flex items-center gap-4 text-sm">
                    @unless ($comment->isApproved())
                        <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-600 text-white px-4 py-1.5 rounded-md hover:bg-green-700">Approve</button>
                        </form>
                    @endunless

                    <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                          onsubmit="return confirm('Delete this comment?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500">
                {{ $status === 'pending' ? 'No comments waiting for approval. 🎉' : 'No approved comments yet.' }}
            </p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $comments->links() }}
    </div>
</x-layout>