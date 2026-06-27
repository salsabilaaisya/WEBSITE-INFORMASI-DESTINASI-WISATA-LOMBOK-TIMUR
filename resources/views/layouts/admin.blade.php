@php
    $title = trim(View::yieldContent('title')) ?: null;
@endphp

<x-layouts::app.sidebar :title="$title">
    <flux:main>
        <x-flash-message />
        @yield('content')
    </flux:main>
</x-layouts::app.sidebar>
