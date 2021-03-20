<?php 
$page_name = "BaoCaoBanHang";
require_once('../helper/security.php');
include_once( '../lib/db.php');
include_once( '../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id = isset($_SESSION['MaNV'])? $_SESSION['MaNV']:"";
$ten = isset($_SESSION['TenNV'])? $_SESSION['TenNV']:"";

$matrungtam = isset($_SESSION['MaTrungTam'])? $_SESSION['MaTrungTam']:"";
$trungtam = isset($_SESSION['TenTrungTam'])? $_SESSION['TenTrungTam']:"";

?>
<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<script>
   $(document).ready(function() {
    $('#today').DataTable();
} );
  $(document).ready(function() {
    $('#yesterday').DataTable();
} );
  
   $(document).ready(function() {
    $('#this_month').DataTable( {
      //Disable filtering on the first column:
      "order": [],
      "columnDefs": [ {
      "targets"  : 0,
      "orderable": false,
      }]
    });
} );
  
//    $(document).ready(function() {
//     $('#custom_month').DataTable();
// } );



</script>
<style>


</style>

</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Bảng kê chi tiết phương thức thanh toán</h3>

            <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Ngày</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Tháng</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Năm</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                            <?php include('ngay.php'); ?>
                        
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                            <?php include('thang.php'); ?>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                            <?php include('nam.php'); ?>
                        
                         <div>
                </div>
            </div>
<!-- END BIEU DO DOANH THU-->

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

