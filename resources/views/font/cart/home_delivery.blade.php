<div class="row p-2 mb-4">
    <div class="col-md-6 mt-2" style="border-right: 1px solid black;" id="billing_details">
        <h3 class="title title-simple text-left text-uppercase">Billing Details</h3>
        <div class="row mb-4">
            <div class="col-xs-6">
                <label>First Name *</label>
                <input type="text" class="form-control" name="firstname" id="firstname" />
                <span style="color: red" id="firstname_error"> </span>
            </div>
            <div class="col-xs-6">
                <label>Last Name *</label>
                <input type="text" class="form-control" name="lastname" id="lastname" />
                <span style="color: red" id="lastname_error"> </span>
            </div>
        </div>
        <div class="row mb-4">
            <label>Country / Region *</label>
            <div class="">
                <select name="country" class="form-control allcountry" id="select_country_for_de">

                </select>
                <span style="color: red" id="country_error"> </span>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xs-12">
                <label>Street Address *</label>
                <input type="text" class="form-control" name="address" placeholder="House number and street name"
                    id="address" />
                <span style="color: red" id="address_error"> </span>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xs-6">
                <label>Town / City *</label>
                <input type="text" class="form-control" name="city" id="city" />
                <span style="color: red" id="city_error"> </span>
            </div>
            <div class="col-xs-6">
                <label>State *</label>
                <input type="text" class="form-control" name="state" id="state" />
                <span style="color: red" id="state_error"> </span>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xs-6">
                <label>ZIP *</label>
                <input type="text" class="form-control" name="zip" id="zip" />
                <span style="color: red" id="zip_error"> </span>
            </div>
            <div class="col-xs-6">
                <label>Phone *</label>
                <input type="text" class="form-control" name="phone" id="phone" />
                <span style="color: red" id="phone_error"> </span>
            </div>
        </div>

        <div class="mb-6 form-checkbox shcheck" style="display: flex;align-items: center">
            <input type="checkbox" class="" id="ship_same_with_bill" name="ship_same_with_bill">
            <label class="form-control-label ls-s mt-1 p-2" for="different-address" id="shiptosame">Ship to
                same
                address?</label>
        </div>
    </div>

    <div class="col-md-6 mt-2" id="ship_details">
        <h3 class="title title-simple text-left text-uppercase">Shipment Details</h3>
        <div class="row mb-5">
            <div class="col-xs-6">
                <label>First Name *</label>
                <input type="text" class="form-control" name="first_name_ship" id="first_name_ship" />
                <span style="color: red" id="first_name_ship_error"> </span>
            </div>
            <div class="col-xs-6">
                <label>Last Name *</label>
                <input type="text" class="form-control" name="last_name_ship" id="last_name_ship" />
                <span style="color: red" id="last_name_ship_error"> </span>
            </div>
        </div>
        <div class="row mb-4">
            <label>Country / Region *</label>
            <div class="">
                <select name="country_ship" class="form-control allcountry" id="country_ship">

                </select>
                <span style="color: red" id="country_ship_error"> </span>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xs-12">
                <label>Street Address *</label>
                <input type="text" class="form-control" name="address_ship" placeholder="House number and street name"
                    id="address_ship" />
                <span style="color: red" id="address_ship_error"> </span>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xs-6">
                <label>Town / City *</label>
                <input type="text" class="form-control" name="city_ship" id="city_ship" />
                <span style="color: red" id="city_ship_error"> </span>
            </div>
            <div class="col-xs-6">
                <label>State *</label>
                <input type="text" class="form-control" name="state_ship" id="state_ship" />
                <span style="color: red" id="state_ship_error"> </span>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xs-6">
                <label>ZIP *</label>
                <input type="text" class="form-control" name="zip_ship" id="zip_ship" />
                <span style="color: red" id="zip_ship_error"> </span>
            </div>
            <div class="col-xs-6">
                <label>Phone *</label>
                <input type="text" class="form-control" name="phone_ship" id="phone_ship" />
                <span style="color: red" id="phone_ship_error"> </span>
            </div>
        </div>

    </div>
</div>
