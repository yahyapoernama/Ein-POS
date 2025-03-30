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

<!-- [Page Specific CSS] -->
<link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/base/css/plugins/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/animate/animate.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/select2/select2-bootstrap-5-theme.min.css') }}">

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

    .select2-search__field {
        width: 100% !important;
        font-size: 0.875rem !important;
    }

    .select2-result__option,
    .select2-selection,
    .select2-selection__choice,
    .select2-results__option {
        font-size: 0.875rem !important;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection,
    .select2-container--bootstrap-5 .select2-dropdown {
        border-color: #343A40;
        box-shadow: none;
    }

    /* div.dt-processing {
        display: none !important;
    } */
</style>
@stack('styles')
