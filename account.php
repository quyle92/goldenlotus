<?php
session_start();
require('lib/db.php');
//if(!isset($_SESSION['MaNV']) && !isset($_SESSION['TenSD'])) header('location:login.php');
$id=$_SESSION['MaNV'];
$tensd = $_SESSION['TenSD'];
$trungtam=$_SESSION['TenTrungTam'];

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
					alert("Cập nhật thành công. Đăng nhập lại để check thông tin");
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
<?php include ('head/head-revenue.month.php');?>
</head>
<body>
<div id="wrapper">
    <?php include 'menu.php'; ?>
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
