<?php include('../../init.php');
include(RAIZf . 'head.php'); ?>
<script>
    $(document).ready(function() {
        // Initialize the select2 plugin
        $('.selDiag').select2({
            ajax: {
                url: 'get_diag3.php',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
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
            </select>
        </div>
    </div>
</div>