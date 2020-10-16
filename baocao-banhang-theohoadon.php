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
            <h3 class="title">Bản kê chi tiết hóa đơn bán hàng</h3>
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
                                    <th>Ngày bán</th>
                                    <th>PTTT</th>
                                    <th>Mã hóa đơn</th>
                                    <th>Thu ngân</th>
                                    <th>Tầng</th>
                                    <th>Món ăn</th>
                                    <th>Ghi chú</th>
                                    <th>Giá bán</th>
                                    <th>SL</th>
                                    <th>Giảm giá</th>
                                    <th>Chiết khâu</th>
                                    <th>Phí dịch vụ</th>
                                    <th>VAT</th>
                                    <th>Thành tiền</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                $bill_details_today = $goldenlotus->getBillDetailsToday( $today );
                                $count = sqlsrv_num_rows($bill_details_today);
                                $total = 0;settype($total,"integer");

                                for ($i = 0; $i < sqlsrv_num_rows($bill_details_today); $i++) {
                                $r = sqlsrv_fetch_array($bill_details_today, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                                ?>
                                  <tr>
                                    <td><?=($i==0)?$r['ThoiGianBan']->format('d-m-Y'):""?></td>
                                    <td><?=( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" )?></td>
                                    <td><?=$r['MaLichSuPhieu']?></td>
                                    <td></td>
                                    <td></td>
                                    <td><?=$r['TenHangBan']?></td>
                                    <td></td>
                                    <td><?=number_format($r['DonGia'],0,",",".")?><sup>đ</sup></td>
                                    <td><?=$r['SoLuong']?></td>
                                    <td><?=$r['TienGiamGia']?></td>
                                    <td></td>
                                    <td><?=$r['SoTienDVPhi']?></td>
                                    <td><?=$r['SoTienVAT']?></td>
                                    <td><?php echo number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".");
                                        $total += $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'] ?><sup>đ</sup></td>
                                  </tr>
                                <?php
                                if ($i == $count - 1) echo ' <tr><td>Tổng</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>' . number_format($total,0,",",".") . '<sup>đ</sup></td>
                                  </tr>';
                                ?>
                                <?php 
                               } ?>
                              </tbody>
                             </table>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="sailorTable">
                                <thead>
                                  <tr>
                                    <th>Ngày bán</th>
                                    <th>PTTT</th>
                                    <th>Mã hóa đơn</th>
                                    <th>Thu ngân</th>
                                    <th>Tầng</th>
                                    <th>Món ăn</th>
                                    <th>Ghi chú</th>
                                    <th>Giá bán</th>
                                    <th>SL</th>
                                    <th>Giảm giá</th>
                                    <th>Chiết khâu</th>
                                    <th>Phí dịch vụ</th>
                                    <th>VAT</th>
                                    <th>Thành tiền</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                $bill_details_yesterday = $goldenlotus->getBillDetailsYesterday( $yesterday );
                                $count = sqlsrv_num_rows($bill_details_yesterday);
                                $total = 0;settype($total,"integer");

                                for ($i = 0; $i < sqlsrv_num_rows($bill_details_yesterday); $i++) {
                                $r = sqlsrv_fetch_array($bill_details_yesterday, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                                ?>
                                  <tr>
                                    <td><?=($i==0)?$r['ThoiGianBan']->format('d-m-Y'):""?></td>
                                    <td><?=( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" )?></td>
                                    <td><?=$r['MaLichSuPhieu']?></td>
                                    <td></td>
                                    <td></td>
                                    <td><?=$r['TenHangBan']?></td>
                                    <td></td>
                                    <td><?=number_format($r['DonGia'],0,",",".")?><sup>đ</sup></td>
                                    <td><?=$r['SoLuong']?></td>
                                    <td><?=$r['TienGiamGia']?></td>
                                    <td></td>
                                    <td><?=$r['SoTienDVPhi']?></td>
                                    <td><?=$r['SoTienVAT']?></td>
                                    <td><?php echo number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".");
                                        $total += $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'] ?><sup>đ</sup></td>
                                  </tr>
                                <?php
                                if ($i == $count - 1) echo ' <tr><td>Tổng</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>' . number_format($total,0,",",".") . '<sup>đ</sup></td>
                                  </tr>';
                                ?>
                                <?php 
                               } ?>
                              </tbody>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="sailorTable">
                                <thead>
                                  <tr>
                                    <th>Ngày bán</th>
                                    <th>PTTT</th>
                                    <th>Mã hóa đơn</th>
                                    <th>Thu ngân</th>
                                    <th>Tầng</th>
                                    <th>Món ăn</th>
                                    <th>Ghi chú</th>
                                    <th>Giá bán</th>
                                    <th>SL</th>
                                    <th>Giảm giá</th>
                                    <th>Chiết khâu</th>
                                    <th>Phí dịch vụ</th>
                                    <th>VAT</th>
                                    <th>Thành tiền</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                $this_month = date('Y/m');
                                $dates_has_bill_of_this_month = $goldenlotus->getDatesHasBillOfThisMonth( $this_month );
                                while ($rs = sqlsrv_fetch_array( $dates_has_bill_of_this_month ))
                                {
                                  $date = $rs['NgayCoBill'];
                                  $bill_details_by_date_of_month = $goldenlotus->getBillDetailsByDayOfMonth( $date );
                                  $count = sqlsrv_num_rows($bill_details_by_date_of_month);
                                  $total = 0;settype($total,"integer");
                                  $grand_total = 0;settype($total,"integer");
                                  for ($i = 0; $i < sqlsrv_num_rows($bill_details_by_date_of_month); $i++) {
                                  $r = sqlsrv_fetch_array($bill_details_by_date_of_month, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                                  ?>
                                    <tr>
                                      <td><?=($i==0)?$r['ThoiGianBan']->format('d-m-Y'):""?></td>
                                      <td><?=( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" )?></td>
                                      <td><?=$r['MaLichSuPhieu']?></td>
                                      <td></td>
                                      <td></td>
                                      <td><?=$r['TenHangBan']?></td>
                                      <td></td>
                                      <td><?=number_format($r['DonGia'],0,",",".")?><sup>đ</sup></td>
                                      <td><?=$r['SoLuong']?></td>
                                      <td><?=$r['TienGiamGia']?></td>
                                      <td></td>
                                      <td><?=$r['SoTienDVPhi']?></td>
                                      <td><?=$r['SoTienVAT']?></td>
                                      <td><?php echo number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".");
                                          $total += $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'] ?><sup>đ</sup></td>
                                    </tr>
                                  <?php
                                  if ($i == $count - 1) { ?> <tr><td>Tổng</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo  number_format($total,0,",",".") ; $grand_total += $total; ?><sup>đ</sup></td>
                                    </tr>
                                  <?php } ?>
                                  <?php 
                                 }

                               } ?>
                                <tr>
                                  <td><strong>Grand Total</strong></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td><?=number_format($grand_total,0,",",".")?><sup>đ</sup></td>
                                </tr>
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
                                    <th>Ngày bán</th>
                                    <th>PTTT</th>
                                    <th>Mã hóa đơn</th>
                                    <th>Thu ngân</th>
                                    <th>Tầng</th>
                                    <th>Món ăn</th>
                                    <th>Ghi chú</th>
                                    <th>Giá bán</th>
                                    <th>SL</th>
                                    <th>Giảm giá</th>
                                    <th>Chiết khâu</th>
                                    <th>Phí dịch vụ</th>
                                    <th>VAT</th>
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
      url:"baocao-banhang-theohoadon/khac.php",
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
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
dropdown[0].click();
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