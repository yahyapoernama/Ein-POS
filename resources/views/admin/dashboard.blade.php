@extends('layouts.admin', [
    'headerTitle' => 'Dashboard',
    'breadcrumbs' => [['name' => 'Dashboard', 'url' => null]],
    'headerSubtitle' => 'Welcome to Ein POS, a simple Point of Sale application for your retail business.
                                This dashboard page will show you an overview of your sales, customers, and
                                products.',
    'active' => 'dashboard',
])

@section('content')
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Home</h5>
                </div>
                <div class="card-body">
                    <p>Home</p>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
@endsection
