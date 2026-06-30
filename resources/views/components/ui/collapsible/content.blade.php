@blaze(fold: true)

@aware(['transition' => true])

@props([
    'style' => null,
    'class' => null,
])

@php
    $transition = filter_var($transition, FILTER_VALIDATE_BOOLEAN);

    $presetClass = (new \AiluraCode\Bladcn\Support\ClassResolver())->add(
        'overflow-hidden',
    );

    $presetAttributes = [
        'data-slot' => 'collapsible-content',
        'x-bind:id' => 'id + \'-content\'',
        'x-bind:data-state' => 'isOpen ? \'open\' : \'closed\'',
        'x-show' => 'isOpen',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}
    @if ($transition) x-collapse.duration.200ms @endif
    x-cloak>
    {{ $slot }}
</div>
