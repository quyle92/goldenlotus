<?php
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;


$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];


if( !isset($tungay) )
{
  $tungay = "01-01-".date('Y');
}

if( !isset($denngay))
{
  $denngay = date('d-m-Y');
}

$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
$page_name = "BaoCaoBanHang";
if( $_SESSION['MaNV'] != 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
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
<style>


</style>

</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Bản kê chi tiết phương thức thanh toán</h3>

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
                                    <th>PTTT</th>
                                    <th>Ngày</th>
                                    <th>Mã hóa đơn</th>
                                    <th>Thành tiền</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                $date = date('2016/03/13');$total = 0;
                                $payment_method_details_by_date = $goldenlotus->getPayMethodDetailsByDate( $date );
                                while( $r = sqlsrv_fetch_array( $payment_method_details_by_date ) ) {  ?>
                                <tr>
                                  <td><?=( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" )?></td>
                                  <td><?=$r['GioVao']->format('d-m-Y')?></td>
                                  <td><?=$r['MaLichSuPhieu']?></td>
                                  <td><?=number_format($r['TienThucTra'],0,",",".")?><sup>đ</sup></td>
                                </tr>
                                <?php $total += $r['TienThucTra'];
                                }                                
                                ?>
                                <tr>
                                  <td>Tổng</td>
                                  <td></td>
                                  <td></td>
                                  <td><?=number_format($total,0,",",".")?><sup>đ</sup></td>
                                </tr>
                              </tbody>
                             </table>
                           </div>
                        
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="yesterday">
                                <thead>
                                  <tr>
                                    <th>PTTT</th>
                                    <th>Ngày</th>
                                    <th>Mã hóa đơn</th>
                                    <th>Thành tiền</th>
                                  </tr>
                                </thead>
                                <tbody>
                               <?php
                                $total = 0;
                                $payment_method_details_by_date = $goldenlotus->getPayMethodDetailsByDate( $date );
                                while( $r = sqlsrv_fetch_array( $payment_method_details_by_date ) ) {  ?>
                                <tr>
                                  <td><?=( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" )?></td>
                                  <td><?=$r['GioVao']->format('d-m-Y')?></td>
                                  <td><?=$r['MaLichSuPhieu']?></td>
                                  <td><?=number_format($r['TienThucTra'],0,",",".")?><sup>đ</sup></td>
                                </tr>
                                <?php $total += $r['TienThucTra'];
                                }                                
                                ?>
                                <tr>
                                  <td>Tổng</td>
                                  <td></td>
                                  <td></td>
                                  <td><?=number_format($total,0,",",".")?><sup>đ</sup></td>
                                </tr>
                              </tbody>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="this_month">
                                <thead>
                                  <tr>
                                    <th>PTTT</th>
                                    <th>Ngày</th>
                                    <th>Mã hóa đơn</th>
                                    <th>Thành tiền</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                $this_month = date('2016/03');
                                $dates_has_bill_of_this_month = $goldenlotus->getDatesHasBillOfThisMonth( $this_month );
                                $k=0;
                                $total_count = sqlsrv_num_rows($dates_has_bill_of_this_month);
                                $grand_total = 0;settype($total,"integer");
                                while ( $rs = sqlsrv_fetch_array( $dates_has_bill_of_this_month ) )
                                {
                                $date = $rs['NgayCoBill'];
                                $payment_details_by_date = $goldenlotus->getPayMethodDetailsByDate( $date );
                                $count = sqlsrv_num_rows($payment_details_by_date);
                                $total = 0;settype($total,"integer");
                               
                                for ($i = 0; $i < sqlsrv_num_rows($payment_details_by_date); $i++) 
                                {
                                $r = sqlsrv_fetch_array($payment_details_by_date, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                                ?>
                                  <tr>
                                  <td><?=( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" )?></td>
                                  <td><?=($i==0) ? $r['GioVao']->format('d-m-Y') : ""?></td>
                                  <td><?=$r['MaLichSuPhieu']?></td>
                                  <td><?php echo number_format($r['TienThucTra'],0,",","."); $total += $r['TienThucTra'];?><sup>đ</sup></td>
                                  </tr>
                                <?php
                                if ($i == $count - 1) { ?> <tr><td>Tổng</td>
                                    <td></td>
                                    <td></td>
      
                                    <td><?php echo number_format($total,0,",",".") ; $grand_total += $total; ?><sup>đ</sup></td>
                                    </tr>
                                  <?php }
                                 
                                } 
                                $k++; 
                                if($k == $total_count){ ?>
                                  <tr>
                                  <td><strong>Grand Total</strong></td>
                                  <td></td>
                                  <td></td>
     
                                  <td><?=number_format($grand_total,0,",",".")?><sup>đ</sup></td>
                                </tr>
                                <?php }
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
                            <table class="table table-striped table-bordered" id="custom_month">
                                <thead>
                                  <tr>
                                    <th>PTTT</th>
                                    <th>Ngày</th>
                                    <th>Mã hóa đơn</th>
                                    <th>Thành tiền</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
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

$('#tu-ngay').datepicker({ uiLibrary: 'bootstrap',format: "mm.yyyy"}); 
$('#den-ngay').datepicker({  uiLibrary: 'bootstrap',format: "mm.yyyy"}); 


</script>
</body>
</html>
