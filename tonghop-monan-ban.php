<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];
$today  = date('Y/m/d',strtotime("-1 month"));
$yesterday  = date('Y/m/d',strtotime("-1 month"));

$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
$page_name = "BaoCaoBanHang";
if( $_SESSION['MaNV'] != 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
?>
<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>
<style>
</style>
</head>
<body>
<div id="wrapper ">
    <?php include 'menu.php'; ?>
      <div id="page-wrapper" >
        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Bảng kê chi tiết hóa đơn bán hàng</h3>
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
                             <table class="table table-striped table-bordered" id="sailorTable">
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
                                $today = date("2020/08/26");
                                $nhom_hang_ban_arr = array();
                                $food_sold_by_group = $goldenlotus->getFoodSoldByGroup( $today, $nhom_hang_ban_arr );
                                                               
                                foreach ( $nhom_hang_ban_arr as $nhom_hang_ban)
                                { 
                                  $food_sold_by_group = $goldenlotus->getFoodSoldByGroup( $today, $nhom_hang_ban_arr, $nhom_hang_ban);
                                  for ($i = 0; $i < sqlsrv_num_rows($food_sold_by_group); $i++) {
                                  $r = sqlsrv_fetch_array($food_sold_by_group, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
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
                                  } 
                                }?>
                              </tbody>
                             </table>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="sailorTable">
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
                                $yesterday = date("2020/08/29");
                                $nhom_hang_ban_arr = array();
                                $food_sold_by_group = $goldenlotus->getFoodSoldByGroup( $yesterday, $nhom_hang_ban_arr );
                                                               
                                foreach ( $nhom_hang_ban_arr as $nhom_hang_ban)
                                { 
                                  $food_sold_by_group = $goldenlotus->getFoodSoldByGroup( $today, $nhom_hang_ban_arr, $nhom_hang_ban);
                                  for ($i = 0; $i < sqlsrv_num_rows($food_sold_by_group); $i++) {
                                  $r = sqlsrv_fetch_array($food_sold_by_group, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
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
                                  } 
                                }?>
                              </tbody>
                              </tbody>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="sailorTable">
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
                                $this_month = date('2020/08');
                                $nhom_hang_ban_arr = array();
                                $food_sold_by_group = $goldenlotus->getFoodSoldByGroup_Month( $this_month, $nhom_hang_ban_arr);
                                                               
                                foreach ( $nhom_hang_ban_arr as $nhom_hang_ban)
                                { 
                                  $food_sold_by_group = $goldenlotus->getFoodSoldByGroup_Month( $this_month, $nhom_hang_ban_arr, $nhom_hang_ban);
                                  for ($i = 0; $i < sqlsrv_num_rows($food_sold_by_group); $i++) {
                                  $r = sqlsrv_fetch_array($food_sold_by_group, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
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
                                  } 
                                }?>
                              </tbody>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">
                            <div class="row">
                              <form action="" method="post">
                                  <div class="col-md-2" style="margin-bottom:5px">Từ:</div>
                                  <div class="col-md-3" style="margin-bottom:5px">
                                    <input name="tu-ngay" type="text"  value="" id="tu-ngay" />
                                  </div>
                                  <div class="col-md-2" style="margin-bottom:5px">Đến:</div>
                                  <div class="col-md-3" style="margin-bottom:5px">
                                    <input name="den-ngay" type="text" value="" id="den-ngay" />
                                  </div>
                                  <div class="col-md-3" style="margin-bottom:5px">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                  </div>
                              </form>
                            </div>
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="sailorTable">
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
<script>

     $('form').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();console.log(tuNgay);
    var denNgay = $('#den-ngay').val();console.log(denNgay);
    
    $.ajax({
      url:"tonghop-monan-ban/khac.php",
      method:"POST",
      data:{'tu-ngay' : tuNgay, 'den-ngay' : denNgay},
      dataType:"json",
      success:function(output)
      {
        $('#tab4primary table tbody').html(output);
      }
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
$('#tu-ngay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
$('#den-ngay').datepicker({  uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
</script>
</body>
</html>