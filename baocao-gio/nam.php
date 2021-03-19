<?php
require('../datetimepicker-year.php');
?>
<div class="container-fluid">
      <div class="row">
        <div class="col-md-12" >
          <canvas id="qtyYear" ></canvas>
        </div>
        <div class="col-md-12" >
          <canvas id="amtYear" ></canvas>
        </div>
      </div>

</div>
<?php require_once('../ajax-loading.php'); ?>
<script>
$(function () {  
  $('body').on('submit', 'form#customYear', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    $.ajax({
    url: 'ajax/year.php',
    method:"POST",
    data:formValues,
    dataType:"json",
    success:function(response)
      {   console.log(response);
           var result = [];
          result = response;
          //console.log(typeof (reponse) );//string
          //console.log(typeof (result) );//object
         /****************** Qty *********************/   
          var qty_sum_arr = new Array();
          var maxValueQty = result.maxQty;
          for (x in response.qty )
        {
          qty_sum_arr.push( parseInt(response.qty[x]) );
        }
      
        
          const QTY_CHART = document.getElementById("qtyYear");
            
            var dataQty = {
              labels: ["8h-9h",  "9h-10h", "10h-11h", "11h-12h", "12h-13h","13h-14h","14h-15h","15h-16h","16h-17h","17h-18h","18h-19h","19h-20h","20h-21h","21h-22h","22h-23h","23h-24h"],
              datasets: [
                {
                  label: "Số Lượng",
                  data: qty_sum_arr,
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

            var optionsQty = {
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
                        max: Math.ceil( maxValueQty/0.7 ),
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
                display:false,
                text:"Tất cả"
               }
            };

          var mylineChart  = new Chart(QTY_CHART, {
              type: 'line',
              data: dataQty,
              options: optionsQty,
          });

/**************** Money *********************/
      var sales_sum_arr = new Array();
        for (x in response.amt )
        {
          sales_sum_arr.push( parseInt(response.amt[x]) );
        }
      var maxValueMoney = result.maxAmt;
      
      const MONEY_CHART = document.getElementById("amtYear");
        
        var dataMoney = {
          labels: ["8h-9h",  "9h-10h", "10h-11h", "11h-12h", "12h-13h","13h-14h","14h-15h","15h-16h","16h-17h","17h-18h","18h-19h","19h-20h","20h-21h","21h-22h","22h-23h","23h-24h"],
          datasets: [
            {
              label: "Số Tiền",
              data: sales_sum_arr,
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

        var optionsMoney = {
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
                    max: Math.round( ( Math.ceil(maxValueMoney)/0.7 )/50000 ) * 50000,
                    callback: function(value, index, values) {
                    // Convert the number to a string and split the string every 3 charaters from the end
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
            display:false,
            text:"Tất cả"
           },
           tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';

                    if (label) {
                        label += ': ';
                    }
                    label += addCommas(tooltipItem.yLabel) ;
                    return label;
                }
              }
          }
        };

      var myMoneyChart  = new Chart(MONEY_CHART , {
          type: 'line',
          data: dataMoney,
          options: optionsMoney
      });


      },
      complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
    });

    
  });

});
</script>