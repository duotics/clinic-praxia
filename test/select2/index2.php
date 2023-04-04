<?php include('../../init.php');
include(RAIZf . 'head.php'); ?>
<script>
    $(document).ready(function() {
        // Initialize the select2 plugin
        $('.selDiag').select2({
            ajax: {
                url: 'get_diag2.php',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            minimumInputLength: 1,
            templateResult: function(client) {
                if (client.loading) {
                    return client.text;
                }

                var markup = "<div class='select2-result-client clearfix'>" +
                    "<div class='select2-result-client__meta'>" +
                    "<div class='select2-result-client__title'>" + client.text + "</div>" +
                    "</div>" +
                    "</div>";

                return markup;
            },
            templateSelection: function(client) {
                return client.text;
            }
        });

        // Log to console when an item is selected
        $('.selDiag').on('select2:select', function(e) {
            var data = e.params.data;
            console.log(data.id);
        });
    });
</script>
<hr>
<div class="container">
    <div class="card">
        <div class="card-body">
            <select class="selDiag" class="form-control" style="width: 100%;">
                <option value=""></option>
            </select>
        </div>
    </div>
</div>