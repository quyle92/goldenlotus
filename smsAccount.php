
<?php
require('lib/db.php');
require('functions/sms.php');

@session_start();
$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];
$smsbrandname=$_SESSION['SMSBrandName'];
//
//	lấy thông số để lay so du
//
$apikey = "";
$secretkey = "";

$sql = "Select * from tblDMTrungTam Where MaTrungTam = '$matrungtam'";
$result_sms = $dbCon->query($sql);
if($result_sms != false)
{
	foreach ($result_sms as $r)
	{
		$apikey = $r['SMSApi'];
		$secretkey = $r['SecretKey'];
	}
}

$makhachhang = "";
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý Spa - ZinSpa</title>
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
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
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
		<div class="row">
			<div class="col-md-2" style="margin-bottom:5px"></div>
			<div class="col-md-3" style="margin-bottom:5px"></div>
			<div class="col-md-3" style="margin-bottom:5px"></div>
			<div class="col-md-2" style="margin-bottom:5px"></div>
	 	</div>
     	<div class="row">
          	<div class="col-md-2" style="margin-bottom:5px"></div>
            <div class="col-md-3" style="margin-bottom:5px"></div>
            <div class="col-md-2" style="margin-bottom:5px"></div>
            <div class="col-md-3" style="margin-bottom:5px"></div>
            <div class="col-md-2" style="margin-bottom:5px"></div>
		</div>
<?php 	
	$sql="SELECT * FROM tblKhachHang_DichVu Where BrandName = '$smsbrandname' and Convert(varchar(20),ThoiGianApDung,120) <= Convert(varchar(20),Getdate(),120)";

	try
	{
		//lay ma kh
		$result_sms = $dbConSMS->query($sql);
		if($result_sms != false)
		{
			foreach ($result_sms as $r1)
			{
				$r1['MaKH'];
			}
			
			$makhachhang = $r1['MaKH'];
//			echo $makhachhang;
		} 
	}
	catch (PDOException $e) {

		//loi ket noi db -> show exception
		echo $e->getMessage();
	}
	//
	//		lay tien con lai tu eSMS
	//
	$tongtien = 0; $tiendasudung = 0; $tienconlai = 0;
	$result = "";	
	try
	{
		if($apikey != "" && $secretkey != "")
		{
			GetBalance_eSMS($apikey,$secretkey,$result);
			if($result != "")
			{
				$balance_str = json_decode($result);
				$tienconlai = $balance_str->Balance;
				
				if($tienconlai >= 0)
				{
					$sql = "Update tblKhachHang_TaiKhoanSMS Set TienConLai = '$tienconlai', TienDaSuDung = TongTien - '$tienconlai' where MaKH = '$makhachhang'";
					try
		    		{
						$dbConSMS->query($sql);
					} catch(PDOException $e){}
				}
			}
		}//end if apikey
	}
	catch (Exception $e) 
	{
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
	//
	//		trường hợp có thông tin khách hàng -> hiện tình trạng tài khoản và lịch sử nạp tiền
	//
	$sql = "SELECT * FROM tblKhachHang_TaiKhoanSMS where MaKH = '$makhachhang'";
	try
	{
		$result_tksms = $dbConSMS->query($sql);
		if($result_tksms != false)
		{
			//show the results
			foreach ($result_tksms as $r1)
			{
				$r1['TongTien'];
				$r1['TienDaSuDung'];
				$r1['TienConLai'];
			}
			
			$tongtien = $r1['TongTien'];
			if($tienconlai > 0)
			{
				$tiendasudung = $tongtien - $tienconlai;
			}
			else
			{
				$tiendasudung = $r1['TienDaSuDung'];
				$tienconlai = $r1['TienConLai'];
			}
		} 
	}
	catch (PDOException $e) {

		//loi ket noi db -> show exception
		echo $e->getMessage();
	}
?>
		<h3 class="title">TÀI KHOẢN SMS</h3>
     		<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th></th>
								<th>Tổng tiền (VNĐ)</th>
								<th>Đã sử dụng (VNĐ)</th>
								<th>Còn lại (VNĐ)</th>
							</tr>
						</thead>
						<tbody>
							<tr class="h3 tienmat">
								<td></td>
								<td><?php echo number_format( $tongtien,0);?></td>
								<td><?php echo number_format( $tiendasudung,0);?></td>
								<td><?php echo number_format( $tienconlai,0);?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>	
		<!-- /#panel -->
		<p></p>
		<h3 class="title">LỊCH SỬ THANH TOÁN</h3>
     		<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th>Ngày nạp tiền</th>
								<th>Tổng tiền (VNĐ)</th>
								<th>HTTT</th>
								<th>Gói dịch vụ</th>
								<th>Ghi chú</th>
							</tr>
						</thead>
						<tbody>
<?php 		
	$sql1="select a.*, b.Ten as TenNhomDichVu from tblKhachHang_ThanhToan a, tblNhomDichVu b Where a.MaNhomDichVu = b.Ma and MaKH = '$makhachhang'"; 
	
	try
	{
		$result_nt = $dbConSMS->query($sql1);
		if($result_nt != false)
		{
			//show the results
			foreach ($result_nt as $r1)
			{
	?>      
							<tr class="success">
								<td><?php echo $r1['NgayNapTien'];?></td>
								<td><?php echo number_format($r1['TongTien'],0);?></td>
								<td><?php echo $r1['HinhThucThanhToan'];?></td>
								<td><?php echo $r1['TenNhomDichVu'];?></td>
								<td><?php echo $r1['GhiChu'];?></td>
							</tr>
<?php 
			}//end foreach
		}//end if result
	}
	catch (PDOException $e2) {

		//loi ket noi db -> show exception
		echo $e2->getMessage();
	}  
?>
						</tbody>
					</table>
				</div>
			</div>	
			<!-- /#panel -->
		<p></p>
		
  		</div>
      <!-- /#xs -->
		</div>
      <!-- /#col-md-12 -->
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
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

dropdown[3].click();
</script>
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
</body>
</html>
