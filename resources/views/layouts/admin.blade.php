<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ein POS</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" type="image/x-icon">
    <!-- [Google Font] Family -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/libs/base/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/libs/base/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/libs/fontawesome/css/all.min.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/libs/base/fonts/material.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/base/css/plugins/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/animate/animate.min.css') }}">

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

        thead>tr>th {
            font-weight: bold !important;
            color: white !important;
            background-color: #343A40 !important;
            border: 1px solid #343A40 !important;
        }

        .form-control:focus {
            background-color: transparent;
            box-shadow: none;
            border-color: black;
        }

        .form-control:hover {
            background-color: transparent;
        }

        .swal2-popup .swal2-styled:focus {
            box-shadow: none !important;
        }

        .swal2-container {
            z-index: 9999 !important;
        }

        .ti {
            display: inline-block;
        }

        .ti-spin {
            animation: spin 2s linear infinite;
            -webkit-animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(1turn);
            }
        }

        /* div.dt-processing {
            display: none !important;
        } */
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
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Set CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Reload Table
            $(document).on('click', '#reloadTable', function() {
                let $reloadBtnIcon = $('#reloadTable').find('i');
                $reloadBtnIcon.addClass('ti-spin');
                $('.datatable').DataTable().ajax.reload(function() {
                    $reloadBtnIcon.removeClass('ti-spin');
                });
            });

            // Handle Create with AJAX
            $(document).on('submit', '.create-form', function(e) {
                e.preventDefault();
                let url = window.location.href;
                let data = $(this).serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            $('#createModal').modal('hide');
                            $('.create-form')[0].reset();
                            $('.datatable').DataTable().ajax.reload();
                            Swal.fire("Success!", response.message, "success");
                        } else {
                            Swal.fire("Oops!", response.message, "error");
                        }
                    }
                });
            })

            // Handle Edit with AJAX
            $(document).on('click', '.edit-btn', function() {
                let $btn = $(this);
                let $icon = $btn.find('i');

                $icon.removeClass('ti-edit').addClass('ti-loader ti-spin');

                let id = $btn.data('id');
                let url = window.location.href + '/' + id + '/edit';

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $icon.removeClass('ti-loader ti-spin').addClass(
                            'ti-edit'); // Kembalikan ikon
                        if (response.success) {
                            $('#editModal').modal('show');
                            $('.edit-form')[0].reset();
                            $('.edit-form').data('id', response.data.id);

                            $.each(response.data, function(key, value) {
                                $('.edit-form').find(`input[name="${key}"]`).val(value);
                            });
                        }
                    },
                    error: function() {
                        // Kembalikan ikon jika error
                        $icon.removeClass('ti-loader ti-spin').addClass('ti-edit');
                    }
                });
            });

            // Handle Update with AJAX
            $(document).on('submit', '.edit-form', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let url = window.location.href + '/' + id;
                let data = $(this).serialize();

                $.ajax({
                    url: url,
                    type: "PUT",
                    data: data,
                    success: function(response) {
                        Swal.fire("Updated!", response.message, "success");
                        $('#editModal').modal('hide');
                        $('.datatable').DataTable().ajax.reload();
                    },
                    error: function() {
                        Swal.fire("Oops!", "An error occurred", "error");
                    }
                });
            });

            // Handle Delete with AJAX
            $(document).on('click', '.delete-btn', function() {
                let url = $(this).data('route');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Deleted data cannot be restored!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Yes, delete it!",
                    allowOutsideClick: false,
                    showCloseButton: true,
                    showClass: {
                        popup: 'animate__animated animate__fadeIn animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut animate__faster'
                    }
                }).then((result) => {
                    console.log(url);
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            success: function(response) {
                                Swal.fire("Deleted!", response.message, "success");
                                $('.datatable').DataTable().ajax.reload();
                            },
                            error: function() {
                                Swal.fire("Oops!", "An error occurred", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
<!-- [Body] end -->

</html>
