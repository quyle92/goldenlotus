<div class="col-md-4">
  <form action="" id="customDate" method="post" class="form-horizontal" >
      <div class="form-group">
        <label for="tu-ngay" class="col-md-3 control-label">Ngày:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
          <input name="tuNgay" type='text' class="form-control" id="tuNgay" value="<?=date('d-m-y')?>"/>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
          </span>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
          <button class="btn btn-primary" type="submit" >
           Submit</button>
        </div>
      </div>
    
  </form>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12" >
      <canvas id="day" ></canvas>
    </div>
  </div>
</div>

<script>
var myPieChart;
  $('form#customDate').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tuNgay').val();//console.log(tuNgay);

    var formValues= $(this).serialize();
   console.log("customDate");
    $.ajax({
    url:"ajax-call/day.php",
    method:"POST",
    //data:{'tu-ngay' : tuNgay, 'den-ngay' : denNgay},
    data:formValues,
    dataType:"json",
    success:function(output)
      {

        const REVENUE_BY_FOOD_GROUP_BY_SELECTION = document.getElementById('day');
       
        var data = {
          labels: output[0],
          datasets: [
            {
              label: "Doanh thu theo nhóm món ăn",
              data: output[1],
              backgroundColor: ["#DC143C",  "#2E8B57", "#ff3399", "#66ccff", "#669900", "#ff6600", "#666699"],
            }
          ]
        };

       
      var options = {
    responsive: true,
    maintainAspectRatio: true,
    // layout: {
    //     padding: 100
    // },
    title: {
      display: true,
      position: "top",
      text: "Doanh thu nhóm món ăn",
      fontSize: 12,
      fontColor: "#111"
    },
    legend: {
      display: true,
      position: "bottom",
      labels: {
        fontColor: "#333",
        fontSize: 10
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
                  text: '%l: %p',
                  color: 'white',
                  stretch: 15,
                  borderRadius: 20,
                  borderWidth:1,
                  font: {
                      resizable: false,
                       minSize: 8,
                       maxSize: 12,
                      size: 8
                  },
                  textAlign:"center",
                  padding: 2,
                  display: function(context){
                          var index = context.dataIndex;
                          var value = context.dataset.data[index];
                          return ( context.percent > 0.10 || context.percent ===0 ) ? false : true;
                          

                  }

              },
    },
    tooltips:{
        callbacks: {
            label: function(tooltipItem, data) {
                var formatNum = addCommas(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                return data.labels[tooltipItem.index] + ': ' + formatNum; 
            }
        }
    } 
  };

      if(myPieChart != undefined)
       {
          myPieChart.destroy();
       }
       
       myPieChart  = new Chart(REVENUE_BY_FOOD_GROUP_BY_SELECTION, {
          type: 'doughnut',
          data: data,
          options: options
      });

      }
    })
  });


</script>

<script>

$(function () {
  //$('#tu-ngay').val('');console.log($('#tu-ngay').val());
  var dateNow = new Date();
   $('#tuNgay').datetimepicker({
     // viewMode: 'years',
      //useCurrent: false,
      format: 'DD-MM-YYYY',
      //defaultDate:dateNow
   });
});



</script>