@blaze(fold: false)
{{-- @see https://ui.shadcn.com/docs/components/collapsible --}}

@props([
    'id' => null,
    'open' => false,
    'transition' => true,
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'data-slot' => 'collapsible',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class($class) }}
    x-bind:data-state="isOpen ? 'open' : 'closed'"
    x-data="bladcnCollapsible({ id: @js(filled($id) ? $id : null), open: @js($open) })"
    x-id="['collapsible']">
    {{ $slot }}
</div>
@pushOnce('bladcn-scripts')
    <script>
        bladcnOnAlpine((Alpine) => {
            Alpine.data('bladcnCollapsible', (config = {}) => ({
                initId: config.id ?? null,
                isOpen: config.open ?? false,

                get id() {
                    return this.initId ?? this.$id(
                        'collapsible');
                },

                toggle() {
                    this.isOpen = !this.isOpen;
                },

                open() {
                    this.isOpen = true;
                },

                close() {
                    this.isOpen = false;
                },
            }));
        });
    </script>
@endPushOnce
