<?php 
$page_name = "BaoCaoQuanTri";
require_once('../helper/security.php');
require('../lib/db.php');
require('../lib/goldenlotus.php');
require('../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);




$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];



?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script> 
<script>


</script>  
</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
    <div id="page-wrapper">

    <div class="col-md-12 graphs">


 <h3 class="title">Báo cáo giờ</h3>
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
                    <div class="col-xs-12 col-sm-12">
                      <?php require('ngay.php'); ?>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="tab2primary">
                    <div class="col-xs-12 col-sm-12">
                      <?php require('thang.php'); ?>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab3primary">
                    <div class="col-xs-12 col-sm-12">
                      <?php require('nam.php');  ?>
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

</body>
</html>

