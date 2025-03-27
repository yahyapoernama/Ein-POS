@extends('layouts.admin', [
    'headerTitle' => 'Categories',
    'breadcrumbs' => [['name' => 'Dashboard', 'url' => '/admin'], ['name' => 'Categories', 'url' => null]],
    'headerSubtitle' => 'This is a page for managing all categories. Feel free to add, edit, or delete categories as needed.',
    'active' => 'categories',
])

@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Categories</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-success mb-3 d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#categoryModal">
                        <i class="ti ti-circle-plus me-2"></i> <span class="align-middle">Add Data</span>
                    </button>
                    <table class="table table-bordered datatable" id="categories-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>

    <div class="modal fade" id="categoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoryForm" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                searching: true,
                ajax: {
                    url: '{{ route('admin.categories.utils.getData') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        width: '5%',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data) {
                            return data ? data :
                                '<span class="text-secondary"><i><small>No description</small></i></span>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width: '15%',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'asc']
                ],
            });

            $('#categoryForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('admin.categories.store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#categoryModal').modal('hide');
                            $('#categoryForm')[0].reset();
                            $('#categories-table').DataTable().ajax.reload();
                            Swal.fire("Success!", response.message, "success");
                        } else {
                            Swal.fire("Oops!", response.message, "error");
                        }
                    }}
                );
            })
        });
    </script>
@endpush
