<script>
    $(document).ready(function() {
        getAllcountry()
    });
    // get all country
    function getAllcountry() {
        $.ajax({
            url: "{{ route('get_all_country') }}",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('#ship_charge_loder').show()
            },
            success: function(data) {
                $('#ship_charge_loder').hide()
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    ''
                    $(".allcountry").append("<option value='" + data[i] + "'>" + data[i] +
                        "</option>");
                }

            }
        })
    }


    function showBranches(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.branch.index') }}",
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
    function branchAction(value, row, index) {
        return [
            '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Edit" onclick="editBranch(' +
            row.id + ')">',
            '<i class="las la-edit"></i>',
            '</a>  ',
            '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteBranch(' +
            row.id + ')">',
            '<i class="las la-trash"></i>',
            '</a>'
        ].join('')
    }

    // edit branch
    function editBranch(id) {
        $('#edit_branch_modal').modal('show');
        $('#edit_branch_name_error').html('')
        $('#edit_branch_detail_error').html('')
        $('#edit_branch_address_error').html('')
        $('#edit_branch_pincode_error').html('')
        $('#edit_branch_country_error').html('');
        $('#edit_ware_house_id_error').html('')
        get_warehouse_for_branch()
        $.ajax({
            url: "{{ route('admin.branch.showEditData') }}",
            type: 'get',
            dataType: "json",
            data: {
                id: id
            },
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                console.log(data)
                $('.inventory_loder').hide()
                $('#ware_house_id').val(data.ware_house_id)
                $('#branch_id').val(data.id)
                $('#branch_name').val(data.name);
                $('#branch_detail').val(data.detail);
                $('#branch_address').val(data.address);
                $('#branch_pincode').val(data.pincode)
                $('#branch_country').val(data.country);
            },
            error: function(error) {
                $('.inventory_loder').hide()
                console.log(error)
            }
        })
    }


    // update branch
    $('#edit_branch_btn').click(function(e) {
        e.preventDefault();
        var form = $('#edit_branch_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.branch.updateBranch') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#edit_branch_spin').show();
                $("#edit_branch_form :input").prop("disabled", true);
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('#edit_branch_spin').hide();
                $('#edit_branch_modal').modal('hide');
                $("#edit_branch_form :input").prop("disabled", false);
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
                $('#table_branches').bootstrapTable('refresh');
            },
            error: function(error) {
                $('#edit_branch_spin').hide();
                $("#edit_branch_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                console.log(error)
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#edit_branch_name_error').html(err.name)
                    $('#edit_branch_detail_error').html(err.detail)
                    $('#edit_branch_address_error').html(err.address)
                    $('#edit_branch_pincode_error').html(err.pincode)
                    $('#edit_branch_country_error').html(err.country);
                }
            }
        })
    });

    function add_branches() {
        $('#add_branch_form')[0].reset();
        $('#add_branch_name_error').html('')
        $('#add_branch_detail_error').html('')
        $('#add_branch_address_error').html('')
        $('#add_branch_pincode_error').html('')
        $('#add_branch_country_error').html('');
        $('#add_ware_house_id_error').html('')

        get_warehouse_for_branch()
    }

    function get_warehouse_for_branch() {
        $.ajax({
            url: "{{ route('admin.showWareHouse') }}",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('.inventory_loder').hide();
                var len = data.length;
                $('.warehouse').empty()
                for (var i = 0; i < len; i++) {
                    $('.warehouse').append("<option value='" + data[i]['id'] + "'>" + data[i]['name'] +
                        "</option>")
                }
            },
            error: function(error) {
                console.log(error)
                $('.inventory_loder').hide();
            }
        });
    }


    // add branch
    $('#add_branch_btn').click(function(e) {
        e.preventDefault()
        var form = $('#add_branch_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ route('admin.branch.store') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                $('#add_branch_spin').show();
                $("#add_branch_form :input").prop("disabled", true);
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('#add_branch_spin').hide();
                $('#add_branch_modal').modal('hide');
                $("#add_branch_form :input").prop("disabled", false);
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
                $('#add_branch_form')[0].reset();
                $('#table_branches').bootstrapTable('refresh');
            },
            error: function(error) {
                $('#add_branch_spin').hide();
                $("#add_branch_form :input").prop("disabled", false);
                $('.inventory_loder').hide()
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    $('#add_branch_name_error').html(err.name)
                    $('#add_branch_detail_error').html(err.detail)
                    $('#add_branch_address_error').html(err.address)
                    $('#add_branch_pincode_error').html(err.pincode)
                    $('#add_branch_country_error').html(err.country);
                    $('#add_ware_house_id_error').html(err.ware_house_id)
                }
            }
        });
    });




    // clear error
    $("#add_branch_form :input").click(function() {
        $('#add_branch_name_error').html("")
        $('#add_branch_detail_error').html("")
        $('#add_branch_address_error').html("")
        $('#add_branch_pincode_error').html("")
        $('#add_branch_country_error').html("");
        $('#add_ware_house_id_error').html('')
    })

    $('#edit_branch_form :input').click(function() {
        $('#edit_branch_name_error').html('')
        $('#edit_branch_detail_error').html('')
        $('#edit_branch_address_error').html('')
        $('#edit_branch_pincode_error').html('')
        $('#edit_branch_country_error').html('');
    });

    // delete branch
    function deleteBranch(id) {
        $('#branch_delete-modal').modal('show');
        $("#branch_delete-link").attr("href", id);
    }
    // delete logic
    $('#branch_delete-link').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.branch.delete') }}",
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
                    $('#branch_delete-modal').modal('hide');
                }
                $('#table_branches').bootstrapTable('refresh');
            },
            error: function(error) {
                $('.inventory_loder').hide()
                console.log(error)
            }
        })
    });
</script>
