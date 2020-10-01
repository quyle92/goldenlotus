<?php
require('lib/db.php');
require('functions/sms.php');

@session_start();

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];
$nhomquyen = $_SESSION['NhomQuyen'];
$manhomnhanvien = $_SESSION['NhomNhanVien'];
$smsbrandname = $_SESSION['SMSBrandName'];
//
//	lấy thông số để gửi sms
//
$curl = "";
$apikey = "";
$secretkey = "";
$isActiveSMS = 0;
$isGuiSMSnhaclichhen = 0;
$isGuiSMSxacnhanlichhen = 0;
$sophutguitruoclichhen = 45;
$smsxacnhanlichhen = "TMV TUẤN LINH XIN XÁC NHẬN LỊCH HẸN VỚI QUÝ KHÁCH";

$sql = "Select * from tblDMTrungTam Where MaTrungTam = '$matrungtam'";
$result_sms = $dbCon->query($sql);
if($result_sms != false)
{
	foreach ($result_sms as $r)
	{
		$curl = $r['UrlApi'];
		$apikey = $r['SMSApi'];
		$secretkey = $r['SecretKey'];
		$isActiveSMS = $r['IsGuiSMS'];
		$isGuiSMSnhaclichhen = $r['IsGuiSMSNhacLichHen'];
		$sophutguitruoclichhen = $r['SoPhutGuiTruocLichHen'];
		$isGuiSMSxacnhanlichhen = $r['IsGuiSMSXacNhanLichHen'];
		$smsxacnhanlichhen = $r['SMSXacNhanLichHen'];
	}
}
//
//	lấy các dữ liệu GET hoặc POST
//
$booking_mabooking = "";
$booking_mabooking = @$_GET['mabooking'];

$booking_matrungtam1 = "";
$booking_makhachhang1 = "";
$booking_tenkhachhang1 = "";
$booking_manguonkhach1 = "";
$booking_dienthoai1 = "";
$booking_email1 = "";
$booking_facebook1 = "";
$booking_zalo1 = "";
$booking_diachi1 = "";
$booking_dichvu1 = "";
$booking_ghichu1 = "";
$booking_ngayhentemp = "";
$booking_ngayhen1 = date('d-m-Y');
$booking_giohen1 = "08:00";
$booking_manhanvien1 = $id;

if($booking_mabooking != "" && $booking_mabooking != null)
{
	$_SESSION['MaBooking'] = $booking_mabooking;		// trường hợp lần đầu edit
	$l_sql = "Select * from tblKhachHangBooking where MaBooking = '".$booking_mabooking."'";
    try
    {
	  	$result_oldbooking = $dbCon->query($l_sql);
		foreach ($result_oldbooking as $r1)
		{
			$booking_matrungtam1 = $r1['MaTrungTam'];
			$booking_makhachhang1 = $r1['MaKH'];
			$booking_tenkhachhang1 = $r1['TenKH'];
			$booking_manguonkhach1 = $r1['MaNhomKH'];
			$booking_dienthoai1 = $r1['DienThoai'];
			$booking_facebook1 = $r1['Facebook'];
			$booking_zalo1 = $r1['Zalo'];
			$booking_email1 = $r1['Email'];
			$booking_diachi1 = $r1['DiaChi'];
			$booking_dichvu1 = $r1['DichVu'];
			$booking_ghichu1 = $r1['GhiChu'];
			$booking_ngayhentemp = $r1['GioBatDau'];
			$booking_manhanvien1 = $r1['MaNV'];
		}
     }
     catch(PDOException $e) { }
	 
	 if($booking_ngayhentemp != "" && $booking_ngayhentemp != null)
	 {
	 	//echo $booking_ngayhentemp; 2019-04-02 15:00:00.000
		$booking_ngayhen1 = substr($booking_ngayhentemp,8,2) . "-" . substr($booking_ngayhentemp,5,2) . "-" . substr($booking_ngayhentemp,0,4);
		$booking_giohen1 = substr($booking_ngayhentemp,11,5);
	 }
}
else
{
	$booking_mabooking = $_SESSION['MaBooking'];		// truong hop submit booking cu -> lay lại session lưu lại
}
//
//----lay thong tin tu form
//
$booking_matrungtam = "";
$booking_matrungtam = @$_POST['booking_trungtam'];

$booking_tenkhachhang = "";
$booking_tenkhachhang = @$_POST['booking_tenkhachhang'];

$booking_manguonkhach = "";
$booking_manguonkhach = @$_POST['booking_manguonkhach'];

$booking_dienthoai = "";
$booking_dienthoai = @$_POST['booking_dienthoai'];

$booking_email = "";
$booking_email = @$_POST['booking_email'];

$booking_facebook = "";
$booking_facebook = @$_POST['booking_facebook'];

