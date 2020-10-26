<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;


$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];

$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];

if($tungay == "")
{
	$tungay = "01-01-".date('Y');
}

if($denngay == "")
{
	$denngay = date('d-m-Y');
}
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>
    
<style type="text/css">


</style>  
</head>
<body>
<div id="wrapper">
    <?php include 'menu.php'; ?>
    <div id="page-wrapper">

    <div class="col-md-12 graphs">
 <h3 class="title">Doanh thu</h3>

            <div class="panel with-nav-tabs panel-primary">
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
                         <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                            <thead>
                              <tr>
                                <th>Ngày bán</th>
                                <th>Nhân viên</th>
                                <th>Tên món</th>
                                <th>SL</th>
                                <th>Tổng tiền</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            $date = date('2020/08 /26');$total = 0;
                            $food_sold_by_staff = $goldenlotus->getBillDetailsToday( $date );
                            for ($i = 0; $i < sqlsrv_num_rows($food_sold_by_staff); $i++) {
                                $r = sqlsrv_fetch_array($food_sold_by_staff, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                            { ?>
                              <tr>
                                <td><?= ($i==0) ? $r['GioVao']->format('d-m-Y') : ""?></td>
                                <td><?=$r['MaNhanVien']?></td>
                                <td><?=$r['TenHangBan']?></td>
                                <td><?=$r['SoLuong']?></td>
                                <td><?php echo number_format($r['DonGia']*$r['SoLuong'],0,",",".");
                                    $total += $r['DonGia']*$r['SoLuong'] ?><sup>đ</sup></td>
                              </tr>
                            <?php } 
                            } ?>
                            <tr>
                                <td>Tổng</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?=number_format($total,0,",",".")?><sup>đ</sup></td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                            <thead>
                              <tr>
                                <th>Ngày bán</th>
                                <th>Nhân viên</th>
                                <th>Tên món</th>
                                <th>SL</th>
                                <th>Tổng tiền</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            $date = date('2020/08/29');$total = 0;
                            $food_sold_by_staff = $goldenlotus->getBillDetailsToday( $date );
                            for ($i = 0; $i < sqlsrv_num_rows($food_sold_by_staff); $i++) {
                                $r = sqlsrv_fetch_array($food_sold_by_staff, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                            { ?>
                              <tr>
                                <td><?= ($i==0) ? $r['GioVao']->format('d-m-Y') : ""?></td>
                                <td><?=$r['MaNhanVien']?></td>
                                <td><?=$r['TenHangBan']?></td>
                                <td><?=$r['SoLuong']?></td>
                                <td><?php echo number_format($r['DonGia']*$r['SoLuong'],0,",",".");
                                    $total += $r['DonGia']*$r['SoLuong'] ?><sup>đ</sup></td>
                              </tr>
                            <?php } 
                            } ?>
                            <tr>
                                <td>Tổng</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?=number_format($total,0,",",".")?><sup>đ</sup></td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                         <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                            <thead>
                              <tr>
                                <th>Ngày bán</th>
                                <th>Nhân viên</th>
                                <th>Tên món</th>
                                <th>SL</th>
                                <th>Tổng tiền</th>
                              </tr>
                            </thead>
                            <tbody>
                               <?php
                                $this_month = date('2020/08');
                                $dates_has_bill_of_this_month = $goldenlotus->getDatesHasBillOfThisMonth( $this_month );
                                $k = 0;
                                $total_count = sqlsrv_num_rows($dates_has_bill_of_this_month);
                                $grand_total = 0;settype($total,"integer");
                                while ( $rs = sqlsrv_fetch_array( $dates_has_bill_of_this_month ) )
                                {
                                $date = $rs['NgayCoBill'];
                                $payment_details_by_date = $goldenlotus->getBillDetailsByDayOfMonth( $date );
                                $count = sqlsrv_num_rows($payment_details_by_date);
                                $total = 0;settype($total,"integer");
                               
                                for ($i = 0; $i < sqlsrv_num_rows($payment_details_by_date); $i++) 
                                {
                                $r = sqlsrv_fetch_array($payment_details_by_date, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
                                ?>
                                  <tr>
                                    <td><?= ($i==0) ? $r['GioVao']->format('d-m-Y') : ""?></td>
                                    <td><?=$r['MaNhanVien']?></td>
                                    <td><?=$r['TenHangBan']?></td>
                                    <td><?=$r['SoLuong']?></td>
                                    <td><?php echo number_format($r['DonGia']*$r['SoLuong'],0,",",".");
                                        $total += $r['DonGia']*$r['SoLuong'] ?><sup>đ</sup>
                                    </td>
                                  </tr>
                                <?php
                                if ($i == $count - 1) { ?> <tr><td>Tổng</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($total,0,",",".") ;  $grand_total += $total; ?><sup>đ</sup></td>
                                    </tr>
                                  <?php 
                                if( $k == $total_count -1  ){
                                   ?>
                                   <tr>
                                    <td><strong>Grand Total</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td><?=number_format($grand_total,0,",",".")?><sup>đ</sup></td>
                                  </tr>
                                  <?php }
                                }
      
                                    }
                                    $k++;  
                                } 
                                
                                //if (!empty($_SESSION['grand_total'])) unset($_SESSION['grand_total']); ?>
                            </tbody>
                          </table>
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
                          <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                            <thead>
                              <tr>
                                <th>Ngày bán</th>
                                <th>Nhân viên</th>
                                <th>Tên món</th>
                                <th>SL</th>
                                <th>Tổng tiền</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td></td>
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
      url:"tonghop-monan-xemtheo-nhanvien/khac.php",
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
