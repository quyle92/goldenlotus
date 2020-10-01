<?php
require('lib/db.php');
@session_start();
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
<?php include ('head/head-revenue.month.php');?>
</head>
<body>
<div id="wrapper">
    <?php include 'menu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
	<div class="xs">
	<h4>BẠN ĐANG ĐĂNG NHẬP VỚI QUYỀN - <?php echo $ten; ?> </h4>
    <form action="" method="post">
	<div class="row">
		<div class="col-md-2" style="margin-bottom:5px">Chi nhánh:</div>
		<div class="col-md-3" style="margin-bottom:5px">
			<select name="matrungtam" id="matrungtam" value="Tat ca">
<?php 
	$sql="SELECT * FROM tblDMTrungTam Order by MaTrungTam";
	try
	{
		//lay ket qua query tong gia tri the
		$result_tt = sqlsrv_query( $conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
		if($result_tt != false)
		{
			//show the results
			for ($i = 0; $i < sqlsrv_num_rows($result_tt); $i++)
			{
				$r= sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
?>
			<?php if($matrungtam == $r['MaTrungTam'])
				{
			 ?>
		 			<option value="<?php echo $r['MaTrungTam'];?>" selected="selected"><?php echo $r['TenTrungTam'];?></option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $r['MaTrungTam'];?>"><?php echo $r['TenTrungTam'];?></option>
			<?php
				}
			?>
<?php
			}
		} 
	}
	catch (PDOException $e) {

		//loi ket noi db -> show exception
		echo $e->getMessage();
	}
?>
			</select>
		</div>
		<div class="col-md-3" style="margin-bottom:5px"></div>
		<div class="col-md-2" style="margin-bottom:5px"></div>
	 </div>
     <div class="row">
          <div class="col-md-2" style="margin-bottom:5px">Từ ngày:</div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?php echo @$tungay ?>" id="tungay" /></div>
            <div class="col-md-2" style="margin-bottom:5px">Đến ngày: </div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="denngay" type="text"  value="<?php echo @$denngay ?>" id="denngay" /></div>
            <div class="col-md-2" style="margin-bottom:5px"><input type="submit" value="Lọc"></div>
	</div>
     </form>
<?php 
	//
	//---------chuyển sang chuỗi tháng -> để query sql
	//
	$tuthang_converted = "";
	$denthang_converted = "";
	if($tungay != "")
	{
		$tuthang_converted = substr($tungay,6) . "/" . substr($tungay,3,2);
	}
	//
	//----loc doanh thu tung thang-----//
	//
	$doanhthu_t1 = 0; $doanhthu_t2 = 0; $doanhthu_t3 = 0; $doanhthu_t4 = 0; $doanhthu_t5 = 0; $doanhthu_t6 = 0;
	$doanhthu_t7 = 0; $doanhthu_t8 = 0; $doanhthu_t9 = 0; $doanhthu_t10 = 0; $doanhthu_t11 = 0; 
	$doanhthu_t12 = 0;
	//
	//---thang
	//
	$sql="SELECT SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '".substr($tungay,6)."/01' Then TongTien Else 0 END) as DoanhThuT1, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/02' Then TongTien Else 0 END) as DoanhThuT2, 
	SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/03' Then TongTien Else 0 END) as DoanhThuT3, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/04' Then TongTien Else 0 END) as DoanhThuT4, 
	SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/05' Then TongTien Else 0 END) as DoanhThuT5, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/06' Then TongTien Else 0 END) as DoanhThuT6, 
	SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/07' Then TongTien Else 0 END) as DoanhThuT7, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/08' Then TongTien Else 0 END) as DoanhThuT8, 
	SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/09' Then TongTien Else 0 END) as DoanhThuT9, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/10' Then TongTien Else 0 END) as DoanhThuT10, 
	SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/11' Then TongTien Else 0 END) as DoanhThuT11, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/12' Then TongTien Else 0 END) as DoanhThuT12 
		FROM tblLichSuPhieu a 
		where a.DangNgoi = 0 and a.PhieuHuy = 0 and a.DaTinhTien = 1";
	try
	{
		$result_dt = sqlsrv_query( $conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
		if($result_dt != false)
		{
			for ($i = 0; $i < sqlsrv_num_rows($result_dt); $i++)
			{
				$r1 = sqlsrv_fetch_array($result_dt, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
				$r1['DoanhThuT1'];
				$r1['DoanhThuT2'];
				$r1['DoanhThuT3'];
				$r1['DoanhThuT4'];
				$r1['DoanhThuT5'];
				$r1['DoanhThuT6'];
				$r1['DoanhThuT7'];
				$r1['DoanhThuT8'];
				$r1['DoanhThuT9'];
				$r1['DoanhThuT10'];
				$r1['DoanhThuT11'];
				$r1['DoanhThuT12'];
			}
			
			$doanhthu_t1 = $r1['DoanhThuT1'];
			$doanhthu_t2 = $r1['DoanhThuT2'];
			$doanhthu_t3 = $r1['DoanhThuT3'];
			$doanhthu_t4 = $r1['DoanhThuT4'];
			$doanhthu_t5 = $r1['DoanhThuT5'];
			$doanhthu_t6 = $r1['DoanhThuT6'];
			$doanhthu_t7 = $r1['DoanhThuT7'];
			$doanhthu_t8 = $r1['DoanhThuT8'];
			$doanhthu_t9 = $r1['DoanhThuT9'];
			$doanhthu_t10 = $r1['DoanhThuT10'];
			$doanhthu_t11 = $r1['DoanhThuT11'];
			$doanhthu_t12 = $r1['DoanhThuT12'];
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
?>
 <h3 class="title">BIỂU ĐỒ DOANH THU</h3>
 <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<canvas id="daily-revenue" ></canvas>
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
  	this.classList.toggle("active");
  	var dropdownContent = this.nextElementSibling;
  	if (dropdownContent.style.display === "block") {
  		dropdownContent.style.display = "none";
  	} else {
  		dropdownContent.style.display = "block";
  	}
  });
}

dropdown[0].click();

</script>
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>

<script>
//var ctx = document.getElementById('myChart').getContext('2d');
const CHART2 = document.getElementById('daily-revenue');
var speedData = {
  labels: ["01", "02", "03", "04", "05", "06","07"],
  datasets: [{
    label: "Car Speed",
    data: [20, 59, 75, 20, 20, 55,97],
    fill: false,
    // cubicInterpolationMode : 'monotone',
    lineTension: 0,
    borderColor: 'rgb(51, 153, 255)',
    backgroundColor: 'rgb(51, 153, 255)',
    pointBorderColor: 'rgb(255, 102, 0)',
    pointBackgroundColor: 'rgb(255, 102, 0)',
    pointRadius: 5,
    pointHoverRadius: 5,
    pointHitRadius: 30,
    pointBorderWidth: 2,
    pointStyle: 'rectRounded'
  }]
};
 
var chartOptions = {
  legend: {
    display: true,
    position: 'top',
    labels: {
      boxWidth: 80,
      fontColor: 'black'
    }
  },
  scales: {
    yAxes: [{
        ticks: {
            beginAtZero: true
        }
       
    }]},
    xAxes: [{

        gridLines:{
           
            offsetGridLines: true
        }
      }]
   ,
};

var lineChart = new Chart(CHART2, {
    type: 'line',
    data: speedData,
    options: chartOptions
});
console.log(Chart.defaults.global.legend);

$('#tungay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
$('#denngay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
</script>
</body>
</html>
