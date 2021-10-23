<script>
    $(document).ready(function() {
        get_product_details()
        get_product_rating()
    });

    $(function() {

        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');

        $('.nav-tabs a').click(function(e) {
            $(this).tab('show');
            if (history.pushState) {
                history.pushState(null, null, this.hash);
            } else {
                location.hash = this.hash;
            }
        });
    });

    function get_product_details() {
        $.ajax({
            url: "{{ URL::signedRoute('user.product_details.create') }}",
            data: {
                'id': "{{ request()->id }}",
                "_token": "{{ csrf_token() }}"
            },
            type: 'post',
            dataType: 'json',
            cache: false,
            success: function(data) {
                console.log(data);
                var url = "{{ asset('') }}";
                if (data.gallery_image) {
                    var mainData = data.gallery_image.split(',');
                    var len = mainData.length;
                    $('#details_product_name').html(data.title)
                    $('#details_product_price').html('$' + data.saleprice)
                    $('#main_desc').html(data.description)
                    if (data.maindesc)
                        $('#main_desc_img').attr('src', url + data.maindesc)

                    $('#details_effect').html(data.effect);
                    if (data.effect_img)
                        $('#details_effect_img').attr('src', url + data.effect_img)
                    $('#details_use_method').html(data.use_method)

                    if (data.method_img)
                        $('#details_use_method_img').attr('src', url + data.method_img)
                    for (var i = 0; i < len; i++) {
                        $('#product_image').append('<figure class="product-image">' +
                            '<img src="' + url + mainData[i] + '"' +
                            'alt="MQ Freckles Essence">' +
                            '</figure>')

                        $('#product_thumbs').append('<div class="product-thumb active">' +
                            '<img src="' + url + mainData[i] + '"' +
                            'alt="MQ Freckles Essence" width="109" height="122">' +
                            '</div>')
                    }
                }
                // $('#product_image').trigger('destroy.owl.carousel');
                $('body').addClass('mainloaded')
            }
        })
    }


    function reviewPoint(id) {
        $('#reviewValue').val(id);
        $("#rs a").on('click', function() {
            $(this).siblings().removeClass('active');
            $(this).addClass('active')
        })
    }

    $('#rating_btn').click(function(e) {
        e.preventDefault();
        var form = $('#rating_form')[0];
        var data = new FormData(form);

        $.ajax({
            url: "{{ URL::signedRoute('users.product_details.rating.store') }}",
            type: 'post',
            data: data,
            dataType: 'json',
            processData: false,
            cache: false,
            contentType: false,
            beforeSend: function() {
                $('#rating_spin').show();
                $('#rating_spin').prop('disabled', true);
            },
            success: function(data) {
                if (data.status == 'success') {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right"
                    };
                    toastr.success(data.message);
                    get_product_rating();
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right"
                    };
                    toastr.warning(data.message);
                }
                $('#rating_spin').hide();
                $('#rating_spin').prop('disabled', false);
                $('#rating_form')[0].reset();
            },
            error: function(error) {
                console.log(error)
                $('#rating_spin').hide();
                $('#rating_spin').prop('disabled', false);
                if (error.status == 401) {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right"
                    };
                    toastr.error("Please Login!");
                }
                if (error.status == 422) {
                    var err = error.responseJSON.errors;
                    $('#rating_message_error').html(err.message)
                    if (err.product_id) {
                        toastr.options = {
                            "closeButton": true,
                            "newestOnTop": true,
                            "positionClass": "toast-top-right"
                        };
                        toastr.error(err.product_id);
                    }
                }
            }
        })
    })

    $('#rating_form :input').click(function() {
        $('#rating_message_error').html('')
    });


    function get_product_rating() {
        $.ajax({
            url: "{{ route('users.product_details.show_product_rating') }}",
            type: 'get',
            data: {
                product_id: "{{ request()->id }}",
            },
            dataType: 'json',
            success: function(data) {
                var len = data.length;
                var url = "{{ asset('') }}"
                $('#rating_count').html('(' + len + ' Reviews)')
                for (var i = 0; i < len; i++) {

                    var star = data[i]['rating'];
                    var calstar = 20 * parseInt(star);
                    var img = "{{ asset('asset/image/icon/user.png') }}"
                    $('#show_rating_list').append(' <li>' +
                        '<div class="comment">' +
                        '<figure class="comment-media">' +
                        '<a href="#">' +
                        '<img src="' + img + '" alt="avatar">' +
                        '</a>' +
                        '</figure>' +
                        '<div class="comment-body">' +
                        '<div class="comment-rating ratings-container mb-0">' +
                        '<div class="ratings-full">' +
                        ' <span class="ratings" style="width:' + calstar + '%"></span>' +
                        ' <span class="tooltiptext tooltip-top">4.00</span>' +
                        ' </div>' +
                        '</div>' +
                        '<div class="comment-user">' +
                        '<span class="comment-date text-body">' + Date(data[i]['date']) +
                        '</span>' +
                        '<h4><a href="#">' + data[i]['name'] + '</a></h4>' +
                        '</div>' +

                        '<div class="comment-content">' +
                        '<p>' + data[i]['message'] + '</p>' +
                        '</div>' +
                        '</div>' +
                        ' </div>' +
                        '</li>')
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }


    function add_to_cart() {
        $.ajax({
            url: "{{ URL::signedRoute('users.cart.store') }}",
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                product_id: "{{ request()->id }}",
                quentity: $('#quentity').val()
            },
            dataType: 'json',
            cache: false,
            beforeSend: function() {
                $('#add_cart_spin').show()
            },
            success: function(data) {
                if (data.status == 'success') {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right"
                    };
                    toastr.success(data.message);
                }
                $('#add_cart_spin').hide()
                calculate_cart()
            },
            error: function(error) {
                $('#add_cart_spin').hide()
                console.log(error)
            }
        })
    }
</script>
