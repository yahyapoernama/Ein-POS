@php
    $formId = $formId ?? 'form-' . uniqid();
    $methodLower = strtolower($method);
    $submitConfig = match ($methodLower) {
        'post' => ['class' => 'btn-success', 'text' => 'Save'],
        'put', 'patch' => ['class' => 'btn-warning', 'text' => 'Save'],
        'delete' => ['class' => 'btn-danger', 'text' => 'Delete'],
        default => ['class' => 'btn-primary', 'text' => 'Submit'],
    };
@endphp

<form action="{{ $action }}" method="POST" id="{{ $formId }}" class="{{ $formId }}">
    @csrf
    @if (in_array($method, ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    @if ($withModal)
        <div class="modal-body">
    @endif

    @foreach ($fields as $field)
        @php
            $label = ucwords(str_replace('_', ' ', is_array($field) ? $field['name'] : $field));
            $name = is_array($field) ? $field['name'] : $field;
            $type = is_array($field) && isset($field['type']) ? $field['type'] : 'text';
        @endphp

        <div class="mb-3">
            <label class="form-label">{{ $label }}</label>
            @if (isset($field['select2']))
                <select class="form-select select2-modal"
                    name="{{ $field['name'] . ($field['select2']['multiple'] ?? false ? '[]' : '') }}"
                    data-multiple="{{ $field['select2']['multiple'] ?? false }}"
                    data-placeholder="{{ $field['select2']['placeholder'] ?? 'Select Option' }}"
                    data-url="{{ $field['select2']['url'] ?? '' }}">
                </select>
            @else
                <input type="{{ $type }}" name="{{ $name }}" class="form-control"
                    placeholder="{{ $model . ' ' . ucfirst($label) }}">
            @endif
        </div>
    @endforeach

    @if ($withModal)
        </div> {{-- End modal-body --}}
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn {{ $submitConfig['class'] }}">
                {{ $submitConfig['text'] }}
            </button>
        </div>
    @endif
</form>
