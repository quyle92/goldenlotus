<?php
$ajax_dir = "../baocao-gio/ajax-call/process-";
$ajax_url = $ajax_dir . $nhom_hang_ban_ten . ".php";;
?>
<div class="tab-pane fade in" id="<?=$nhom_hang_ban_id?>">
  <form action="" method="post" id="2014204" class="<?=$nhom_hang_ban_id?>">
    <div class="col-md-2" style="margin-bottom:5px">Ngày:</div>
    <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?php echo @$tungay ?>" id="tungay-<?=$nhom_hang_ban_id?>" />
      <input name="nhom_hang_ban_id" type="hidden"  value="<?=$nhom_hang_ban_id ?>" id="nhom_hang_ban_id" />
      <input name="nhom_hang_ban_ten" type="hidden"  value="<?=$nhom_hang_ban_ten ?>" id="nhom_hang_ban_ten" />
    </div>
    <div class="col-md-2" style="margin-bottom:5px"><input type="submit" value="Lọc"></div>
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


<script>

    $('#tungay-<?=$nhom_hang_ban_id?>').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
  
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap',
         format: "dd/mm/yyyy",
          todayBtn: true,
    });


  
  $('form.<?=$nhom_hang_ban_id?>').on('submit', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    var url = '<?=$ajax_url?>';console.log(url);

    $.ajax({
      url: url,
      method:"POST",
      data:formValues,
      //dataType:"json",
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
              labels: ["8h00",  "9h00", "10h00", "11h00", "12h00","13h00","14h00","15h00","16h00","17h00","18h00","19h00","20h00"],
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
          labels: ["8h00",  "9h00", "10h00", "11h00", "12h00","13h00","14h00","15h00","16h00","17h00","18h00","19h00","20h00"],
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

      var myMoneyChart  = new Chart(MONEY_CHART_<?=$nhom_hang_ban_ten?> , {
          type: 'line',
          data: dataMoney,
          options: optionsMoney
      });


      }
    });
   });


</script>



