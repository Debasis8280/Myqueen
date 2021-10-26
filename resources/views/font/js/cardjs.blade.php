<script>
    $(document).ready(function() {
        get_cart_item();
        get_all_country();
    });

    function get_cart_item() {
        $.ajax({
            url: "{{ URL::signedRoute('users.cart.create') }}",
            type: 'get',
            dataType: 'json',
            success: function(data) {
                console.log(data)
                var len = data.length
                var url = "{{ asset('') }}"
                $('#cart_product_list').empty();
                var total_cart_amount = 0;
                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        total_cart_amount = total_cart_amount + (data[i]['quentity'] * data[i][
                            'saleprice'
                        ]);

                        $('#cart_product_list').append(' <div class="card mycard">' +
                            '<div class="card-body p-4">' +
                            '<div class="row">' +
                            '<div class="item-img col-md-4">' +
                            '<a href="app-ecommerce-details.html">' +
                            '<img src="' + url + data[i]['image'] + '"' +
                            'alt="img-placeholder" style="width: 200px; height: 100%;">' +
                            '</a>' +
                            '</div>' +
                            '<div class="col-md-5">' +
                            '<div class="row">' +
                            '<div class="col-md-6 mt-9">' +
                            '<div class="item-name">' +
                            '<h6 class="mb-0"><a href="app-ecommerce-details.html" class="text-body" style="display: inline-block;">' +
                            '' + data[i]['title'] + '</a></h6>' +
                            '</div>' +

                            ' <div class="ratings-container">' +
                            '<div class="ratings-full">' +
                            '<span class="ratings" style="width:80%"></span>' +
                            '<span class="tooltiptext tooltip-top"></span>' +
                            '</div>' +
                            '<a href="#review" class="link-to-tab rating-reviews" id="rating_count"></a>' +
                            '</div>' +
                            '</div>' +

                            '<div class="col-md-6 mt-9">' +
                            '<div class="item-quantity">' +
                            '<span class="quantity-title">Qty:</span>' +
                            '<input id="demo1" type="text" value="' + data[i]['quentity'] +
                            '" name="quentity" class="cart_quentity" data-product-id="' + data[i][
                                'product_id'
                            ] +
                            '" data-cart-id="' + data[i]['cart_id'] + '">' +
                            '</div>' +

                            '</div>' +
                            '</div>' +
                            '</div>' +

                            '<div class="item-options text-center col-md-3 ">' +
                            '<div class="item-wrapper">' +
                            '<button style="padding: 10px 15px;" type="button" class=" btn btn-primary float-right" onclick="remove_from_cart(' +
                            data[i]['product_id'] + ',' + data[i]['cart_id'] + ')">' +
                            '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"' +
                            'fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"' +
                            'stroke-linejoin="round" class="feather feather-x align-middle me-25">' +
                            '<line x1="18" y1="6" x2="6" y2="18"></line>' +
                            '<line x1="6" y1="6" x2="18" y2="18"></line>' +
                            '</svg>' +
                            '<span>Remove</span>' +
                            '</button>' +
                            '<div class="item-cost">' +
                            '<h4 class="item-price">$' + data[i]['quentity'] * data[i]['saleprice'] +
                            '</h4>' +
                            '</div>' +
                            '</div>' +

                            '</div>' +

                            '</div>' +

                            '</div>' +
                            '</div>')
                    }
                    $("input[name='quentity']").TouchSpin({
                        min: 1,
                        max: 100,
                        step: 1,
                    });
                    $("input[name='quentity']").on('change', function() {
                        var quentity = $(this).val()
                        var product_id = $(this).data("product-id")
                        var cart_id = $(this).data("cart-id")
                        update_cart(quentity, product_id, cart_id)
                    });

                    $('.total_cart_amount').html("$" + total_cart_amount);
                    $('#place_order_btn').prop('disabled', false)
                } else {
                    var redirect = "{{ URL::signedRoute('users.view_product_list') }}"
                    $('#cart_product_list').append(' <div class="card mycard">' +
                        '<div class="card-body p-4">' +
                        'Your cart is empty!' +
                        'Add items to it now.' +
                        '<a href="' + redirect +
                        '" class="btn btn-primary" style="padding: 12px;">Shop Now</a>' +
                        '</div></div>');

                    $('.total_cart_amount').html('$' + total_cart_amount);
                    $('#place_order_btn').prop('disabled', true)
                }
            }

        })
    }


    function remove_from_cart(product_id, cart_id) {
        $.ajax({
            url: "{{ URL::signedRoute('users.delete.cart') }}",
            type: 'post',
            dataType: 'json',
            data: {
                product_id: product_id,
                cart_id: cart_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.status == 'success') {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-bottom-center",
                    };
                    toastr.success(data.message);
                    get_cart_item();
                }
            },
            error: function(error) {
                console.log(error)
                if (error.status == 422) {
                    var err = error.responseJSON.errors;
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-bottom-center",
                    };
                    if (err.product_id)
                        toastr.error(err.product_id);
                    if (err.cart_id)
                        toastr.error(err.cart_id);
                }
            }
        })
    }



    function update_cart(quentity, product_id, cart_id) {
        $.ajax({
            url: "{{ URL::signedRoute('users.update.cart') }}",
            type: 'post',
            data: {
                product_id: product_id,
                cart_id: cart_id,
                quentity: quentity,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            cache: false,
            success: function(data) {
                console.log(data);
                if (data.status == 'success') {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-bottom-center",
                    };
                    toastr.success(data.message);
                    get_cart_item();
                }
            },
            error: function(error) {
                console.log(error)
            }
        })
    }

    $(document).ready(function() {
        setTimeout(() => {
            $('body').addClass('mainloaded')
        }, [1000])
        get_address();

    });

    var stepperWizard = new Stepper($(".bs-stepper")[0], {
        // linear: false,
        // animation: true
    });

    $(".btnNext").click(function() {
        validate_form();
    });

    $(".btnPrevious").click(function() {
        stepperWizard.previous();
    });
    $('#ship_same_with_bill').click(function() {
        if ($('#ship_same_with_bill').prop('checked') == true) {
            $('#ship_details').hide()
            $('#billing_details').addClass('col-md-12')
            $('#billing_details').css('border-right', '')
        } else {
            $('#ship_details').show()
            $('#billing_details').removeClass('col-md-12')
            $('#billing_details').css('border-right', '1px solid black')
        }
    })

    $('#home_delivery_option').click(function() {
        // $('#home_delivery_select').val(1);
        // $('#self_pickup_select').val(0)
        // $('#address_btn').prop('disabled', false)
        $('#self_pickup_select').val(0)
        $('#address_btn').prop('disabled', false)
        if ($('#home_delivery_select').val() == 1) {
            $('#home_delivery_select').val(0)
        } else {
            $('#home_delivery_select').val(1)
        }

    });

    $('#self_pickup_option').click(function() {
        // $('#home_delivery_select').val(0);
        // $('#self_pickup_select').val(1)
        $('#home_delivery_select').val(0);
        $('#address_btn').prop('disabled', false)
        if ($('#self_pickup_select').val() == 1) {
            $('#self_pickup_select').val(0)
        } else {
            $('#self_pickup_select').val(1)
        }

    })


    function get_address() {
        $.ajax({
            url: "{{ URL::signedRoute('users.address.create') }}",
            type: 'get',
            dataType: 'json',
            success: function(data) {
                console.log(data)
                var bill_len = data.bill.length
                if (bill_len > 0) {
                    for (var i = 0; i < bill_len; i++) {
                        console.log(data.bill[i]['country'])
                        $('#firstname').val(data.bill[i]['first_name'])
                        $('#lastname').val(data.bill[i]['lastname'])
                        $('#select_country_for_de').val(data.bill[i]['country']).change()
                        $('#address').val(data.bill[i]['address'])
                        $('#city').val(data.bill[i]['city'])
                        $('#state').val(data.bill[i]['state'])
                        $('#zip').val(data.bill[i]['zip'])
                        $('#phone').val(data.bill[i]['Phone'])
                    }
                }

                var ship_len = data.ship.length
                if (ship_len > 0) {
                    for (var i = 0; i < ship_len; i++) {
                        $('#first_name_ship').val(data.ship[i]['first_name'])
                        $('#last_name_ship').val(data.ship[i]['lastname'])
                        $('#country_ship').val(data.ship[i]['country'])
                        $('#city_ship').val(data.ship[i]['city'])
                        $('#state_ship').val(data.ship[i]['state'])
                        $('#address_ship').val(data.ship[i]['address'])
                        $('#zip_ship').val(data.ship[i]['zip'])
                        $('#phone_ship').val(data.ship[i]['Phone'])
                    }
                }

                var slef_pick_len = data.slef_pick.length
                if (slef_pick_len > 0) {
                    for (var i = 0; i < slef_pick_len; i++) {
                        $('#country_self').val(data.slef_pick[i]['country'])
                        $('#state_self').val(data.slef_pick[i]['state'])
                        $('#zip_self').val(data.slef_pick[i]['zip'])
                    }
                }

            },
            error: function(error) {
                console.log(error)
            }
        })
    }



    $('#mct_pay').click(function() {
        $('#offline_pay').prop('checked', false);
        $('#offline_pay_option').hide();
        $('#mct_pay_option').show();

        if ($('#mct_pay').prop('checked') == true) {
            $('#mct_pay_option').show();
            $('#mct_pay').prop('checked', true)
            $('#payment_method').val('MCT Pay');

            get_mct_pay_qr_code()

        } else {
            $('#mct_pay_option').hide();
            $('#mct_pay').prop('checked', false)
        }
    })

    function get_mct_pay_qr_code() {
        $.ajax({
            url: "{{ URL::signedRoute('users.payment_option.store') }}",
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                country: $('#select_country_for_de').val(),
                coupon: $('#apply_coupon').val(),
                home_delivery_select: $('#home_delivery_select').val()
            },
            beforeSend: function() {
                $('#cart_page_loading').show()
            },
            success: function(data) {
                $('#mct_pay_qrcode_image').attr('src', data.qr_pic_url);
                $('#cart_page_loading').hide()
            }
        })
    }


    $('#offline_pay').click(function() {
        $('#mct_pay').prop('checked', false);
        $('#mct_pay_option').hide();

        if ($('#offline_pay').prop('checked') == true) {
            $('#offline_pay_option').show();
            $('#offline_pay').prop('checked', true)
            $('#payment_method').val('Offline Pay')
        } else {
            $('#offline_pay_option').hide();
            $('#offline_pay').prop('checked', false)
        }

    })


    function validate_form() {
        var form = $('#main_order_form')[0];
        var data = new FormData(form);
        $.ajax({
            url: "{{ URL::signedRoute('users.order.validate_form') }}",
            type: 'post',
            dataType: 'json',
            cache: false,
            data: data,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#cart_page_loading').show()
            },
            success: function(data) {
                $('#cart_page_loading').hide()
                if (data.status == 'success') {
                    stepperWizard.next();
                }
            },
            error: function(error) {
                $('#cart_page_loading').hide()
                console.log(error)
                if (error.status == 422) {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right",
                    };
                    var err = error.responseJSON.errors
                    if (err.select_one) {
                        toastr.error(err.select_one);
                    }
                    if (err.address_part)
                        toastr.error(err.address_part)

                    $('#firstname_error').html(err.firstname)
                    $('#lastname_error').html(err.lastname)
                    $('#country_error').html(err.country)
                    $('#address_error').html(err.addredd)
                    $('#city_error').html(err.city)
                    $('#state_error').html(err.state)
                    $('#zip_error').html(err.zip)
                    $('#phone_error').html(err.phone)

                    $('#first_name_ship_error').html(err.first_name_ship);
                    $('#last_name_ship_error').html(err.last_name_ship);
                    $('#country_ship_error').html(err.country_ship);
                    $('#address_ship_error').html(err.address_ship);
                    $('#city_ship_error').html(err.city_ship);
                    $('#state_ship_error').html(err.state_ship);
                    $('#zip_ship_error').html(err.zip_ship);
                    $('#phone_ship_error').html(err.phone_ship);

                    $('#country_self_error').html(err.country_self)
                    $('#state_self_error').html(err.state_self)
                    $('#zip_self_error').html(err.zip_self)


                }
            }
        })
    }

    $('#main_order_form :input').click(function() {
        $('#firstname_error').html('')
        $('#lastname_error').html('')
        $('#country_error').html('')
        $('#address_error').html('')
        $('#city_error').html('')
        $('#state_error').html('')
        $('#zip_error').html('')
        $('#phone_error').html('')

        $('#first_name_ship_error').html('');
        $('#last_name_ship_error').html('');
        $('#country_ship_error').html('');
        $('#address_ship_error').html('');
        $('#city_ship_error').html('');
        $('#state_ship_error').html('');
        $('#zip_ship_error').html('');
        $('#phone_ship_error').html('');

        $('#country_self_error').html('')
        $('#state_self_error').html('')
        $('#zip_self_error').html('')
    });

    $('#place_order_btn').click(function() {
        $('#cart_part').val(1);
        $('#address_part').val(2)
    })

    $('#address_previous_btn').click(function() {
        $('#address_part').val("")
    })
    $('#address_btn').click(function() {
        check_delivery_charge()
    })

    $('#payment_option_previous').click(function() {
        // $('#main_discount_div').hide();
        // $('#apply_coupon').val('')

        // get_mct_pay_qr_code();
    })


    $('#apply_coupon_btn').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ URL::signedRoute('users.coupon.store') }}",
            type: 'post',
            data: {
                coupon: $('#apply_coupon').val(),
                _token: "{{ csrf_token() }}",
                country: $('#select_country_for_de').val(),
                home_delivery_select: $('#home_delivery_select').val()
            },
            dataType: 'json',
            beforeSend: function() {
                $('#cart_page_loading').show()
            },
            success: function(data) {
                if (data.status == 'success') {
                    $('#main_discount_div').show();
                    $('.total_cart_amount').html('$' + data.after_discount_amount)
                    $('#discount_amount').html(data.discount_amount + " " + data.type)
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right",
                    };
                    toastr.success("You Get " + data.discount_amount + " " + data.type +
                        " Discount");
                    get_mct_pay_qr_code()

                } else {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right",
                    };
                    toastr.error(data.message)

                }
                $('#cart_page_loading').hide()
            },
            error: function(error) {
                $('#cart_page_loading').hide()
                console.log(error);
                if (error.status == 422) {
                    var err = error.responseJSON.errors
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-bottom-center",
                    };
                    toastr.error(err.coupon);
                }
            }
        })
    });


    function check_delivery_charge() {
        country = $('#ship_same_with_bill').prop('checked') == false ? $('#country_ship').val() : $(
            '#select_country_for_de').val()
        $.ajax({
            url: "{{ URL::signedRoute('users.delivery_charge.store') }}",
            type: 'post',
            data: {
                home_delivery_select: $('#home_delivery_select').val(),
                _token: "{{ csrf_token() }}",
                country: country,
                coupon: $('#apply_coupon').val(),
            },
            dataType: 'json',
            beforeSend: function() {
                $('#cart_page_loading').show()
            },
            success: function(data) {
                if (data.status == 'success') {
                    if (data.delivery_charge > 0) {
                        $('#delivery_charge_show').html("$" + data.delivery_charge)
                        $('#delivery_charge_show').removeClass('text-success')
                        $('.total_cart_amount').html("$" + data.total)
                        $('#total_cart_amount_product').html('$' + (data.order_sum))
                    } else {
                        $('#delivery_charge_show').html('Free')
                        $('#delivery_charge_show').addClass('text-success')
                        $('.total_cart_amount').html("$" + data.total)
                        $('#total_cart_amount_product').html('$' + data.order_sum)
                    }
                }
                $('#cart_page_loading').hide()
            },
            error: function(error) {
                $('#cart_page_loading').hide()
                console.log(error)
            }
        })
    }


    function get_all_country() {
        $.ajax({
            url: "{{ route('get_all_country') }}",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('#cart_page_loading').show()
            },
            success: function(data) {
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    ''
                    $(".allcountry").append("<option value='" + data[i] + "'>" + data[i] +
                        "</option>");
                }
                $('#cart_page_loading').hide()
            }
        })
    }

    $('#complete_form_submit_btn').click(function(e) {
        e.preventDefault();
        var form = $('#main_order_form')[0];
        var data = new FormData(form);

        $.ajax({
            url: "{{ URL::signedRoute('users.order.store') }}",
            type: 'post',
            data: data,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#cart_page_loading').show()
            },
            success: function(data) {
                if (data.status == 'success') {
                    $('#cart_page_loading').hide()
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right",
                    };
                    toastr.success(data.message);
                    setTimeout(() => {
                        redirect_thanks_page(data.order_id)
                    }, 1000)
                }
            },
            error: function(error) {
                $('#cart_page_loading').hide()
                console.log(error)
                if (error.status == 422) {
                    var err = error.responseJSON.errors;
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right",
                    };

                    if (err.select_one_payment)
                        toastr.error(err.select_one_payment);
                    if (err.offline_pay_screen_shot)
                        toastr.error(err.offline_pay_screen_shot);
                }
            }
        })
    });

    function redirect_thanks_page(id) {
        $.ajax({
            url: "{{ URL::signedRoute('users.thank.index') }}",
            type: 'get',
            data: {
                id: id
            },
            dataType: 'json',
            beforeSend: function() {
                $('#cart_page_loading').show()
            },
            success: function(data) {
                if (data.status == 'success') {
                    $('#cart_page_loading').hide()
                    window.location.href = data.url
                }
            }
        })
    }
</script>
