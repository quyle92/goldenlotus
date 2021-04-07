<div class="col-md-4">
  <form action="" id="customYear" method="post" class="form-horizontal" >
      <div class="form-group">
        <label for="tu-ngay" class="col-md-3 control-label">Năm:</label><!--2020/12/01 -->
        <div class="col-md-9 input-group date">
          <input name="tuNam" type='text' class="form-control" id="tuNam" value="<?=date('y')?>"/>
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
      <canvas id="year" ></canvas>
    </div>
  </div>
</div>

<script>
  $('form#customYear').on('submit', function (event){
    event.preventDefault();
    var tuNam = $('#tuNam').val();//console.log(tuNam);

    var formValues= $(this).serialize();

    $.ajax({
    url:"ajax-call/year.php",
    method:"POST",
    //data:{'tu-ngay' : tuNam, 'den-ngay' : denNgay},
    data:formValues,
    dataType:"json",
    success:function(output)
      {
    console.log(output[0]);
    console.log(output[1]);
        const REVENUE_BY_FOOD_GROUP_BY_SELECTION = document.getElementById('year');
       
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
            formatter: (value, REVENUE_BY_FOOD_GROUP_THIS_year) => {
              if(value>0)
              {
                let sum = 0;
                let dataArr = REVENUE_BY_FOOD_GROUP_THIS_year.chart.data.datasets[0].data;
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
   $('#tuNam').datetimepicker({
     // viewMode: 'years',
      //useCurrent: false,
      format: 'YYYY',
      //defaultDate:dateNow
   });
});



</script>