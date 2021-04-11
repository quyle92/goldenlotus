<?php include('../datetimepicker-day.php');  ?>
<div class="row">
    <div class="col-md-12" >
      <canvas id="day" ></canvas>
    </div>
</div>

<script type="text/javascript">
var barChart; 
$('form#customDate > div:first-child:not(:last-child)').remove();

$('form#customDate').on('submit', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    //console.log(formValues);
    $.ajax({
      url:"ajax/day.php",
      method:"POST",
      data:formValues,
      dataType:"json",
      'beforeSend': function (request) {
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(response)
      { 
        //console.log(response);
        let [men, women] = response;

        var menQty = [];
        for (x in men)
        {
          menQty.push( men[x] );
        }

        var womenQty = [];
        for (x in women)
        {
          womenQty.push( women[x] );
        }

        let timeRange = ["8h-9h",  "9h-10h", "10h-11h", "11h-12h", "12h-13h","13h-14h","14h-15h","15h-16h","16h-17h","17h-18h","18h-19h","19h-20h"];
        /**
         * ChartJs
         */
          const ctx  = document.getElementById('day');

          const data = {
          labels: timeRange,
          datasets: [{
              label: "Men",
              data:  menQty, 
              backgroundColor: "#FF7693"
            },
            {
              label: "Women",
              data: womenQty, 
              backgroundColor: "#90CBF4"
            }
          ]
        };

        const options = {
          legend: {
            display: true,
            position: 'top',
            labels: {
              boxWidth: 80,
              fontColor: 'black',
              padding: 50,
              generateLabels(chart){
                return data.datasets.map(function(set) {
                   let total = set.data.map(Number);
                  return {
                    text: set.label  + " : " +  total.reduce( (a, b) =>  a + b  , 0),
                    fillStyle: set.backgroundColor
                  }

                });
               
              }
            }
          },
          plugins: {
                datalabels: false
          },
          legendCallback: function(chart) {
             var backgroundColor = chart.data.datasets[0].backgroundColor;console.log(backgroundColor)
             var value = chart.data.datasets[0].data;console.log(value)
          },
          scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
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

                gridbars:{
                   
                    offsetGridbars: true
                }
              }],
           title: {
            display:true,
            text:title
           },
           tooltips:{
              callbacks: {
                  label: function(tooltipItem, data) {
                      var formatNum = addCommas(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                      return data.datasets[tooltipItem.datasetIndex].label + ': ' + formatNum; 
                  }
              }
           } 
        };

        if( barChart !== undefined ) barChart.destroy();

        barChart = new Chart(ctx, {//(4)
            type: 'bar',
            data: data,
            options: options,

        });
        
        /** End ChartJs **/
      },
      complete: function() { $("#loadingMask").css('visibility', 'hidden'); }

    });
});
</script>
<?php
