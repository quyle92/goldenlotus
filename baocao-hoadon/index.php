<?php 
$page_name = "BieuDoDoanhThu";
require_once('../helper/security.php');
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

 $date = date('yy/m/d');
$qty_chart = $goldenlotus-> getQtyOrderSummary( $date );
//$qty_sum_arr = array();
foreach ( $qty_chart as $r )
{
  $qty_sum_arr = array();
  foreach ($r as $k=>$v)
  {
    $qty_sum_arr[] = (int) $v;
  }
}
//var_dump($qty_sum_arr);




$sales_chart = $goldenlotus-> getSalesAmountSummary( $date );
$sales_sum_arr = array();
foreach ( $sales_chart as $r1 ){
  $sales_sum_arr = array();
  foreach ($r1 as $k=>$v)
  {
    $sales_sum_arr[] = (int) $v;
  }
}
//var_dump($sales_sum_arr);



$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];

$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];

if($tungay == "")
{
	$tungay = "01-01-".date('Y');
}

if($denngay == "")
{
	$denngay = date('d-m-Y');
}


 
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script> 
<script>


</script>  
</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
    <div id="page-wrapper">

    <div class="col-md-12 graphs">
	<div class="xs">

 <h3 class="title">Báo cáo hóa đơn</h3>
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
<!-- END BIEU DO DOANH THU-->
  </div>
 	<!-- #end class xs-->
   </div>
   <!-- #end class col-md-12 -->
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
<script>
	/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  	//this.classList.toggle("active");
  	var dropdownContent = this.nextElementSibling;
  	if (dropdownContent.style.display === "block") {
  		dropdownContent.style.display = "none";
  	} else {
  		dropdownContent.style.display = "block";
  	}
  });
}

//dropdown[0].click();

</script>
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>

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
</body>
</html>

