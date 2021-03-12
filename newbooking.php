<?php
require('lib/db.php');

@session_start();
$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$trungtam=$_SESSION['TenTrungTam'];

//----lay thong tin tu form
$booking_matrungtam = "";
$booking_matrungtam = @$_POST['booking_trungtam'];
$booking_tenkhachhang = "";
$booking_tenkhachhang = @$_POST['booking_tenkhachhang'];
$booking_dienthoai = "";
$booking_dienthoai = @$_POST['booking_dienthoai'];
$booking_email = "";
$booking_email = @$_POST['booking_email'];
$booking_diachi = "";
$booking_diachi = @$_POST['booking_diachi'];
$booking_dichvu = "";
$booking_dichvu = @$_POST['booking_dichvu'];

$booking_giobatdau=@$_POST['booking_giobatdau'];
$booking_gioketthuc=@$_POST['booking_gioketthuc'];
if($booking_giobatdau == "")
{
	$booking_giobatdau = date('Y-m-d H:i:s');
}

if($booking_gioketthuc == "")
{
	$booking_gioketthuc = date('Y-m-d H:i:s');
}

$booking_mabacsi = "";
$booking_mabacsi = @$_POST['booking_bacsi'];
$booking_manhanvien = "";
$booking_manhanvien = @$_POST['booking_nhanvien'];
$booking_ghichu = "";
$booking_ghichu = @$_POST['booking_ghichu'];

