<script>
    function showForcast(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.forcast.index') }}",
            dataType: "json",
            success: function(data) {
                params.success(data)
            },
            error: function(er) {
                params.error(er);
            }
        });
    }

    function forcastImage(data) {
        var url = "{{ asset('') }}";
        return "<img src='" + url + data + "' width='100'>"
    }
</script>
