<?php
$date = date("2020/08/29");
$nhb_doanh_thu_arr = array();

$sales_by_food_group = $goldenlotus->getSalesByFoodGroup( $date );
while( $r = sqlsrv_fetch_array($sales_by_food_group) )
{
  $nhb_doanh_thu_arr[] = !empty( $r['DoanhThu'] ) ? $r['DoanhThu'] : 0;
}

?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12" >
      <canvas id="revenue-lastmonth" ></canvas>
    </div>
  </div>
</div>

<script>

const REVENUE_BY_FOOD_GROUP_LAST_MONTH = document.getElementById('revenue-lastmonth');

  var data = {
    labels: ['NƯỚC UỐNG', 'SALAD', 'STEAK BÒ THƯỜNG', 'STEAK BÒ MỸ', 'MÓN THÊM', 'PIZZA (CỞ NHỎ)', 'PIZZA( CỞ VỪA)', 'EXTRA TOPPING', 'SPAGHETTI (MÌ Ý)' , 'SPAGHETTI (ĐÚT LÒ)', 'CHICKEN', 'MÓN KHÁC', 'SALMON'
      ],
    datasets: [
      {
        label: "Doanh thu theo nhóm món ăn",
        data: [<?php
      foreach($nhb_doanh_thu_arr as $nhb_doanh_thu){
      echo $nhb_doanh_thu . ",";
    }

      ?>],
        backgroundColor: ["#DC143C",  "#2E8B57", "#ff3399", "#66ccff", "#669900", "#ff6600", "#666699","#00ffcc", "#993333","#663300","#ffff00","#006600","#ccff33","#ff5050"],
    //     borderColor: [
      // "#CB252B",
    //       "#1D7A46"
    //     ],
    //     borderWidth: [1, 1]
      }
    ]
  };

  var options = {
    responsive: true,
    title: {
      display: true,
      position: "top",
      text: "Doanh thu nhóm món ăn",
      fontSize: 18,
      fontColor: "#111"
    },
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
            formatter: (value, REVENUE_BY_FOOD_GROUP_LAST_MONTH) => {
                if(value>0)
              {
                let sum = 0;
                let dataArr = REVENUE_BY_FOOD_GROUP_LAST_MONTH.chart.data.datasets[0].data;
                dataArr.map(data => {
                    sum += data;
                });
                let percentage = (value*100 / sum).toFixed(2)+"%";
                return percentage;
              }
              else
              {
                value = "";
                return value;
              }
            },
            color: '#fff',
            
        }
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

var myPieChart  = new Chart(REVENUE_BY_FOOD_GROUP_LAST_MONTH, {
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

</script>