$booking_zalo = "";
$booking_zalo = @$_POST['booking_zalo'];

$booking_diachi = "";
$booking_diachi = @$_POST['booking_diachi'];

$booking_dichvu = "";
$booking_dichvu = @$_POST['booking_dichvu'];

$booking_ghichu = "";
$booking_ghichu = @$_POST['booking_ghichu'];

$booking_ngayhen=@$_POST['booking_ngayhen'];

$booking_giohen=@$_POST['booking_giohen'];

if($booking_ngayhen == "" || $booking_ngayhen == null)
{
	$booking_ngayhen = date('d-m-Y');
}

if($booking_giohen == "" || $booking_giohen == null)
{
	$booking_giohen = "08:00";
}

$booking_manhanvien = "";
$booking_manhanvien = @$_POST['booking_nhanvien'];
if(strtolower($nhomquyen) != "quanly")
{
	$booking_manhanvien = $id;
}

$ketqua_xulybooking = 0;

if(isset($_POST['booking_trungtam']) && $booking_matrungtam != "" && $booking_matrungtam != "none")
{
	if($booking_ngayhen != "")
	{
		$booking_ngayhen_converted = substr($booking_ngayhen,6) . "-" . substr($booking_ngayhen,3,2) . "-" . substr($booking_ngayhen,0,2);
	}
	if($booking_giohen != "")
	{
		$booking_ngayhen_converted = $booking_ngayhen_converted." ".$booking_giohen.":00";
	}
	else
	{
		$booking_ngayhen_converted = $booking_ngayhen_converted." 08:00:00";
	}
	//
	//	xu ly noi dung gui sms nhac lich hen
	//
	$booking_ngayguisms_converted = $booking_ngayhen_converted;		// new DateTime('$booking_ngayhen_converted');
	if($smsxacnhanlichhen != "")
		$smsxacnhanlichhen = str_replace("[GioBatDau]",$booking_ngayguisms_converted,$smsxacnhanlichhen);
	//
	//	xu ly so dien thoai, thieu 0 va chieu dai < 10
	//
	if(strlen($booking_dienthoai) < 10)
	{
		$booking_dienthoai = substr("0000000000",0,10-strlen($booking_dienthoai)).$booking_dienthoai;
	}
	//
	//	check đây là khách hàng cũ theo số điện thoại -> để lấy mã khách hàng
	//
	$makhachhang = "";
	$l_sql = "Select MaDoiTuong from tblDMKHNCC Where (DienThoai is not null and DienThoai <> '' and DienThoai = '$booking_dienthoai') or (DienThoaiDD is not null and DienThoaiDD <> '' and DienThoaiDD = '$booking_dienthoai')";
	try
    {
		$result_kh = $dbCon->query($l_sql);
		foreach ($result_kh as $rkh)
		{
			$makhachhang = $rkh['MaDoiTuong'];
		}
    }
    catch(PDOException $e) { $makhachhang = ""; }
	//
	//	trường hợp cập nhật booking cũ
	//
	if($booking_mabooking != "" && $booking_mabooking != null)
	{
		//echo $mabooking; mac dinh tinh trang chua den
	 	$sql_update = "Update tblKhachHangBooking set MaKH='".$makhachhang."',TenKH=N'".$booking_tenkhachhang."',DichVu=N'".$booking_dichvu."',GioBatDau='".$booking_ngayhen_converted."',GioKetThuc='".$booking_ngayhen_converted."',GhiChu=N'".$booking_ghichu."',MaNV='".$booking_manhanvien."',DiaChi=N'".$booking_diachi."',DienThoai='".$booking_dienthoai."',Email=N'".$booking_email."',MaTrungTam='".$booking_matrungtam."',IsGuiSMS='".$isActiveSMS."',MaNhomKH='".$booking_manguonkhach."',SoPhutGuiTruocLichHen = '".$sophutguitruoclichhen."',Facebook='".$booking_facebook."',Zalo='".$booking_zalo."' where MaBooking = '".$booking_mabooking."'";
///	echo $sql_update;
		try
    	{
			$dbCon->query($sql_update);
			
			$ketqua_xulybooking = 1;		//cập nhật nếu xử lý sql ok
?>
<script>
		setTimeout('window.location="booking.php"',0);
</script>
<?php
		} catch(PDOException $e){}
	}
	else
	{
	//
	//	trường hợp booking mới
	//
		$mabooking = "00-".date("Ymd");
		$l_sql = "Select MAX(Right(MaBooking,4)) as iBooking from tblKhachHangBooking where Left(MaBooking,2) like '00'";
		$l_index = 0;
    	try
    	{
	  		$result_mabooking = $dbCon->query($l_sql);
			foreach ($result_mabooking as $rbk)
			{
				$l_index = intval($rbk['iBooking']);
			}
     	}
     	catch(PDOException $e) { $l_index = 0; }
     
	 	$l_index = $l_index + 1;
	 
	 	$sufix = substr("0000",0, 4 - strlen($l_index));
     	$mabooking = $mabooking.$sufix.$l_index;
	 
	 	//echo $mabooking; mac dinh tinh trang chua den
	 	$sql_insert = "Insert into tblKhachHangBooking(MaBooking,TenKH,SoLuong,DichVu,isDatCoc,TienDatCoc,GioBatDau,GioKetThuc,GhiChu,isCancel,isArrived,
	 	MaNV,ThoiGianTao,DiaChi,DienThoai,Email,MaTrungTam,IsGuiSMS,MaNhomKH,Facebook,Zalo,SoPhutGuiTruocLichHen) values('"
		.$mabooking."',N'"
		.$booking_tenkhachhang."','1',N'"
		.$booking_dichvu."','0','0','"
		.$booking_ngayhen_converted."','"
		.$booking_ngayhen_converted."',N'"
		.$booking_ghichu."','0','0','"
		.$booking_manhanvien."','"
		.date('Y-m-d H:i:s')."',N'"
		.$booking_diachi."','"
		.$booking_dienthoai."','"
		.$booking_email."','"
		.$booking_matrungtam."','"
		.$isGuiSMSnhaclichhen."','"
		.$booking_manguonkhach."','"
		.$booking_facebook."','"
		.$booking_zalo."','"				
		.$sophutguitruoclichhen."')";
		
		//echo $sql_insert;
		
		try
    	{
			$dbCon->query($sql_insert);
			
			$ketqua_xulybooking = 1;		//cập nhật nếu xử lý sql ok
?>
<script>
		setTimeout('window.location="booking.php"',0);
</script>
<?php
		} catch(PDOException $e){}		
	}//end if else check booking cũ và mới
	 
	//
	//	xử lý gửi sms
	//
	if($ketqua_xulybooking == 1)
	{
		if($isActiveSMS == 1 || $isActiveSMS == 'True')
		{	
			if($isGuiSMSxacnhanlichhen == 1 || $isGuiSMSxacnhanlichhen == 'True')
			{
				$result = "";
				//
				//	sử dụng eSMS
				//
				//$urlApi = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get";
				//$apiKey = "940406E900A5252AC061867BE12598";
				//$secretkey = "E3702E69F16E1C3EA77818FA19F6E0";
				$phone = $booking_dienthoai;// "0966885959";
				$brandname = $smsbrandname;//"QCAO_ONLINE";
				$content = $smsxacnhanlichhen;
				$smsType = 2;
			
				SendSMS_eSMS($curl, $apikey, $secretkey, $phone, $brandname, $content, $smsType, $result);
				//
				//	echo "Da send sms";
				//
				$sql_insert = "Insert into tblKhachHangBooking_GuiSMS(MaBooking,MaTrungTam,TenKH,DienThoai,NgayHen,NoiDungSMS,GhiChu,NgayGuiSMS,KetQuaSMS) values('"
					.$mabooking."','"
					.$booking_matrungtam."',N'"
					.$booking_tenkhachhang."','"
					.$booking_dienthoai."','"
					.$booking_ngayhen_converted."',N'"
					.$content."','','"
					.date('Y-m-d H:i:s')."',N'"
					.$result."')";

				try
		    	{
					$dbCon->query($sql_insert);
				} catch(PDOException $e){}
			}
		}
	}
}//end if check post trung tam
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
                        <li>
                            <a href="booking.php"><i class="fa fa-table nav_icon"></i>Lịch hẹn khách hàng<span class="fa arrow"></span></a>
                        </li>
						<li class="active">
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
			<?php if($booking_matrungtam1 == $r['MaTrungTam'])
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
            				<td> 
								<input name="booking_tenkhachhang" value="<?php echo $booking_tenkhachhang1; ?>" type="text" size="35" required>
							</td>
            				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Nhóm khách:</th>
            				<td> <select name="booking_manguonkhach">
