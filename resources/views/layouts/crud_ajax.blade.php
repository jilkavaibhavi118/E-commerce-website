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

    $(document).on('click', '.deleteBtn', function (e) {
        e.preventDefault();
        let btn = $(this);

        showSwal({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            confirmButtonText: "Yes, Delete it!",
        }, function () {
            let id = btn.data('id');
            let URL = $('#delete-form-' + id).attr('action');
            let formData = new FormData(document.getElementById('delete-form-' + id));

            $.ajax({
                type: 'DELETE',
                url: URL,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    showSuccessToast(result.success);
                    if (result.url) {
                        window.location.href = result.url;
                    } else {
                        datatable.ajax.reload();
                    }
                },
                error: function (err) {
                    showErrorToast(err.responseJSON.error);
                },
            });
        });
    });
</script>
