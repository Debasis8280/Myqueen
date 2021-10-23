<script>
    function customViewFormatter(data) {
        var template = $('#profileTemplate').html()
        var view = ''
        $.each(data, function(i, row) {
            view += template.replace('%NAME%', row.title)
                .replace('%PRODUCT_PICTURE%', row.image)
                .replace('%PRICE%', row.saleprice)
                .replace('%PRODUCT_ID%', row.id)
                .replace('%WISH_PRODUCT_ID%', row.id)
        })

        return `<div class="row justify-content-center">${view}</div>`
    }

    function all_product(params) {
        $.ajax({
            type: "GET",
            url: "{{ URL::signedRoute('users.wishlist.create') }}",
            dataType: "json",
            success: function(data) {
                console.log(data);
                params.success(data)
                $('body').addClass('mainloaded')
            },
            error: function(er) {
                params.error(er);
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
                $('#product_click_loder').show()
            },
            success: function(data) {
                // console.log(data);
                $('#product_click_loder').hide()
                window.location.href = data
            }
        })
    }

    function remove_wishlist(id) {
        $.ajax({
            url: "{{ URL::signedRoute('users.wishlist.store') }}",
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                product_id: id
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    toastr.options = {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-bottom-center"
                    };
                    toastr.success(data.message);
                }

                $('#table').bootstrapTable('refresh');
            },
            error: function(errror) {
                console.log(error)
            }
        })
    }
</script>
