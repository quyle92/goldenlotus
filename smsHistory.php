
<?php
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$trungtam=$_SESSION['TenTrungTam'];
$smsbrandname=$_SESSION['SMSBrandName'];

$makhachhang = "";

$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];

if($tungay == "")
{
	$tungay = date('d-m-Y');
}
if($denngay == "")
{
	$denngay = date('d-m-Y');
}
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
</head>
<body>
<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"><?php echo $trungtam; ?></a>
            </div>
            <!-- /.navbar-header -->
            
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="chart_doanhthu.php"><i class="fa fa-signal nav_icon"></i>Biểu đồ phát triển<span class="fa arrow"></span></a> 
                        </li>
                        <li>
                            <a href="home.php"><i class="fa fa-signal nav_icon"></i>Doanh thu chi tiết<span class="fa arrow"></span></a> 
                        </li>
                        <li>
                            <a href="khachhang.php"><i class="fa fa-signal nav_icon"></i>Báo cáo khách hàng<span class="fa arrow"></span></a> 
                        </li>
                        <li>
                            <a href="khachhang.php"><i class="fa fa-signal nav_icon"></i>Báo cáo lịch hẹn<span class="fa arrow"></span></a> 
                        </li>
						<li>
                            <a href="smsApi.php"><i class="fa fa-gear nav_icon"></i>Cấu hình SMS Api<span class="fa arrow"></span></a>  
                        </li>
						<li>
                            <a href="smsAccount.php"><i class="fa fa-archive nav_icon"></i>Tài khoản SMS<span class="fa arrow"></span></a>  
                        </li>
						<li>
                            <a href="smsHistory.php"><i class="fa fa-table nav_icon"></i>Lịch sử gửi SMS<span class="fa arrow"></span></a>  
                        </li>
                        <li>
                            <a href="account.php"><i class="fa fa-user fa-fw nav_icon"></i>Đổi mật khẩu<span class="fa arrow"></span></a>    
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-sign-out nav_icon"></i>Đăng xuất<span class="fa arrow"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
           
        </nav>
       	<div id="page-wrapper">
       	<div class="col-md-12 graphs">
	   	<div class="xs">
	   	<h4>BẠN ĐANG ĐĂNG NHẬP VỚI QUYỀN - <?php echo $ten; ?> </h4>
		<form action="" method="post">
		<div class="row">
			<div class="col-md-2" style="margin-bottom:5px"></div>
			<div class="col-md-3" style="margin-bottom:5px"></div>
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
	// convert to japan date format to filter data
	$tungay_converted = "";
	$denngay_converted = "";
	if($tungay != "")
	{
		$tungay_converted = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);
	}
	
	if($denngay != "")
	{
		$denngay_converted = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);
	}
?>
		<h3 class="title">LỊCH SỬ GỬI SMS LỊCH HẸN</h3>
     		<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th>Mã booking</th>
								<th>Tên KH</th>
								<th>Điện thoại</th>
								<th>Ngày gửi</th>
								<th>Nội dung</th>
							</tr>
						</thead>
						<tbody>
<?php 		
	$sql1="select * from tblKhachHangBooking_GuiSMS Where KetQuaSMS <> '' and KetQuaSMS is not null"; 
	
	if($tungay_converted != "")
	{
		$sql1 = $sql1 . " and Convert(varchar,isnull(NgayGuiSMS,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql1 = $sql1 . " and Convert(varchar,isnull(NgayGuiSMS,getdate()),111) <= '$denngay_converted'";
	}
	
	$sql1 = $sql1." Order by NgayGuiSMS";

	try
	{
		$result_bk = $dbCon->query($sql1);
		if($result_bk != false)
		{
			//show the results
			foreach ($result_bk as $r1)
			{
	?>      
							<tr class="success">
								<td><?php echo $r1['MaBooking'];?></td>
								<td><?php echo $r1['TenKH'];?></td>
								<td><?php echo $r1['DienThoai'];?></td>
								<td><?php echo $r1['NgayGuiSMS'];?></td>
								<td><?php echo $r1['NoiDungSMS'];?></td>
							</tr>
<?php 
			}//end foreach
		}//end if result
	}
	catch (PDOException $e2) {

		//loi ket noi db -> show exception
		echo $e2->getMessage();
	}  
?>						</tbody>
					</table>
				</div>
			</div>	
		<!-- /#panel -->
		<p></p>
		<h3 class="title">LỊCH SỬ GỬI SMS GỬI SINH NHẬT</h3>
     		<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th>Mã</th>
								<th>Tên KH</th>
								<th>Điện thoại</th>
								<th>Sinh nhật</th>
								<th>Ngày gửi</th>
								<th>Nội dung</th>
							</tr>
						</thead>
						<tbody>
<?php 		
	$sql1="select a.* from tblKhachHang_GuiSMS a Where KetQuaSMS <> '' and KetQuaSMS is not null"; 
	
	$sql1 = $sql1. " Order by NgayGuiSMS";

	try
	{
		$result_nt = $dbCon->query($sql1);
		if($result_nt != false)
		{
			//show the results
			foreach ($result_nt as $r1)
			{
	?>      
							<tr class="success">
								<td><?php echo $r1['MaKH'];?></td>
								<td><?php echo $r1['TenKH'];?></td>
								<td><?php echo $r1['DienThoai'];?></td>
								<td><?php echo $r1['NgaySinh'];?></td>
								<td><?php echo $r1['NgayGuiSMS'];?></td>
								<td><?php echo $r1['NoiDungSMS'];?></td>
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
		<h3 class="title">LỊCH SỬ GỬI SMS CẢM ƠN KHÁCH HÀNG</h3>
     		<div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th>Mã Bill</th>
								<th>Tên KH</th>
								<th>Điện thoại</th>
								<th>Ngày gửi</th>
								<th>Nội dung</th>
							</tr>
						</thead>
						<tbody>
<?php 		
	$sql1="select a.* from tblLSPhieu_GuiSMS a Where IsDaGuiSMS = 1 and KetQuaSMS <> '' and KetQuaSMS is not null"; 
	
	$sql1 = $sql1. " Order by NgayGuiSMS";

	try
	{
		$result_nt = $dbCon->query($sql1);
		if($result_nt != false)
		{
			//show the results
			foreach ($result_nt as $r1)
			{
	?>      
							<tr class="success">
								<td><?php echo $r1['MaLichSuPhieu'];?></td>
								<td><?php echo $r1['TenKH'];?></td>
								<td><?php echo $r1['DienThoai'];?></td>
								<td><?php echo $r1['NgayGuiSMS'];?></td>
								<td><?php echo $r1['NoiDungSMS'];?></td>
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
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
</body>
</html>
