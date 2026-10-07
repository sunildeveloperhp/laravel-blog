@props(['active' => false])

<a {{ $attributes->class([
    'text-blue-600' => $active,
    'text-gray-600 hover:text-gray-900' => ! $active,
]) }}>
    {{ $slot }}
</a>