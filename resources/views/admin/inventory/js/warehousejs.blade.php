<script>
    function showWarehouse(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.showWareHouse') }}",
            dataType: "json",
            success: function(data) {
                // console.log(data);
                params.success(data)
            },
            error: function(er) {
                params.error(er);
            }
        });
    }

    function showRack(index, row) {
        var html = []
        $.ajax({
            async: false,
            url: "{{ route('admin.showRack') }}",
            type: 'GET',
            data: {
                id: row.id
            },
            beforeSend: function() {
                $('.inventory_loder').show();
            },
            dataType: 'json',
            success: function(data) {
                $('.inventory_loder').hide();
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    html.push("<div class='d-flex'><div>Name:" + data[i]['name'] + "</div></div>");
                }
            }
        })
        return html.join('')
    }

    function ware_house_status(data) {
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

    function ware_house_action(value, row, index) {
        return [
            // '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Edit">',
            // '<i class="fa fa-eye" aria-hidden="true"></i>',
            // '</a>  ',
            '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteWareHouseWithRack(' +
            row.id + ')">',
            '<i class="las la-trash"></i>',
            '</a>'
        ].join('')
    }
    // delete order
    function deleteWareHouseWithRack(id) {
        $('#ware_house_delete-modal').modal('show');
        $("#ware_house_delete-link").attr("href", id);
    }
    // delete logic
    $('#ware_house_delete-link').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.ware_house.delete') }}",
            type: "post",
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                id: $(this).attr('href')
            },
            beforeSend: function() {
                $('.inventory_loder').show();
            },
            success: function(data) {
                $('.inventory_loder').hide();
                $('#table').bootstrapTable('refresh');
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
                    $('#ware_house_delete-modal').modal('hide');
                }
            },
            error: function(error) {
                $('.inventory_loder').hide();
                console.log(error)
            }
        })
    });

    function add_ware_house() {
        $('#add_warehouse_form')[0].reset();
        $('#add_warehouse_name_error').html('')
        $('#add_warehouse_detail_error').html('')
        $('#add_warehouse_statu_error').html('')
    }

    $('#add_warehouse_btn').click(function(e) {
        e.preventDefault()
        var form = $('#add_warehouse_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.addWarehouse') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#add_warehouse_spin').show();
                $("#add_warehouse_form :input").prop("disabled", true);
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('#add_warehouse_spin').hide();
                $('#add_warehouse_modal').modal('hide');
                $("#add_warehouse_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                $('#table').bootstrapTable('refresh');
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
                $('#add_warehouse_spin').hide();
                $("#add_warehouse_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#add_warehouse_name_error').html(err.name)
                    $('#add_warehouse_detail_error').html(err.detail)
                    $('#add_warehouse_statu_error').html(err.status)
                }
            }
        });
    });

    function addRack() {
        $('#add_rack_form')[0].reset();
        $('#select_warehouse_name_error').html('')
        $('#add_rack_name_error').html('')
        $.ajax({
            url: "{{ route('admin.showWareHouse') }}",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('.inventory_loder').hide()
                var len = data.length;
                $('#select_ware_house').empty();
                $('#select_ware_house').append('<option value="">--Select--</option>');
                for (var i = 0; i < len; i++) {
                    $('#select_ware_house').append("<option value='" +
                        data[i]['id'] + "'>" + data[i][
                            'name'
                        ] + "</option>")
                }
            },
            error: function(error) {
                $('.inventory_loder').hide()
                console.log(error);
            }
        })
    }

    // add rack
    $('#add_rack_btn').click(function(e) {
        e.preventDefault()
        var form = $('#add_rack_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.addRack') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#add_rack_spin').show();
                $("#add_rack_form :input").prop("disabled", true);
                $('.inventory_loder').show()
            },
            success: function(data) {
                console.log(data);
                $('#add_rack_spin').hide();
                $("#add_rack_form :input").prop("disabled", false);
                $('#add_rack_modal').modal('hide');
                $('.inventory_loder').hide()
                $('#table').bootstrapTable('refresh');
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
                $('#add_rack_spin').hide();
                $("#add_rack_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#select_warehouse_name_error').html(err.warehouses_id)
                    $('#add_rack_name_error').html(err.name)
                }
            }
        });
    });

    // clear error
    $("#add_rack_form :input").click(function() {
        $('#select_warehouse_name_error').html('')
        $('#add_rack_name_error').html('')
    })

    $('#add_warehouse_form :input').click(function() {
        $('#add_warehouse_name_error').html("")
        $('#add_warehouse_detail_error').html("")
        $('#add_warehouse_statu_error').html("")
    });
</script>
