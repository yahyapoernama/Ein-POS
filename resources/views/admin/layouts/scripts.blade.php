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

    // Reset form when modal closed
    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.select2-modal').val(null).trigger('change');
    });

    // Handle Select2
    $('.select2-modal').each(function() {
        let select = $(this);
        let url = select.data('url');
        let width = select.data('width') ? select.data('width') : select.hasClass('w-100') ? '100%' : 'style';
        let placeholder = select.data('placeholder') ? select.data('placeholder') : 'Select Option';
        let multiple = select.data('multiple') ? select.data('multiple') : false;
        let closeOnSelect = multiple ? false : true;
        if (!url) {
            select.select2({
                theme: "bootstrap-5",
                width: width,
                placeholder: placeholder,
                dropdownParent: $('.modal'),
                multiple: multiple,
                closeOnSelect: closeOnSelect,
                allowClear: true,
            });
        } else {
            select.select2({
                theme: "bootstrap-5",
                width: width,
                placeholder: placeholder,
                dropdownParent: $('.modal'),
                multiple: multiple,
                closeOnSelect: closeOnSelect,
                allowClear: true,
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        }
    });
</script>
@stack('scripts')
