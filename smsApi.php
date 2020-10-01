<?php
session_start();
require('lib/db.php');
if(!isset($_SESSION['MaNV']) && !isset($_SESSION['TenSD'])) header('location:login.php');

$id=$_SESSION['MaNV'];
$tensd = $_SESSION['TenSD'];
$matrungtam=$_SESSION['MaTrungTam'];
$tentrungtam=$_SESSION['TenTrungTam'];

$curl=$_POST['curl'];
$apikey=$_POST['apikey'];
$secretkey=$_POST['secretkey'];
$isActive = 0;
$brandname = "";
$isGuiSMSNhacLichHen = 0;
$sophutguitruoclichhen = 0;
$isGuiSMSXacNhanLichHen = 0;
$isGuiSMSChucMungSinhNhat = 0;
$isGuiSMSKetThucPhieu = 0;
$sophutguisaukhiketthucphieu = 0;
$smsxacnhanlichhen = "";
$smsloichucsinhnhat = "";
$smsketthucphieu = "";

if(isset($_POST['IsGuiSMS']))
{
	$isActive = 1;
}
else
{
	$isActive = 0;
}

if(isset($_POST['tentrungtam']))
{
	if(isset($_POST['IsGuiSMSNhacLichHen']))
	{
		$isGuiSMSNhacLichHen = 1;
	}
	else
	{
		$isGuiSMSNhacLichHen = 0;
	}
	
	if(isset($_POST['IsGuiSMSXacNhanLichHen']))
	{
		$isGuiSMSXacNhanLichHen = 1;
	}
	else
	{
		$isGuiSMSXacNhanLichHen = 0;
	}
	
	if(isset($_POST['IsGuiSMSChucMungSinhNhat']))
	{
		$isGuiSMSChucMungSinhNhat = 1;
	}
	else
	{
		$isGuiSMSChucMungSinhNhat = 0;
	}
	
	if(isset($_POST['IsGuiSMSKetThucPhieu']))
	{
		$isGuiSMSKetThucPhieu = 1;
	}
	else
	{
		$isGuiSMSKetThucPhieu = 0;
	}
	
	$brandname = $_POST['brandname'];
	$smsxacnhanlichhen = $_POST['smsxacnhanlichhen'];
	$smsloichucsinhnhat = $_POST['smsloichucsinhnhat'];
	$smsketthucphieu = $_POST['smsketthucphieu'];
	$sophutguitruoclichhen = $_POST['sophutguitruoclichhen'];
	
	$sql="update tblDMTrungTam set UrlApi = N'$curl', SMSApi = '$apikey', SecretKey = '$secretkey', IsGuiSMS = '$isActive',
	SMSBrandName='$brandname',IsGuiSMSNhacLichHen = '$isGuiSMSNhacLichHen',SMSXacNhanLichHen = '$smsxacnhanlichhen',
	IsGuiSMSChucMungSinhNhat='$isGuiSMSChucMungSinhNhat',SMSChucMungSinhNhat='$smsloichucsinhnhat',
	IsGuiSMSKetThucPhieu='$isGuiSMSKetThucPhieu',SMSKetThucPhieu='$smsketthucphieu',SoPhutGuiTruocLichHen='$sophutguitruoclichhen',
	SoPhutGuiSauKhiKetThucPhieu='$sophutguisaukhiketthucphieu'";
	
	//lay ket qua query tong gia tri the
	$result_updatesms = $dbCon->query($sql);
	if($result_updatesms != false)
	{
?>               
		<script>
			window.onload=function(){
				alert("Cập nhật thành công !");
					setTimeout('window.location="smsApi.php"',0);
				}
		</script>
<?php
	}
	else
	{
?>
		<script>					
			alert("Cập nhật không thành công");
		</script>
<?php
	}
}
else
{
	$sql="select * from tblDMTrungTam WHERE MaTrungTam='$matrungtam'";
	//lay ket qua query tong gia tri the
	$result_sms = $dbCon->query($sql);
	if($result_sms != false)
	{
		//show the results
		foreach ($result_sms as $r)
		{
			$curl = $r['UrlApi'];
			$apikey = $r['SMSApi'];
			$secretkey=$r['SecretKey'];
			$isActive = $r['IsGuiSMS'];
			$brandname = $r['SMSBrandName'];
			$isGuiSMSNhacLichHen = $r['IsGuiSMSNhacLichHen'];
			$sophutguitruoclichhen = $r['SoPhutGuiTruocLichHen'];
			$isGuiSMSXacNhanLichHen = $r['IsGuiSMSXacNhanLichHen'];
			$smsxacnhanlichhen = $r['SMSXacNhanLichHen'];
			$isGuiSMSChucMungSinhNhat = $r['IsGuiSMSChucMungSinhNhat'];
			$smsloichucsinhnhat = $r['SMSChucMungSinhNhat'];						
			$isGuiSMSKetThucPhieu = $r['IsGuiSMSKetThucPhieu'];
			$smsketthucphieu = $r['SMSKetThucPhieu'];		
			$sophutguisaukhiketthucphieu = $r['SoPhutGuiSauKhiKetThucPhieu'];
		}
	}
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
    <?php include 'menu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
	  <div class="xs">
  	<h3>CẤU HÌNH VIỆC GỬI SMS CHO KHÁCH HÀNG</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <div class="table-responsive">
     <form action="" method="post">
      <table class="table">
          <tr>
            <td width="7%"></td>
            <td width="11%"></td>
             <th width="19%" scope="row">Trung tâm:</th>
            <td width="22%"><input name="tentrungtam" type="text" size="35" value="<?php echo $tentrungtam;?>"></td>
            <td width="27%"></td>
            <td width="14%"></td>
          </tr>
          <tr>
            <td width="7%"></td>
            <td width="11%"></td>
            <th width="19%" scope="row">Brand name:</th>
            <td width="22%"><input name="brandname" type="text" size="35" value="<?php echo $brandname;?>"></td>
            <td width="27%"></td>
            <td width="14%"></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <th scope="row">URL:</th>
            <td> <input name="curl" type="text" size="35" value="<?php echo $curl;?>" required></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <th scope="row">Api Key:</th>
            <td><input name="apikey" type="text" size="35" value="<?php echo $apikey;?>" required></td>
            <td></td>
            <td></td>
          </tr>
		  <tr>
            <td></td>
            <td></td>
            <th scope="row">Secret Key:</th>
            <td> <input name="secretkey" type="text" size="35" value="<?php echo $secretkey;?>" required></td>
            <td class="error"><?php echo @$msg?></td>
            <td></td>
          </tr>
		<tr>
            <td></td>
            <td></td>
            <th scope="row">Gửi SMS nhắc lịch hẹn:</th>
            <td><input type="checkbox" name="IsGuiSMSNhacLichHen" <?php if($isGuiSMSNhacLichHen == 1 || $isGuiSMSNhacLichHen == 'True') echo 'checked'; ?>></td>
            <td></td>
            <td></td>
          </tr>  
		<tr>
            <td></td>
            <td></td>
            <th scope="row">Số phút gửi trước lịch hẹn:</th>
            <td><input type="number" name="sophutguitruoclichhen" min="0" max="60" value="<?php echo $sophutguitruoclichhen;?>"></td>
            <td></td>
            <td></td>
          </tr>
		<tr>
            <td></td>
            <td></td>
            <th scope="row">Gửi SMS xác nhận lịch hẹn:</th>
            <td><input type="checkbox" name="IsGuiSMSXacNhanLichHen" <?php if($isGuiSMSXacNhanLichHen == 1 || $isGuiSMSXacNhanLichHen == 'True') echo 'checked'; ?>></td>
            <td></td>
            <td></td>
          </tr>  
		<tr>
            <td></td>
            <td></td>
            <th scope="row">Nội dung xác nhận lịch hẹn:</th>
            <td><textarea rows = "3" cols = "60" name="smsxacnhanlichhen" size="35"><?php echo $smsxacnhanlichhen;?></textarea></td>
            <td></td>
            <td></td>
          </tr>

		<tr>
            <td></td>
            <td></td>
            <th scope="row">Gửi SMS cảm ơn khách hàng:</th>
            <td><input type="checkbox" name="IsGuiSMSKetThucPhieu" <?php if($isGuiSMSKetThucPhieu == 1 || $isGuiSMSKetThucPhieu == 'True') echo 'checked'; ?>></td>
            <td></td>
            <td></td>
          </tr>  
		<tr>
            <td></td>
            <td></td>
            <th scope="row">Nội dung gửi lời cảm ơn:</th>
            <td><textarea rows = "3" cols = "60" name="smsketthucphieu" size="35"><?php echo $smsketthucphieu;?></textarea></td>
            <td></td>
            <td></td>
          </tr>
		 <tr>
            <td></td>
            <td></td>
            <th scope="row">Số phút gửi sau khi kết thúc phiếu:</th>
            <td><input type="number" name="sophutguisaukhiketthucphieu" min="0" max="60" value="<?php echo $sophutguisaukhiketthucphieu;?>"></td>
            <td></td>
            <td></td>
          </tr>
		  <tr>
            <td></td>
            <td></td>
            <th scope="row">Active:</th>
            <td><input type="checkbox" name="IsGuiSMS" <?php if($isActive == 1 || $isActive == 'True') echo 'checked'; ?>></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><input name="submit" type="submit" value="Lưu cài đặt"></td>
            
            <td></td>
            <td></td>
          </tr>

     
      </table>
      </form>
    </div><!-- /.table-responsive -->
   </div>
	
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
