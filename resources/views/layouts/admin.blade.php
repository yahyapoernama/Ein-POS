<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ein POS</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" type="image/x-icon">
    <!-- [Google Font] Family -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/libs/base/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/libs/base/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/libs/base/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/libs/base/fonts/material.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/base/css/plugins/dataTables.bootstrap5.min.css') }}">

    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/libs/base/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/libs/base/css/style-preset.css') }}">
    <!-- [Custom CSS] -->
    <style>
        body {
            font-family: "Outfit", sans-serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
        }

        .row {
            padding-top: 0 !important;
        }
        thead > tr > th {
            font-weight: bold !important;
            color: white !important;
            background-color: #343A40 !important;
            border: 1px solid #343A40 !important;
        }
    </style>
    @stack('styles')
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    @include('admin.layouts.sidebar')
    <!-- [ Sidebar Menu ] end -->
    <!-- [ Header Topbar ] start -->
    @include('admin.layouts.header')
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12 px-3 d-flex align-items-start justify-content-between ">
                            @if (isset($headerTitle))
                                <div class="page-header-title">
                                    <h1 class="m-b-10">{{ $headerTitle }}</h1>
                                </div>
                            @endif
                            @if (isset($breadcrumbs) && count($breadcrumbs) > 0)
                                <ul class="breadcrumb">
                                    @foreach ($breadcrumbs as $breadcrumb)
                                        @if ($breadcrumb['url'])
                                            <li class="breadcrumb-item"><a
                                                    href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                                        @else
                                            <li class="breadcrumb-item" aria-current="page">{{ $breadcrumb['name'] }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @if (isset($headerSubtitle))
                            <div class="col-md-12 px-3">
                                <p>
                                    {{ $headerSubtitle }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            @yield('content')
            <!-- [ Main Content ] end -->
        </div>
    </div>
    @include('admin.layouts.footer')

    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets/libs/base/js/plugins/apexcharts.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/base/js/pages/dashboard-default.js') }}"></script> --}}
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('assets/libs/jquery/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/base/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/base/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/base/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/libs/base/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/libs/base/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/libs/base/js/plugins/feather.min.js') }}"></script>
    @stack('scripts')
</body>
<!-- [Body] end -->

</html>
