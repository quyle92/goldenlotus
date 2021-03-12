<?php 
$page_name = "BaoCaoBanHang";
require_once('../helper/security.php');
require('../lib/db.php');
require('../lib/goldenlotus.php');
require('../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];

//$today = date('yy/m/d');
//$yesterday  = date('Y/m/d',strtotime("-1 day"));
$today = $yesterday =date('2020/12/01');




?>
<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<style>
</style>
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
            <h3 class="title"> Báo cáo bán hàng chi tiết món theo từng hóa đơn</h3> 

            <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Hôm nay</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Hôm qua</a></li>
                           
                            <li><a href="#tab3primary" data-toggle="tab">Tháng này</a></li>
                            <li><a href="#tab4primary" data-toggle="tab">Tháng khác</a></li> 
                             <!-- <button type="button" class="btn btn-info" style="background-color:#337AB7; border-color:#337AB7;margin-top:4px"><a href="thangkhac.php" style="color: #fff;font-weight: bold; ">Tháng khác</a></button> -->
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                            <div class="col-xs-12 col-sm-12 table-responsive">
                             <table class="table table-striped table-bordered" id="today">
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
                                
                                $bill_details_today = $goldenlotus->getBillDetailsToday( $today, $count );
                        //var_dump($bill_details_today);
                                $total = 0;settype($total,"integer");
                $i = 0;
                                foreach ( $bill_details_today as $r ) {
                                ?>
                                  <tr>
                                    <td><?=substr($r['ThoiGianBan'],0,10)?></td>
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
                                <?php $i++;
                               } ?>
                              </tbody>
                             </table>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="yesterday">
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
                                //$yesterday = date('2020/08/26');
                                //$yesterday  = date('Y/m/d',strtotime("-1 day"));
                                $bill_details_yesterday = $goldenlotus->getBillDetailsYesterday( $yesterday, $count );
                               // var_dump($bill_details_yesterday);
                                $total = 0;settype($total,"integer");
                $i = 0;
                                foreach ( $bill_details_yesterday as $r ) {
                                
                                ?>
                                  <tr>
                                    <td><?=substr($r['ThoiGianBan'],0,10)?></td>
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
                                <?php $i++;
                               } ?>
                              </tbody>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="this_month">
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
                                //$this_month = date('2020/08');
                                $this_month = date('Y/m');
                                $this_month = date('2015/12');
                                //if($_SERVER['REQUEST_URI'])getBillDetailsByMonthRange_2
                                $bill_details_by_date_of_month = $goldenlotus->getBillDetailsThisMonth( $this_month, $total );
                               //  $bill_details_by_date_of_month = $goldenlotus->getBillDetailsByMonthRange_2( $this_month, $total );
                                  
                                  
                                  $i = 0;
                                  foreach ( $bill_details_by_date_of_month as $r )
                                  {
                               
                                  ?>
                                    <tr>
                                      <td><?=substr($r['ThoiGianBan'],0,10)?></td>
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
                                    $i++;
                                    }
                                
                                  if( $i == $total    ){
                                   ?>
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
                                  <?php } ?>
                                  
                  
            
                                
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
<script >

 //$('#custom_month').DataTable();
    $('form').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();console.log(tuNgay);
    var denNgay = $('#den-ngay').val();console.log(denNgay);
    
    $('#custom_month').DataTable({
        columns: [
            { data: "NgayCoBill"  },
            { data: "MaLoaiThe" },
            { data: "MaLichSuPhieu" },
            { data: "NVTinhTienMaNV" },
            { data: "Floor"  },
            { data: "TenHangBan" },
            { data: "Note" },
            { data: "DonGia" },
            { data: "SoLuong"  },
            { data: "TienGiamGia" },
            { data: "Discount" },
            { data: "SoTienDVPhi" },
            { data: "SoTienVAT"  },
            { data: "ThanhTien" },

        ],
        "destroy": true, //use for reinitialize datatable
        "processing": true,
        "serverSide": true,
        ajax : {
            "url": "json_khac.php",
            "data": function ( d ) {
                //method 1: d.time = time;
                //method 2: d.custom = $('#myInput').val();
     
                return $.extend( {}, d, {
                    "tuNgay" : tuNgay,
                    "denNgay": denNgay
                } );//d is current default data object created by DataTable and "time": is additional data.
                //ref: https://datatables.net/reference/option/ajax.data
                //ref: https://stackoverflow.com/questions/4528744/how-does-the-extend-function-work-in-jquery  
            }
        },


    });
    
  });
/**
 * Twitter Bootstrap Tabs: Go to Specific Tab on Page Reload or Hyperlink
 */
// Javascript to enable link to tab
// var url = document.location.toString();
// if (url.match('#')) {
//     $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
// } 
// console.log(url);
// // Change hash for page-reload
// $('.nav-tabs a').on('shown.bs.tab', function (e) {
//     window.location.hash = e.target.hash;
// })

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
