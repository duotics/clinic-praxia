<?php
$idp = null;
$field = null;
$type = null;
$idp = $_REQUEST['idp'] ?? null;
$field = $_REQUEST['field'] ?? null;
$type = $_REQUEST['type'] ?? null;
?>
<fieldset>
    <input type="hidden" id="idp" value="<?php echo $idp ?>">
    <input type="hidden" id="field" value="<?php echo $field ?>">
    <input type="hidden" id="type" value="<?php echo $type ?>">
</fieldset>

<div class="row">
    <div class="col-sm-6">
        <canvas id="myChart" width="400" height="400"></canvas>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="col-card-header">Ultimos registros</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        idp = $("#idp").val();
        field = $("#field").val();
        type = $("#type").val();
        console.log(idp + field);
        //$("#vIMC").html('<span>Calculando...</span>');
        $.ajax({
            url: '_serv-sig-v2.php', // la URL para la petición
            data: {
                idp: idp,
                field: field,
                type: type
            }, // la información a enviar
            type: 'GET', // especifica si será una petición POST o GET
            dataType: 'json', // el tipo de información que se espera de respuesta
            success: function(json) { // código a ejecutar si la petición es satisfactoria;
                graphv2(json);
                //console.log(json.data)
                //$("#vIMC").html(json.inf);
            },
            error: function(xhr, status) { // código a ejecutar si la petición falla;
                console.log('Disculpe, existió un problema');
            },
            complete: function(xhr, status) { // código a ejecutar sin importar si la petición falló o no
                console.log('Petición realizada');
            }
        });

        function random_rgba() {
            var o = Math.round,
                r = Math.random,
                s = 255;
            return 'rgba(' + o(r() * s) + ',' + o(r() * s) + ',' + o(r() * s) + ',' + r().toFixed(1) + ')';
        }

        function graphv2(param) {

            var data = param.data;
            console.log(param.data);
            console.log('-');
            var cont = 0;
            const dataset = [];
            var bgcolor;
            $.each(data, function(index) {
                console.log(index);
                console.log(data[index]);
                bgcolor = 'rgba(0, 99, 132, 0.6)';
                if (cont > 0) bgcolor = random_rgba;
                dataset[cont] = ({
                    label: index,
                    data: data[index],
                    backgroundColor: bgcolor,
                    borderColor: bgcolor,
                    borderWidth: 5,
                    tension: 0.2,
                    fill: false
                });
                cont++;
            });
            /*
            $.each(data, function() {
            $.each(this, function(k, v) {
                console.log(k);
                console.log(v);
            });
            });
            */


            $contDS = 2;



            var datasetA = {
                label: 'Density of Planet (kg/m3)',
                data: [5427, 5243, 5514, 3933, 1326, 687, 1271, 1638],
                backgroundColor: 'rgba(0, 99, 132, 0.6)',
                borderWidth: 0,
                yAxisID: "y-axis-density"
            };

            var datasetB = {
                label: 'Gravity of Planet (m/s2)',
                data: [3.7, 8.9, 9.8, 3.7, 23.1, 9.0, 8.7, 11.0],
                backgroundColor: 'rgba(99, 132, 0, 0.6)',
                borderWidth: 0,
                yAxisID: "y-axis-gravity"
            };

            var planetData = {
                labels: param.labels,
                datasets: dataset
            };

            var chartOptions = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: param.type,
                data: planetData,
                options: chartOptions
            });
        }

        function graph(param) {
            console.log(param);
            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: param.labels,
                    datasets: [{
                        label: param.label,
                        data: param.data,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
</script>