<script>
    // status
    function return_status(data) {
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

    function showReturn(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.return.index') }}",
            dataType: "json",
            success: function(data) {
                params.success(data)
            },
            error: function(er) {
                params.error(er);
            }
        });
    }

    // action
    function returnAction(value, row, index) {
        return [
            '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Edit" onclick="editReturn(' +
            row.id + ')">',
            '<i class="las la-edit"></i>',
            '</a>  ',
            '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteReturn(' +
            row.id + ')">',
            '<i class="las la-trash"></i>',
            '</a>'
        ].join('')
    }

    // show edit data
    function editReturn(id) {
        $('#edit_return_modal').modal('show');
        $('#edit_return_form')[0].reset();
        $('#edit_warehouse_stock_product_name_error').html('')
        $('#edit_return_warehouse_name_error').html('')
        $('#edit_return_rack_name_error').html('')
        $('#edit_return_quantity_error').html('')
        $('#edit_return_datetime_error').html('')
        $('#edit_return_status_error').html('')
        $.ajax({
            url: "{{ route('admin.return.showData') }}",
            type: 'get',
            data: {
                id: id
            },
            dataType: 'json',
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('.inventory_loder').hide()
                $('#edit_retutn_productname').val(data.data.title)
                $('#edit_return_stock').val(data.data.quantity)
                $('#edit_return_id').val(data.data.id);
                $('#edit_date').val(data.data.date);
                $('#select_edit_return_status').val(data.data.status);
                var len = data.warehouse.length;
                var checked = data.data.warehouseid;
                $('#select_edit_return_warehouse').empty();
                for (var i = 0; i < len; i++) {
                    var condition = checked == data.warehouse[i]['id'] ? "selected" : "";
                    $('#select_edit_return_warehouse').append("<option value='" + data.warehouse[i]
                        ['id'] + "' " + condition + ">" + data.warehouse[i]['name'] + "</option>")
                }

                var rlen = data.rack.length;
                var rchecked = data.data.rackid;
                $('#select_edit_return_rack').empty();
                for (var i = 0; i < rlen; i++) {
                    var condition = rchecked == data.rack[i]['id'] ? "selected" : "";
                    $('#select_edit_return_rack').append("<option value='" + data.rack[i]
                        ['id'] + "' " + condition + ">" + data.rack[i]['name'] + "</option>")
                }
            }
        })
    }

    $('#select_edit_return_warehouse').change(function() {
        $.ajax({
            url: "{{ route('admin.showRack') }}",
            type: 'get',
            data: {
                id: $(this).val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('.inventory_loder').hide()
                var wlen = data.length;
                $('#select_edit_return_rack').empty();
                for (var i = 0; i < wlen; i++) {
                    $('#select_edit_return_rack').append("<option value='" + data[i][
                            'id'
                        ] +
                        "'>" + data[i]['name'] + "</option>");
                }
            },
            error: function(error) {
                $('.inventory_loder').hide()
                console.log(errpr);
            }
        })
    });

    // update return
    $('#edit_return_btn').click(function(e) {
        e.preventDefault();
        var form = $('#edit_return_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.return.updateReturn') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#edit_return_spin').show();
                $("#edit_return_form :input").prop("disabled", true);
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('#edit_return_spin').hide();
                $('#edit_return_modal').modal('hide');
                $("#edit_return_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                $('#table_return').bootstrapTable('refresh');
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
            },
            error: function(error) {
                $('#edit_return_spin').hide();
                $("#edit_return_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                console.log(error)
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#edit_warehouse_stock_product_name_error').html(err.id)
                    $('#edit_return_warehouse_name_error').html(err.warehouseid)
                    $('#edit_return_rack_name_error').html(err.rackid)
                    $('#edit_return_quantity_error').html(err.quantity)
                    $('#edit_return_datetime_error').html(err.date)
                    $('#edit_return_status_error').html(err.status)
                }
            }
        })
    });


    // image 
    function imageFormatter(data) {
        var url = "{{ asset('') }}";
        return "<img src='" + url + data + "' width='100'>"
    }

    // get data
    function getReturnData() {
        $('#add_return_form')[0].reset();
        $('#add_return_product_name_error').html('')
        $('#add_return_name_error').html('')
        $('#add_return_rack_name_error').html('')
        $('#add_return_quantity_error').html('')
        $('#add_return_datetime_error').html('')
        $('#add_return_status_error').html('')
        $.ajax({
            url: "{{ route('admin.return.create') }}",
            dataType: "json",
            type: 'get',
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('.inventory_loder').hide()
                var plen = data.product.length;
                $('#select_return_product').empty()
                $('#select_return_product').append('<option value="">--Select--</option>')
                for (var i = 0; i < plen; i++) {
                    $('#select_return_product').append("<option value='" + data.product[i][
                        'id'
                    ] + "'>" + data.product[i]['title'] + "</option>");
                }

                var wlen = data.warehouse.length;
                $('#select_return_warehouse').empty()
                $('#select_return_warehouse').append('<option value="">--Select--</option>')
                for (var i = 0; i < wlen; i++) {
                    $('#select_return_warehouse').append("<option value='" + data.warehouse[i][
                        'id'
                    ] + "'>" + data.warehouse[i]['name'] + "</option>");
                }

                $('#select_return_warehouse').trigger("change");
            },
            error: function(error) {
                $('.inventory_loder').hide()
                console.log(error)
            }
        });
    }

    // show rack
    $('#select_return_warehouse').change(function() {
        $.ajax({
            url: "{{ route('admin.showRack') }}",
            type: 'get',
            data: {
                id: $(this).val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('.inventory_loder').hide()
                var wlen = data.length;
                $('#select_return_rack').empty();
                $('#select_return_rack').append('<option value="">--Select--</option>')
                if (wlen) {
                    for (var i = 0; i < wlen; i++) {
                        $('#select_return_rack').append("<option value='" + data[i]['id'] +
                            "'>" + data[i]['name'] + "</option>");
                    }
                } else {
                    $('#select_return_rack').append("<option value=''>No Data Found</option>");
                }
            },
            error: function(error) {
                $('.inventory_loder').hide()
                console.log(error);
            }
        })
    });

    // add return
    $('#add_return_btn').click(function(e) {
        e.preventDefault()
        var form = $('#add_return_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.return.store') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#add_return_spin').show();
                $("#add_return_form :input").prop("disabled", true);
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('#add_return_spin').hide();
                $('#add_return_modal').modal('hide');
                $("#add_return_form :input").prop("disabled", false);
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
                $('#table_return').bootstrapTable('refresh');
            },
            error: function(error) {
                $('#add_return_spin').hide();
                $("#add_return_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#add_return_product_name_error').html(err.productid)
                    $('#add_return_name_error').html(err.warehouseid)
                    $('#add_return_rack_name_error').html(err.rackid)
                    $('#add_return_quantity_error').html(err.quantity)
                    $('#add_return_datetime_error').html(err.date)
                    $('#add_return_status_error').html(err.status)
                }
            }
        });
    });




    // clear error
    $("#add_return_form :input").click(function() {
        $('#add_return_product_name_error').html("")
        $('#add_return_name_error').html("")
        $('#add_return_rack_name_error').html("")
        $('#add_return_quantity_error').html("")
        $('#add_return_datetime_error').html("")
        $('#add_return_status_error').html("")
    })

    $('#edit_return_form :input').click(function() {
        $('#edit_warehouse_stock_product_name_error').html("")
        $('#edit_return_warehouse_name_error').html("")
        $('#edit_return_rack_name_error').html("")
        $('#edit_return_quantity_error').html("")
        $('#edit_return_datetime_error').html("")
        $('#edit_return_status_error').html("")
    });

    // delete retutn
    function deleteReturn(id) {
        $('#return_delete-modal').modal('show');
        $("#return_delete-link").attr("href", id);
    }
    // delete logic
    $('#return_delete-link').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.retutn.delete') }}",
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
                    $("#return_delete-modal").modal("hide");
                }
                $('#table_return').bootstrapTable('refresh');

            },
            error: function(error) {
                console.log(error)
                $('.inventory_loder').hide()
            }
        })
    });
</script>
