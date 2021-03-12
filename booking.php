
<?php
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$trungtam=$_SESSION['TenTrungTam'];
$manhomnhanvien = $_SESSION['NhomNhanVien'];

//echo $nhomquyen;
//
//	xu ly lay gia tri post
//
$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];
$matrungtam = "";
$matrungtam = @$_POST['matrungtam'];
$manhanvien = "";
$manhanvien = @$_POST['nhanvien'];
$manhomkhach = "";
$manhomkhach = @$_POST['manhomkhach'];

if($tungay == "")
{
	//$tungay = date('d-m-Y');
}
if($denngay == "")
{
	//$denngay = date('d-m-Y');
}

$limit = 10;
$start = 1;
$page = 0;
if(isset($_GET['pageid']))
{
	$pageid=$_GET['pageid'] ; 
    $start=($pageid-1)*$limit;
}
else
{
	$pageid=1;
}

//echo $tungay."-".$denngay;
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
            
            <div class="navbar-default" role="navigation">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="booking.php"><i class="fa fa-table nav_icon"></i>Lịch hẹn khách hàng<span class="fa arrow"></span></a>
                        </li>
						<li>
                            <a href="editbooking.php"><i class="fa fa-calendar nav_icon"></i>Thêm lịch hẹn<span class="fa arrow"></span></a>
                        </li>
						<li>
                            <a href="account2.php"><i class="fa fa-user nav_icon"></i>Đổi mật khẩu<span class="fa arrow"></span></a>
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-sign-out fa-fw nav_icon"></i>Đăng xuất<span class="fa arrow"></span></a>
                        </li>
                    </ul>               
            </div>
        </nav>
 <div>
    <div class="col-md-12 graphs">
	   <div class="xs">
	   	<h4>BẠN ĐANG ĐĂNG NHẬP VỚI QUYỀN - <?php echo $ten; ?> </h4>
     	<form name="booking_filter" action="" method="post">
	 	<div class="row">
			<div class="col-md-2" style="margin-bottom:5px">Chi nhánh:</div>
			<div class="col-md-3" style="margin-bottom:5px">
				<select name="matrungtam">
					<option value="all">Tat ca</option>
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
			<div class="col-md-2" style="margin-bottom:5px">Nhóm khách:</div>
			<div class="col-md-3" style="margin-bottom:5px">
				<select name="manhomkhach">
					<option value="all">Tat ca</option>
