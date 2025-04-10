@extends('layouts.admin', [
    'headerTitle' => 'Products',
    'breadcrumbs' => [['name' => 'Dashboard', 'url' => '/admin'], ['name' => 'Products', 'url' => null]],
    'headerSubtitle' => 'This is a page for managing all products. Feel free to add, edit, or delete products as needed.',
    'active' => 'products',
])

@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Products</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <button class="btn btn-success me-1 d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="ti ti-circle-plus me-2"></i> <span class="align-middle">Add Data</span>
                        </button>
                        <button class="btn btn-dark me-1 d-flex align-items-center" id="reloadTable">
                            <i class="ti ti-refresh me-2"></i> <span class="align-middle">Reload Table</span>
                        </button>
                    </div>
                    <x-table-datatable id="products-table" :columns="['#', 'Name', 'Price', 'Category', 'Description', 'Action']" />
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>

    <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="create-form" enctype="multipart/form-data" method="POST" spellcheck="false">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Product Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price"
                                placeholder="Product Price" required>
                        </div>
                        <div class="mb-3">
                            <label for="categories" class="form-label">Category</label>
                            <select class="form-select select2-modal" id="categories" name="categories[]"
                                data-multiple="true" data-placeholder="Select Category"
                                data-url="{{ route('admin.categories.utils.select2') }}">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Product Description"></textarea>
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

    <x-modal-manager :editModal="true" :editFields="[
        'name',
        'price',
        [
            'name' => 'categories',
            'select2' => [
                'multiple' => 'true',
                'placeholder' => 'Select Category',
                'url' => route('admin.categories.utils.select2'),
            ],
        ],
        'description',
    ]" />
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                searching: true,
                ajax: {
                    url: '{{ route('admin.products.utils.getData') }}',
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
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'categories',
                        name: 'categories'
                    },
                    {
                        data: 'description',
                        name: 'description'
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
        });
    </script>
@endpush
