 <h3 class="title">Báo cáo hóa đơn</h3>
 <?php include('datetimepicker-day.php')
 ?>
<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
  <div class="panel-body no-padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" >
          <canvas id="bieudo-soluong" ></canvas>
        </div>
        <div class="col-md-12" >
          <canvas id="bieudo-sotien" ></canvas>
        </div>
      </div>

    </div>
      
  </div>
</div>

<script>
var qty_sum_arr = new Array();
    qty_sum_arr = <?php echo json_encode( $qty_sum_arr );?>

const QTY_CHART = document.getElementById('bieudo-soluong');
	
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
            formatter: (value, QTY_CHART) => {
                let sum = 0;
                let dataArr = QTY_CHART.chart.data.datasets[0].data;
                dataArr.map(data => {
                    sum += data;
                });
                let percentage = (value*100 / sum).toFixed(2)+"%";
                return percentage;
            },
            color: '#fff',
            
        }
    },
    title: {
        display:true,
        text:"Biểu đồ số lượng",
        fontSize:19
      }

  };

var myPieChart  = new Chart(QTY_CHART, {
    type: 'doughnut',
    data: data,
    options: options
});


</script>

<script>

    $('#tungay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
    $('#denngay').datepicker({  uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 

    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap',
         format: "dd/mm/yyyy",
          todayBtn: true,
    });
</script>

<script>
var sales_sum_arr = []; 
sales_sum_arr =  <?php echo json_encode( $sales_sum_arr );?>

const Money_Chart = document.getElementById('bieudo-sotien');
  
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
          "#63BF85"
        ],
        borderWidth: [1, 1]
      }
    ]
  };

  var options2 = {
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
            formatter: (value, Money_Chart) => {
                let sum = 0;
                let dataArr = Money_Chart.chart.data.datasets[0].data;
                dataArr.map(data => {
                    sum += data;
                });
                let percentage = (value*100 / sum).toFixed(2)+"%";
                return percentage;
            },
            color: '#fff',
            
        }
    },
      title: {
        display:true,
        text:"Biểu đồ số tiền",
        fontSize:19
      }
  };

var myPieChart  = new Chart(Money_Chart, {
    type: 'doughnut',
    data: data2,
    options: options2
});


</script>