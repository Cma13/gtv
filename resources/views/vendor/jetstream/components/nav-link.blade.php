@props(['active'])

@php
$classes = ($active ?? false)
            ? 'font-bold text-base inline-flex items-center pt-1 border-b-2 border-sky-900 text-sm font-medium leading-5 text-sky-900 focus:outline-none focus:border-indigo-700 transition'
            : 'font-bold text-base inline-flex items-center pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
