@php
    $pendingComments = App\Models\Comment::pending()->count();

    $adminLinks = [
        ['route' => 'admin.dashboard', 'label' => 'Overview', 'active' => 'admin.dashboard'],
        ['route' => 'admin.users.index', 'label' => 'Users', 'active' => 'admin.users.*'],
        ['route' => 'admin.posts.index', 'label' => 'All posts', 'active' => 'admin.posts.*'],
        ['route' => 'admin.comments.index', 'label' => 'Comments', 'active' => 'admin.comments.*', 'badge' => $pendingComments],
        ['route' => 'admin.categories.index', 'label' => 'Categories', 'active' => 'admin.categories.*'],
        ['route' => 'admin.tags.index', 'label' => 'Tags', 'active' => 'admin.tags.*'],
    ];
@endphp

<nav class="flex flex-wrap gap-2 mb-8 border-b border-gray-200 pb-4 text-sm font-medium">
    @foreach ($adminLinks as $link)
        <a href="{{ route($link['route']) }}"
           @class([
               'inline-flex items-center gap-2 px-3 py-1.5 rounded-md',
               'bg-blue-600 text-white' => request()->routeIs($link['active']),
               'text-gray-600 hover:bg-gray-100' => ! request()->routeIs($link['active']),
           ])>
            {{ $link['label'] }}

            @if (! empty($link['badge']))
                <span class="rounded-full bg-amber-500 text-white text-xs px-2 py-0.5">{{ $link['badge'] }}</span>
            @endif
        </a>
    @endforeach
</nav>