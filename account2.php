<?php
session_start();
require('lib/db.php');
if(!isset($_SESSION['MaNV']) && !isset($_SESSION['TenSD'])) header('location:login.php');
$id=$_SESSION['MaNV'];
$tensd = $_SESSION['TenSD'];
$trungtam=$_SESSION['TenTrungTam'];
$manhomnhanvien = $_SESSION['NhomNhanVien'];

if(isset($_POST['pass']))
{
		$pass=$_POST['pass'];
		$repass=$_POST['repass'];
		$captcha=$_POST['captcha'];
		if($pass!=$repass)
			$msg='Mật khẩu nhập lại không đúng';
		elseif($captcha!=$_SESSION['captcha'])
			$msg1='Ảnh bảo mật nhập không đúng';
		//else
		//{
			$sql="update tblDSNguoiSD set MatKhau=PWDENCRYPT('$pass') WHERE TenSD='$tensd'";
			//lay ket qua query tong gia tri the
			$result_doipass = $dbCon->query($sql);
			if($result_doipass != false)
			{
	?>
                
				<script>
					window.onload=function(){
					alert("Cập nhật thành công. Đăng nhập lại để xem thông tin");
						setTimeout('window.location="login.php"',0);
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
		//}
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
                        <li>
                            <a href="booking.php"><i class="fa fa-table nav_icon"></i>Lịch hẹn khách hàng<span class="fa arrow"></span></a>
                        </li>
						<li>
                            <a href="editbooking.php"><i class="fa fa-calendar nav_icon"></i>Thêm lịch hẹn<span class="fa arrow"></span></a>
                        </li>
						<li class="active">
                            <a href="account2.php"><i class="fa fa-user nav_icon"></i>Đổi mật khẩu<span class="fa arrow"></span></a>
                        </li>
                        <li>
                            <a href="logout.php"><i class="fa fa-sign-out fa-fw nav_icon"></i>Đăng xuất<span class="fa arrow"></span></a>
                        </li>
                    </ul>           
            </div>
        </nav>
 <div>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   <div class="xs">
  	 <h3>ĐỔI MẬT KHẨU</h3>
     
     
  	<div class="bs-example4" data-example-id="contextual-table">
    <div class="table-responsive">
     <form action="" method="post">
      <table class="table">
        
          <tr>
            <td width="7%"></td>
            <td width="11%"></td>
             <th width="19%" scope="row">Tên đăng nhập:</th>
            <td width="22%"><input name="id" type="text" size="35" value="<?php echo $_SESSION['TenSD']?>"></td>
            <td width="27%"></td>
            <td width="14%"></td>
          </tr>
          
          <tr>
            <td></td>
            <td></td>
            <th scope="row">Mật khẩu mới:</th>
            <td> <input name="pass" type="password" size="35" required></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <th scope="row">Nhập lại mật khẩu:</th>
            <td> <input name="repass" type="password" size="35" required></td>
            <td class="error"><?php echo @$msg?></td>
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
