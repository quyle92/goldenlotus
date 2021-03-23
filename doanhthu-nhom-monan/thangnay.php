<?php
//$date = date("2020/08/26");
$today = date('Y/m');
$nhb_doanh_thu_arr = array();

$sales_by_food_group = $goldenlotus->getSalesByFoodGroup( $today   );
foreach ( $sales_by_food_group as $r ) 
{
  settype($r['DoanhThu'],'integer');
	$nhb_doanh_thu_arr[]  = !empty( $r['DoanhThu'] ) ? $r['DoanhThu'] : 0;
  
}


$nhom_hang_ban = $goldenlotus->getDMNhomHangBan();
$nhb_arr = array();
//var_dump($nhb_doanh_thu_arr);
foreach( $nhom_hang_ban as $nhb ){
	
	$nhb_arr[] = $nhb['Ten'];
}

?>
<div class="container-fluid">
  <div class="row"></div><div class="row"></div><div class="row"></div><div class="row"></div>
	<div class="row">
		<div class="col-md-12 mychart" >
			<canvas id="revenue-thismonth" ></canvas>
		</div>
	</div>
</div>

<script>
//var ctx = document.getElementById('myChart').getContext('2d');
const REVENUE_BY_FOOD_GROUP_THIS_MONTH = document.getElementById('revenue-thismonth');
//const NHOM_MON_AN = array('NU001', 'NU002', 'NU003', 'NU004', 'NU005', 'NU006', 'NU007', 'NU008', 'NU009' , 'NU010', 'NU011', 'NU012', 'NU013');

	var data = {
    labels: [<?php
    	foreach($nhb_arr as $nhb){
			echo  '"'. $nhb .'"' . ",";
		}

    	?>],
    datasets: [
      {
        label: "Doanh thu theo nhóm món ăn",
        data: [<?php
    	foreach($nhb_doanh_thu_arr as $nhb_doanh_thu){
			echo $nhb_doanh_thu  . ",";
		}

    	?>],
        backgroundColor: ["#DC143C",  "#2E8B57", "#ff3399", "#66ccff", "#669900", "#ff6600", "#666699","#00ffcc", "#993333","#663300","#ffff00","#006600","#ccff33","#ff5050", "#a53180","#a86387", "#989979", "#99594b", "#219456", "#f09cbb"],
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
                if( (value*100 / sum).toFixed(2) > 5 )
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



var myPieChart  = new Chart(REVENUE_BY_FOOD_GROUP_THIS_MONTH, {
    type: 'doughnut',
    data: data,
    options: options
});
    ////hàm này đề format lại Number theo 1,000
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