<?php 
	$sql="SELECT * FROM tblDMNhomKH";
	try
	{
		//lay ket qua query tong gia tri the
		$result_nkh = $dbCon->query($sql);
		if($result_nkh != false)
		{
			//show the results
			foreach ($result_nkh as $r)
			{
?>
			<?php if($manhomkhach == $r['Ma'])
				{
			 ?>
		 			<option value="<?php echo $r['Ma'];?>" selected="selected"><?php echo $r['Ten'];?></option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $r['Ma'];?>"><?php echo $r['Ten'];?></option>
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
			<div class="col-md-2" style="margin-bottom:5px"></div>
	 </div>
     <div class="row">
          	<div class="col-md-2" style="margin-bottom:5px">Từ ngày:</div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?php if($tungay != "") echo @$tungay; else echo date('d-m-Y'); ?>" id="tungay" /></div>
            <div class="col-md-2" style="margin-bottom:5px">Đến ngày: </div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="denngay" type="text"  value="<?php if($denngay != "") echo @$denngay; else echo date('d-m-Y'); ?>" id="denngay" /></div>
            <div class="col-md-2" style="margin-bottom:5px"></div>
	</div>
	<div class="row">
          	<div class="col-md-2" style="margin-bottom:5px">NV đặt lịch:</div>
            <div class="col-md-3" style="margin-bottom:5px">
			<select name="nhanvien">
					<option value="all">Tat ca</option>
<?php
	$sqlnv="SELECT * FROM tblDMNhanVien where DaNghiViec = 0";
	try
	{
		//lay ket qua query nhân viên
		$result_nv = $dbCon->query($sqlnv);
		if($result_nv != false)
		{
			//show the results
			foreach ($result_nv as $rnv)
			{
?>
			<?php if($manhanvien == $rnv['MaNV'])
				{
			 ?>
		 			<option value="<?php echo $rnv['MaNV'];?>" selected="selected"><?php echo $rnv['TenNV'];?></option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $rnv['MaNV'];?>"><?php echo $rnv['TenNV'];?></option>
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
				</select></div>
            <div class="col-md-2" style="margin-bottom:5px"></div>
            <div class="col-md-3" style="margin-bottom:5px"></div>
<?php
//	thống kê số lượng
$sql2="select count(*) as Total from tblKhachHangBooking a 
		left join tblDMNhanVien b on a.MaBacSi = b.MaNV 
		left join tblDMNhanVien c on a.MaNV = c.MaNV 
		left join tblDMNhomKH e on a.MaNhomKH = e.Ma 
		left join tblDMTrungTam d on a.MaTrungTam = d.MaTrungTam Where 1=1"; 
		
	//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,GioBatDau,111) >= '$tungay_converted'";
	}
	
	if($denngay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,GioBatDau,111) <= '$denngay_converted'";
	}
	//
	//----loc theo trung tam -----//
	if($matrungtam != "" && $matrungtam != "all")
		$sql2 = $sql2 . " and a.MaTrungTam like '$matrungtam'";
			
	//----loc theo nguon khach -----//
	if($manhomkhach != "" && $manhomkhach != "all")
		$sql2 = $sql2 . " and a.MaNhomKH = '$manhomkhach'";
	
	if($manhanvien != "" && $manhanvien != "all")	//	CHO PHÉP QUẢN LÝ LỌC THEO MÃ NHÂN VIÊN
	{
		$sql2 = $sql2 . " and a.MaNV like '$manhanvien'";
	}
	
	$total = 0;
	try
	{
		//lay ket qua query 
		$result_page = $dbCon->query($sql2);
		if($result_page != false)
		{
			//show the results
			foreach ($result_page as $r2)
			{
				$total = $r2['Total'];
			}
		}
	}
	catch (PDOException $e1) {

		//loi ket noi db -> show exception
		echo $e1->getMessage();
	} 
	
	//echo $total;
	$limit = $total;
	//if($limit = 0)
	//{ $page = 1; $limit = $total; }
	//else
	//{ $page=ceil($total/$limit); }
	//
	//
	//
?>
            <div class="col-md-2" style="color:red">Số lượng: <?php echo $total; ?></div>
	</div>
	 <div class="row">
	 	<div class="col-md-2"><input type="submit" value="Lọc"></div>
		<div class="col-md-3"></div>
		<div class="col-md-2"></div>
		<div class="col-md-3"></div>
		<div class="col-md-2"></div>
	 </div>
	     </form>
	<h3 class="title">DANH SÁCH LỊCH HẸN</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã Booking</th>
		  <th>Khách hàng</th>
		  <th>Nhóm khách</th>
		  <th>Điện thoại</th>
		  <th>Email</th>
		  <th>Facebook</th>
          <th>Zalo</th>
          <th>Dịch vụ</th>
		  <th>Ngày đặt</th>
		  <th>Ngày hẹn</th>
		  <th>Bác sĩ</th>
          <th>NV đặt</th>
          <th>Chi nhánh</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	//
	//	thể hiện chi tiết booking
	//
	$sql2="select * from (select ROW_NUMBER() OVER (ORDER BY DATEDIFF(DAY,GioBatDau,GETDATE()),DATEDIFF(HOUR,GioBatDau,GETDATE()), DATEDIFF(MINUTE,GioBatDau,GETDATE())) AS RowId, 
	a.*, c.TenNV as TenNV, d.TenTrungTam,e.Ten as TenNhomKH from tblKhachHangBooking a 
		left join tblDMNhanVien b on a.MaBacSi = b.MaNV 
		left join tblDMNhanVien c on a.MaNV = c.MaNV 
		left join tblDMNhomKH e on a.MaNhomKH = e.Ma 
		left join tblDMTrungTam d on a.MaTrungTam = d.MaTrungTam Where 1=1"; 
		
	//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,GioBatDau,111) >= '$tungay_converted'";
	}
	
	if($denngay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,GioBatDau,111) <= '$denngay_converted'";
	}
	//
	//----loc theo trung tam -----//
	if($matrungtam != "" && $matrungtam != "all")
		$sql2 = $sql2 . " and a.MaTrungTam like '$matrungtam'";
		
	//----loc theo nguon khach -----//
	if($manhomkhach != "" && $manhomkhach != "all")
		$sql2 = $sql2 . " and a.MaNhomKH = '$manhomkhach'";
	
	if($manhanvien != "" && $manhanvien != "all")	//	CHO PHÉP QUẢN LÝ LỌC THEO MÃ NHÂN VIÊN
	{
		$sql2 = $sql2 . " and a.MaNV like '$manhanvien'";
	}
	
	$sql2 = $sql2 . ") tbl where RowId BETWEEN $start AND $limit Order by DATEDIFF(DAY,GioBatDau,GETDATE()), DATEDIFF(HOUR,GioBatDau,GETDATE()), DATEDIFF(MINUTE,GioBatDau,GETDATE())";
	//echo $sql2;
	//
	try
	{
		//lay ket qua query 
		$result_booking = $dbCon->query($sql2);
		if($result_booking != false)
		{
			//show the results
			foreach ($result_booking as $r2)
			{
	?>      
        <tr class="success">
		  <td><a href="editbooking.php?mabooking=<?php echo $r2['MaBooking'];?>"><?php echo $r2['MaBooking'];?></a></td>
		  <td><?php echo $r2['TenKH'];?></td>
		  <td><?php echo $r2['TenNhomKH'];?></td>
		  <td><?php echo $r2['DienThoai'];?></td>
		  <td><a href="<?php echo $r2['Email'];?>"><?php echo $r2['Email'];?></a></td>
		  <td><a href="<?php echo $r2['Facebook']; ?>"><?php echo $r2['Facebook'];?></a></td>
		  <td><a href="<?php echo $r2['Zalo']; ?>"><?php echo $r2['Zalo'];?></a></td>
		  <td><?php echo $r2['DichVu'];?></td>
		  <td><?php $date2 = date_create($r2['ThoiGianTao']); echo date_format($date2,'d-m-Y H:i:s'); ?></td>
          <td><?php $date1 = date_create($r2['GioBatDau']); echo date_format($date1,'d-m-Y H:i:s'); ?></td>
          <td><?php echo $r2['TenNV_KTV'];?></td>
          <td><?php echo $r2['TenNV'];?></td>
		  <td><?php echo $r2['TenTrungTam'];?></td>
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
    <ul class="pagination">
 <?php 
if($pageid > 1) 
{	
?> 
	<li><a href="?pageid=<?php echo ($pageid-1) ?>">Previous</a></li>
<?php 
}
?>
<?php
  for($i=1;$i <= $page;$i++)  
  {
?>
   <li><a href="?pageid=<?php echo $i ?>"><?php echo $i; ?></a></li>
<?php
  }
?>
</ul>
   <p></p>
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
