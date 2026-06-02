@props(['defaultTab' => '', 'errorTab' => ''])

<div x-data="{ activeTab: '{{ $errorTab ?: $defaultTab }}' }">
    {{ $slot }}
</div>