<?php
	$sqlnkh="SELECT * FROM tblDMNhomKH";
	try
	{
		//lay ket qua query tong gia tri the
		$result_nkh = $dbCon->query($sqlnkh);
		if($result_nkh != false)
		{
			//show the results
			foreach ($result_nkh as $rnkh)
			{
?>
			<?php if($booking_manguonkhach1 == $rnkh['Ma'])
				{
			 ?>
		 			<option value="<?php echo $rnkh['Ma'];?>" selected="selected"><?php echo $rnkh['Ten'];?></option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $rnkh['Ma'];?>"><?php echo $rnkh['Ten'];?></option>
			<?php
				}
			}//end for
		} //end if dataset
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
            				<th scope="row">Điện thoại:</th>
            				<td> <input name="booking_dienthoai" value="<?php echo $booking_dienthoai1; ?>" type="text" size="35" required></td>
           	 				<td></td>
            				<td></td>
          				</tr>
         	 			<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Facebook:</th>
            				<td> <input name="booking_facebook" value="<?php echo $booking_facebook1; ?>" type="text" size="35"></td>
           	 				<td></td>
            				<td></td>
          				</tr>
         	 			<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Zalo:</th>
            				<td> <input name="booking_zalo" value="<?php echo $booking_zalo1; ?>" type="text" size="35"></td>
           	 				<td></td>
            				<td></td>
          				</tr>												
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Email:</th>
            				<td> <input name="booking_email" value="<?php echo $booking_email1; ?>" type="text" size="35"></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Địa chỉ:</th>
            				<td> <input name="booking_diachi" value="<?php echo $booking_diachi1; ?>" type="text" size="35"></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Dịch vụ:</th>
            				<td> 
								<select name="booking_dichvu">
								<?php if($booking_dichvu1 == "CHĂM SÓC DA") { ?>
									<option value="CHĂM SÓC DA" selected="selected">CHĂM SÓC DA</option>
								<?php } else { ?>
									<option value="CHĂM SÓC DA">CHĂM SÓC DA</option>
								<?php } ?>
								<?php if($booking_dichvu1 == "LĂN KIM") { ?>
									<option value="LĂN KIM" selected="selected">LĂN KIM</option>
								<?php } else { ?>
									<option value="LĂN KIM">LĂN KIM</option>
								<?php } ?>
								<?php if($booking_dichvu1 == "TRỊ MỤN") { ?>
									<option value="TRỊ MỤN" selected="selected">TRỊ MỤN</option>
								<?php } else { ?>
									<option value="TRỊ MỤN">TRỊ MỤN</option>
								<?php } ?>	
								<?php if($booking_dichvu1 == "PHUN XĂM") { ?>
									<option value="PHUN XĂM" selected="selected">PHUN XĂM</option>
								<?php } else { ?>
									<option value="PHUN XĂM">PHUN XĂM</option>
								<?php } ?>	
								
								<?php if($booking_dichvu1 == "TẮM TRẮNG") { ?>
									<option value="TẮM TRẮNG" selected="selected">TẮM TRẮNG</option>
								<?php } else { ?>
									<option value="TẮM TRẮNG">TẮM TRẮNG</option>
								<?php } ?>	
								
								<?php if($booking_dichvu1 == "HÚT CHÌ") { ?>
									<option value="HÚT CHÌ" selected="selected">HÚT CHÌ</option>
								<?php } else { ?>
									<option value="HÚT CHÌ">HÚT CHÌ</option>
								<?php } ?>	
								
								<?php if($booking_dichvu1 == "CHẠY VITAMINC") { ?>
									<option value="CHẠY VITAMINC" selected="selected">CHẠY VITAMINC</option>
								<?php } else { ?>
									<option value="CHẠY VITAMINC">CHẠY VITAMINC</option>
								<?php } ?>	
								
								<?php if($booking_dichvu1 == "DỊCH VỤ KHÁC") { ?>
									<option value="DỊCH VỤ KHÁC" selected="selected">DỊCH VỤ KHÁC</option>
								<?php } else { ?>
									<<option value="DỊCH VỤ KHÁC">DỊCH VỤ KHÁC</option>
								<?php } ?>									
									
								</select>
							</td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Ghi chú:</th>
            				<td> <input name="booking_ghichu" value="<?php echo $booking_ghichu1; ?>" type="text" size="35"></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Ngày hẹn:</th>
            				<td> <input name="booking_ngayhen" type="text"  value="<?php echo $booking_ngayhen1; ?>" id="booking_ngayhen" required/></td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Giờ hẹn:</th>
            				<td><input name="booking_giohen" type="time"  value="<?php echo $booking_giohen1; ?>" id="booking_giohen" required/> </td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">KTV Làm DV:</th>
            				<td> 
								<input name="booking_tenktv" value="<?php echo $booking_tenktv1; ?>" type="text" size="35"></td>
							</td>
           	 				<td></td>
            				<td></td>
          				</tr>
						<tr>
            				<td></td>
            				<td></td>
            				<th scope="row">Nhân viên đặt lịch:</th>
            				<td> 
								<select name="booking_nhanvien">
									<option value="none">Không chọn</option>
<?php
	$sqlnv="SELECT * FROM tblDMNhanVien where DaNghiViec = 0";
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
			<?php if($booking_manhanvien1 == $rnv['MaNV'])
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
            				<td></td>
            				<td><input name="submit" type="submit" value="Gửi xác nhận"></td>
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
	$('#booking_ngayhen').datepicker({
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
