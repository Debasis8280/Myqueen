@extends('font.layouts.main')

@section('content')
    <main class="main">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('users.index') }}"><i class="d-icon-home"></i></a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </nav>
        <img src="{{ asset('asset/image/font/Contact-us-us-.jpg') }}" alt="" class="img-fluid" style="width:100%" />
        <div class="mt-10 page-content pt-7">
            <section class="contact-section">
                <div class="container">
                    <div class="row">
                        <div class="mb-4 col-lg-3 col-md-4 col-sm-6 ls-m">
                            <div class="grey-section d-flex align-items-center h-100">
                                <div>
                                    <h4 class="mb-2 text-capitalize">Address</h4>
                                    <p>114 Lavender Street #11-83 CT Hub 2 Singapore 338729
                                    </p>

                                    <h4 class="mb-2 text-capitalize">Phone Number</h4>
                                    <p>
                                        <a href="tel:#">+65 67219257
                                        </a>

                                    </p>

                                    <h4 class="mb-2 text-capitalize">Support</h4>
                                    <p class="mb-4">
                                        <a href="#">Xizhiyanbiotechlab@gmail.com</a><br>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 col-lg-8 col-md-7 col-sm-6 d-flex align-items-center">
                            <div class="w-100">
                                <form class="pl-lg-2" action="#" id="contact_us_form">
                                    @csrf
                                    <h4 class="ls-m font-weight-bold">Let’s Connect</h4>
                                    <p>Your email address will not be published. Required fields are
                                        marked *</p>
                                    <div class="mb-2 row">
                                        <div class="mb-4 col-md-6">
                                            <input class="form-control" type="text" placeholder="Name *" name="name">
                                            <span style="color: red" id="name_error"></span>
                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <input class="form-control" type="email" placeholder="Email *" name="email">
                                            <span style="color: red" id="email_error"></span>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-12">
                                        <textarea class="form-control" required placeholder="Comment*"
                                            name="comment"></textarea>
                                        <span style="color: red" id="comment_error"></span>
                                    </div>
                                    <button class="btn btn-dark btn-rounded" type="button" id="contact_us_btn">
                                        <i class="loading-icon fa fa-spinner fa-spin" id="contact_us_spin"
                                            style="display: none">
                                        </i>
                                        Submit
                                        <i class="d-icon-arrow-right"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@section('javascript')

    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('body').addClass('mainloaded')
            }, [1000])
        });
        $('#contact_us_btn').click(function() {
            var form = $('#contact_us_form')[0];
            var data = new FormData(form)
            $.ajax({
                url: "",
                type: "POST",
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('#contact_us_spin').show();
                    $("#contact_us_form :input").prop("disabled", true);
                },
                success: function(data) {
                    $('#contact_us_spin').hide();
                    $("#contact_us_form :input").prop("disabled", false);
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
                    $('#contact_us_form')[0].reset();
                },
                error: function(error) {
                    $('#contact_us_spin').hide();
                    $("#contact_us_form :input").prop("disabled", false);
                    console.log(error)
                    var err = error.responseJSON.errors;
                    if (error.status == 422) {
                        $('#name_error').html(err.name)
                        $('#email_error').html(err.email)
                        $('#comment_error').html(err.comment);
                    }
                }
            })
        })

        $("#contact_us_form :input").click(function() {
            $('#name_error').html('')
            $('#email_error').html('')
            $('#comment_error').html('');
        })
    </script>
@endsection

@endsection
