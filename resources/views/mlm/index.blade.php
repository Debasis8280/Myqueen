@extends('mlm.layouts.main')
@section('content')
    <style>
        label {
            font-weight: bold;
        }

    </style>
    <main class="main account">
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="demo1.html"><i class="d-icon-home"></i></a></li>
                    <li>Member Request</li>
                </ul>
            </div>
        </nav>


        <img src="{{ asset('asset/image/Member-registration.jpg') }}" alt="" class="img-fluid" style="width:100%">
        <div class="container">
            <p class="text-left"> <strong>Ranking*:</strong> </p>
            <form method="post" id="order_with_pv_point_form">
                <div class="row">
                    @csrf
                    <div class="col-md-3">
                        <select name="ranking" id="ranking" class="form-control">

                        </select>
                        <span id="ranking_id_error" style="color: red"></span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <label>Branch *</label>
                        <select name="branch_id" class="form-control" id="select_branch">

                        </select>
                        <span id="branch_id_error" style="color: red"></span>
                    </div>
                    <div class="col-md-3">
                        <label>Member Id*</label>
                        <input type="text" class="form-control" name="member_id" id="member_id">
                        <span id="member_id_error" style="color: red"></span>
                    </div>
                    <div class="col-md-3">
                        <label>Member Name*</label>
                        <input type="text" class="form-control" name="member_name" id="member_name" readonly>
                        <span id="member_name_error" style="color: red"></span>
                    </div>
                    <div class="col-md-3">
                        <label>Zip</label>
                        <input type="text" class="form-control" name="postcode">
                    </div>

                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <label>Nationality*</label>
                        <select name="nationality" class="form-control allcountry" id="nationality">

                        </select>
                        <span id="nationality_error" style="color: red"></span>
                    </div>
                    <div class="col-md-3">
                        <label>Sponser Id*</label>
                        <input type="text" class="form-control" name="sponser_id" value="{{ Auth::user()->unique_id }}"
                            readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Placement ID*</label>
                        <select name="placement_id" id="placement_id" class="form-control">

                        </select>
                        <span id="placement_id_error" style="color: red"></span>
                    </div>

                    <div class="col-md-3">
                        <label>Placement*</label>
                        <select name="placement" id="placement" class="form-control">

                        </select>
                        <span id="placement_error" style="color: red"></span>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <label>Street Address</label>
                        <input type="text" class="form-control" name="street_address">
                    </div>

                    <div class="col-md-3">
                        <label>Office Contact No. </label>
                        <input type="text" class="form-control" name="office_contact_no">
                    </div>

                    <div class="col-md-3">
                        <label>Home Contact No. </label>
                        <input type="text" class="form-control" name="home_contact_no">
                    </div>

                    <div class="col-md-3">
                        <label>Nick Name.</label>
                        <input type="text" class="form-control" name="nick_name">
                    </div>

                </div>
                <br>

                <div class="row">
                    <div class="col-md-3">
                        <label>Gender </label>
                        <select name="gender" class="form-control">
                            <option value="male" selected="">Male</option>
                            <option value="female"> Female</option>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Birthday </label>
                        <input type="date" class="form-control" name="birthday">
                    </div>
                    <div class="col-md-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>Contact Address</label>
                        <textarea type="text" class="form-control" name="contact_address"></textarea>
                    </div>
                </div>
                <br>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <label>Account holder</label>
                        <input type="text" class="form-control" name="account_holder">
                    </div>
                    <div class="col-md-3">
                        <label>Bank name</label>
                        <select name="bank_name" class="form-control">
                            <option value="DBS" selected="">DBS</option>
                            <option value="OCBC"> OCBC</option>
                            <option value="POSB">POSB</option>
                            <option value="UOB">UOB</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Payment information</label>
                        <select name="payment_information" class="form-control">
                            <option value="SG" selected="">Singapore</option>
                            <option value="US"> United States</option>
                            <option value="CN">Canada</option>
                            <option value="NZ">New Zealand</option>
                            <option value="KR">Korea</option>
                            <option value="JP">Japan</option>
                            <option value="VIET">Vietnam</option>
                            <option value="DB">Dubai</option>
                            <option value="IND">India</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Branch</label>
                        <input type="text" class="form-control" name="branch">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <label>Account no.</label>
                        <input type="text" class="form-control" name="account_no">

                    </div>
                    <div class="col-md-5">
                        <p class="text-grey">Please provide complete bank account detail, otherwise the commission can
                            not
                            be presented.</p>
                    </div>
                </div>
                <br>
                <div class="form-checkbox mb-0">
                    <input type="checkbox" class="custom-checkbox" id="terms&condition" name="terms&condition">
                    <label class="form-control-label ls-s" for="terms&condition">I have read and agreed <a
                            href="#">Registration
                            agreement</a></label>
                </div>
                <br>
                <hr>
                <div class="row">
                    <h5 id="show_pv_point"></h5>
                </div>
                <div>
                    <h5 id="pv_point_message"></h5>
                </div>
                <br>
        </div>


        <div class="page-content mt-2 mb-10 pb-6" id="show_if_pv_high">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <button class="btn btn-success" type="button" id="order_with_pv_point">confirm</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        </div>
    </main>

    <div id="loder" style="display: none">
        @include('mlm.loder.index');
    </div>


@section('javascript')
    @include('mlm.js.register')
@endsection


@endsection
