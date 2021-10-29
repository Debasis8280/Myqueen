<div class="container">
    <div class="main-body">
        <nav aria-label="breadcrumb" class="main-breadcrumb">
        </nav>
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="" alt="" class="img-fluid" id="top_up_payment_image_details">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                {{-- details --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Amount</h6>
                            </div>
                            <div class="col-sm-9 text-secondary" id="top_up_amount_details">
                                {{-- name --}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary" id="top_up_name_details">
                                {{-- name --}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary" id="top_up_email_details">
                                {{-- email --}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary" id="top_up_phone_details">
                                {{-- phone --}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Payment Date</h6>
                            </div>
                            <div class="col-sm-9 text-secondary" id="top_up_payment_date">
                                {{-- join date --}}
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                {{-- end details --}}
            </div>
        </div>

    </div>
</div>

<style>
    #top_up_payment_image_details {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #top_up_payment_image_details:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .big_screen {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content-image {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image */
    #top_up_caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation */
    .modal-content-image,
    #top_up_caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close_big_screen {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close_big_screen:hover,
    .close_big_screen:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content-image {
            width: 100%;
        }
    }

</style>

<!-- The Modal -->
<div id="top_up_myModal" class="big_screen">
    <span class="close_big_screen">&times;</span>
    <img class="modal-content-image" id="top_up_img01">
    <div id="top_up_caption"></div>
</div>

<script src="{{ asset('asset/js/jquery-3.3.1.min.js') }}"></script>
<script>
    // Get the modal
    var top_up_modal = document.getElementById("top_up_myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var top_up_img = document.getElementById("top_up_payment_image_details");
    var top_up_modalImg = document.getElementById("top_up_img01");
    var top_up_captionText = document.getElementById("top_up_caption");
    top_up_img.onclick = function() {
        top_up_modal.style.display = "block";
        top_up_modalImg.src = this.src;
        top_up_captionText.innerHTML = this.alt;
        console.log(1)
    }

    $('.close_big_screen').click(function() {
        top_up_modal.style.display = "none";
    })
</script>
