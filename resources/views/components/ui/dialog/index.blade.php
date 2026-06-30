@blaze(fold: false)
{{-- @see https://ui.shadcn.com/docs/components/dialog --}}
{{-- @see https://github.com/ailuracode/alpinejs-toolkit/blob/master/docs/plugins/dialog.md --}}

@props([
    'id' => null,
    'open' => false,
    'transition' => true,
    'style' => null,
    'class' => null,
])

@php
    $isOpen = filter_var($open, FILTER_VALIDATE_BOOLEAN);

    $presetAttributes = [
        'data-slot' => 'dialog',
        'data-state' => $isOpen ? 'open' : 'closed',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class($class) }}
    x-bind:data-state="isOpen ? 'open' : 'closed'"
    x-data="bladcnDialog({ id: @js(filled($id) ? $id : null), open: @js($isOpen) })"
    x-id="['dialog']"
    x-on:keydown.window="handleKeydown($event)">
    {{ $slot }}
</div>
@pushOnce('bladcn-scripts')
    <script>
        bladcnOnAlpine((Alpine) => {
            Alpine.data('bladcnDialog', (config = {}) => ({
                initId: config.id ?? null,
                initialOpen: Boolean(config.open),

                get id() {
                    return this.initId ?? this.$id(
                    'dialog');
                },

                get isOpen() {
                    return this.$store.dialog.isOpen(this
                        .id);
                },

                init() {
                    this.$nextTick(() => {
                        const id = this.id;

                        this.$store.dialog.register(
                        id, {
                            labelledBy: `${id}-title`,
                            describedBy: `${id}-description`,
                        });

                        if (this.initialOpen) {
                            this.$store.dialog.open(id);
                        }
                    });
                },

                destroy() {
                    this.$store.dialog.unregister(this.id);
                },

                open(event) {
                    const trigger = event
                        ?.target instanceof HTMLElement ?
                        event.target :
                        null;
                    this.$store.dialog.open(this.id, {
                        trigger,
                    });
                },

                close() {
                    this.$store.dialog.close(this.id);
                },

                handleKeydown(event) {
                    this.$store.dialog.handleKeydown(this.id,
                        event);
                },
            }));
        });
    </script>
@endPushOnce
