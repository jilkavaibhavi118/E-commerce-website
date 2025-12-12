<script>
    $(document).on('click', '#crudFormSave', function (e) {
        e.preventDefault();
        $(this).prop('disabled', true);
        var URL = $('#crudForm').attr('action');
        let formData = new FormData(document.getElementById('crudForm'));
        $.ajax({
            type: 'POST',
            url: URL,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (result) {
                if (result.error) {
                    $('#crudFormSave').prop('disabled', false);

                    showErrorToast(result.error);
                    return false;
                } else {
                    showSuccessToast(result.success);
                    setTimeout(() => {
                        window.location.href = result.url;
                    }, 3000);
                }
            },
            error: function (err) {
                console.log(err);
                if (err.responseJSON.errors) {
                    $.each(err.responseJSON.errors, function (key, value) {
                        showErrorToast(value);
                    });
                } else {
                    showErrorToast(err.responseJSON.error);
                }
                $("#crudFormSave").prop('disabled', false);
            },
        });
    });

    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();

        let url = $(this).data('url');

        Swal.fire({
            title: "Are you sure?",
            text: "This item will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success",
                        });

                        // reload datatable
                        $('#table').DataTable().ajax.reload();
                    }
                });

            }
        });

    });

</script>
