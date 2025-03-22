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
                    <table class="table table-bordered table-striped" id="products-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
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
                    url: '{{ route('admin.products.getData') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
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
                ],
                order: [
                    [0, 'asc']
                ],
            });
        });
    </script>
@endpush
