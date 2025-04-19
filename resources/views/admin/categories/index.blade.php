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
                    <div class="d-flex mb-3">
                        <button class="btn btn-success me-1 d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="ti ti-circle-plus me-2"></i> <span class="align-middle">Add Data</span>
                        </button>
                        <button class="btn btn-dark me-1 d-flex align-items-center" id="reloadTable">
                            <i class="ti ti-refresh me-2"></i> <span class="align-middle">Reload Table</span>
                        </button>
                    </div>
                    <x-table-datatable class="main-table" id="categories-table" :columns="['#', 'Name', 'Slug', 'Description', 'Action']" />
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>

    <x-modal-wrapper id="createModal" title="Add Data" :wrapBody="false">
        <x-form-builder :formId="'create-form'" :model="'Category'" :fields="['name', 'slug']" method="POST" :withModal="true" />
    </x-modal-wrapper>
    <x-modal-wrapper id="listModal" title="List Data" :size="'xl'">
        <x-table-datatable id="list-products-table" :columns="['#', 'Name', 'Price', 'Description', 'Action']" :darkThead="false" />
    </x-modal-wrapper>
    <x-modal-wrapper id="editModal" title="Edit Data" :wrapBody="false">
        <x-form-builder :formId="'edit-form'" :model="'Category'" :fields="['name', 'slug']" method="PUT" :withModal="true" />
    </x-modal-wrapper>
    <x-modal-wrapper id="editProductModal" title="Edit Data" :wrapBody="false">
        <x-form-builder :formId="'edit-product-form'" :model="'Product'" :fields="[
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
        ]" method="PUT" :withModal="true" />
    </x-modal-wrapper>
@endsection

@push('scripts')
    <script>
        $(function() {
            const table = $('#categories-table').DataTable({
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

            table.on('processing.dt', function(e, settings, processing) {
                const wrapper = $(this).closest('.datatable-wrapper');
                wrapper.toggleClass('processing', processing);
            });
        });
    </script>
@endpush
