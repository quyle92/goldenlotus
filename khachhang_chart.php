
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
<title>Giải pháp quản lý Spa, Clinic - ZinSpa</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<link href="css/custom.css" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" />
 <script>
	$('#tungay').datepicker({
		dateFormat:'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		yearRange:'-99:+0',
	})
	 
	$('#denngay').datepicker({
		dateFormat:'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		yearRange:'-99:+0',
	})

</script>   
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
/*--new menu 19042020 ---*/
.li-level1
{
  padding: 8px 8px 8px 5px;
}

.menu-level1 {
  font-size: 14px;
  color: #818181;
}

.menu-level1:hover {
  color: #f1f1f1;
}

.menu-level2 {
  padding: 8px 8px 8px 15px;
  font-size: 14px;
  color: #818181;
}

.menu-level2:hover {
  color: #f1f1f1;
}

.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 8px 8px 8px 5px; /*top right bottom left*/
  text-decoration: none;
  font-size: 14px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  background-color: green;
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 15px;
  line-height: 2em;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 12px;}
}

/*-----end style new menu 19042020*/
</style>
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
		$result_tt = $dbCon->query($sql);
		if($result_tt != false)
		{
			//show the results
			foreach ($result_tt as $r)
			{
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
	$slkhach_t1 = 0; $slkhach_t2 = 0; $slkhach_t3 = 0; $slkhach_t4 = 0; $slkhach_t5 = 0; $slkhach_t6 = 0;
	$slkhach_t7 = 0; $slkhach_t8 = 0; $slkhach_t9 = 0; $slkhach_t10 = 0; $slkhach_t11 = 0; 
	$slkhach_t12 = 0;
	//
	//---thang
	//
	$sql="SELECT SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) like '".substr($tungay,6)."/01' Then 1 Else 0 END) as SLKhachT1, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/02' Then 1 Else 0 END) as SLKhachT2, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/03' Then 1 Else 0 END) as SLKhachT3, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/04' Then 1 Else 0 END) as SLKhachT4, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/05' Then 1 Else 0 END) as SLKhachT5, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/06' Then 1 Else 0 END) as SLKhachT6, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/07' Then 1 Else 0 END) as SLKhachT7, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/08' Then 1 Else 0 END) as SLKhachT8, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/09' Then 1 Else 0 END) as SLKhachT9, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/10' Then 1 Else 0 END) as SLKhachT10, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/11' Then 1 Else 0 END) as SLKhachT11, 
SUM(CASE WHEN substring(Convert(varchar,ISNULL(NgayQuanHe,getdate()),111),0,8) = '".substr($tungay,6)."/12' Then 1 Else 0 END) as SLKhachT12 
		FROM tblDMKHNCC a";
	try
	{
		$result_kh = $dbCon->query($sql);
		if($result_kh != false)
		{
			foreach ($result_kh as $r1)
			{
				$r1['SLKhachT1'];
				$r1['SLKhachT2'];
				$r1['SLKhachT3'];
				$r1['SLKhachT4'];
				$r1['SLKhachT5'];
				$r1['SLKhachT6'];
				$r1['SLKhachT7'];
				$r1['SLKhachT8'];
				$r1['SLKhachT9'];
				$r1['SLKhachT10'];
				$r1['SLKhachT11'];
				$r1['SLKhachT12'];
			}
			
			$slkhach_t1 = $r1['SLKhachT1'];
			$slkhach_t2 = $r1['SLKhachT2'];
			$slkhach_t3 = $r1['SLKhachT3'];
			$slkhach_t4 = $r1['SLKhachT4'];
			$slkhach_t5 = $r1['SLKhachT5'];
			$slkhach_t6 = $r1['SLKhachT6'];
			$slkhach_t7 = $r1['SLKhachT7'];
			$slkhach_t8 = $r1['SLKhachT8'];
			$slkhach_t9 = $r1['SLKhachT9'];
			$slkhach_t10 = $r1['SLKhachT10'];
			$slkhach_t11 = $r1['SLKhachT11'];
			$slkhach_t12 = $r1['SLKhachT12'];
		}
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
?>
 <h3 class="title">BIỂU ĐỒ KHÁCH HÀNG</h3>
 <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
<div id="chart_div2"></div>
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic2);

function drawBasic2() {

      var data2 = new google.visualization.DataTable();
      data2.addColumn('string', 'Thang');
      data2.addColumn('number', 'Khách hàng');

      data2.addRows([
        [{v: 'Tháng 1'}, parseInt('<?php echo $slkhach_t1; ?>')],
        [{v: 'Tháng 2'}, parseInt('<?php echo $slkhach_t2; ?>')],
        [{v: 'Tháng 3'}, parseInt('<?php echo $slkhach_t3; ?>')],
        [{v: 'Tháng 4'}, parseInt('<?php echo $slkhach_t4; ?>')],
        [{v: 'Tháng 5'}, parseInt('<?php echo $slkhach_t5; ?>')],
        [{v: 'Tháng 6'}, parseInt('<?php echo $slkhach_t6; ?>')],
        [{v: 'Tháng 7'}, parseInt('<?php echo $slkhach_t7; ?>')],
        [{v: 'Tháng 8'}, parseInt('<?php echo $slkhach_t8; ?>')],
        [{v: 'Tháng 9'}, parseInt('<?php echo $slkhach_t9; ?>')],
        [{v: 'Tháng 10'}, parseInt('<?php echo $slkhach_t10; ?>')],
        [{v: 'Tháng 11'}, parseInt('<?php echo $slkhach_t11; ?>')],
        [{v: 'Tháng 12'}, parseInt('<?php echo $slkhach_t12; ?>')]
      ]);

      var options2 = {
        title: 'Khách hàng',
          hAxis: {
          title: 'Tháng',
          viewWindow: {
            min: [0],
            max: [12]
          }
        },
        vAxis: {
          title: 'Khách hàng'
        }
      };

      var chart2 = new google.visualization.ColumnChart(
        document.getElementById('chart_div2'));

      chart2.draw(data2, options2);
    }
</script>
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

dropdown[1].click();

</script>
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
</body>
</html>
