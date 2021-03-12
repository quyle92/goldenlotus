<?php 
$page_name = "BaoCaoBanHang";
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

//$today = $yesterday  = date("2020/12/01");
$today = date('yy/m/d');
$yesterday = date('yy/m/d',strtotime("-1 days"));


?>
<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<script>
$(document).ready(function() {
    $('#today').DataTable( {
      //Disable filtering on the first column:
      "order": [],
      "columnDefs": [ {
      "targets"  : 0,
      "orderable": false,
      }]
  } );

        $('#yesterday').DataTable( {
      //Disable filtering on the first column:
      "order": [],
      "columnDefs": [ {
      "targets"  : 0,
      "orderable": false,
      }]
  } );


  

    $('#this_month').DataTable( {
      //Disable filtering on the first column:
      "order": [],
      "columnDefs": [ {
      "targets"  : 0,
      "orderable": false,
      }]
    });


});


</script>
</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >
        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Tổng hợp món ăn bán</h3>
            <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Hôm nay</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Hôm qua</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Tháng này</a></li>
                            <li><a href="#tab4primary" data-toggle="tab">Tháng khác</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                            <div class="col-xs-12 col-sm-12 table-responsive">
                             <table class="table table-striped table-bordered" id="today">
                                <thead>
                                  <tr>
                                    <th>Tên nhóm</th>
                                    <th>Mã nhóm</th>
                                    <th>Tên món</th>
                                    <th>Số lượng</th>
                                    <th>Giá vốn</th>
                                    <th>Giá bán</th>
                                    <th>Giảm giá</th>
                                    <th>Chiết khâu</th>
                                    <th>Phí dịch vụ</th>
                                    <th>VAT</th>
                                    <th>Thành tiền</th>
                                    <th>Lợi nhuận</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $nhom_hang_ban_arr = array();
                                $food_sold_by_group = $goldenlotus->getFoodSoldByGroup( $today, $nhom_hang_ban_arr );
                                                               
                                foreach ( $nhom_hang_ban_arr as $nhom_hang_ban)
                                { 
                                  $food_sold_by_group = $goldenlotus->getFoodSoldByGroup( $today, $nhom_hang_ban_arr, $nhom_hang_ban);
                                   $i = 0;
                                  foreach ( $food_sold_by_group as $r ) {
                                 
                                  ?>
                                    <tr>
                                      <td><?=($i==0) ? $r['Ten'] : ""?></td>
                                      <td><?=$r['MaHangBan'] ?></td>
                                      <td><?=$r['TenHangBan']?></td>
                                      <td><?=$r['SoLuong']?></td>
                                      <td></td>
                                      <td><?=number_format($r['DonGia'],0,",",".")?><sup>đ</sup></td>
                                      <td><?=$r['TienGiamGia']?></td>
                                      <td></td>
                                      <td><?=$r['SoTienDVPhi']?></td>
                                      <td><?=$r['SoTienVAT']?></td>
                                      <td><?php echo number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".");
                                          $total = $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'] ?><sup>đ</sup></td>
                                      <td><?php echo number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".");
                                          $total = $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'] ?><sup>đ</sup></td>
                                    </tr>
                                  <?php 
                                  $i++;
                                  } 
                                }?>
                              </tbody>
                             </table>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="yesterday">
                                <thead>
                                  <tr>
                                    <th>Tên nhóm</th>
                                    <th>Mã nhóm</th>
                                    <th>Tên món</th>
                                    <th>Số lượng</th>
                                    <th>Giá vốn</th>
                                    <th>Giá bán</th>
                                    <th>Giảm giá</th>
                                    <th>Chiết khâu</th>
                                    <th>Phí dịch vụ</th>
                                    <th>VAT</th>
                                    <th>Thành tiền</th>
                                    <th>Lợi nhuận</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                               
                                $nhom_hang_ban_arr = array();
                                $food_sold_by_group = $goldenlotus->getFoodSoldByGroup( $yesterday, $nhom_hang_ban_arr );
                                                        
                                foreach ( $nhom_hang_ban_arr as $nhom_hang_ban)
                                { 
                                  $food_sold_by_group = $goldenlotus->getFoodSoldByGroup( $yesterday, $nhom_hang_ban_arr, $nhom_hang_ban);
                                   $i = 0;
                                  foreach ( $food_sold_by_group as $r )  {
                                   
                                  ?>
                                    <tr>
                                      <td><?=($i==0) ? $r['Ten'] : ""?></td>
                                      <td><?=$r['MaHangBan'] ?></td>
                                      <td><?=$r['TenHangBan']?></td>
                                      <td><?=$r['SoLuong']?></td>
                                      <td></td>
                                      <td><?=number_format($r['DonGia'],0,",",".")?><sup>đ</sup></td>
                                      <td><?=$r['TienGiamGia']?></td>
                                      <td></td>
                                      <td><?=$r['SoTienDVPhi']?></td>
                                      <td><?=$r['SoTienVAT']?></td>
                                      <td><?php echo number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".");
                                          $total = $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'] ?><sup>đ</sup></td>
                                      <td><?php echo number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".");
                                          $total = $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'] ?><sup>đ</sup></td>
                                    </tr>
                                  <?php 
                                  $i++;
                                  } 
                                }?>
                              </tbody>
                              </tbody>
                             </table>
							</div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="this_month">
                                <thead>
                                  <tr>
                                    <th>Tên nhóm</th>
                                    <th>Mã nhóm</th>
                                    <th>Tên món</th>
                                    <th>Số lượng</th>
                                    <th>Giá vốn</th>
                                    <th>Giá bán</th>
                                    <th>Giảm giá</th>
                                    <th>Chiết khâu</th>
                                    <th>Phí dịch vụ</th>
                                    <th>VAT</th>
                                    <th>Thành tiền</th>
                                    <th>Lợi nhuận</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$this_month = date('2016/03');
                                $this_month = date('yy/m');
                                $nhom_hang_ban_arr = array();
                                $food_sold_by_group = $goldenlotus->getFoodSoldByGroup_Month( $this_month, $nhom_hang_ban_arr);
                                foreach ( $nhom_hang_ban_arr as $nhom_hang_ban)
                                { 
                                  $food_sold_by_group = $goldenlotus->getFoodSoldByGroup_Month( $this_month, $nhom_hang_ban_arr, $nhom_hang_ban);
                                  $i = 0;
                                  foreach ( $food_sold_by_group as $r )  { ?>
                                	<tr>
                                      <td><?=($i==0) ? $r['Ten'] : ""?></td>
									<td><?=$r['MaHangBan'] ?></td>
                                      <td><?=$r['TenHangBan']?></td>
                                      <td><?=$r['SoLuong']?></td>
                                      <td></td>
                                      <td><?=number_format($r['DonGia'],0,",",".")?><sup>đ</sup></td>
										 <td><?=$r['TienGiamGia']?></td>
                                      <td></td>
                                      <td><?=$r['SoTienDVPhi']?></td>
                                      <td><?=$r['SoTienVAT']?></td>
										<td><?php echo number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".");
                                          $total = $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'] ?><sup>đ</sup></td>
                                      <td><?php echo number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".");
                                          $total = $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'] ?><sup>đ</sup></td>
                                    </tr>
 
                                <?php  } 
                                }?>
                              </tbody>
                             </table>
							  </div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">
                             <?php require_once('../datetimepicker.php'); ?>
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="custom_month">
                                <thead>
                                  <tr>
                                    <th>Tên nhóm</th>
                                    <th>Mã nhóm</th>
                                    <th>Tên món</th>
                                    <th>Số lượng</th>
                                    <th>Giá vốn</th>
                                    <th>Giá bán</th>
                                    <th>Giảm giá</th>
                                    <th>Chiết khâu</th>
                                    <th>Phí dịch vụ</th>
                                    <th>VAT</th>
                                    <th>Thành tiền</th>
                                    <th>Lợi nhuận</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                             </table>
                          </div>
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
	    $('#tab4primary').on('submit', 'form', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();console.log(tuNgay);
    var denNgay = $('#den-ngay').val();console.log(denNgay);
    
    $.ajax({
      url:"../tonghop-monan-ban/khac.php",
      method:"POST",
      data:{'tu-ngay' : tuNgay, 'den-ngay' : denNgay},
      dataType:"json",
	  beforeSend: function ( xhr ) {    
        $("#loadingMask").css('visibility', 'visible');
      },
      success:function(output)
      {
		 if ($.fn.DataTable.isDataTable("#custom_month")) {
             $("#custom_month").dataTable().fnDestroy();
		 }
		  
        $('#tab4primary table tbody').html(output);
		  
		$('#custom_month').DataTable({
			  "order": [],
			  "processing": true,
			 "language": {
				 "processing": "DataTables is currently busy"
			 },
			  "columnDefs": [ {
				  "targets"  : 0,
				  "orderable": false,
			  }]
		  });
		  
		  $.extend(true,  $.fn.dataTable.defaults, {
			  language: {
				  "processing": "Loading. Please wait..."
			  },
       	  });
      
		  
      },
		complete : function() { $("#loadingMask").css('visibility', 'hidden'); }
    })
  });


  /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;
for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    //this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
//dropdown[0].click();
</script>
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
});

</script>
</body>
</html>
