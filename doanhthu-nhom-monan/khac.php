
<form method="POST" action="">
    <div class="col-md-2" style="margin-bottom:5px">Từ:</div>
    <div class="col-md-3" style="margin-bottom:5px">
      <input name="tu-ngay" type="text"  value="" id="tu-ngay" />
    </div>
    <div class="col-md-2" style="margin-bottom:5px">Đến:</div>
    <div class="col-md-3" style="margin-bottom:5px">
      <input name="den-ngay" type="text" value="" id="den-ngay" />
    </div>
    <div class="col-md-3" style="margin-bottom:5px">
      <button type="submit" class="btn btn-info">Submit</button>
    </div>
</form>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12" >
      <canvas id="revenue-byselection" ></canvas>
    </div>
  </div>
</div>

<script>
  $('form').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();//console.log(tuNgay);
    var denNgay = $('#den-ngay').val();//console.log(denNgay);
    var formValues= $(this).serialize();
   
    $.ajax({
    url:"../doanhthu-nhom-monan/ajax-call/process-khac.php",
    method:"POST",
    //data:{'tu-ngay' : tuNgay, 'den-ngay' : denNgay},
    data:formValues,
    dataType:"json",
    success:function(output)
      {

        const REVENUE_BY_FOOD_GROUP_BY_SELECTION = document.getElementById('revenue-byselection');
       
        var data = {
          labels: ['NƯỚC UỐNG', 'SALAD', 'STEAK BÒ THƯỜNG', 'STEAK BÒ MỸ', 'MÓN THÊM', 'PIZZA (CỞ NHỎ)', 'PIZZA( CỞ VỪA)', 'EXTRA TOPPING', 'SPAGHETTI (MÌ Ý)' , 'SPAGHETTI (ĐÚT LÒ)', 'CHICKEN', 'MÓN KHÁC', 'SALMON'
            ],
          datasets: [
            {
              label: "Doanh thu theo nhóm món ăn",
              data: output,
              backgroundColor: ["#DC143C",  "#2E8B57", "#ff3399", "#66ccff", "#669900", "#ff6600", "#666699","#00ffcc", "#993333","#663300","#ffff00","#006600","#ccff33","#ff5050"],
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
                          var value = context.dataset.data[index];console.log(context.percent);
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

      var myPieChart  = new Chart(REVENUE_BY_FOOD_GROUP_BY_SELECTION, {
          type: 'doughnut',
          data: data,
          options: options
      });

      //hàm này đề format lại Number theo 1,000
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
      }
    })
  });


</script>

<script>

  $('#tu-ngay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
  $('#den-ngay').datepicker({  uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 

  $('#datepicker').datepicker({
      uiLibrary: 'bootstrap',
       format: "dd/mm/yyyy",
        todayBtn: true,
  });

</script>