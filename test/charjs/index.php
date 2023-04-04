<!DOCTYPE html>
<html>

<head>
    <title>Dynamic Line Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <canvas id="myChart"></canvas>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        function updateChart() {
            fetch('data.php')
                .then(response => response.json())
                .then(data => {
                    chart.data.labels = data.labels;
                    chart.data.datasets = data.datasets;
                    chart.update();
                })
                .catch(error => console.error(error));
        }

        //updateChart();
        //setInterval(updateChart, 5000); // Update chart every 5 seconds
    </script>
</body>

</html>