if(isset($_POST['booking_trungtam']) && $booking_matrungtam != "" && $booking_matrungtam != "none")
{
	$mabooking = "00-".date("Ymd");
	$l_sql = "Select MAX(Right(MaBooking,4)) as iBooking from tblKhachHangBooking where Left(MaBooking,2) like '00'";
	$l_index = 0;
    try
    {
	  	$result_mabooking = $dbCon->query($l_sql);
		foreach ($result_mabooking as $rbk)
		{
			$rbk['iBooking'];
		}
		if(isset($rbk['iBooking']))
			$l_index = intval($rbk['iBooking']);
     }
     catch(PDOException $e) { $l_index = 0; }
     
	 $l_index = $l_index + 1;
	 
	 $sufix = substr("0000",0, 4 - strlen($l_index));
     $mabooking = $mabooking.$sufix.$l_index;
	 
	 //echo $mabooking;
	 $sql_insert = "Insert into tblKhachHangBooking(MaBooking,TenKH,SoLuong,DichVu,isDatCoc,TienDatCoc,GioBatDau,GioKetThuc,isCancel,isArrived,GhiChu,
	 	MaNV,ThoiGianTao,DiaChi,DienThoai,Email,MaBacSi,MaTrungTam) values('"
		.$mabooking."',N'"
		.$booking_tenkhachhang."','1',N'"
		.$booking_dichvu."','0','0','"
		.$booking_giobatdau."','"
		.$booking_gioketthuc."','0','0',N'"
		.$booking_ghichu."','"
		.$booking_manhanvien."','"
		.date('Y-m-d H:i:s')."',N'"
		.$booking_diachi."','"
		.$booking_dienthoai."','"
		.$booking_email."','"
		.$booking_mabacsi."','"
		.$booking_matrungtam."')";
///	echo $sql_insert;
	try
    {
		$dbCon->query($sql_insert);
?>
<script>
		setTimeout('window.location="crm.php"',0);
</script>
<?php
	}
     catch(PDOException $e){}
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
            
            <div class="navbar-default" role="navigation">
                    <ul class="nav navbar-nav">
                        <li class="active">
                            <a href="crm.php"><i class="fa fa-table nav_icon"></i>Lịch hẹn khách hàng<span class="fa arrow"></span></a>
                        </li>
						<li>
                            <a href="newbooking.php"><i class="fa fa-calendar nav_icon"></i>Thêm lịch hẹn<span class="fa arrow"></span></a>
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-user fa-fw nav_icon"></i>Đăng xuất<span class="fa arrow"></span></a>
                        </li>
                    </ul>               
            </div>
        </nav>
 <div id="page-wrapper">
    <div class="col-md-12 graphs">
	  	<div class="xs">
	   	<h3>THÊM MỚI LỊCH HẸN</h3>
  			<div class="bs-example4" data-example-id="contextual-table">
    			<div class="table-responsive">
     				<form action="" method="post">
     				 <table class="table">
          				<tr>
            				<td width="7%"></td>
            				<td width="11%"></td>
             				<th width="19%" scope="row">Chi nhánh:</th>
            				<td width="22%">
								<select name="booking_trungtam">
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
			<?php if($booking_matrungtam == $r['MaTrungTam'])
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
							</td>
            				<td width="27%"></td>
            				<td width="14%"></td>
          				</tr>
          				<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Tên khách hàng:</th>
            				<td> <input name="booking_tenkhachhang" type="text" size="35" required></td>
            				<td></td>
            				<td></td>
          				</tr>
         	 			<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Điện thoại:</th>
            				<td> <input name="booking_dienthoai" type="text" size="35" required></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Email:</th>
            				<td> <input name="booking_email" type="text" size="35" required></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Địa chỉ:</th>
            				<td> <input name="booking_diachi" type="text" size="35"></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Dịch vụ:</th>
            				<td> <input name="booking_dichvu" type="text" size="35" required></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Giờ bắt đầu:</th>
            				<td> <input type="text" name="booking_giobatdau" value="<?php echo date('Y-m-d H:i'); ?>" size="35" id="booking_giobatdau" required></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Giờ kết thúc:</th>
            				<td> <input type="text" name="booking_gioketthuc" value="<?php echo date('Y-m-d H:i'); ?>" size="35" id="booking_gioketthuc" required></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Bác sĩ:</th>
            				<td> 
								<select name="booking_bacsi">
								<option value="none">Không chọn</option>
<?php
	$sqlbs="SELECT * FROM tblDMNhanVien where MaNV like 'BS%'";
	try
	{
		//lay ket qua query tong gia tri the
		$result_bs = $dbCon->query($sqlbs);
		if($result_bs != false)
		{
			//show the results
			foreach ($result_bs as $rbs)
			{
?>
			<?php if($booking_mabacsi == $rbs['MaNV'])
				{
			 ?>
		 			<option value="<?php echo $rbs['MaNV'];?>" selected="selected"><?php echo $rbs['TenNV'];?></option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $rbs['MaNV'];?>"><?php echo $rbs['TenNV'];?></option>
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
							</td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Nhân viên:</th>
            				<td> 
								<select name="booking_nhanvien">
									<option value="none">Không chọn</option>
<?php
	$sqlnv="SELECT * FROM tblDMNhanVien where MaNV not like 'BS%' and DaNghiViec = 0";
	try
	{
		//lay ket qua query tong gia tri the
		$result_nv = $dbCon->query($sqlnv);
		if($result_nv != false)
		{
			//show the results
			foreach ($result_nv as $rnv)
			{
?>
			<?php if($booking_manhanvien == $rnv['MaNV'])
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
								</select>
							</td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Ghi chú:</th>
            				<td> <input name="booking_ghichu" type="text" size="35" required></td>
           	 				<td></td>
            				<td></td>
          				</tr>
          				<tr>
            				<td></td>
            				<td></td>
            				<td></td>
            				<td><input name="submit" type="submit" value="Xác nhận"></td>
               				<td></td>
            				<td></td>
          				</tr>
      				</table>
      				</form>
    			</div><!-- /.table-responsive -->
   			</div><!-- /.bs-example4 -->
   		</div>
   </div>      <!-- /col-md-12 graphs -->
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
	
	$("#booking_giobatdau").datetimepicker({
		format: 'yyyy-mm-dd hh:ii'
	})
	
	$("#booking_gioketthuc").datetimepicker({
		format: 'yyyy-mm-dd hh:ii'
	})
</script>   
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
</body>
</html>
