<select id="mySelect" style="width: 100%;">
</select>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#mySelect').select2({
            ajax: {
                url: 'get_items.php',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.items.map(function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            };
                        }),
                        pagination: {
                            more: data.hasMorePages
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Search for an item',
            minimumInputLength: 1
        });
    });
</script>