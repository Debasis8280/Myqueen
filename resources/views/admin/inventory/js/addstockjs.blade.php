<script>
    function ajaxRequest(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.inventory.create') }}",
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
    function operateFormatter(value, row, index) {
        return [
            '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Edit" onclick="editInventory(' +
            row.id + ')">',
            '<i class="las la-edit"></i>',
            '</a>  ',
            '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteInventory(' +
            row.id + ')">',
            '<i class="las la-trash"></i>',
            '</a>'
        ].join('')
    }

    // show edit data
    function editInventory(id) {
        $('#edit_warehouse_stock_modal').modal('show');
        $('#edit_warehouse_stock_form')[0].reset();
        $('#edit_warehouse_stock_product_name_error').html('')
        $('#edit_warehouse_stock_name_error').html('')
        $('#edit_warehouse_stock_rack_name_error').html('')
        $('#edit_edit_warehouse_stock_quantity_error').html('')

        $.ajax({
            url: "{{ route('admin.showeditinventoryData') }}",
            type: 'get',
            data: {
                id: id
            },
            dataType: 'json',
            beforeSend: function() {
                $('#warehouse_add_stock_loder').show()
            },
            success: function(data) {
                $('#warehouse_add_stock_loder').hide()
                $('#productname').val(data.data.title)
                $('#stock').val(data.data.stock)
                $('#id').val(data.data.id);
                var len = data.warehouse.length;
                var checked = data.data.warehouseid;
                for (var i = 0; i < len; i++) {
                    var condition = checked == data.warehouse[i]['id'] ? "selected" : "";
                    $('#select_edit_warehouse_stock_warehouse').append("<option value='" + data.warehouse[i]
                        ['id'] + "' " + condition + ">" + data.warehouse[i]['name'] + "</option>")
                }

                var rlen = data.rack.length;
                var rchecked = data.data.rackid;
                for (var i = 0; i < rlen; i++) {
                    var condition = rchecked == data.rack[i]['id'] ? "selected" : "";
                    $('#select_edit_warehouse_stock_rack').append("<option value='" + data.rack[i]
                        ['id'] + "' " + condition + ">" + data.rack[i]['name'] + "</option>")
                }
            }
        })
    }

    $('#select_edit_warehouse_stock_warehouse').change(function() {
        $.ajax({
            url: "{{ route('admin.showRack') }}",
            type: 'get',
            data: {
                id: $(this).val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#warehouse_add_stock_loder').show()
            },
            success: function(data) {
                $('#warehouse_add_stock_loder').hide()
                var wlen = data.length;
                $('#select_edit_warehouse_stock_rack').empty();
                for (var i = 0; i < wlen; i++) {
                    $('#select_edit_warehouse_stock_rack').append("<option value='" + data[i][
                            'id'
                        ] +
                        "'>" + data[i]['name'] + "</option>");
                }
            },
            error: function(error) {
                $('#warehouse_add_stock_loder').hide()
                console.log(errpr);
            }
        })
    });

    // update inventory
    $('#edit_stock_btn').click(function(e) {
        e.preventDefault();
        var form = $('#edit_warehouse_stock_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.updateInventory') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#edit_stock_spin').show();
                $("#edit_warehouse_stock_form :input").prop("disabled", true);
                $('#warehouse_add_stock_loder').show()
            },
            success: function(data) {
                $('#edit_stock_spin').hide();
                $('#edit_warehouse_stock_modal').modal('hide');
                $("#edit_warehouse_stock_form :input").prop("disabled", false);
                $('#warehouse_add_stock_loder').hide()
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

                $('#table_add_stock').bootstrapTable('refresh');
            },
            error: function(error) {
                $('#edit_stock_spin').hide();
                $("#edit_warehouse_stock_form :input").prop("disabled", false);
                $('#warehouse_add_stock_loder').hide()
                console.log(error)
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#edit_warehouse_stock_product_name_error').html(err.id)
                    $('#edit_warehouse_stock_name_error').html(err.warehouseid)
                    $('#edit_warehouse_stock_rack_name_error').html(err.rackid)
                    $('#edit_edit_warehouse_stock_quantity_error').html(err.stock)
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
    function getData() {
        $('#add_warehouse_stock_form')[0].reset();
        $('#add_warehouse_stock_product_name_error').html('')
        $('#add_warehouse_stock_name_error').html('')
        $('#add_warehouse_stock_rack_name_error').html('')
        $('#add_warehouse_stock_quantity_error').html('')

        $.ajax({
            url: "{{ route('admin.getAllWarehouseDetails') }}",
            dataType: "json",
            type: 'get',
            beforeSend: function() {
                $('#warehouse_add_stock_loder').show();
            },
            success: function(data) {
                $('#warehouse_add_stock_loder').hide();
                var plen = data.product.length;
                $('#select_warehouse_stock_product').empty();
                $('#select_warehouse_stock_product').append('<option value="">--Select--</option>');
                for (var i = 0; i < plen; i++) {
                    $('#select_warehouse_stock_product').append("<option value='" + data.product[i][
                        'id'
                    ] + "'>" + data.product[i]['title'] + "</option>");
                }

                $('#select_warehouse_stock_warehouse').empty();
                $('#select_warehouse_stock_warehouse').append('<option value="">--Select--</option>');
                var wlen = data.warehouse.length;
                for (var i = 0; i < wlen; i++) {
                    $('#select_warehouse_stock_warehouse').append(
                        "<option value='" + data.warehouse[i][
                            'id'
                        ] + "'>" + data.warehouse[i]['name'] + "</option>");
                }
                $('#select_warehouse_stock_warehouse').trigger("change");
            },
            error: function(error) {
                $('#warehouse_add_stock_loder').hide();
                console.log(error)
            }
        });
    }

    // show rack
    $('#select_warehouse_stock_warehouse').change(function() {
        $.ajax({
            url: "{{ route('admin.showRack') }}",
            type: 'get',
            data: {
                id: $(this).val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#warehouse_add_stock_loder').show();
            },
            success: function(data) {
                $('#warehouse_add_stock_loder').hide();
                var wlen = data.length;
                $('#select_warehouse_stock_rack').empty();
                $('#select_warehouse_stock_rack').append('<option value="">--Select--</option>');
                if (wlen) {
                    for (var i = 0; i < wlen; i++) {
                        $('#select_warehouse_stock_rack').append("<option value='" + data[i]['id'] +
                            "'>" + data[i]['name'] + "</option>");
                    }
                } else {
                    $('#select_warehouse_stock_rack').append(
                        "<option value=''> No Data Found</option>")
                }
            },
            error: function(error) {
                $('#warehouse_add_stock_loder').hide();
                console.log(error);
            }
        })
    });

    $('#add_warehouse_stock_btn').click(function(e) {
        e.preventDefault()
        var form = $('#add_warehouse_stock_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.inventory.store') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#add_warehouse_stock_spin').show();
                $("#add_warehouse_stock_form :input").prop("disabled", true);
                $('#warehouse_add_stock_loder').show();
            },
            success: function(data) {
                $('#add_warehouse_stock_spin').hide();
                $('#add_warehouse_stock').modal('hide');
                $("#add_warehouse_stock_form :input").prop("disabled", false);
                $('#warehouse_add_stock_loder').hide();
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
                $('#table_add_stock').bootstrapTable('refresh');
            },
            error: function(error) {
                $('#add_warehouse_stock_spin').hide();
                $("#add_warehouse_stock_form :input").prop("disabled", false);
                $('#warehouse_add_stock_loder').hide();
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#add_warehouse_stock_product_name_error').html(err.productid)
                    $('#add_warehouse_stock_name_error').html(err.warehouseid)
                    $('#add_warehouse_stock_rack_name_error').html(err.rackid)
                    $('#add_warehouse_stock_quantity_error').html(err.stock)
                }
            }
        });
    });




    // clear error
    $("#add_warehouse_stock_form :input").click(function() {
        $('#add_warehouse_stock_product_name_error').html('')
        $('#add_warehouse_stock_name_error').html('')
        $('#add_warehouse_stock_rack_name_error').html('')
        $('#add_warehouse_stock_quantity_error').html('')
    })

    $('#edit_warehouse_stock_form :input').click(function() {
        $('#add_warehouse_name_error').html("")
        $('#add_warehouse_detail_error').html("")
        $('#add_warehouse_statu_error').html("")
    });

    // delete inventory
    function deleteInventory(id) {
        $('#delete-modal').modal('show');
        $("#delete-link").attr("href", id);
    }
    // delete logic
    $('#delete-link').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.inventory.delete') }}",
            type: "post",
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                id: $(this).attr('href')
            },
            beforeSend: function() {
                $('#warehouse_add_stock_loder').show();
            },
            success: function(data) {
                $('#warehouse_add_stock_loder').hide();
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
                    $("#delete-modal").modal("hide");
                }
                $('#table_add_stock').bootstrapTable('refresh');
            },
            error: function(error) {
                $('#warehouse_add_stock_loder').hide();
                console.log(error)
            }
        })
    });
</script>
