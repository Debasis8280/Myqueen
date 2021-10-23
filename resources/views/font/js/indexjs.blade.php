<script>
    $(document).ready(function() {
        get_banner();

        $('#welcome_products').trigger('destroy.owl.carousel');
        $("#welcome_products").owlCarousel({
            items: 4,
            nav: false,
            dots: false,
            margin: 20,
            loop: false,
            responsive: {
                0: {
                    items: 2
                },
                768: {
                    items: 3
                },
                992: {
                    items: 5
                }
            }
        });
    });

    function get_banner() {
        $.ajax({
            url: "{{ route('users.index.item') }}",
            type: 'get',
            dataType: 'json',
            cache: false,
            success: function(data) {
                var banner_len = data.banner.length;
                var url = "{{ asset('') }}"
                $("#welcome_banner").owlCarousel({
                    dots: false,
                    items: 1,
                    loop: true,
                    nav: true,
                    navText: ["<i class='fa fa-chevron-left'></i>",
                        "<i class='fa fa-chevron-right'></i>"
                    ],
                    autoplay: true,
                    autoplayTimeout: 8000,
                    autoWidth: false,
                    responsive: {
                        640: {
                            items: 1,
                        }
                    }
                });

                for (var i = 0; i < banner_len; i++) {
                    $('#welcome_banner').append(
                        ' <div class="intro-slide1 banner banner-fixed" style="background-color: #f6f6f6;">' +
                        '<figure>' +
                        '<img src="' + url + data.banner[i]['image'] +
                        '" alt="intro-banner" width="500" height="500"' +
                        'style="background-color: #f6f6f6;" />' +
                        '</figure>' +
                        '</div>')
                }
                $('#welcome_banner').trigger('destroy.owl.carousel');
                $("#welcome_banner").owlCarousel({
                    dots: false,
                    items: 1,
                    loop: false,
                    nav: true,
                    navText: ["<i class='fa fa-chevron-left'></i>",
                        "<i class='fa fa-chevron-right'></i>"
                    ],
                    autoplay: true,
                    autoplayTimeout: 8000,
                    autoWidth: false,
                    responsive: {
                        640: {
                            items: 1,
                        }
                    }

                });



                var product_len = data.product.length;
                for (var i = 0; i < product_len; i++) {

                    var active_color = data.product[i]['active'] == data.product[i]['id'] ?
                        "style=color:red" : '';

                    $('#welcome_products').append('<div class="product text-center"> ' +
                        '<figure class="product-media">' +
                        '<a href="#!" onclick=redirect_to_details(' + data.product[i]['id'] + ')>' +
                        '<img src="' + url + data.product[i]['image'] +
                        '" alt="product" width="300"' +
                        'height="338" style="width: fit-content;height: 250px; object-fit: cover;">' +
                        '</a>' +
                        '<div class="product-label-group">' +
                        '<span class="product-label label-sale">27% off</span>' +
                        '</div>' +
                        '<div class="product-action-vertical">' +
                        '<a href="#!" class="btn-product-icon btn-cart" title="Cart">' +
                        '<i class="d-icon-bag"></i>' +
                        '</a>' +
                        '<a href="#!" class=" btn-product-icon btn-wishlist" title="Add to wishlist" onclick="add_to_wishlist(' +
                        data.product[i]['id'] + ')" id="wish_hart' + data.product[i]['id'] +
                        '" ' + active_color + '>' +
                        '<i class="fas fa-heart"></i></a>' +
                        '</div>' +
                        '<div class="product-action" onclick="redirect_to_details(' + data.product[i][
                            'id'
                        ] +
                        ')">' +
                        '<a href="#!"  class="btn-product btn-quickview" title="Quick View">Quick' +
                        'View</a>' +
                        '</div>' +
                        '</figure>' +
                        '<div class="product-details">' +
                        '<h3 class="product-name">' +
                        '<a href="product-details.html">' + data.product[i]['title'] + '</a>' +
                        '</h3>' +
                        '<div class="product-price">' +
                        '<ins class="new-price">$' + data.product[i]['saleprice'] +
                        ' (' + data.product[i]['size'] + ')</ins> <br>' +
                        // '<ins class="new-price">$166 (Retail Price)</ins>' +
                        '</div>' +
                        '<div class="ratings-container">' +
                        '<div class="ratings-full">' +
                        '<span class="ratings" style="width:70%"></span>' +
                        '<span class="tooltiptext tooltip-top"></span>' +
                        '</div>' +
                        '<a href="#" class="rating-reviews">( 3 reviews )</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>')


                }

                $('#welcome_products').trigger('destroy.owl.carousel');
                $("#welcome_products").owlCarousel({
                    items: 4,
                    nav: false,
                    dots: false,
                    margin: 20,
                    loop: false,
                    responsive: {
                        0: {
                            items: 2
                        },
                        768: {
                            items: 3
                        },
                        992: {
                            items: 5
                        }
                    }
                });


                $('body').addClass('mainloaded')

            },
            error: function(error) {
                console.log(error)
            }
        });
    }



    function redirect_to_details(id) {
        $.ajax({
            url: "{{ route('user.product_details.index') }}",
            type: 'get',
            data: {
                id: id
            },
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                $('#product_click_loder').show();
            },
            success: function(data) {
                $('#product_click_loder').show();
                window.location.href = data
            }
        })
    }

    function add_to_wishlist(id) {
        $.ajax({
            url: "{{ URL::signedRoute('users.wishlist.store') }}",
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                product_id: id
            },
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if (data.status == 'success') {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-bottom-center"
                    };
                    toastr.success(data.message);

                    $('#wish_hart' + id).css('color', data.color);
                }
            },
            error: function(errror) {
                console.log(error)
            }
        })
    }
</script>
