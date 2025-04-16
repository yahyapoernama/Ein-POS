@php
    $dialogClasses = 'modal-dialog';
    if ($size) {
        $dialogClasses .= " modal-{$size}";
    }
    if ($centered) {
        $dialogClasses .= ' modal-dialog-centered';
    }
    if ($scrollable) {
        $dialogClasses .= ' modal-dialog-scrollable';
    }
@endphp

<div
    {{ $attributes->merge([
        'class' => 'modal fade',
        'id' => $id,
        'aria-hidden' => 'true',
        // 'data-bs-backdrop' => $backdrop ? 'static' : 'false',
        'data-bs-keyboard' => $keyboard ? 'true' : 'false',
    ]) }}>
    <div class="{{ $dialogClasses }}">
        <div class="modal-content">
            @if ($title)
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif

            @if ($wrapBody)
                <div class="modal-body">
                    {{ $slot }}
                </div>
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
</div>
