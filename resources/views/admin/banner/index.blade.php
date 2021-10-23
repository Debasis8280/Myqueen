@extends('admin.layout.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="mb-2 row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Banner </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Banners</h3>
                                <div class="float-right">
                                    <button type="button" class="btn btn-info add-new" data-toggle="modal"
                                        data-target="#add_banner_modal" onclick="add_banner()"><i
                                            class="fa fa-plus"></i>
                                        Add
                                        Banner</button>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="table" data-toggle="table" data-height="460" data-ajax="showBanner"
                                    data-pagination="true" data-show-columns="true" data-show-pagination-switch="true"
                                    data-show-refresh="true" data-search="true" data-show-export="true">
                                    <thead>
                                        <tr>
                                            <th data-checkbox="true"></th>
                                            <th data-field="id">ID</th>
                                            <th data-field="Image_eng" data-formatter="bannerEngImage">English Image
                                            </th>
                                            <th data-field="Image_ch" data-formatter="bannerChaImage">China Image</th>
                                            <th data-field="operate" data-formatter="bannerAction">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- add banner --}}
    <div class="modal fade " id="add_banner_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="add_banner_form">
                        @csrf
                        <div class="form-group required">
                            <label for="" class="control-label">English Image:</label>
                            <input type="file" name="Image_eng" class="form-control">
                            <span id="add_banner_en_image_error" style="color: red"></span>
                        </div>
                        <div class="form-group required">
                            <label for="" class="control-label">China Image:</label>
                            <input type="file" name="Image_ch" class="form-control">
                            <span id="add_banner_ch_image_error" style="color: red"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="add_banner_btn"><i
                            class="loading-icon fa fa-spinner fa-spin" id="add_banner_spin" style="display: none">
                        </i>Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end add banner --}}

    <div id="banner_delete-modal" class="modal fade">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">Are you sure to delete this?</p>
                    <button type="button" class="btn btn-link mt-2" data-dismiss="modal">Cancel</button>
                    <a href="" id="banner_delete-link" class="btn btn-primary mt-2">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <div id="banner_loder" style="display: none">
        @include('admin.loder.index')
    </div>

@section('javascript')

    <script>
        function showBanner(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.banner.create') }}",
                dataType: "json",
                success: function(data) {
                    params.success(data)
                },
                error: function(er) {
                    params.error(er);
                }
            });
        }
        // image
        function bannerEngImage(data) {
            var url = "{{ asset('') }}";
            return "<img src='" + url + data + "' width='100' height='80'>"
        }

        function bannerChaImage(data) {
            var url = "{{ asset('') }}";
            return "<img src='" + url + data + "' width='100' height='80'>"
        }

        // action
        function bannerAction(value, row, index) {
            return [
                '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteBanner(' +
                row.id + ')">',
                '<i class="las la-trash"></i>',
                '</a>'
            ].join('')
        }

        function add_banner() {
            $('#add_banner_form')[0].reset();
            $('#add_banner_en_image_error').html("")
            $('#add_banner_ch_image_error').html("")
        }

        // add banner
        $('#add_banner_btn').click(function(e) {
            e.preventDefault();
            var form = $('#add_banner_form')[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{ route('admin.banner.store') }}",
                type: "POST",
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#add_banner_spin').show();
                    $("#add_banner_form :input").prop("disabled", true);
                    $('#banner_loder').show()
                },
                success: function(data) {
                    $('#add_banner_spin').hide();
                    $('#add_banner_modal').modal('hide');
                    $("#add_banner_form :input").prop("disabled", false);
                    $('#banner_loder').hide()
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
                    $('#add_banner_form')[0].reset();
                },
                error: function(error) {
                    $('#add_banner_spin').hide();
                    $("#add_banner_form :input").prop("disabled", false);
                    $('#banner_loder').hide()
                    console.log(error)
                    var err = error.responseJSON.errors;
                    if (error.status == 422) {
                        $('#add_banner_en_image_error').html(err.Image_eng)
                        $('#add_banner_ch_image_error').html(err.Image_ch)
                    }
                }
            })
        })
        // clear error
        $('#add_banner_form :input').click(function() {
            $('#add_banner_en_image_error').html("")
            $('#add_banner_ch_image_error').html("")
        })

        // delete banner
        function deleteBanner(id) {
            $('#banner_delete-modal').modal('show');
            $("#banner_delete-link").attr("href", id);
        }
        // delete logic
        $('#banner_delete-link').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.banner.deleteBanner') }}",
                type: "post",
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: $(this).attr('href')
                },
                beforeSend: function() {
                    $('#banner_loder').show()
                },
                success: function(data) {
                    $('#banner_loder').hide()
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
                        $('#banner_delete-modal').modal('hide');
                        $('#table').bootstrapTable('refresh');
                    }
                },
                error: function(error) {
                    $('#banner_loder').hide()
                    console.log(error)
                }
            })
        });
    </script>
@endsection
@endsection
