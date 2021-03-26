
<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
  <div class="panel-body no-padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" >

         <?php include('../datetimepicker-day.php');
         ?>
          <canvas id="qtyDay" ></canvas>
        </div>
        <div class="col-md-12" >
          <canvas id="moneyDay" ></canvas>
        </div>
      </div>

    </div>
      
  </div>
</div>

<script>
var qtyChart;
var moneyChart;
//console.log($('body form#customDate'));
$(function () {  
  $('body').on('submit', 'form#customDate', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    $.ajax({
      url: 'ajax/day.php',
      method:"POST",
      data:formValues,
      dataType:"json",
      success:function(response)
      {   
        var qty_sum_arr = [];

        for (x in response.qty )
        {
          qty_sum_arr.push( parseInt(response.qty[x]) );
        }
      
        const QTY_CHART = document.getElementById('qtyDay');
          
          var data = {
            labels: ["<=1",  "1-2", "2-3", "3-4", ">=5"],
            datasets: [
              {
                label: "Độ phủ theo thời gian thực",
                data: qty_sum_arr,
                backgroundColor: [
                  "#D9A2BD",
                  "#633DC6",
                  "#D94826",
                  "#C3D7CA",
                  "#63BF85"
                ],
                borderWidth: [1, 1]
              }
            ]
          };

          var options = {
            responsive: true,
            legend: {
              display: true,
              position: "bottom",
              labels: {
                fontColor: "#333",
                fontSize: 16
              }
            },
              plugins: {
                datalabels: {
                    formatter: (value, REVENUE_BY_FOOD_GROUP_THIS_MONTH) => {
                      if(value>0)
                      {
                        let sum = 0;
                        let dataArr = REVENUE_BY_FOOD_GROUP_THIS_MONTH.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value*100 / sum).toFixed(2)+"%";
                        //if( (value*100 / sum).toFixed(2) > 10 )
                          return percentage;
                        //else return "";
                      }
                      else
                      {
                        value = "";
                        return value;
                      }
                    },
                    color: '#fff',
                     font: {
                      weight: 'bold',
                      size: 10,
                    }
                    
                },
                outlabels: false
            },
            title: {
                display:true,
                text:"Biểu đồ số lượng",
                fontSize:19
              }

          };

        if(qtyChart != undefined)
       {
          qtyChart.destroy();
       }

         qtyChart  = new Chart(QTY_CHART, {
            type: 'doughnut',
            data: data,
            options: options
        });



        var sales_sum_arr = []; 
        for (x in response.amt )
        {
          sales_sum_arr.push( parseInt(response.amt[x]) );
        }

        
        const Money_Chart = document.getElementById('moneyDay');
          
          var data2 = {
            labels: ["<= 500 000",  "500 000 - 1 000 000", "1 000 000 - 2 000 000", "2 000 000 - 3 000 000", "3 000 000 - 4 000 000", ">= 4 000 000"],
            datasets: [
              {
                label: "Độ phủ theo thời gian thực",
                data: sales_sum_arr,
                backgroundColor: [
                  "#D9A2BD",
                  "#633DC6",
                  "#D94826",
                  "#C3D7CA",
                  "#63BF85",
                  "yellow"
                ],
                borderWidth: [1, 1]
              }
            ]
          };

          var options2 = {
            layout: {
                padding: {
                    left: 65,
                    right: 65,
                    top: 65,
                    bottom: 65
                }
            },
            responsive: true,
            legend: {
              display: true,
              position: "bottom",
              labels: {
                fontColor: "#333",
                fontSize: 16
              }
            },
              plugins: {
                datalabels: {
                    formatter: (value, REVENUE_BY_FOOD_GROUP_THIS_MONTH) => {
                      if(value>0)
                      {
                        let sum = 0;
                        let dataArr = REVENUE_BY_FOOD_GROUP_THIS_MONTH.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value*100 / sum).toFixed(2)+"%";
                        if( (value*100 / sum).toFixed(2) > 10 )
                          return percentage;
                        else return "";
                      }
                      else
                      {
                        value = "";
                        return value;
                      }
                    },
                    color: '#fff',
                     font: {
                      weight: 'bold',
                      size: 10,
                    }
                    
                },
                outlabels: {
                  text: '%l => %p',
                  color: 'white',
                  stretch: 15,
                  borderRadius: 20,
                  borderWidth:1,
                  font: {
                      resizable: false,
                       minSize: 8,
                       maxSize: 12,
                      size: 12
                  },
                  textAlign:"center",
                  padding: 2,
                  display: function(context){
                          var index = context.dataIndex;
                          var value = context.dataset.data[index];//console.log(context.percent);
                          return ( context.percent > 0.10 || context.percent ===0 ) ? false : true;
                  }
              }
            },
              title: {
                display:true,
                text:"Biểu đồ số tiền",
                fontSize:19
              }
          };

       if(moneyChart != undefined)
       {
          moneyChart.destroy();
       }

         moneyChart  = new Chart(Money_Chart, {
            type: 'doughnut',
            data: data2,
            options: options2
        });

         if (window.matchMedia('(min-width: 769px)').matches) {
            moneyChart.canvas.parentNode.style.width = '93vw';
            moneyChart.canvas.parentNode.style.margin = '1px -148px';
        } 
        
      }     
    });
  });
}); 


</script>