<script>
    $(document).ready(function() {
        get_all_rank()
        getAllcountry()
    })

    function getAllcountry() {
        $.ajax({
            url: "{{ route('get_all_country') }}",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('#loder').show()
            },
            success: function(data) {
                $('#loder').hide()
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    ''
                    $(".allcountry").append("<option value='" + data[i] + "'>" + data[i] +
                        "</option>");
                }

            }
        })
    }

    function get_all_rank() {
        $.ajax({
            url: "{{ URL::signedRoute('MLM.register.create') }}",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('#loder').show();
            },
            success: function(data) {
                var len = data.ranking.length;
                $('#ranking').empty();
                $('#ranking').append('<option value="">--Select--</option>')
                for (var i = 0; i < len; i++) {
                    $('#ranking').append('<option value="' + data.ranking[i]['id'] + '">' + data
                        .ranking[i]['type'] + ' (' + data.ranking[i][
                            'points'
                        ] + 'PV)' +
                        '</option>')
                }
                var branch_len = data.branch.length;
                $('#select_branch').empty();
                $('#select_branch').append('<option value="">--Select--</option>')
                for (var i = 0; i < branch_len; i++) {
                    $('#select_branch').append('<option value="' + data.branch[i]['id'] + '">' + data
                        .branch[i]['name'] +
                        '</option>')
                }
                $('#loder').hide();
            },
            error: function(error) {
                console.log(error)
                $('#loder').hide();
                if (error.status == 401) {
                    window.location.href = "{{ route('login') }}"
                }
            }
        });
    }


    // get all user 
    $('#member_id').autocomplete({
        source: function(request, response) {
            $.ajax({
                type: 'get',
                url: "{{ route('MLM.register.search_user') }}",
                dataType: "json",
                data: {
                    term: $('#member_id').val()
                },
                success: function(data) {
                    response(data);
                    console.log(data)
                },
            });
        },
        minLength: 1,
        select: function(event, ui) {
            if (ui.item.id != 0) {
                $('#member_name').val(ui.item.name);
                $('#email').val(ui.item.email)

                check_user_status(ui.item.unique_id)

            }
        },
    });


    function check_user_status(id) {
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right"
        };
        $.ajax({
            url: "{{ URL::signedRoute('MLM.register.check_user_status') }}",
            type: 'post',
            data: {
                '_token': "{{ csrf_token() }}",
                id: id,
                pv_id: $('#ranking').val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loder').show()
            },
            success: function(data) {
                console.log(data);
                if (data.status == 'success') {
                    $('#member_id_error').html('');
                    get_placement_id();
                    get_pv_point(id);
                } else {
                    $('#member_id_error').html(data.message);
                }
                $('#loder').hide()
            },
            error: function(error) {
                $('#loder').hide()
                console.log(error)
                if (error.status == 422) {
                    var err = error.responseJSON.errors;
                    if (err.not_user)
                        toastr.error(err.not_user);
                }
            }
        })
    }

    function get_placement_id() {
        $.ajax({
            url: "{{ URL::signedRoute('MLM.register.get_placement_id') }}",
            type: 'post',
            dataType: 'json',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('#loder').show();
            },
            success: function(data) {
                if (data.status == 'success') {
                    var len = data.data.length;
                    $('#placement_id').empty();
                    $('#placement_id').append('<option value="">--Select--</option>')
                    for (var i = 0; i < len; i++) {
                        $('#placement_id').append('<option value="' + data.data[i]['id'] + '">' + data.data[
                            i]['name'] + '</option>')
                    }
                } else {
                    $('#placement_id').empty();
                    $('#placement_id').append('<option value="">--Select--</option>')
                    $('#placement_id').append('<option value="' + data.id + '">' + data.name +
                        '</option>')

                    $('#placement').empty();
                    $('#placement').append('<option value="">--Select--</option>')
                    $('#placement').append(
                        '<option value="0">Left</option><option value="1">Right</option>')
                }

                $('#loder').hide();
            },
            error: function(error) {
                $('#loder').hide();
                console.log(error)
            }
        })
    }


    function get_pv_point(id) {
        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right"
        };
        $.ajax({
            url: "{{ URL::signedRoute('MLM.register.get_pv_point') }}",
            type: 'post',
            data: {
                '_token': "{{ csrf_token() }}",
                id: id == null ? $('#ranking').val() : id,
                pv_id: $('#ranking').val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loder').show()
            },
            success: function(data) {
                if (data.status == 'success') {
                    // toastr.success("");
                } else {
                    toastr.error(data.message);
                }
                $('#loder').hide()
            },
            error: function(error) {
                $('#loder').hide()
                console.log(error)
                if (error.status == 422) {
                    var err = error.responseJSON.errors;
                    if (err.not_user)
                        toastr.error(err.not_user);
                }
            }
        })
    }

    // on ranking change
    $('#ranking').change(function() {
        get_pv_point()
    });



    $('#placement_id').change(function() {
        $.ajax({
            url: "{{ URL::signedRoute('MLM.register.get_placement') }}",
            type: 'post',
            data: {
                id: $('#placement_id').val(),
                '_token': "{{ csrf_token() }}"
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loder').show();
            },
            success: function(data) {

                $('#placement').empty();
                if (data.view == 2) {
                    $('#placement').append(
                        '<option value="">--Select--</option> <option value="0">' + data.data
                        .left +
                        '</option><option value="1">' + data.data.right + '</option>')
                } else {
                    $('#placement').append('<option value="">--Select--</option> <option value="' +
                        data.value + '">' + data.data +
                        '</option>')
                }
                $('#loder').hide();
            },
            error: function(error) {
                $('#loder').hide();
                console.log(error)
            }
        });
    });



    $('#order_with_pv_point').click(function(e) {
        e.preventDefault();
        var form = $('#order_with_pv_point_form')[0];
        var data = new FormData(form);

        toastr.options = {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right"
        };
        $.ajax({
            url: "{{ URL::signedRoute('MLM.register.store') }}",
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                $('#loder').show()
            },
            success: function(data) {
                if (data.status == 'success') {
                    toastr.success(data.message);
                }
                $('#order_with_pv_point_form').trigger("reset");
                $('#loder').hide()
            },
            error: function(error) {
                $('#loder').hide()
                var err = error.responseJSON.errors;
                if (error.status == 422) {
                    toastr.error("Error");
                    $('#ranking_id_error').html(err.ranking)
                    $('#branch_id_error').html(err.branch_id)
                    $('#member_id_error').html(err.member_id)
                    $('#member_name_error').html(err.member_name)
                    $('#placement_id_error').html(err.placement_id)
                    $('#placement_error').html(err.placement)
                    if (err.less_pv) {
                        toastr.error(err.less_pv);
                    }
                }
                console.log(error)
            }
        })
    });

    $('#order_with_pv_point_form :input').click(function() {
        $('#ranking_id_error').html('')
        $('#branch_id_error').html('')
        $('#member_id_error').html('')
        $('#member_name_error').html('')
        $('#placement_id_error').html('')
        $('#placement_error').html('')
        $('#nationality_error').html('')
    })
</script>
