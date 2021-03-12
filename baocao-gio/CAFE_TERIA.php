<?php
$ajax_dir = "../baocao-gio/ajax-call/process-";
$ajax_url = $ajax_dir . $nhom_hang_ban_ten . ".php";;
?>
<div class="tab-pane fade in" id="<?=$nhom_hang_ban_id?>">
  <form action="" method="post" id="2014204" class="<?=$nhom_hang_ban_id?>">

        <div class="col-md-4 form-group">
          <label for="tu-ngay">Từ:</label>
          <div class="input-group date" style="margin-bottom:5px">
            <input name="tuNgay" type='text' class="form-control" id="tungay-<?=$nhom_hang_ban_id?>" value="<?php echo @$tuNgay ?>"/>
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
  <input name="nhom_hang_ban_id" type="hidden"  value="<?=$nhom_hang_ban_id ?>" id="nhom_hang_ban_id" />
      <input name="nhom_hang_ban_ten" type="hidden"  value="<?=$nhom_hang_ban_ten ?>" id="nhom_hang_ban_ten" />
  <button type="submit" class="btn btn-info" style="margin:21px auto">Submit</button>
 
</form>



  <div class="tab-pane fade in" id="<?=$nhom_hang_ban_id?>">
    <div class="col-xs-12 col-sm-12 table-responsive">
        <div class="col-md-12" >
         <canvas id="bieudo-soluong-<?=$nhom_hang_ban_id?>" ></canvas> 
        </div>
        <div class="col-md-12" >
          <canvas id="bieudo-sotien-<?=$nhom_hang_ban_id?>" ></canvas>
        </div>
    </div>  
  </div>
</div>

<?php require_once('../ajax-loading.php'); ?>
<script>


$(function () {
  $('#tungay-<?=$nhom_hang_ban_id?>').val('');
  var dateNow = new Date();
   $('#tungay-<?=$nhom_hang_ban_id?>').datetimepicker({
     // viewMode: 'years',
      useCurrent: false,
      format: 'DD/MM/YYYY',
      defaultDate:dateNow
   });
});

  
  $('form.<?=$nhom_hang_ban_id?>').on('submit', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    var url = '<?=$ajax_url?>';

    $.ajax({
      url: url,
      method:"POST",
      data:formValues,
      beforeSend :function(){
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(response)
      {
          var result = [];
          result = JSON.parse(response);
          //console.log(typeof (reponse) );//string
          //console.log(typeof (result) );//object
         /****************** Qty *********************/   
          var qty_sum_arr = new Array();
              qty_sum_arr = result[0];
          var maxValueQty = result[1];
         
          const QTY_CHART_<?=$nhom_hang_ban_ten?> = document.getElementById("bieudo-soluong-" + "<?=$nhom_hang_ban_id?>");
            
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

          var mylineChart  = new Chart(QTY_CHART_<?=$nhom_hang_ban_ten?>, {
              type: 'line',
              data: dataQty,
              options: optionsQty,
          });

/**************** Money *********************/
      var sales_sum_arr = new Array();
          sales_sum_arr = result[2];
      var maxValueMoney = result[3];
      
      const MONEY_CHART_<?=$nhom_hang_ban_ten?> = document.getElementById('bieudo-sotien-' + "<?=$nhom_hang_ban_id?>");
        
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

      var myMoneyChart  = new Chart(MONEY_CHART_<?=$nhom_hang_ban_ten?> , {
          type: 'line',
          data: dataMoney,
          options: optionsMoney
      });


      },
      complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
    });
   });

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



