<script>
    function showCategory(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.category.index') }}",
            dataType: "json",
            success: function(data) {
                console.log(data)
                params.success(data)
            },
            error: function(er) {
                params.error(er);
            }
        });
    }

    // status
    function category_status(data) {
        if (data == 0) {
            return ["<a class='btn btn-soft-warning ' href='#' title='Status'>",
                "Pending",
                "</a>"
            ].join('');
        } else {
            return ["<a class='btn btn-soft-success' href='#' title='Status'>",
                "Active",
                "</a>"
            ].join('');
        }

    }

    // action
    function categoryAction(value, row, index) {
        return [
            '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Edit" onclick="editCategory(' +
            row.id + ')">',
            '<i class="las la-edit"></i>',
            '</a>  ',
            '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteCategory(' +
            row.id + ')">',
            '<i class="las la-trash"></i>',
            '</a>'
        ].join('')
    }

    // edit category
    function editCategory(id) {
        $('#edit_category_modal').modal('show');
        $('#edit_category_form')[0].reset();
        $('#edit_category_name_error').html('')
        $('#edit_category_slug_error').html('')
        $('#edit_category_description_error').html('')
        $('#edit_category_status_error').html('')
        $('#edit_category_image_error').html('')
        $.ajax({
            url: "{{ route('admin.category.showEditData') }}",
            type: 'get',
            dataType: "json",
            data: {
                id: id
            },
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('.inventory_loder').hide()
                $('#edit_category_name').val(data.name);
                $('#edit_category_id').val(data.id);
                $('#edit_category_slug').val(data.slug);
                $('#edit_category_description').val(data.description)
                $('#edit_category_status').val(data.status);
                var url = "{{ asset('') }}";
                $('#edit_category_exit_image').attr('src', url + data.image);

            },
            error: function(error) {
                $('.inventory_loder').hide()
                console.log(error)
            }
        })
    }


    // update return
    $('#edit_category_btn').click(function(e) {
        e.preventDefault();
        var form = $('#edit_category_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.category.updateCategory') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#edit_category_spin').show();
                $("#edit_category_form :input").prop("disabled", true);
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('#edit_category_spin').hide();
                $('#edit_category_modal').modal('hide');
                $("#edit_category_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                $('#table_category').bootstrapTable('refresh');
            },
            error: function(error) {
                $('#edit_category_spin').hide();
                $("#edit_category_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                console.log(error)
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#edit_category_name_error').html(err.name)
                    $('#edit_category_slug_error').html(err.slug)
                    $('#edit_category_description_error').html(err.description)
                    $('#edit_category_status_error').html(err.status)
                    $('#edit_category_image_error').html(err.image)
                }
            }
        })
    });


    // image 
    function categoryImage(data) {
        var url = "{{ asset('') }}";
        return "<img src='" + url + data + "' width='100'>"
    }


    function add_category() {
        $('#add_category_form')[0].reset();
        $('#add_category_name_error').html('')
        $('#add_category_slug_error').html('')
        $('#add_category_description_error').html('')
        $('#add_category_status_error').html('')
        $('#add_category_image_error').html('')
    }

    // add return
    $('#add_category_btn').click(function(e) {
        e.preventDefault()
        var form = $('#add_category_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.category.store') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#add_category_spin').show();
                $("#add_category_form :input").prop("disabled", true);
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('#add_category_spin').hide();
                $('#add_category_modal').modal('hide');
                $("#add_category_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                $('#table_category').bootstrapTable('refresh');
            },
            error: function(error) {
                $('#add_category_spin').hide();
                $("#add_category_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#add_category_name_error').html(err.name)
                    $('#add_category_slug_error').html(err.slug)
                    $('#add_category_description_error').html(err.description)
                    $('#add_category_status_error').html(err.status)
                    $('#add_category_image_error').html(err.image)
                }
            }
        });
    });




    // clear error
    $("#add_category_form :input").click(function() {
        $('#add_category_name_error').html("")
        $('#add_category_slug_error').html("")
        $('#add_category_description_error').html("")
        $('#add_category_status_error').html("")
        $('#add_category_image_error').html("")
    })

    $('#edit_category_form :input').click(function() {
        $('#edit_category_name_error').html("")
        $('#edit_category_slug_error').html("")
        $('#edit_category_description_error').html("")
        $('#edit_category_status_error').html("")
        $('#edit_category_image_error').html("")
    });

    // delete retutn
    function deleteCategory(id) {
        $('#category_delete-modal').modal('show');
        $("#category_delete-link").attr("href", id);
    }
    // delete logic
    $('#category_delete-link').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.category.deleteCategory') }}",
            type: "post",
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                id: $(this).attr('href')
            },
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('.inventory_loder').hide()
                if (data.status == 'success') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    })
                    $('#category_delete-modal').modal('hide');
                }
                $('#table_category').bootstrapTable('refresh');
            },
            error: function(error) {
                $('.inventory_loder').hide()
                console.log(error)
            }
        })
    });
</script>
