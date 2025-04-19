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

    thead.thead-dark>tr>th {
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

    div.dt-processing>div {
        display: none !important;
        /* background: #343A40 !important; */
    }

    /* Spinner Style */
    .dt-processing::before {
        content: "";
        display: block;
        width: 50px;
        height: 50px;
        margin: 25px auto 10px auto;
        border: 5px solid #343A40;
        border-top-color: transparent;
        border-radius: 50%;
        animation: dt-spinner 1s linear infinite;
    }

    @keyframes dt-spinner {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .dt-processing::after {
        content: "Loading...";
        display: block;
        text-align: center;
        color: #343A40;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .datatable-overlay {
        position: absolute;
        top: 0;
        left: 0;
        background-color: rgba(255, 255, 255, 0.6);
        /* semi-transparent */
        width: 100%;
        height: 100%;
        z-index: 10;

        /* Animation */
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        pointer-events: none;
        /* optional: to prevent clicking while loading */
    }

    .datatable-wrapper.processing .datatable-overlay {
        opacity: 1;
        visibility: visible;
    }

    .datatable-wrapper.processing table {
        filter: blur(1px);
    }


    .page-link {
        color: #6c757d;
    }

    .page-link:hover {
        color: #343A40;
    }

    .active>.page-link:hover {
        color: white !important;
    }
</style>
@stack('styles')
