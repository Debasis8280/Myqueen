@extends('font.layouts.main')
@section('content')
    <style>
        .login-popup .tab {
            font-size: 17px;
            color: #ccc;

        }



        .login-bg {
            height: 700px;
        }

        /* .tab-pane {
                                                                                                                                                                                line-height: 1.5rem;
                                                                                                                                                                            } */

    </style>
    <main class="main">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
                    <li><a href="shop.html">Myqueen</a></li>
                    <li>My Account</li>
                </ul>
            </div>
        </nav>
        <div class="page-content mt-6 pb-2 mb-10">
            <div class="container">
                <div class="login-popup login-bg">
                    <div class="form-box">
                        <div class="tab tab-nav-simple tab-nav-boxed form-tab">
                            <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active border-no lh-1 ls-normal" href="#signin">Login</a>
                                </li>
                                <li class="delimiter">or</li>
                                <li class="nav-item">
                                    <a class="nav-link border-no lh-1 ls-normal" href="#register">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="signin">
                                    <form id="login_user_form">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" id="singin-email" name="email"
                                                placeholder="Username or Email Address *" value="{{ old('email') }}" />
                                            <span style="color: red" id="login_email_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="singin-password"
                                                name="password" placeholder="Password *" />
                                            <span style="color: red" id="login_password_error"></span>
                                        </div>
                                        <div class="form-footer">
                                            <div class="form-checkbox">
                                                <input type="checkbox" class="custom-checkbox" id="signin-remember"
                                                    name="signin-remember" />
                                                <label class="form-control-label" for="signin-remember">Remember
                                                    me</label>
                                            </div>
                                            <a href="#" class="lost-link">Lost your password?</a>
                                        </div>
                                        <button class="btn btn-dark btn-block btn-rounded" type="submit" id="login_btn">
                                            <i class="loading-icon fa fa-spinner fa-spin" id="login_spin"
                                                style="display: none">
                                            </i>
                                            Login
                                        </button>
                                    </form>
                                    <div class="form-choice text-center">
                                        <label class="ls-m">or Login With</label>
                                        <div class="social-links">
                                            <a href="#" class="social-link social-google fab fa-google border-no"></a>
                                            <a href="#" class="social-link social-facebook fab fa-facebook-f border-no"></a>
                                            <a href="#" class="social-link social-twitter fab fa-twitter border-no"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="register">
                                    <form id="register_user_form">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="first_name" name="name"
                                                placeholder="Your Name *" value="{{ old('name') }}" />
                                            <span style="color: red" id="register_name_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="register-email" name="email"
                                                placeholder="Your Email address *" value="{{ old('email') }}" />
                                            <span style="color: red" id="register_email_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="register-password"
                                                name="password" placeholder="Password *" />
                                            <span style="color: red" id="register_password_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="tel" class="form-control col-md-12" id="phone" name="phone"
                                                placeholder="Phone *" style="padding-left: 50px;" />
                                            <input type="hidden" class="form-control" id="country_code" name="code" />
                                            <span style="color: red" id="register_phone_error"></span>
                                            <span style="color: red" id="register_code_error"></span>
                                        </div>
                                        <div class="form-footer">
                                            <div class="form-checkbox">
                                                <input type="checkbox" class="custom-checkbox" id="register-agree"
                                                    name="policy" />

                                                <label class="form-control-label" for="register-agree">I agree to the
                                                    privacy policy</label>
                                            </div>
                                        </div>
                                        <span style="color: red" id="register_policy_error"></span>
                                        <button class="btn btn-dark btn-block btn-rounded" type="submit" id="register_btn">
                                            <i class="loading-icon fa fa-spinner fa-spin" id="register_spin"
                                                style="display: none">
                                            </i>
                                            Register
                                        </button>
                                    </form>
                                    <div class="form-choice text-center">
                                        <label class="ls-m">or Register With</label>
                                        <div class="social-links">
                                            <a href="#" class="social-link social-google fab fa-google border-no"></a>
                                            <a href="#" class="social-link social-facebook fab fa-facebook-f border-no"></a>
                                            <a href="#" class="social-link social-twitter fab fa-twitter border-no"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <link rel="stylesheet" href="{{ asset('asset/countryCode/intlTelInput.css') }}">

