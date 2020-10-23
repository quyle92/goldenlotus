<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script> 
        <script src="https://rawgit.com/beaver71/Chart.PieceLabel.js/master/build/Chart.PieceLabel.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <title>Pie Chart Outlabels</title>
        <style>

        </style>
    </head>
    <body>
        <div id="chart-wrapper">
            <div class="container">
                <div class="row">
                    <div class="mychart">
                        <canvas id="outlabeledChart"></canvas>
                    </div>
                </div>
            </div>
              
        </div>
<script id="script-construct">
    const CHART2 =  document.getElementById('outlabeledChart').getContext("2d");
    var lineChart = new Chart(CHART2, {
       type: 'line',
       data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
          datasets: [{
             label: 'LINE 1',
             data: [3, 1, 4, 2, 5],
             backgroundColor: 'rgba(0, 119, 290, 0.5)',
             borderColor: 'rgba(0, 119, 290, 0.6)',
             fill: false
          }]
       },
       options: {
          scales: {
             yAxes: [{
                ticks: {
                   beginAtZero: true,
                   max: 7
                }
             }]
          }
       },
       plugins: [{
          afterDatasetsDraw: function(chart) {
             var ctx = chart.ctx;
             chart.data.datasets.forEach(function(dataset, index) {
                var datasetMeta = chart.getDatasetMeta(index);
                if (datasetMeta.hidden) return;
                datasetMeta.data.forEach(function(point, index) {
                   var value = dataset.data[index],
                       x = point.getCenterPoint().x,
                       y = point.getCenterPoint().y,
                       radius = point._model.radius,
                       fontSize = 14,
                       fontFamily = 'Verdana',
                       fontColor = 'black',
                       fontStyle = 'normal';
                   ctx.save();
                   ctx.textBaseline = 'middle';
                   ctx.textAlign = 'center';
                   ctx.font = fontStyle + ' ' + fontSize + 'px' + ' ' + fontFamily;
                   ctx.fillStyle = fontColor;
                   ctx.fillText(value, x, y - radius - fontSize);
                   ctx.restore();
                });
             });
          }
       }]
    });
        
</script>
    </body>
</html>