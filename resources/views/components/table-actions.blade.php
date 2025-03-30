<div class="">
    @if ($listRoute)
        <button type="button" class="btn btn-sm btn-secondary list-btn mx-1" data-id="{{ $id }}">
            <i class="ti ti-list"></i>
        </button>
    @endif

    @if ($editRoute)
        <button type="button" class="btn btn-sm btn-warning edit-btn mx-1" data-id="{{ $id }}">
            <i class="ti ti-edit"></i>
        </button>
    @endif

    @if ($deleteRoute)
        <button class="btn btn-sm btn-danger delete-btn" data-route="{{ route($deleteRoute, $id) }}">
            <i class="ti ti-trash"></i>
        </button>
    @endif
</div>

