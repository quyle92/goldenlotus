<?php  
$page_name = "BaoCaoBanHang";
require_once('../helper/security.php'); 
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$today = date('yy/m/d');
$yesterday = date('yy/m/d',strtotime("-1 days"));
//$today = $yesterday = date('2020/12/01');

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];


?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<style>
.bangke-chitiet-hoadon .table-responsive .table-striped{
  font-size: 13px!important;
}
.bangke-chitiet-hoadon .panel-body{
  padding: 0;
}
</style>
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

</script>
</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Bảng kê chi tiết hóa đơn bán hàng</h3>

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
                             <table class="table table-striped table-bordered" id="today">
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
                  
                                $bill_details_today = $goldenlotus->getBillDetailsToday( $today, $count );
                                //$count = sqlsrv_num_rows($bill_details_today);

                                $total_tong_tien = 0;
                                $total_giam_gia_mon = 0;
                                $total_thuc_thu = 0;
                                $i = 0;
                                foreach ( $bill_details_today as $r ) {
                                ?>
                                  <tr>
                                    <td><?=$r['MaLichSuPhieu']?></td>
                                    <td><?=( !empty( $r['NVTinhTienMaNV'] ) ? $r['NVTinhTienMaNV'] : "" )?></td>
                                    <td><?=substr($r['GioVao'],11,5)?></td>
                                    <td><?=substr($r['ThoiGianDongPhieu'],11,5)?></td>
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
                                  <td></td>                                 
                                  </tr>';
                                ?>
                                <?php $i++;
                               } ?>
                              </tbody>
                             </table>
                           </div>
                        
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" width="100%" id="yesterday">
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
         
                                $bill_details_yesterday = $goldenlotus->getBillDetailsYesterday( $yesterday, $count );
                           
                                $total_tong_tien = 0;
                                $total_giam_gia_mon = 0;
                                $total_thuc_thu = 0;

                                foreach ( $bill_details_yesterday as $r ) {
                                ?>
                                  <tr>
                                    <td><?=$r['MaLichSuPhieu']?></td>
                                    <td><?=( !empty( $r['NVTinhTienMaNV'] ) ? $r['NVTinhTienMaNV'] : "" )?></td>
                                    <td><?=substr($r['GioVao'],11,5)?></td>
                                    <td><?=( $r['ThoiGianDongPhieu'] ) ? substr($r['ThoiGianDongPhieu'],11,5) : ""?></td>
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
                            <table class="table table-striped table-bordered" width="100%" id="this_month">
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
                                //$this_month = date('2020/08');
                                $this_month = date('yy/m');
                            
                                $k = 0;

                                $grand_total_tong_tien = 0;
                                $grand_total_giam_gia_mon = 0;
                                $grand_total_thuc_thu = 0;
                               
                                  $bill_details_this_month = $goldenlotus->getBillDetailsThisMonth( $this_month , $total_count);
                                  //$count = sqlsrv_num_rows($bill_details_by_date_of_month); 
                                  $total_tong_tien = 0;
                                  $total_giam_gia_mon = 0;
                                  $total_thuc_thu = 0;
                                  foreach ( $bill_details_this_month as $r ) {
                                  ?>
                                    <tr>
                                      <td><?=$r['MaLichSuPhieu']?></td>
                                      <td><?=( !empty( $r['NVTinhTienMaNV'] ) ? $r['NVTinhTienMaNV'] : "" )?></td>
                                      <td><?=substr($r['GioVao'],11,5)?></td>
                                      <td><?=( $r['ThoiGianDongPhieu'] ) ? substr($r['ThoiGianDongPhieu'],11,5)  : ""?></td>
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
                                  
                                  ?>
                                </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">
                            <div class="row" style="padding-left: 17px;">
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
                            <table class="table table-striped table-bordered" width="100%" id="custom_month">
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
      url:"khac.php",
      method:"POST",
      data:{'tu-ngay' : tuNgay, 'den-ngay' : denNgay},
      dataType:"json",
      success:function(output)
      {
		 if ($.fn.DataTable.isDataTable("#custom_month")) {
             $("#custom_month").dataTable().fnDestroy();
            // $('#custom_month').DataTable({ 
            //   "destroy": true, //use for reinitialize datatable
            // });

        } 
		  
        $('#tab4primary table tbody').html(output);
		 
		$('#custom_month').DataTable({ 
          "order": [],
          "columnDefs": [ {
          "targets"  : 0,
          "orderable": false,
          }]
        });
    
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

