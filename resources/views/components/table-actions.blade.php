<div class="">
    @if ($editRoute)
        <button type="button" class="btn btn-sm btn-warning mx-1" data-bs-toggle="modal"
            data-bs-target="#editModal">
            <i class="ti ti-edit"></i>
        </button>
    @endif

    @if ($deleteRoute)
        <button class="btn btn-sm btn-danger delete-btn" data-route="{{ route($deleteRoute, $id) }}">
            <i class="ti ti-trash"></i>
        </button>
    @endif

    <!-- Modal Edit -->
    @if ($editRoute && $editFields)
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="edit-form" action="{{ route($editRoute, $id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body text-start">
                            @foreach ($editFields as $name => $value)
                                <div class="mb-3">
                                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $name)) }}</label>
                                    <input type="text" name="{{ $name }}" class="form-control"
                                        value="{{ $value }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

