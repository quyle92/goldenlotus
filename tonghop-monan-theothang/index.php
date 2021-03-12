<?php
$page_name = "BaoCaoBanHang";
require_once('../helper/security.php');
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id = $_SESSION['MaNV'];
$ten = $_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];

$ma_quay = isset( $_GET['ma_quay'] ) ? $_GET['ma_quay'] : '';
if( ! empty( $ma_quay ) )
{
  $goldenlotus->layView( $ma_quay  );
}
// $thang_nay  = date('Y/m');
// $thang_truoc  = date('Y/m',strtotime("-1 month"));
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
    
<script>
   $(document).ready(function() {
    $('#this_month').DataTable();
} );
  $(document).ready(function() {
    $('#last_month').DataTable();
} );

</script>   
</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
    <div id="page-wrapper">

    <div class="col-md-12 graphs">
 <h3 class="title"> Tổng hợp món ăn bán theo tháng</h3>

            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Tháng nay</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Tháng qua</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Khác</a></li>

                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                          <div class="row">
                            <div class="col-md-6">
                              <strong>Tổng doanh thu: <?php 
                                   $hang_ban = $goldenlotus->getFoodSoldThisMonth ( $total, $ma_quay );
                                   //pr(count($hang_ban));
                                   echo  number_format($total,0,",",".");
                                  ?><sup>đ</sup>  
                              </strong>
                            </div>
                          </div>
                          <br>
                            
                         <table class="table table-striped table-bordered display" width="100%" id="this_month">
                          <thead>
                            <tr>
                              <th>Hàng Bán</th>
                              <th>DVT</th>
                              <th>SL</th>
                              <th>Thành tiền</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          //$hang_ban = $goldenlotus->getFoodSoldThisMonth($thang_nay, $ma_quay);pr(count($hang_ban));
                          $total = 0;
                          foreach ($hang_ban as $r){ ?>
                             <tr>
                              <td><?=$r['TenHangBan']?></td>
                              <td><?=$r['MaDVT']?></td>
                              <td><?=$r['SoLuong']?></td>
                              <td><?php echo number_format($r['ThanhTien'],0,",","."); $total += $r['ThanhTien'];?><sup>đ</sup></td>
                            </tr>
                         <?php }
                           ?> 
                          </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="row">
                            <div class="col-md-6">
                              <strong>Tổng doanh thu: <?php 
                                   $hang_ban = $goldenlotus->getFoodSoldLastMonth ($total, $ma_quay);
                                   echo  number_format($total,0,",",".");
                                  ?><sup>đ</sup>  
                              </strong>
                            </div>
                          </div>
                          <br>
                          <table class="table table-striped table-bordered display" width="100%" id="last_month">
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
                          <div class="row">
                            <form action="" method="post">
                              <input name="ma_quay" type='hidden' class="form-control" id="ma_quay" value="<?=$ma_quay?>"/>

                                <div class="col-md-2" style="margin-bottom:5px">Từ:</div>
                                <div class="col-md-3 input-group date" style="margin-bottom:5px;float:left">
                                  <input name="tu-thang"type='text' class="form-control" id="tu-thang" />
                                  <span class="input-group-addon">
                                  <span class="glyphicon glyphicon-calendar"></span>
								                  </span>
                                </div>
                                <div class="col-md-2" style="margin-bottom:5px">Đến:</div>
                                <div class="col-md-3 input-group date" style="margin-bottom:5px">
                                  <input name="den-thang" type="text" class="form-control" id="den-thang" />
								                  <span class="input-group-addon">
                                 	 <span class="glyphicon glyphicon-calendar"></span>
								                  </span>
                                </div>
                                <div class="col-md-3" style="margin-bottom:5px">
                                  <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                              </form>
                          </div>
                          <div class="row tong_doanh_thu">
                            <div class="col-md-6">
                              <strong>  
                              </strong>
                            </div>
                          </div>
                          <br>
                         <table class="table table-striped table-bordered display" width="100%" id="custom_month">
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
    console.log(formValues);
    $.ajax({
      url:"../tonghop-monan-theothang/theothang.php",
      method:"POST",
      data:formValues,
      beforeSend :function(){
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(response)
      {  
		console.log(response);
        var result = JSON.parse(response);
        var total = result[0];
        
        /*
        *remove total (first value in array) from array
        */
         result.shift();

		
        $('#tab3primary .row.tong_doanh_thu .col-md-6 strong').html(total);
       
		if ($.fn.DataTable.isDataTable("#custom_month")) {
			$("#custom_month").dataTable().fnDestroy();
		}
		   
	    $('#tab3primary table tbody').html(result);
		
		$('#custom_month').DataTable({
            "order": [],
            "columnDefs": [ {
              "targets"  : 0,
              "orderable": false,
            }]
          });


      },
		complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
    })
  });

  /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;


for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
   // //this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;//console.log(dropdownContent);
    if (dropdownContent.style.display == "block") {
      dropdownContent.style.display = "none";
    

    } else {
      dropdownContent.style.display = "block";

    }
  });
}

////dropdown[0].click();


</script>
<script>


$(function () {
	
	$('#tu-thang').datetimepicker({
		viewMode: 'years',
		format: 'MM/YYYY'
	});
	
	$('#den-thang').datetimepicker({
		viewMode: 'years',
		format: 'MM/YYYY'
	});
}); 

</script>
</body>
</html>

