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
  $tungay = "01-01-".date('Y');
}

if($denngay == "")
{
  $denngay = date('d-m-Y');
}
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>

<style>
.danh-sach-ban .soluong{
text-align: center;
border: 1px solid #333;
border-radius: 100%;
height: 45px;
width: 45px;
display: flex;
align-items: center;
justify-content: center;
}


</style>
<script>
  $(document).ready(function() {
    $('[id^=detail-]').hide();
    $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
    });
});
</script>
</head>
<body>
<div id="wrapper ">
    <?php include 'menu.php'; ?>
      <div id="page-wrapper" >
		<div class="col-xs-12 col-sm-12 col-md-12 graphs">
			<div class="container">
        <div class="row">
        <div class="col-sm-12">
        <h1>Change Password</h1>
        </div>
        </div>
        <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
        <p class="text-center">Use the form below to change your password. Your password cannot be the same as your username.</p>
        <form method="post" id="passwordForm">
        <input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off">
        <div class="row">
        <div class="col-sm-6">
        <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> 8 Characters Long<br>
        <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Uppercase Letter
        </div>
        <div class="col-sm-6">
        <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Lowercase Letter<br>
        <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Number
        </div>
        </div>
        <input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Repeat Password" autocomplete="off">
        <div class="row">
        <div class="col-sm-12">
        <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Passwords Match
        </div>
        </div>
        <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Changing Password..." value="Change Password">
        </form>
        </div><!--/col-sm-6-->
        </div><!--/row-->
        </div>
      </div>
   <!-- #end class col-md-12 -->
    </div>
      <!-- /#page-wrapper -->
</div>
    <!-- /#wrapper -->
</body>