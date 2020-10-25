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
    </body>
<script>

         
          const QTY_CHART_NU001 = document.getElementById("outlabeledChart");
            
            var dataNU001 = {
              labels: ["8h00",  "9h00", "10h00", "11h00", "12h00","13h00","14h00","15h00","16h00","17h00","18h00","19h00","20h00"],
              datasets: [
                {
                  label: "Số Lượng",
                  data: [ 0, 0, 0, 0, 0, 1, 1, 4, 0, 0,  4, 0, 0 ],
                  fill: false,
                // cubicInterpolationMode : 'monotone',
                lineTension: 0,
                borderColor: 'rgb(51, 153, 255)',
                backgroundColor: 'rgb(51, 153, 255)',
                pointBorderColor: 'rgb(255, 102, 0)',
               // pointBackgroundColor: 'rgb(255, 102, 0)',
                pointRadius: 5,
                pointHoverRadius: 5,  
                pointHitRadius: 30,
                pointBorderWidth: 2,
                pointStyle: 'rectRounded',
                }
              ]
            };

            var optionsNU001 = {
              legend: {
                display: true,
                position: 'top',
                labels: {
                  boxWidth: 80,
                  fontColor: 'black'
                }
              },
              plugins: {
                    datalabels: false
              },
              scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true, 
                        //max: Math.ceil( maxValueQty/0.7 ),
                        callback: function(value, index, values) {
                        // Convert the number to a string and splite the string every 3 charaters from the end
                        value = value.toString();
                        value = value.split(/(?=(?:...)*$)/);

                        // Convert the array to a string and format the output
                        value = value.join('.');
                        return  value;
                        }

                    }
                   
                }]},
              xAxes: [{

                    gridLines:{
                       
                        offsetGridLines: true
                    }
                  }]
               ,
               title: {
                display:true,
                text:"Tất cả"
               }
            };

          var mylineChart_  = new Chart(QTY_CHART_NU001, {
              type: 'line',
              data: dataNU001,
              options: optionsNU001,
          });


</script>