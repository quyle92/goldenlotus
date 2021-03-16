<?php 
$page_name = "BieuDoDoanhThu";
require_once('../helper/security.php');
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];


 
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>


</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
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
		$rs = $dbCon->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if($rs != false)
    {
      //show the results
    
      foreach ( $rs as $r ) 
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


     </form>
     <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Ngày</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Tháng này</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Tháng trước</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Khác</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                          <div class="col-xs-12 col-sm-12">
                          	<?php require('../bieudo-dophu/baygio.php'); ?>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12">
                          	<?php //require('bieudo-dophu/thangnay.php'); ?>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12">
                          	<?php //require('bieudo-dophu/thangtruoc.php');  ?>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12">
                            <?php //require('bieudo-dophu/khac.php');  ?>
                          </div>
                        </div>
                        
                    </div>
                </div>
            </div>
<!-- END BIEU DO DOANH THU-->

  </div>
 	<!-- #end class xs-->
   </div>
   <!-- #end class col-md-12 -->
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->


</body>
</html>

