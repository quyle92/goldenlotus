
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

$dropmenu = -1;
$dropmenu = @$_GET['dropmenu'];
echo $dropmenu;
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý Spa, Clinic - ZinSpa</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa ZinSpa" />
<script type="application/x-javascript"> 
addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
function hideURLbar(){ window.scrollTo(0,1); } 
</script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />

<link href="css/font-awesome.css" rel="stylesheet"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
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
  padding-left: 12px;
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
		$result_tt = $dbCon->query($sql);
		if($result_tt != false)
		{
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
	
	$sql="SELECT ISNULL(SUM(a.TongTien),0) as TongTien, ISNULL(SUM(a.TienThucTra),0) as TienThucTra, ISNULL(SUM(a.TienGiamGia),0) as TienGiamGia, ISNULL(Sum(b.SoTienConThieu),0) as TienKhachNo   
		FROM tblLichSuPhieu a 
		LEFT JOIN tblKhachHangThieuNo b ON a.MaLichSuPhieu = b.MaLichSuPhieu AND ISNULL(b.DaTra,0) = 0 
		where a.DangNgoi = 0 and a.PhieuHuy = 0 and a.DaTinhTien = 1";
	//
	//----loc theo ngay-----//
	if($tungay_converted != "")
	{
		$sql = $sql . "	and Convert(varchar,isnull(GioVao,getdate()),111) >= '$tungay_converted'"; //format: yyyy/MM/dd
	}
	
	if($denngay_converted != "")
	{
		$sql = $sql . " and Convert(varchar,isnull(GioVao,getdate()),111) <= '$denngay_converted'";
	}

	$tiendichvu = 0; $tiengiamgia = 0; $tienthuctra = 0; $tienkhachno = 0;
	try
	{
		//lay ket qua query tong gia tri the
		$result_dt = $dbCon->query($sql);
		if($result_dt != false)
		{
			//show the results
			foreach ($result_dt as $r1)
			{
				$r1['TongTien'];
				$r1['TienGiamGia'];
				$r1['TienThucTra'];
				$r1['TienKhachNo'];
			}
			
			$tiendichvu = $r1['TongTien'];
			$tiengiamgia = $r1['TienGiamGia'];
			$tienthuctra = $r1['TienThucTra'];
			$tienkhachno = $r1['TienKhachNo'];
		} 
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
	//
	//---doanh thu the lieu trinh
	//
	$doanhthu_thelieutrinh = 0; $doanhthu_khachle = 0;
	$sql="SELECT ISNULL(SUM(a.TongTien),0) as TongTien FROM tblLichSuPhieu a 
		where a.DangNgoi = 0 and a.PhieuHuy = 0 and a.DaTinhTien = 1 and (ISNULL(a.IsBanTheGhiNoDV,0) = 1 Or ISNULL(a.IsBanTheGhiNoTT,0) = 1)";
	if($tungay_converted != "")
	{
		$sql = $sql . "	and Convert(varchar,isnull(GioVao,getdate()),111) >= '$tungay_converted'"; 
	}
	
	if($denngay_converted != "")
	{
		$sql = $sql . " and Convert(varchar,isnull(GioVao,getdate()),111) <= '$denngay_converted'";
	}
	try
	{
		$result_dt = $dbCon->query($sql);
		if($result_dt != false)
		{
			foreach ($result_dt as $r1)
			{
				$r1['TongTien'];
			}
			
			$doanhthu_thelieutrinh = $r1['TongTien'];
		} 
	}
	catch (PDOException $e) {
		echo $e->getMessage();
	}
	$doanhthu_khachle = $tiendichvu - $doanhthu_thelieutrinh;
	//
	//
	//
	$sql = "Select SUM(CASE WHEN LoaiPhieu like 'TN' or LoaiPhieu like 'TKN' Then TongTien Else 0 END) as ThuKhachNo,
		SUM(CASE WHEN LoaiPhieu not like 'TN' and LoaiPhieu not like 'TKN' and LoaiPhieu like 'T%' Then TongTien Else 0 END) as ThuKhac, 
		SUM(CASE WHEN LoaiPhieu like 'CHH' Then TongTien Else 0 END) as ChiHoaHongNhanVien,
		SUM(CASE WHEN LoaiPhieu not like 'CHK' and LoaiPhieu like 'C%' Then TongTien Else 0 END) as ChiKhac, 
		SUM(CASE WHEN LoaiPhieu like 'CHK' Then TongTien Else 0 END) as ChiChuyenKhoan 
		from tblPhieuThuChi";
	
	//----loc theo ngay-----//
	if($tungay_converted != "")
	{
		$sql = $sql . "	and Convert(varchar,isnull(NgayLap,getdate()),111) >= '$tungay_converted'"; //format: yyyy/MM/dd
	}
	
	if($denngay_converted != "")
	{
		$sql = $sql . " and Convert(varchar,isnull(NgayLap,getdate()),111) <= '$denngay_converted'";
	}
		
	$tienmat = 0; $thukhachno = 0; $thukhac = 0; $chikhac = 0; $chichuyenkhoan = 0; $chihoahongnhanvien = 0;

	try
	{
		//lay ket qua query tong gia tri the
		$result_dt = $dbCon->query($sql);
		if($result_dt != false)
		{
			//show the results
			foreach ($result_dt as $r1)
			{
				$r1['ThuKhachNo'];
				$r1['ThuKhac'];
				$r1['ChiKhac'];
				$r1['ChiChuyenKhoan'];
				$r1['ChiHoaHongNhanVien'];
			}
			
				$thukhachno = $r1['ThuKhachNo'];
				$thukhac = $r1['ThuKhac'];
				$chikhac = $r1['ChiKhac'];
				$chichuyenkhoan = $r1['ChiChuyenKhoan'];
				$chihoahongnhanvien = $r1['ChiHoaHongNhanVien'];
		} 
	}
	catch (PDOException $e) {

		//loi ket noi db -> show exception
		echo $e->getMessage();
	}
	
	$tienmat = $tienthuctra + $thukhachno + $thukhac - $chikhac;
?>
	<h3 class="title">DOANH THU TỔNG HỢP</h3>
     <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
				<div class="panel-body no-padding">
					<table class="table table-striped">
						<thead>
							<tr class="warning">
								<th></th>
								<th>Item</th>
								<th>Thu</th>
								<th>Chi</th>
							</tr>
						</thead>
						<tbody>
							<tr class="h3 tienmat">
								<td></td><td>Doanh thu</td><td><?php echo number_format( $tiendichvu,0);?></td><td></td>
							</tr>
							<tr>
								<td></td><td>+ Doanh thu liệu trình</td><td><?php echo number_format( $doanhthu_thelieutrinh,0);?></td><td></td>
							</tr>
							<tr>
								<td></td><td>+ Doanh thu khách lẻ</td><td><?php echo number_format( $doanhthu_khachle,0);?></td><td></td>
							</tr>
							<tr>
								<td></td><td>Thu khách nợ</td><td><?php echo number_format( $thukhachno,0);?></td><td></td>
							</tr>
							<tr>
								<td></td><td>Giảm giá</td><td></td><td><?php echo number_format( $tiengiamgia,0);?></td>
							</tr>
							<tr>
								<td></td><td>Tiền khách nợ</td><td></td><td><?php echo number_format( $tienkhachno,0);?></td>
							</tr>
							<tr>
								<td></td><td>Hoa hồng nhân viên</td><td></td><td><?php echo number_format( $chihoahongnhanvien,0);?></td>
							</tr>
						</tbody>
					</table>
				</div>
	</div>
	<h3 class="title">CHI TIẾT PHIẾU</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã Bill</th>
		  <th>Thời gian</th>
          <th>Giường</th>
		  <th>Tổng tiền (VNĐ)</th>
          <th>Giảm giá</th>
          <th>Thực thu(VNĐ)</th>
          <th>Ghi chú</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	$sql2="select MaLichSuPhieu, GioVao, isnull(GioTra,ThoiGianDongPhieu) as GioTra, MaBan, TongTien,TienGiamGia,TienThucTra,GhiChu from tblLichSuPhieu
		where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1";
	//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) <= '$denngay_converted'";
	}
	try
	{
		//lay ket qua query chi tiet nap tien vao the
		$result_hd = $dbCon->query($sql2);
		if($result_hd != false)
		{
			//show the results
			foreach ($result_hd as $r2)
			{
	?>      
        <tr class="success">
			<td><?php echo $r2['MaLichSuPhieu'];?></td>
          <td><?php echo date_format($r2['GioVao'],'d-m-Y H:i:s');?></td>
          <td><?php echo $r2['MaBan'];?></td>
          <td><?php echo number_format($r2['TongTien'],0);?></td>
          <td><?php echo number_format($r2['TienGiamGia'],0);?></td>
          <td><?php echo number_format($r2['TienThucTra'],0);?></td>
          <td><?php echo $r2['GhiChu'];?></td>
        </tr>
<?php 		
			}
		}
	}
	catch (PDOException $e1) {

		//loi ket noi db -> show exception
		echo $e1->getMessage();
	} 
	?>
      </tbody>
    </table>
   </div>
   <p></p>
     <h3 class="title">CHI TIẾT DỊCH VỤ</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Dịch vụ</th>
		  <th>Số lượng</th>
          <th>Thành Tiền</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	$sql3="select TenHangBan, SUM(SoLuong) as SoLuong, SUM(ThanhTien) as ThanhTien from tblLSPhieu_HangBan 
		where MaLichSuPhieu in (Select MaLichSuPhieu from tblLichSuPhieu where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1"; 
	
	if($tungay_converted != "")
	{
		$sql3 = $sql3 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql3 = $sql3 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) <= '$denngay_converted'";
	}
	//----loc theo quay -----//
	//if($maquay != "")
	//	$sql3 = $sql3 . " and MaKhu in (Select MaKhu from tblDMKhu where MaQuay like '$maquay')";
		
	$sql3 = $sql3 . ")"; // close sub query
	
	$sql3 = $sql3 . " group by TenHangBan order by SoLuong desc";
try
	{
		//lay ket qua query chi tiet dv
		$result_dv = $dbCon->query($sql3);
		if($result_dv != false)
		{
			//show the results
			foreach ($result_dv as $r3)
			{
	?>      
        <tr class="success">
			<td><?php echo $r3['TenHangBan'];?></td>
          <td><?php echo number_format($r3['SoLuong'],0);?></td>
          <td><?php echo number_format($r3['ThanhTien'],0);?></td>
        </tr>
<?php 
			} 
		}
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
 
   </div>
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
<!-- Nav CSS -->
<link href="css/custom.css" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" />
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
</script>
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
