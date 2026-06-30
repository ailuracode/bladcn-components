@blaze(fold: true)

@props([
    'asChild' => true,
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'type' => 'button',
        'data-slot' => 'dialog-trigger',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }

    $alpineAttributes = [
        'x-on:click' => '$store.dialog.open(id, { trigger: $event.target })',
        'x-bind:data-state' =>
            '$store.dialog.isOpen(id) ? \'open\' : \'closed\'',
        'x-bind:aria-expanded' => '$store.dialog.isOpen(id)',
    ];
@endphp

<x-ui.abstract :as-child="$asChild"
    {{ $attributes->merge($presetAttributes)->merge($alpineAttributes)->class($class) }}
    default-tag="button">
    {{ $slot }}
</x-ui.abstract>
