<script>
    // show data in table
    function showProduct(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.product.index') }}",
            dataType: "json",
            success: function(data) {
                params.success(data)
            },
            error: function(er) {
                params.error(er);
            }
        });
    }
    // status
    function product_status(data) {
        if (data == 0) {
            return ["<a class='btn btn-soft-warning ' href='#' title='Status'>",
                "Pending",
                "</a>"
            ].join('');
        } else {
            return ["<a class='btn btn-soft-success' href='#' title='Status'>",
                "Active",
                "</a>"
            ].join('');
        }

    }
    // for image
    function productImage(data) {
        var url = "{{ asset('') }}";
        return "<img src='" + url + data + "' width='100'>"
    }

    // action
    function productAction(value, row, index) {
        var url = "{{ url('') }}" + "/admin/adminproduct/" + row.id + "/edit";
        // var url = "{{ route('admin.product.edit', 23) }}"
        return [
            '<a class="btn btn-soft-info  btn-icon btn-circle btn-sm" href="' + url + '" title="Edit" >',
            '<i class="las la-edit"></i>',
            '</a>  ',
            '<a class="btn btn-soft-danger  btn-icon btn-circle btn-sm" href="javascript:void(0)" title="Delete" onclick="deleteProduct(' +
            row.id + ')">',
            '<i class="las la-trash"></i>',
            '</a>'
        ].join('')
    }

    // delete retutn
    function deleteProduct(id) {
        $('#product_delete-modal').modal('show');
        $("#product_delete-link").attr("href", id);
    }
    // delete logic
    $('#product_delete-link').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.product.deleteProduct') }}",
            type: "post",
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                id: $(this).attr('href')
            },
            beforeSend: function() {
                $('.inventory_loder').show()
            },
            success: function(data) {
                $('.inventory_loder').hide()
                if (data.status == 'success') {
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
                    $('#product_delete-modal').modal('hide');
                    $('#product_table_list').bootstrapTable('refresh');
                }
            },
            error: function(error) {
                $('.inventory_loder').hide()
                console.log(error)
            }
        })
    });
</script>
