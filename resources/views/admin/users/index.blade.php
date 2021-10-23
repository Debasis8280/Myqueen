@extends('admin.layout.main')

@section('content')
    <style>
        .form-group.required .control-label:after {
            content: "*";
            color: red;
        }

    </style>
    <div class="content-wrapper">
        <div class="container-fluid bg-white table-responsive">
            <table id="table" data-toggle="table" data-height="460" data-ajax="showusers" data-pagination="true"
                data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-search="true"
                data-show-export="true">
                <thead>
                    <tr>
                        <th data-checkbox="true"></th>
                        <th data-field="id">ID</th>
                        <th data-field="unique_id">Unique Id</th>
                        <th data-field="name">Name</th>
                        <th data-field="total_pv_point">PV Point</th>
                        <th data-field="email">Email</th>
                        <th data-field="phone">Phone</th>
                        <th data-field="operate" data-formatter="usersAction">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        {{-- edit user --}}
        <div class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="edit_user_form">
                            @csrf
                            <div class="form-group required">
                                <label for="" class="control-label">First Name:</label>
                                <input type="text" name="name" class="form-control" id="username">
                                <input type="hidden" name="id" id="userid">
                                <span id="edit_user_firstname_error" style="color: red"></span>
                            </div>

                            <div class="form-group required">
                                <label for="" class="control-label">Email:</label>
                                <input type="text" name="email" class="form-control" id="useremail">

                                <span id="edit_user_email_error" style="color: red"></span>
                            </div>

                            <div class="form-group required">
                                <label for="" class="control-label">Phone:</label>
                                <input type="text" name="phone" class="form-control" id="userphone">

                                <span id="edit_user_phone_error" style="color: red"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="edit_user_btn"><i
                                class="loading-icon fa fa-spinner fa-spin" id="edit_user_spin" style="display: none">
                            </i>Save</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end edit user --}}


    </div>


    <div id="user_delete-modal" class="modal fade">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">Are you sure to delete this?</p>
                    <button type="button" class="btn btn-link mt-2" data-dismiss="modal">Cancel</button>
                    <a href="" id="user_delete-link" class="btn btn-primary mt-2">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <div id="user_loder" style="display: none">
        @include('admin.loder.index')
    </div>

@section('javascript')


    <script>
        function showusers(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.users.create') }}",
                dataType: "json",
                success: function(data) {
                    // console.log(data)
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }



        // action
        function usersAction(value, row, index) {
            var url = "{{ route('admin.profile.show', ':id') }}";
            url = url.replace(':id', row.id)
            return [
                '<a class="btn btn-soft-success  btn-icon btn-circle btn-sm" href="' + url + '" title="Show">',
                '<i class="las la-eye"></i>',
                '</a>  ',
                '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Edit" onclick="editUsers(' +
                row.id + ')">',
                '<i class="las la-edit"></i>',
                '</a>  ',
                '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteUser(' +
                row.id + ')">',
                '<i class="las la-trash"></i>',
                '</a>'
            ].join('')
        }

        function editUsers(id) {
            $('#edit_user_modal').modal('show');
            $('#edit_user_form')[0].reset();
            $('#edit_user_firstname_error').html("")
            $('#edit_user_lastname_error').html("")
            $('#edit_user_email_error').html("")
            $('#edit_user_phone_error').html("")
            $.ajax({
                url: "{{ route('admin.users.getUserDetails') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                dataType: "json",
                beforeSend: function() {
                    $('#user_loder').show()
                },
                success: function(data) {
                    $('#user_loder').hide()
                    $('#userid').val(data.id);
                    $("#username").val(data.name);
                    $("#useremail").val(data.email);
                    $('#userphone').val(data.phone)
                },
                error: function() {
                    $('#user_loder').hide()
                    alert("Fail")
                }

            })
        }
        // update user
        $('#edit_user_btn').click(function(e) {
            e.preventDefault();
            var form = $('#edit_user_form')[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{ route('admin.users.updateUser') }}",
                type: "POST",
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#edit_user_spin').show();
                    $("#edit_user_form :input").prop("disabled", true);
                    $('#user_loder').show()
                },
                success: function(data) {
                    $('#edit_user_spin').hide();
                    $('#edit_user_modal').modal('hide');
                    $("#edit_user_form :input").prop("disabled", false);
                    $('#user_loder').hide()
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
                    $('#table').bootstrapTable('refresh');
                },
                error: function(error) {
                    $('#edit_user_spin').hide();
                    $("#edit_user_form :input").prop("disabled", false);
                    $('#user_loder').hide()
                    console.log(error)
                    var err = error.responseJSON.errors;
                    if (error.status == 422) {
                        $('#edit_user_firstname_error').html(err.firstname)
                        $('#edit_user_lastname_error').html(err.lastname)
                        $('#edit_user_email_error').html(err.email)
                        $('#edit_user_phone_error').html(err.phone)
                    }
                }
            })
        });

        // clear error
        $('#edit_user_form :input').click(function() {
            $('#edit_user_firstname_error').html("")
            $('#edit_user_lastname_error').html("")
            $('#edit_user_email_error').html("")
            $('#edit_user_phone_error').html("")
        })

        // delete user
        function deleteUser(id) {
            $('#user_delete-modal').modal('show');
            $("#user_delete-link").attr("href", id);
        }
        // delete logic
        $('#user_delete-link').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.users.deleteUser') }}",
                type: "post",
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $(this).attr('href')
                },
                beforeSend: function() {
                    $('#user_loder').show()
                },
                success: function(data) {
                    $('#user_loder').hide()
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
                        $('#user_delete-modal').modal('hide');
                        $('#table').bootstrapTable('refresh');
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            })
        });
    </script>
@endsection
@endsection
