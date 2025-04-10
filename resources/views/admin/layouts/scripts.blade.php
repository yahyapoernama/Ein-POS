<!-- [Page Specific JS] start -->
<script src="{{ asset('assets/libs/base/js/plugins/apexcharts.min.js') }}"></script>
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
<script src="{{ asset('assets/libs/select2/select2.full.min.js') }}"></script>
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
            let $btn = $(this).find('button[type="submit"]');
            let $btnText = $btn.text();

            $btn.html('<i class="ti ti-loader ti-spin"></i>');

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    $btn.text($btnText);
                    if (response.success) {
                        $('#createModal').modal('hide');
                        $('.datatable').DataTable().ajax.reload();
                        Swal.fire("Success!", response.message, "success");
                    } else {
                        Swal.fire("Oops!", response.message, "error");
                    }
                },
                error: function() {
                    $btn.text($btnText);
                }
            });
        });

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
                    // Return icon to default
                    $icon.removeClass('ti-loader ti-spin').addClass('ti-edit');
                    if (response.success) {
                        $('#editModal').modal('show');
                        $('.edit-form')[0].reset();
                        $('.edit-form').data('id', response.data.id);

                        $.each(response.data, function(key, value) {
                            // If value is array, set for select2
                            if (Array.isArray(value)) {
                                value.forEach(function(item) {
                                    $('.edit-form').find(
                                            `select[name="${key}[]"]`)
                                        .select2("trigger", "select", {
                                            data: {
                                                id: item.id,
                                                text: item.name
                                            }
                                        });
                                });
                            } else {
                                // If value is not array, set for regular text input
                                $('.edit-form').find(`input[name="${key}"]`).val(
                                    value);
                            }
                        });
                    }
                },
                error: function() {
                    // Return icon to default if error
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
            let $btn = $(this).find('button[type="submit"]');
            let $btnText = $btn.text();

            $btn.html('<i class="ti ti-loader ti-spin"></i>');

            $.ajax({
                url: url,
                type: "PUT",
                data: data,
                success: function(response) {
                    $btn.text($btnText);
                    Swal.fire("Updated!", response.message, "success");
                    $('#editModal').modal('hide');
                    $('.datatable').DataTable().ajax.reload();
                },
                error: function() {
                    $btn.text($btnText);
                    Swal.fire("Oops!", "An error occurred", "error");
                }
            });
        });

        // Handle Delete with AJAX
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            let url = window.location.href + '/' + id;

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

        // Handle ListModal
        $(document).on('click', '.list-btn', function() {
            const id = $(this).data('id');
            const url = window.location.href + '/utils/' + id + '/products';
    
            let $icon = $(this).find('i');
            $icon.removeClass('ti-database').addClass('ti-loader ti-spin');
    
            $('#list-products-table').on('draw.dt', function() {
                $icon.removeClass('ti-loader ti-spin').addClass('ti-database');
            });
    
            if ($.fn.DataTable.isDataTable('#list-products-table')) {
                $('#list-products-table').DataTable().ajax.url(url).load(); // reload
            } else {
                $('#list-products-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
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
                    initComplete: function(settings, json) {
                        $('#listModal').modal('show');
                    },
                    drawCallback: function(settings) {
                        $('#listModal').modal('show');
                    }
                });
            }
        });
                                id: item.id,
                                text: item.name
                            };
                        })
                    };
                },
                cache: true
            };
        }

        select.select2(config);
    });
</script>
@stack('scripts')
