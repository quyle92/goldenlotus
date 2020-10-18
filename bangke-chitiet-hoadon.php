<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;


$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];

?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>
<style>
.bangke-chitiet-hoadon .table-responsive .table-striped{
  font-size: 13px!important;
}
.bangke-chitiet-hoadon .panel-body{
  padding: 0;
}
</style>

</head>
<body>
<div id="wrapper ">
    <?php include 'menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Bản kê chi tiết hóa đơn bán hàng</h3>

            <div class="panel with-nav-tabs panel-primary bangke-chitiet-hoadon">
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
                                    <th>Số HĐ</th>
                                    <th>Thu ngân</th>
                                    <th>Giờ vào</th>
                                    <th>Giờ ra</th>
                                    <th>Khách</th>
                                    <th>Khu vực</th>
                                    <th>Bàn</th>
                                    <th>Tổng tiền</th>
                                    <th>Giảm giá món</th>
                                    <th>% chiết khấu</th>
                                    <th>Tiền chiết khấu %</th>
                                    <th>Tiền phiếu giảm giá</th>
                                    <th>Phí dịch vụ</th>
                                    <th>Tiền phí dịch vụ</th>
                                    <th>Tiền thuế</th>
                                    <th>Thực thu</th>
                                    <th>Ghi chú</th>
                                    <th>Tạm tính</th>
                                    <th>Tên khách</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                $today = date('2020/08/26');
                                $bill_details_today = $goldenlotus->getBillDetailsToday( $today );
                                $count = sqlsrv_num_rows($bill_details_today);

                                $total_tong_tien = 0;
                                $total_giam_gia_mon = 0;
                                $total_thuc_thu = 0;

                                for ($i = 0; $i < sqlsrv_num_rows($bill_details_today); $i++) {
                                $r = sqlsrv_fetch_array($bill_details_today, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                                ?>
                                  <tr>
                                    <td><?=$r['MaLichSuPhieu']?></td>
                                    <td><?=( !empty( $r['NVTinhTienMaNV'] ) ? $r['NVTinhTienMaNV'] : "" )?></td>
                                    <td><?=$r['GioVao']->format('H:i')?></td>
                                    <td><?=$r['ThoiGianDongPhieu']->format('H:i')?></td>
                                    <td><?=$r['MaKhachHang']?></td>
                                    <td><?=$r['MaKhu']?></td>
                                    <td><?=$r['MaBan']?></td>
                                    <td><?php echo $r['TongTien']; $total_tong_tien += $r['TongTien']; ?></td>
                                    <td><?php echo $r['TienGiamGia']; $total_giam_gia_mon += $r['TienGiamGia']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?=$r['SoTienDVPhi']?></td>
                                    <td><?=$r['SoTienVAT']?></td>
                                    <td><?php echo number_format($r['TienThucTra'],0,",",".");
                                        $total_thuc_thu += $r['TienThucTra'] ?><sup>đ</sup>
                                    </td>
                                    <td></td>
                                    <td><?php echo number_format($r['TienThucTra'],0,",",".")?><sup>đ</sup></td>
                                    <td><?=$r['MaKhachHang']?></td>
                                  </tr>
                                <?php
                                if ($i == $count - 1) echo ' <tr><td>Tổng</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>'. number_format($total_tong_tien,0,",",".") . '<sup>đ</sup></td>
                                  <td>'. number_format($total_giam_gia_mon,0,",",".") . '<sup>đ</sup></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>' . number_format($total_thuc_thu,0,",",".") . '<sup>đ</sup>
                                  </td
                                  <td></td>
                                  <td></td>
                                  <td></td>                                  
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
                            <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                                <thead>
                                  <tr>
                                    <th>Số HĐ</th>
                                    <th>Thu ngân</th>
                                    <th>Giờ vào</th>
                                    <th>Giờ ra</th>
                                    <th>Khách</th>
                                    <th>Khu vực</th>
                                    <th>Bàn</th>
                                    <th>Tổng tiền</th>
                                    <th>Giảm giá món</th>
                                    <th>% chiết khấu</th>
                                    <th>Tiền chiết khấu %</th>
                                    <th>Tiền phiếu giảm giá</th>
                                    <th>Phí dịch vụ</th>
                                    <th>Tiền phí dịch vụ</th>
                                    <th>Tiền thuế</th>
                                    <th>Thực thu</th>
                                    <th>Ghi chú</th>
                                    <th>Tạm tính</th>
                                    <th>Tên khách</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                $yesterday = date('2020/08/29');
                                $bill_details_yesterday = $goldenlotus->getBillDetailsYesterday( $yesterday );
                                $count = sqlsrv_num_rows($bill_details_yesterday);

                                $total_tong_tien = 0;
                                $total_giam_gia_mon = 0;
                                $total_thuc_thu = 0;

                                for ($i = 0; $i < sqlsrv_num_rows($bill_details_yesterday); $i++) {
                                $r = sqlsrv_fetch_array($bill_details_yesterday, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                                ?>
                                  <tr>
                                    <td><?=$r['MaLichSuPhieu']?></td>
                                    <td><?=( !empty( $r['NVTinhTienMaNV'] ) ? $r['NVTinhTienMaNV'] : "" )?></td>
                                    <td><?=$r['GioVao']->format('H:i')?></td>
                                    <td><?=( $r['ThoiGianDongPhieu'] ) ? $r['ThoiGianDongPhieu']->format('H:i') : ""?></td>
                                    <td><?=$r['MaKhachHang']?></td>
                                    <td><?=$r['MaKhu']?></td>
                                    <td><?=$r['MaBan']?></td>
                                    <td><?php echo $r['TongTien']; $total_tong_tien += $r['TongTien']; ?></td>
                                    <td><?php echo $r['TienGiamGia']; $total_giam_gia_mon += $r['TienGiamGia']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?=$r['SoTienDVPhi']?></td>
                                    <td><?=$r['SoTienVAT']?></td>
                                    <td><?php echo number_format($r['TienThucTra'],0,",",".");
                                        $total_thuc_thu += $r['TienThucTra'] ?><sup>đ</sup>
                                    </td>
                                    <td></td>
                                    <td><?php echo number_format($r['TienThucTra'],0,",",".")?><sup>đ</sup></td>
                                    <td><?=$r['MaKhachHang']?></td>
                                  </tr>
                                <?php
                                if ($i == $count - 1) echo ' <tr><td>Tổng</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>'. number_format($total_tong_tien,0,",",".") . '<sup>đ</sup></td>
                                  <td>'. number_format($total_giam_gia_mon,0,",",".") . '<sup>đ</sup></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td>' . number_format($total_thuc_thu,0,",",".") . '<sup>đ</sup>
                                  </td
                                  <td></td>
                                  <td></td>
                                  <td></td>                                  
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
                            <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                                <thead>
                                  <tr>
                                    <th>Số HĐ</th>
                                    <th>Thu ngân</th>
                                    <th>Giờ vào</th>
                                    <th>Giờ ra</th>
                                    <th>Khách</th>
                                    <th>Khu vực</th>
                                    <th>Bàn</th>
                                    <th>Tổng tiền</th>
                                    <th>Giảm giá món</th>
                                    <th>% chiết khấu</th>
                                    <th>Tiền chiết khấu %</th>
                                    <th>Tiền phiếu giảm giá</th>
                                    <th>Phí dịch vụ</th>
                                    <th>Tiền phí dịch vụ</th>
                                    <th>Tiền thuế</th>
                                    <th>Thực thu</th>
                                    <th>Ghi chú</th>
                                    <th>Tạm tính</th>
                                    <th>Tên khách</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                $this_month = date('2020/08');
                                $dates_has_bill_of_this_month = $goldenlotus->getDatesHasBillOfThisMonth( $this_month );
                                $k = 0;
                                $total_count = sqlsrv_num_rows($dates_has_bill_of_this_month);

                                $grand_total_tong_tien = 0;
                                $grand_total_giam_gia_mon = 0;
                                $grand_total_thuc_thu = 0;
                                while ($rs = sqlsrv_fetch_array( $dates_has_bill_of_this_month ))
                                {
                                  $date = $rs['NgayCoBill'];
                                  $bill_details_by_date_of_month = $goldenlotus->getBillDetailsByDayOfMonth( $date );
                                  $count = sqlsrv_num_rows($bill_details_by_date_of_month); 
                                  $total_tong_tien = 0;
                                  $total_giam_gia_mon = 0;
                                  $total_thuc_thu = 0;
                                  for ($i = 0; $i < sqlsrv_num_rows($bill_details_by_date_of_month); $i++) {
                                  $r = sqlsrv_fetch_array($bill_details_by_date_of_month, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                                  ?>
                                    <tr>
                                      <td><?=$r['MaLichSuPhieu']?></td>
                                      <td><?=( !empty( $r['NVTinhTienMaNV'] ) ? $r['NVTinhTienMaNV'] : "" )?></td>
                                      <td><?=$r['GioVao']->format('H:i')?></td>
                                      <td><?=( $r['ThoiGianDongPhieu'] ) ? $r['ThoiGianDongPhieu']->format('H:i') : ""?></td>
                                      <td><?=$r['MaKhachHang']?></td>
                                      <td><?=$r['MaKhu']?></td>
                                      <td><?=$r['MaBan']?></td>
                                      <td><?php echo $r['TongTien']; $total_tong_tien += $r['TongTien']; ?></td>
                                      <td><?php echo $r['TienGiamGia']; $total_giam_gia_mon += $r['TienGiamGia']; ?></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td><?=$r['SoTienDVPhi']?></td>
                                      <td><?=$r['SoTienVAT']?></td>
                                      <td><?php echo number_format($r['TienThucTra'],0,",",".");
                                          $total_thuc_thu += $r['TienThucTra'] ?><sup>đ</sup>
                                      </td>
                                      <td></td>
                                      <td><?php echo number_format($r['TienThucTra'],0,",",".")?><sup>đ</sup></td>
                                      <td><?=$r['MaKhachHang']?></td>
                                    </tr>
                                  <?php }
                                  $k++; 
                                  $grand_total_tong_tien += $total_tong_tien;
                                  $grand_total_giam_gia_mon += $total_giam_gia_mon;
                                  $grand_total_thuc_thu += $total_thuc_thu;
                                  if ($k == $total_count ) echo ' <tr><td>Tổng</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>'. number_format($grand_total_tong_tien,0,",",".") . '<sup>đ</sup></td>
                                    <td>'. number_format($grand_total_giam_gia_mon,0,",",".") . '<sup>đ</sup></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>' . number_format($grand_total_thuc_thu,0,",",".") . '<sup>đ</sup>
                                    </td
                                    <td></td>
                                    <td></td>
                                    <td></td>                                  
                                    </tr>';
                                  ?>
                                  <?php 
                                  
                                } ?>
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
                            <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                                <thead>
                                  <tr>
                                    <th>Số HĐ</th>
                                    <th>Thu ngân</th>
                                    <th>Giờ vào</th>
                                    <th>Giờ ra</th>
                                    <th>Khách</th>
                                    <th>Khu vực</th>
                                    <th>Bàn</th>
                                    <th>Tổng tiền</th>
                                    <th>Giảm giá món</th>
                                    <th>% chiết khấu</th>
                                    <th>Tiền chiết khấu %</th>
                                    <th>Tiền phiếu giảm giá</th>
                                    <th>Phí dịch vụ</th>
                                    <th>Tiền phí dịch vụ</th>
                                    <th>Tiền thuế</th>
                                    <th>Thực thu</th>
                                    <th>Ghi chú</th>
                                    <th>Tạm tính</th>
                                    <th>Tên khách</th>
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
      url:"bangke-chitiet-hoadon/khac.php",
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
