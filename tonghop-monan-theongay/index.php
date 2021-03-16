<?php 
$page_name = "BaoCaoBanHang";
require_once('../helper/security.php'); 
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];



$hom_nay  = date('Y/m/d');
$hom_truoc  = date('Y/m/d',strtotime("-1 day"));//2016/03/13
//$hom_nay = $hom_truoc = $hom_khac = date('2020/12/01');


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

</script> 
<style type="text/css">


</style>  
</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
    <div id="page-wrapper">

    <div class="col-md-12 graphs">
 <h3 class="title"> Tổng hợp món ăn bán theo ngày</h3>

            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Hôm nay</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Hôm qua</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Khác</a></li>

                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                          <div class="row">
                            <div class="col-md-6">
                              <strong>Tổng số tiền: <?php 
                                   $goldenlotus->getFoodSoldToday ($hom_nay, $total);
                                   echo  number_format($total,0,",",".");
                                  ?><sup>đ</sup>  
                              </strong>
                            </div>
                          </div>
                          <br>

                         <table class="table table-striped table-bordered" width="100%" id="today">
                          <thead>
                            <tr>
                              <th>Món ăn</th>
                              <th>DVT</th>
                              <th>SL</th>
                              <th>Thành tiền</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          $hang_ban = $goldenlotus->getFoodSoldToday($hom_nay, $total);
                          foreach ($hang_ban as $r){ ?>
                             <tr>
                              <td><?=$r['TenHangBan']?></td>
                              <td><?=$r['MaDVT']?></td>
                              <td><?=$r['SoLuong']?></td>
                              <td><?=number_format($r['ThanhTien'],0,",",".")?><sup>đ</sup></td>
                            </tr>
                         <?php }
                           ?>
                          </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="row">
                            <div class="col-md-6">
                              <strong>Tổng số tiền: <?php 
                                   $goldenlotus->getFoodSoldYesterday ($hom_truoc, $total);
                                   echo  number_format($total,0,",",".");
                                  ?><sup>đ</sup>  
                              </strong>
                            </div>
                          </div>
                          <br>

                          <table class="table table-striped table-bordered" width="100%" id="yesterday">
                            <thead>
                              <tr>
                                <th>Món ăn</th>
                                <th>DVT</th>
                                <th>SL</th>
                                <th>Thành tiền</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $hang_ban = $goldenlotus->getFoodSoldYesterday($hom_truoc, $total);
                                foreach ($hang_ban as $r){ ?>
                                   <tr>
                                    <td><?=$r['TenHangBan']?></td>
                                    <td><?=$r['MaDVT']?></td>
                                    <td><?=$r['SoLuong']?></td>
                                    <td><?=number_format($r['ThanhTien'],0,",",".")?><sup>đ</sup></td>
                                  </tr>
                                <?php }
                              ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="row tong_doanh_thu">
                            <div class="col-md-6">
                              <strong>  
                              </strong>
                            </div>
                          </div>
                          <br>

                          <?php require_once('../datetimepicker.php'); ?>
                         <table class="table table-striped table-bordered" width="100%" id="custom_day">
                            <thead>
                              <tr>
                              <th>Món ăn</th>
                              <th>DVT</th>
                              <th>SL</th>
                              <th>Thành tiền</th>
                              </tr>
                            </thead>
                            <tbody>
       
                            </tbody>
                          </table>
                        </div>

                        
                    </div>
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
<?php require_once('../ajax-loading.php'); ?>
<script>
 
 $('form').on('submit', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    
    $.ajax({
      url:"../tonghop-monan-theongay/theongay.php",
      method:"POST",
      data:formValues,
      beforeSend :function(){
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(response)
      {
        var result = JSON.parse(response);
        var total = result[0];
        
        /*
        *remove total (first value in array) from array
        */
         result.shift();


        $('#tab3primary .row.tong_doanh_thu .col-md-6 strong').html(total);
       
		if ($.fn.DataTable.isDataTable("#custom_day")) {
			$("#custom_day").dataTable().fnDestroy();
		}
		   
	    $('#tab3primary table tbody').html(result);
		
		$('#custom_day').DataTable({
            "order": [],
            "columnDefs": [ {
              "targets"  : 0,
              "orderable": false,
            }]
          });


      },
	complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
    });
  });



</script>

</body>
</html>

