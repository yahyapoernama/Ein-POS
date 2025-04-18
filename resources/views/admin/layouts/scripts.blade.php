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
            $('.main-table').each(function() {
                if (!$(this).is('#list-products-table')) {
                    $(this).DataTable().ajax.reload(function() {
                        $reloadBtnIcon.removeClass('ti-spin');
                    });
                }
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
                        Swal.fire("Success!", response.message, "success");
                        $('#createModal').modal('hide');
                        $('.datatable').DataTable().ajax.reload();
                    } else {
                        Swal.fire("Oops!", response.message, "error");
                    }
                },
                error: function(e) {
                    Swal.fire("Oops!", "An error occurred", "error");
                    $btn.text($btnText);
                }
            });
        });

        // Handle Edit with AJAX
        $(document).on('click', '.edit-btn', function editButtonHandler(e) {
            // Get the button element
            const $button = $(this);

            // Get the icon element
            const $icon = $button.find('i');

            // Get the ID from the data attribute
            const id = $button.data('id');

            // Construct the edit URL
            let editUrl;
            if ($button.data('url') !== null && $button.data('url') !== '') {
                editUrl = $button.data('url');
                customForm = true;
            } else {
                editUrl = `${window.location.href}/${id}/edit`;
                customForm = false;
            }
            const url = editUrl;

            // Show the loading icon
            $icon.removeClass('ti-edit').addClass('ti-loader ti-spin');

            // Make the AJAX request
            $.ajax({
                    url,
                    type: 'GET'
                })
                .done((response) => {
                    // Hide the loading icon
                    $icon.removeClass('ti-loader ti-spin').addClass('ti-edit');

                    // Check if the response is valid
                    if (!response.success) {
                        // Show the error message
                        Swal.fire("Oops!", response.message, "error");
                        return;
                    }

                    // Get the data from the response
                    const {
                        data
                    } = response;

                    // Check if the data exists
                    if (!data) {
                        // Show the error message
                        Swal.fire("Oops!", "Data not found", "error");
                        return;
                    }

                    if (customForm) {
                        // Set the ID to the form
                        $('#edit-' + $button.data('model') + '-form').data('id', data.id);

                        // Show the edit modal
                        $('#edit' + $button.data('model').replace(/^./, m => m.toUpperCase()) + 'Modal').modal('show');

                        // Reset the edit form
                        $('#edit-' + $button.data('model') + '-form')[0].reset();

                        // Set the ID to the form
                        $('#edit-' + $button.data('model') + '-form').data('id', data.id);

                        // Fill the form fields with the data
                        Object.entries(data).forEach(([key, value]) => {
                            if (Array.isArray(value)) {
                                // Select the items in the select2
                                const select = $('#edit-' + $button.data('model') + '-form').find(`select[name="${key}[]"]`);
                                value.forEach((item) =>
                                    select.select2("trigger", "select", {
                                        data: {
                                            id: item.id,
                                            text: item.name
                                        },
                                    })
                                );
                            } else {
                                // Set the value of the input field
                                $('#edit-' + $button.data('model') + '-form').find(`input[name="${key}"]`).val(value);
                            }
                        });
                    } else {
                        // Set the ID to the form
                        $('#edit-form').data('id', data.id);

                        // Show the edit modal
                        $('#editModal').modal('show');
    
                        // Reset the edit form
                        $('.edit-form')[0].reset();
    
                        // Set the ID to the form
                        $('.edit-form').data('id', data.id);
    
                        // Fill the form fields with the data
                        Object.entries(data).forEach(([key, value]) => {
                            if (Array.isArray(value)) {
                                // Select the items in the select2
                                const select = $('.edit-form').find(`select[name="${key}[]"]`);
                                value.forEach((item) =>
                                    select.select2("trigger", "select", {
                                        data: {
                                            id: item.id,
                                            text: item.name
                                        },
                                    })
                                );
                            } else {
                                // Set the value of the input field
                                $('.edit-form').find(`input[name="${key}"]`).val(value);
                            }
                        });
                    }
                })
                .fail((xhr, status, error) => {
                    // Hide the loading icon
                    $icon.removeClass('ti-loader ti-spin').addClass('ti-edit');

                    // Show the error message
                    const errorMessage = `${xhr.status} ${xhr.statusText}`;
                    if (xhr.responseJSON) {
                        errorMessage += `: ${xhr.responseJSON.message}`;
                    }
                    Swal.fire("Oops!", errorMessage, "error");
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
                error: function(xhr, status, error) {
                    $btn.text($btnText);
                    const errorMessage = xhr.responseJSON ? xhr.responseJSON.message : "An error occurred";
                    Swal.fire("Oops!", errorMessage, "error");
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

        $(document).on('show.bs.modal', '.modal', function(event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass(
                    'modal-stack');
            }, 0);
        });

        // Reset form when modal is closed
        // This event is triggered when the modal is closed. We need to reset the form
        // so that the values are cleared and the select2 is reset.
        $('.modal').on('hidden.bs.modal', function(event) {
            const $modal = $(event.target);
            const $form = $modal.find('form')[0];
            if ($form) {
                // Reset the form fields
                $form.reset();

                // Reset the select2 values
                $modal.find('.select2-modal').val(null).trigger('change');
            }
        });

        // Handle Select2
        $('.select2-modal').each(function() {
            const $select = $(this);
            const url = $select.data('url');
            const width = $select.data('width') || ($select.hasClass('w-100') ? '100%' : 'resolve');
            const placeholder = $select.data('placeholder') || 'Select Option';
            const multiple = $select.data('multiple') === true || $select.data('multiple') === 'true';
            const closeOnSelect = !multiple;

            // Initialize Select2 with custom options
            $select.select2({
                theme: 'bootstrap-5',
                width: width,
                placeholder: placeholder,
                dropdownParent: $select.closest('.modal'), // Ensure dropdown is within modal
                multiple: multiple,
                closeOnSelect: closeOnSelect,
                allowClear: true,
                ajax: url ? {
                    url: url,
                    dataType: 'json',
                    delay: 250, // Delay for search queries
                    data: function(params) {
                        return {
                            q: params.term
                        }; // Query parameter for search term
                    },
                    processResults: function(data) {
                        // Map the results to the format Select2 expects
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: item.name
                            }))
                        };
                    },
                    cache: true // Cache results for performance
                } : null
            });
        });
    });
</script>
@stack('scripts')
