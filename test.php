<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script> 
        <script src="https://rawgit.com/beaver71/Chart.PieceLabel.js/master/build/Chart.PieceLabel.min.js"></script>
        <title>Pie Chart Outlabels</title>
    </head>
    <body>
        <div id="chart-wrapper">
              <canvas id="outlabeledChart"></canvas>
        </div>
        <script id="script-construct">
          const TEST_CHART =  document.getElementById('outlabeledChart');
            var chart = new Chart(TEST_CHART, {
                type: 'doughnut',
                data: {
                    labels: [
                        'ONE',
                        'TWO',
                        'THREE',
                        'FOUR',
                        'FIVE',
                        'SIX',
                        'SEVEN',
                        'EIGHT',
                        'NINE',
                        'TEN'
                    ],
                    datasets: [{
                        backgroundColor: [
                            '#FF3784',
                            '#36A2EB',
                            '#4BC0C0',
                            '#F77825',
                            '#9966FF',
                            '#00A8C6',
                            '#379F7A',
                            '#CC2738',
                            '#8B628A',
                            '#8FBE00'
                        ],
                        data: [1000, 2000, 3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000]
                    }]
                },
                options: {
                  responsive: true,
                  layout: {
                    padding: 100
                  },
                  zoomOutPercentage: 15, // makes chart 55% smaller (50% by default, if the preoprty is undefined)
                  plugins: {
                        legend: false,
                        outlabels: {
                            text: '%l %p',
                            color: 'white',
                            stretch: 45,
                            font: {
                                resizable: true,
                                minSize: 8,
                                maxSize: 12,
                                size: 6
                            },
                            padding: {top: 20},

                        },
                  },
                   tooltips:{
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var indice = tooltipItem.index;
                            var formatNum = addCommas(data.datasets[tooltipItem.datasetIndex].data[indice]);                 
                            return  data.labels[indice] +': '+ formatNum + '';
                        }
                    }
                } 
  
                }
              });
            console.log(chart.options.tooltips.callbacks);

    function addCommas(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
        
        </script>
    </body>
</html>