@section('javascript')
    <script type="text/javascript" src="{{ asset('asset/countryCode/intlTelInput.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('body').addClass('mainloaded')
            }, [1000])
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
        $('#phone').intlTelInput({
            // allowDropdown: false,
            // autoHideDialCode: false,
            // autoPlaceholder: "off",
            // dropdownContainer: document.body,
            // excludeCountries: ["us"],
            // formatOnDisplay: false,
            // geoIpLookup: function(callback) {
            //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            //     var countryCode = (resp && resp.country) ? resp.country : "";
            //     callback(countryCode);
            //   });
            // },
            // hiddenInput: "full_number",
            initialCountry: "SG",
            // localizedCountries: { 'de': 'Deutschland' },
            // nationalMode: false,
            // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            // placeholderNumberType: "MOBILE",
            // preferredCountries: ['cn', 'jp'],
            // separateDialCode: true,
            // utilsScript: "{{ asset('asset/countryCode/utils.js') }}",
        });

        $('#register_btn').on('click', function() {
            var code = $("#phone").intlTelInput("getSelectedCountryData").dialCode;
            $('#country_code').val(code);
            // var phoneNumber = $('#phone').val();
            // var name = $("#phone").intlTelInput("getSelectedCountryData").name;
        });


        $('#login_btn').click(function(e) {
            e.preventDefault();
            var form = $('#login_user_form')[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{ URL::signedRoute('login') }}",
                type: 'post',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#login_spin').show()
                },
                success: function(data) {
                    console.log(data)
                    if (data.status == 'success') {
                        toastr.options = {
                            "closeButton": true,
                            "newestOnTop": true,
                            "positionClass": "toast-top-right"
                        };
                        toastr.success(data.message);
                        setTimeout(() => {
                            window.location.href = '/';
                        }, [1000])
                    }
                    $('#login_spin').hide()
                },
                error: function(error) {
                    $('#login_spin').hide()
                    console.log(error)
                    if (error.status == 422) {
                        var err = error.responseJSON.errors;
                        $('#login_email_error').html(err.email);
                        $('#login_password_error').html(err.password);
                    }
                }
            })
        });


        $('#register_btn').click(function(e) {
            e.preventDefault();
            var form = $('#register_user_form')[0];
            var data = new FormData(form);
            $.ajax({
                url: "{{ URL::signedRoute('register') }}",
                type: 'post',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#register_spin').show()
                },
                success: function(data) {
                    console.log(data)
                    if (data.status == 'success') {
                        toastr.options = {
                            "closeButton": true,
                            "newestOnTop": true,
                            "positionClass": "toast-top-right"
                        };
                        toastr.success(data.message);
                        setTimeout(() => {
                            window.location.href = '/';
                        }, [1000])
                    }
                    $('#register_spin').hide()
                },
                error: function(error) {
                    $('#register_spin').hide()
                    console.log(error)
                    if (error.status == 422) {
                        var err = error.responseJSON.errors;
                        $('#register_name_error').html(err.name);
                        $('#register_email_error').html(err.email);
                        $('#register_password_error').html(err.password);
                        $('#register_phone_error').html(err.phone);
                        $('#register_code_error').html(err.code);
                        $('#register_policy_error').html(err.policy);
                    }
                }
            })
        })

        $('#register_user_form :input').click(function() {
            $('#register_name_error').html('');
            $('#register_email_error').html('');
            $('#register_password_error').html('');
            $('#register_phone_error').html('');
            $('#register_code_error').html('');
            $('#register_policy_error').html('');
        });
    </script>
@endsection
@endsection
