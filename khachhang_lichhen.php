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
<title>Giải pháp quản lý Spa, Clinic - ZinSpa</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="Phần mềm quản lý spa, clinic - ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->

<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<link href="images/favicon-zintech.png" rel='icon' type='image/x-icon' />	
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
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
	//
	//
	//
	$sokhachdathen = 0; $sokhachden = 0; $doanhthukhachden = 0;
	//
	//-------khach moi đặt lịch hẹn: láy theo ngày booking----------//
	// so khach hen, so khach den
	//
	$sql="SELECT Count(*) as SoKhachDatHen FROM tblKhachHangBooking a Where 1 = 1";
	//
	//----loc theo ngay-----//
	if($tungay_converted != "")
	{
		$sql = $sql . "	and Convert(varchar,isnull(GioBatDau,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql = $sql . " and Convert(varchar,isnull(GioBatDau,getdate()),111) <= '$denngay_converted'";
	}

	try
	{
		$result_dathen = $dbCon->query($sql);
		if($result_dathen != false)
		{
			foreach ($result_dathen as $r1)
			{
				$sokhachdathen = $r1['SoKhachDatHen'];
			}
		} 
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
	//
	//-------end if khach dat hen -----------------------//
	//
	//-------khach den ----------------------------------//
	//
	$sql="SELECT Count(*) as SoKhachDen, DoanhThu FROM tblKhachHangBooking a left join (Select MaKhachHang, MaBooking, Sum(ISNULL(TongTien,0)) as DoanhThu from tblLichSuPhieu Group by MaKhachHang, MaBooking) b On a.MaBooking = b.MaBooking Or a.MaKH = b.MaKhachHang Where 1 = 1";

	//
	//----loc theo ngay-----//
	if($tungay_converted != "")
	{
		$sql = $sql . "	and Convert(varchar,isnull(GioBatDau,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql = $sql . " and Convert(varchar,isnull(GioBatDau,getdate()),111) <= '$denngay_converted'";
	}

	try
	{
		$result_khden = $dbCon->query($sql);
		if($result_khden != false)
		{
			foreach ($result_khden as $r1)
			{
				$sokhachden = $r1['SoKhachDen'];
				$doanhthukhachden = $r1['DoanhThu'];
			}
		} 
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
	//--------end if khach cu --------------------//
?>
	 <h3 class="title">TỔNG HỢP LỊCH HẸN</h3>
     <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th>Số đặt hẹn</th>
								<th>Số khách đến</th>
								<th>Doanh thu</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo number_format($sokhachdathen,0);?></td>
								<td><?php echo number_format($sokhachden,0);?></td>
								<td><?php echo number_format($doanhthukhachden,0);?></td>
							</tr>
						</tbody>
					</table>
				</div>
	</div>
     <h3 class="title">DANH SÁCH KHÁCH ĐẶT HẸN</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Giờ hẹn</th>
		  <th>Mã Booking</th>
		  <th>Tên</th>
		  <th>Điện thoại</th>
		  <th>SL</th>
		  <th>Dịch vụ</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	//
	//-------danh sách khach đặt hẹn: láy theo ngày quan hệ----------//
	//
	$sql1="SELECT Convert(varchar,a.GioBatDau,120) as GioHen, a.MaBooking, a.TenKH, a.DienThoai, a.SoLuong, a.DichVu FROM tblKhachHangBooking a Where 1 = 1";
	
	//----loc theo ngay-----//
	if($tungay_converted != "")
	{
		$sql1 = $sql1 . "	and Convert(varchar,isnull(GioBatDau,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql1 = $sql1 . " and Convert(varchar,isnull(GioBatDau,getdate()),111) <= '$denngay_converted'";
	}
		
	try
	{
		$result_khdathen = $dbCon->query($sql1);
		if($result_khdathen != false)
		{
			foreach ($result_khdathen as $r2)
			{
?>      
        <tr class="success">
		  <td><?php echo $r2['GioHen'];?></td>
		  <td><?php echo $r2['MaBooking'];?></td>
          <td><?php echo $r2['TenKH'];?></td>
          <td><?php echo $r2['DienThoai'];?></td>
          <td><?php echo $r2['SoLuong'];?></td>
          <td><?php echo $r2['DichVu'];?></td>
        </tr>
<?php 		}
		}
	}
	catch (PDOException $e1) {
		echo $e1->getMessage();
	}  
?>
      </tbody>
    </table>
   </div>
	
	<h3 class="title">DANH SÁCH KHÁCH ĐẾN</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Giờ hẹn</th>
		  <th>Mã Booking</th>
		  <th>Tên</th>
		  <th>Điện thoại</th>
		  <th>SL</th>
		  <th>Dịch vụ</th>
          <th>Doanh thu</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	//
	//-------khach den ----------------------------------//
	//
	$sql2="SELECT Convert(varchar,a.GioBatDau,120) as GioHen, a.MaBooking, a.TenKH, a.DienThoai, a.SoLuong, a.DichVu, DoanhThu FROM tblKhachHangBooking a left join (Select MaKhachHang, MaBooking, Sum(ISNULL(TongTien,0)) as DoanhThu from tblLichSuPhieu Group by MaKhachHang, MaBooking) b On a.MaBooking = b.MaBooking Or a.MaKH = b.MaKhachHang Where 1 = 1";
	//
	//
	//----loc theo ngay-----//
	//
	if($tungay_converted != "")
	{
		$sql2 = $sql2 . "	and Convert(varchar,isnull(a.GioBatDau,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(a.GioBatDau,getdate()),111) <= '$denngay_converted'";
	}
	
	try
	{
		$result_khcu = $dbCon->query($sql2);
		if($result_khcu != false)
		{
			foreach ($result_khcu as $r3)
			{
	?>      
        <tr class="success">
		  <td><?php echo $r3['GioHen'];?></td>
		  <td><?php echo $r3['MaBooking'];?></td>
          <td><?php echo $r3['TenKH'];?></td>
          <td><?php echo $r3['DienThoai'];?></td>
          <td><?php echo $r3['SoLuong'];?></td>
          <td><?php echo $r3['DichVu'];?></td>
          <td><?php echo $r3['DoanhThu'];?></td>
        </tr>
<?php 
			}
		}
	}
	catch (PDOException $e3) {
		echo $e3->getMessage();
	} 
?>
      </tbody>
    </table>
   </div>
<!-- END SECTION  DOANH THU KHÁCH CŨ-->  
  </div>
   </div>
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
