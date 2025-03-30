<!-- Modal Edit -->
@if ($editModal)
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="edit-form" method="POST">
                    <div class="modal-body text-start">
                        @foreach ($editFields as $field)
                            <div class="mb-3">
                                @if (is_array($field))
                                    <label class="form-label">
                                        {{ ucwords(str_replace('_', ' ', $field['name'])) }}
                                    </label>
                                    @if (isset($field['select2']))
                                        <select class="form-select select2-modal"
                                            name="{{ $field['name'] }}@if($field['select2']['multiple'] ?? false)[]@endif"
                                            data-multiple="{{ $field['select2']['multiple'] ?? false }}"
                                            data-placeholder="{{ $field['select2']['placeholder'] ?? 'Select Option' }}"
                                            data-url="{{ $field['select2']['url'] ?? '' }}">
                                        </select>
                                    @else
                                        <input type="text" name="{{ $field['name'] }}" class="form-control">
                                    @endif
                                @else
                                    <label class="form-label">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                                    <input type="text" name="{{ $field }}" class="form-control">
                                @endif
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
