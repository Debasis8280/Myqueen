@extends('admin.layout.main')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.2/tinymce.min.js"></script>
    <style>
        .mce-notification {
            display: none !important;
        }

    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="mb-2 row">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Add Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>

            <section class="content">
                <form id=@if ($edit == 1)
                    edit_product_form
                @else add_product_form @endif enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card card-outline card-info">

                                @csrf
                                @if ($edit == 1)
                                    @method('put')
                                @else
                                    @method('post')
                                @endif

                                <div class="form-group">
                                    <label for="inputName"> Product Title</label>
                                    <input type="text" name="title" class="form-control" id="edit_product_title">
                                    <span style="color: red" id="title_error"></span>
                                </div>
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Main Components Description
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <textarea id="description" name="description"></textarea>
                                </div>
                            </div>
                            <div class="card p-3 bg-white">
                                <div class="p-3 bg-white">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for=""> Main Components Image English</label>
                                            <input type="file" class="form-control" name="main_components_image_eng">
                                            <span style="color: red" id="main_components_imagee_error_eng"></span>
                                        </div>
                                    </div>
                                </div>
                                @if ($edit == 1)
                                    <div class="p-3 bg-white">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img src="" alt="" id="edit_main_components_image_eng"
                                                    class="img-fluid" width="100">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="p-3 bg-white">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for=""> Main Components Image Chinese</label>
                                            <input type="file" class="form-control" name="main_components_image_chn">
                                            <span style="color: red" id="main_components_imagee_error_chn"></span>
                                        </div>
                                    </div>
                                </div>
                                @if ($edit == 1)
                                    <div class="p-3 bg-white">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img src="" alt="" id="edit_main_components_image_chn"
                                                    class="img-fluid" width="100">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                            <div class="p-3 bg-white">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for=""> Product Image English</label>
                                        <input type="file" class="form-control" name="product_imagee">
                                        <span style="color: red" id="product_imagee_error"></span>
                                    </div>
                                </div>
                            </div>
                            @if ($edit == 1)
                                <div class="p-3 bg-white">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="" alt="" id="edit_product_imagee" class="img-fluid" width="100">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="p-3 bg-white">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for=""> Gallery Image English</label>
                                        <input type="file" class="form-control" name="gallery_imagee[]" multiple>
                                        <span style="color: red" id="gallery_imagee_error"></span>
                                    </div>
                                </div>
                            </div>
                            @if ($edit == 1)
                                <div class="p-3 bg-white">
                                    <div class="row">
                                        <div class="col-md-12" id="edit_gallery_imagee">
                                            <img src="" alt="" class="img-fluid" width="100">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="p-3 mb-3 bg-white">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for=""> Shop Banner English</label>
                                        <input type="file" class="form-control" name="shop_bannere[]" multiple>
                                        <span style="color: red" id="shop_bannere_error"></span>
                                    </div>
                                </div>
                            </div>

                            @if ($edit == 1)
                                <div class="p-3 bg-white">
                                    <div class="row">
                                        <div class="col-md-12" id="edit_shop_bannere">
                                            <img src="" alt="" class="img-fluid" width="100">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="p-3 bg-white">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for=""> Product Image Chinese </label>
                                        <input type="file" class="form-control" name="product_imagec">
                                        <span style="color: red" id="product_imagec_error"></span>
                                    </div>
                                </div>
                            </div>

                            @if ($edit == 1)
                                <div class="p-3 bg-white">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="" alt="" class="img-fluid" width="100" id="edit_product_imagec">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="p-3 bg-white">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for=""> Gallery Image Chinese </label>
                                        <input type="file" class="form-control" name="gallery_imagec[]" multiple>
                                        <span style="color: red" id="gallery_imagec_error"></span>
                                    </div>
                                </div>
                            </div>

                            @if ($edit == 1)
                                <div class="p-3 bg-white">
                                    <div class="row">
                                        <div class="col-md-12" id="edit_gallery_imagec">
                                            <img src="" alt="" class="img-fluid" width="100">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="p-3 mb-3 bg-white">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for=""> Shop Banner Chinese </label>
                                        <input type="file" class="form-control" name="shop_bannerc[]" multiple>
                                        <span style="color: red" id="shop_bannerc_error"></span>
                                    </div>
                                </div>
                            </div>

                            @if ($edit == 1)
                                <div class="p-3 bg-white">
                                    <div class="row">
                                        <div class="col-md-12" id="edit_shop_bannerc">
                                            <img src="" alt="" class="img-fluid" width="100">
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="p-3 mb-3 bg-white">
                                <div class="mt-4 row">
                                    <label for=""> Product Type</label>
                                    <nav class="w-100">
                                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                                            <a class=" nav-link active" id="product-desc-tab" data-toggle="tab"
                                                href="#product-desc" role="tab" aria-controls="product-desc"
                                                aria-selected="true">General</a>
                                            <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab"
                                                href="#product-comments" role="tab" aria-controls="product-comments"
                                                aria-selected="false">Inventory</a>
                                            <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab"
                                                href="#product-rating" role="tab" aria-controls="product-rating"
                                                aria-selected="false">Major Effects</a>
                                            <a class="nav-item nav-link" id="product-Use-Method-tab" data-toggle="tab"
                                                href="#product-Use-Method" role="tab" aria-controls="product-Use-Method"
                                                aria-selected="false">Use Method</a>

                                        </div>
                                    </nav>
                                    <div class="p-3 tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                                            aria-labelledby="product-desc-tab">
                                            <label for="inputName"> Add Pricing</label>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">

                                                        <input type="text" class="form-control"
                                                            placeholder="Regular Price" name="regular_price"
                                                            id="edit_product_regular_price">
                                                        <span style="color: red" id="regular_price_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="Sale Price"
                                                            name="sale_price" id="edit_product_sale_price">
                                                        <span style="color: red" id="sale_price_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="inputName"> Site User Signup Offer</label>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">

                                                        <input type="text" class="form-control" placeholder="Offer Price"
                                                            name="offer_price" id="edit_product_offer_price">
                                                        <span style="color: red" id="offer_price_error"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="product-comments" role="tabpanel"
                                            aria-labelledby="product-comments-tab">
                                            <div class="form-group">
                                                <label for="inputName"> Inventory</label>
                                                <div class="form-group">
                                                    <label for="">Stock</label>
                                                    <select class="form-control custom-select" name="stock"
                                                        id="edit_product_stock">
                                                        <option value="1">In Stock</option>
                                                        <option value="0">Out of stock</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="product-rating" role="tabpanel"
                                            aria-labelledby="product-rating-tab">
                                            <div class="form-group">
                                                <label for="">Effects</label>
                                                <div class="card-body">
                                                    <textarea id="effect" name="features"></textarea>
                                                </div>
                                                <div class="p-3 bg-white">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for=""> Effects Image English </label>
                                                            <input type="file" class="form-control"
                                                                name="effects_image_eng">
                                                            <span style="color: red" id="effects_image_eng_error"></span>
                                                        </div>
                                                    </div>

                                                    @if ($edit == 1)
                                                        <div class="p-3 bg-white">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <img src="" alt="" id="edit_effects_image_eng"
                                                                        class="img-fluid" width="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="p-3 bg-white">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for=""> Effects Image Chinese </label>
                                                            <input type="file" class="form-control"
                                                                name="effects_image_chn">
                                                            <span style="color: red" id="effects_image_chn_error"></span>
                                                        </div>
                                                    </div>

                                                    @if ($edit == 1)
                                                        <div class="p-3 bg-white">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <img src="" alt="" id="edit_effects_image_chn"
                                                                        class="img-fluid" width="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="product-Use-Method" role="tabpanel"
                                            aria-labelledby="product-Use-Method-tab">
                                            <div class="form-group">
                                                <label for="inputName"> Use Method</label>
                                                <div class="card-body">
                                                    <textarea id="use_method" name="use_method"></textarea>
                                                </div>
                                                <div class="p-3 bg-white">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for=""> Method Image English </label>
                                                            <input type="file" class="form-control"
                                                                name="method_image_eng">
                                                            <span style="color: red" id="method_image_eng_error"></span>
                                                        </div>
                                                    </div>

                                                    @if ($edit == 1)
                                                        <div class="p-3 bg-white">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <img src="" alt="" id="edit_method_image_eng"
                                                                        class="img-fluid" width="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="p-3 bg-white">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for=""> Method Image Chinese </label>
                                                            <input type="file" class="form-control"
                                                                name="method_image_chn">
                                                            <span style="color: red" id="method_image_chn_error"></span>
                                                        </div>
                                                    </div>

                                                    @if ($edit == 1)
                                                        <div class="p-3 bg-white">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <img src="" alt="" id="edit_method_image_chn"
                                                                        class="img-fluid" width="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="p-3 mb-3 bg-white">

                                <label for="">Product SEO</label>
                                <div class="form-group">

                                    <input type="text" class="form-control" placeholder="Page Title" name="page_title"
                                        id="edit_product_page_title">

                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" placeholder="Enter Slug, url" name="page_url"
                                        id="edit_product_page_url">

                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" placeholder="Meta Tag Description"
                                        name="meta_description" id="edit_product_meta_description">

                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Meta Tag Keywords"
                                        name="meta_keyword" id="edit_product_meta_keyword">
                                </div>
                            </div>
                            <div class="p-3 mb-3 bg-white">

                                <label for="">Product Video Settings</label>
                                <div class="form-group">
                                    <label for="inputName"> Video Title</label>
                                    <input type="text" class="form-control" placeholder="Video Title" name="video_title"
                                        id="edit_product_video_title">
                                </div>

                                <div class="form-group">
                                    <label for="inputName"> Attach Link</label>
                                    <input type="text" class="form-control" placeholder="paste your url"
                                        name="video_source" id="edit_product_video_source">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-primary card-outline">
                            </div>
                            <div class="card card-primary">
                                <div class="card-body">
                                    <strong><i class="fas fa-box"></i> New Product</strong>
                                    <p class="text-muted">
                                        Add Information And Save All Changes.
                                    </p>
                                    <hr>
                                    <div class="form-group">
                                        <label for="inputName"> Size</label>
                                        <input type="text" class="form-control" placeholder="Enter Size" name="size"
                                            id="edit_product_size">
                                        <span style="color: red" id="size_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName">PV Point</label>
                                        <input type="text" class="form-control" placeholder="Enter Point" name="pv_point"
                                            id="edit_product_pv_point">
                                        <span style="color: red" id="pv_point_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Product Status</label>
                                        <select class="form-control custom-select" name="status" id="edit_product_status">
                                            <option value="1">Enable</option>
                                            <option value="0">Disable</option>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select id="product_category" class="form-control custom-select"
                                            name="category_id">

                                        </select>
                                        <span style="color: red" id="category_id_error"></span>
                                    </div>

                                    <div class="">
                                        @if ($edit == 0)
                                            <button type="
                                        button" class="btn btn-primary" id="add_product_btn">Add
                                        Product</button>
                                    @else
                                        <button type="button" class="btn btn-primary" id="update_product_btn">Update
                                            Product</button>
                                        @endif

                                        <button type="button" class="btn btn-info">cancel</button>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <div id="product_loder" style="display: none">
        @include('admin.loder.index')
    </div>

    @section('javascript')


        <script>
            $(document).ready(function() {
                product_category();
                var edit = "{{ $edit == 1 ? true : false }}";
                if (edit) {
                    get_edit_data_for_Product();
                }
            })

            function product_category() {
                $.ajax({
                    url: "{{ route('admin.product.categoryList') }}",
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        var len = data.length;
                        $('#product_category').empty();
                        for (var i = 0; i < len; i++) {
                            $('#product_category').append("<option value='" + data[i]['id'] + "'>" + data[i].name +
                                "</option>");
                        }
                    }
                })
            }




            $(document).on('click', '#add_product_btn', function(e) {
                e.preventDefault()
                tinyMCE.triggerSave();
                var form = $('#add_product_form')[0];
                var data = new FormData(form);
                $.ajax({
                    type: "post",
                    url: "{{ route('admin.product.store') }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $("#add_product_form :input").prop("disabled", true);
                        $('#product_loder').show();
                    },
                    success: function(data) {
                        $('#add_warehouse_stock').modal('hide');
                        $("#add_product_form :input").prop("disabled", false);
                        $('#product_loder').hide();
                        var m = JSON.parse(data)
                        if (m.status == 'success') {
                            $('#addsubcategory').modal('hide')
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'success',
                                title: m.message
                            })
                            $('#add_product_form')[0].reset();
                        }
                    },
                    error: function(error) {
                        $("#add_product_form :input").prop("disabled", false);
                        $('#product_loder').hide();
                        console.log(error)
                        if (error.status == 422) {
                            var err = error.responseJSON.errors;
                            if (err) {
                                console.log(err.gallery_imagee);
                                $('#title_error').html(err.title)
                                $('#product_imagee_error').html(err.product_imagee)
                                $('#main_components_imagee_error_chn').html(err.main_components_image_chn)
                                $('#main_components_imagee_error_eng').html(err.main_components_image_eng)
                                $('#effects_image_eng_error').html(err.effects_image_eng)
                                $('#effects_image_chn_error').html(err.effects_image_chn)
                                $('#method_image_eng_error').html(err.method_image_eng)
                                $('#method_image_chn_error').html(err.method_image_chn)
                                $('#gallery_imagee_error').html(err.gallery_imagee);
                                $('#shop_bannere_error').html(err.shop_bannere)
                                $('#product_imagec_error').html(err.product_imagec)
                                $('#gallery_imagec_error').html(err.gallery_imagec)
                                $('#shop_bannerc_error').html(err.shop_bannerc)
                                $('#regular_price_error').html(err.regular_price)
                                $('#sale_price_error').html(err.sale_price)
                                $('#offer_price_error').html(err.offer_price)
                                $('#size_error').html(err.size)
                                $('#pv_point_error').html(err.pv_point)
                                $('#category_id_error').html(err.category_id)
                            }
                        }
                    }
                });
            });

            function get_edit_data_for_Product() {
                $.ajax({
                    url: "{{ URL::signedRoute('admin.product.get_edit_data') }}",
                    type: 'post',
                    data: {
                        id: "{{ request()->adminproduct }}",
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#product_loder').show();
                    },
                    success: function(data) {
                        $('#product_loder').hide();
                        console.log(data)
                        var url = "{{ asset('') }}"

                        $('#edit_product_title').val(data.title)
                        if (data.description != null)
                            tinymce.get('description').setContent(data.description)
                        $('#edit_product_imagee').attr('src', url + data.productimagee)


                        if (data.galleryimagee) {
                            var mainData = data.galleryimagee.split(',');
                            var len = mainData.length;

                            for (var i = 0; i < len; i++) {
                                $('#edit_gallery_imagee').append("<img src='" + url + mainData[i] +
                                    "' width='100' class='img-fluid p-2'>")
                            }
                        }
                        if (data.shopbannere) {
                            var mainData = data.shopbannere.split(',');
                            var len = mainData.length;

                            for (var i = 0; i < len; i++) {
                                $('#edit_shop_bannere').append("<img src='" + url + mainData[i] +
                                    "' width='100' class='img-fluid p-2'>")
                            }
                        }

                        $('#edit_product_imagec').attr('src', url + data.productimagec)

                        if (data.galleryimagec) {
                            var mainData = data.galleryimagec.split(',');
                            var len = mainData.length;

                            for (var i = 0; i < len; i++) {
                                $('#edit_gallery_imagec').append("<img src='" + url + mainData[i] +
                                    "' width='100' class='img-fluid p-2'>")
                            }
                        }
                        if (data.shopbannerc) {
                            var mainData = data.shopbannerc.split(',');
                            var len = mainData.length;

                            for (var i = 0; i < len; i++) {
                                $('#edit_shop_bannerc').append("<img src='" + url + mainData[i] +
                                    "' width='100' class='img-fluid p-2'>")
                            }
                        }
                        $('#edit_product_regular_price').val(data.regularprice)
                        $('#edit_product_sale_price').val(data.saleprice)
                        $('#edit_product_offer_price').val(data.offerprice)
                        $('#edit_product_stock').val(data.stock)
                        if (data.features != null)
                            tinymce.get('effect').setContent(data.features)
                        if (data.usemethod != null)
                            tinymce.get('use_method').setContent(data.usemethod)
                        $('#edit_product_page_title').val(data.pagetitle);
                        $('#edit_product_page_url').val(data.pageurl);
                        $('#edit_product_meta_description').val(data.metadescription)
                        $('#edit_product_meta_keyword').val(data.metakeyword)
                        $('#edit_product_video_title').val(data.videotitle);
                        $('#edit_product_video_source').val(data.videosource)
                        $('#edit_product_size').val(data.size);
                        $('#edit_product_pv_point').val(data.pv);
                        $('#edit_product_status').val(data.status);
                        $('#product_category').val(data.category_id);

                        $('#edit_main_components_image_eng').attr('src', url + data.main_components_image_eng);
                        $('#edit_main_components_image_chn').attr('src', url + data.main_components_image_chn);
                        $('#edit_effects_image_eng').attr('src', url + data.effects_image_eng)
                        $('#edit_effects_image_chn').attr('src', url + data.effects_image_chn)
                        $('#edit_method_image_eng').attr('src', url + data.method_image_eng)
                        $('#edit_method_image_chn').attr('src', url + data.effects_image_chn)
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            }


            // edit
            $(document).on('click', '#update_product_btn', function(e) {
                e.preventDefault()
                tinyMCE.triggerSave();
                var form = $('#edit_product_form')[0];
                var data = new FormData(form);
                $.ajax({
                    type: "post",
                    url: "{{ route('admin.products.update', request()->adminproduct ? request()->adminproduct : '') }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $("#edit_product_form :input").prop("disabled", true);
                        $('#product_loder').show();
                    },
                    success: function(data) {
                        console.log(data);
                        $('#add_warehouse_stock').modal('hide');
                        $("#edit_product_form :input").prop("disabled", false);
                        $('#product_loder').hide();
                        var m = JSON.parse(data)
                        if (m.status == 'success') {
                            $('#addsubcategory').modal('hide')
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'success',
                                title: m.message
                            })
                            window.location.href = "{{ url('admin/inventory#product') }}"
                        }
                    },
                    error: function(error) {
                        $("#edit_product_form :input").prop("disabled", false);
                        $('#product_loder').hide();
                        console.log(error)
                        if (error.status == 422) {
                            var err = error.responseJSON.errors;
                            if (err) {
                                console.log(err.gallery_imagee);
                                $('#title_error').html(err.title)
                                $('#product_imagee_error').html(err.product_imagee)
                                $('#main_components_imagee_error_chn').html(err.main_components_image_chn)
                                $('#main_components_imagee_error_eng').html(err.main_components_image_eng)
                                $('#effects_image_eng_error').html(err.effects_image_eng)
                                $('#effects_image_chn_error').html(err.effects_image_chn)
                                $('#method_image_eng_error').html(err.method_image_eng)
                                $('#method_image_chn_error').html(err.method_image_eng)
                                $('#gallery_imagee_error').html(err.gallery_imagee);
                                $('#shop_bannere_error').html(err.shop_bannere)
                                $('#product_imagec_error').html(err.product_imagec)
                                $('#gallery_imagec_error').html(err.gallery_imagec)
                                $('#shop_bannerc_error').html(err.shop_bannerc)
                                $('#regular_price_error').html(err.regular_price)
                                $('#sale_price_error').html(err.sale_price)
                                $('#offer_price_error').html(err.offer_price)
                                $('#size_error').html(err.size)
                                $('#pv_point_error').html(err.pv_point)
                                $('#category_id_error').html(err.category_id)
                            }
                        }
                    }
                });
            });
            // end edit




            $('#add_product_form :input,#update_product_btn :input').click(function() {
                $('#title_error').html('')
                $('#product_imagee_error').html('')
                $('#main_components_imagee_error_chn').html('')
                $('#main_components_imagee_error_eng').html('')
                $('#effects_image_eng_error').html('')
                $('#effects_image_chn_error').html('')
                $('#method_image_eng_error').html('')
                $('#method_image_chn_error').html('')
                $('#gallery_imagee_error').html('');
                $('#shop_bannere_error').html('')
                $('#product_imagec_error').html('')
                $('#gallery_imagec_error').html('')
                $('#shop_bannerc_error').html('')
                $('#regular_price_error').html('')
                $('#sale_price_error').html('')
                $('#offer_price_error').html('')
                $('#size_error').html('')
                $('#pv_point_error').html('')
                $('#category_id_error').html('')
            });



            tinymce.init({
                selector: '#use_method,#effect,#description',
                // plugins: 'image',
                menubar: 'insert',
                file_picker_types: 'image',
                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function() {
                        var file = this.files[0];

                        var reader = new FileReader();
                        reader.onload = function() {

                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);
                            cb(blobInfo.blobUri(), {
                                title: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                },
            });
        </script>
    @endsection


@endsection
