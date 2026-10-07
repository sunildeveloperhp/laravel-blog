@props(['title' => 'Admin'])

<x-layout :title="$title">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin panel</h1>

    @include('admin._nav')

    {{ $slot }}
</x-layout>