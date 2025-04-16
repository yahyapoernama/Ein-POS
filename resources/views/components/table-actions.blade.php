<div class="">
    @if ($listButton)
        <button type="button" class="btn btn-sm btn-info list-btn mx-1 position-relative" data-id="{{ $id }}">
            <i class="ti ti-database"></i>
            @if ($listCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $listCount }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            @endif
        </button>
    @endif

    @if ($editButton)
        <button type="button" class="btn btn-sm btn-warning edit-btn mx-1" data-id="{{ $id }}" data-url="{{ $editUrl }}" data-model="{{ $model }}">
            <i class="ti ti-edit"></i>
        </button>
    @endif

    @if ($deleteButton)
        <button class="btn btn-sm btn-danger delete-btn mx-1" data-id="{{ $id }}">
            <i class="ti ti-trash"></i>
        </button>
    @endif
</div>
