<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);
$maNV = isset($_GET['maNV']) ? $_GET['maNV'] : "";
if( !empty($maNV) ){
// $user = $goldenlotus->layTenUser($maNV);

}
$thanhcong="";
$loi=array();

if(isset($_POST['submit']))
{
  $tenSD= $_SESSION['TenSD'];
  $password= $_POST['password'];
  $repass = $_POST['repass'];//var_dump($password); var_dump($repass);die;
  $thanhcong = $goldenlotus->changePassword( $tenSD, $password, $repass, $loi );
}

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];

$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];

if( !$_SESSION['MaNV']  )
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
?>


<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>
<style>

</style>
<!-- Bootstrap iOS toggle https://www.bootstraptoggle.com/ -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
<div id="wrapper">
    <?php include 'menu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
    <div class="xs">
   
      <h3>ĐỔI MẬT KHẨU</h3>
    <div class="bs-example4" data-example-id="contextual-table">
      
            <?php
              if($thanhcong==false) {
                  foreach( $loi as $l)
                  {
                    echo "<div class='alert alert-danger'>
                         <ul><li>$l</li></ul>
                      </div>";
                  }
              }
              else{
                  echo "<div class='alert alert-success'>
                         Đổi Password thành công
                      </div>";
              }

            ?>
         
    <div class="table-responsive">
     <form action="" method="post">
      <table class="table">
          <tr>
            <td width="7%"></td>
            <td width="11%"></td>
             <th width="19%" scope="row">Tên đăng nhập:</th>
            <td width="22%"><input name="username" type="text" size="35" value="<?php echo $_SESSION['TenSD']?>" disabled></td>
            <td width="27%"></td>
            <td width="14%"></td>
          </tr>
          
          <tr>
            <td></td>
            <td></td>
            <th scope="row">Mật khẩu mới:</th>
            <td> <input name="password" type="password" size="35" ></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <th scope="row">Nhập lại mật khẩu:</th>
            <td> <input name="repass" type="password" size="35" ></td>
            <td class="error"></td>
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
    <!-- #end class xs-->
   </div>
   <!-- #end class col-md-12 -->
      </div>
      <!-- /#page-wrapper -->
   </div>


</body>
</html>
