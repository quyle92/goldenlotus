<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];



$thang_nay  = date('Y/m',strtotime("-1 month"));
$thang_truoc  = date('Y/m',strtotime("-1 month"));
$thang_nay = $thang_truoc  = date('2016/09');


$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
$page_name = "BaoCaoBanHang";
if( $_SESSION['MaNV'] != 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>
    
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
    <?php include 'menu.php'; ?>
    <div id="page-wrapper">

    <div class="col-md-12 graphs">
 <h3 class="title">Doanh thu bán hàng theo tháng</h3>

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
                                   $goldenlotus->getFoodSoldThisMonth ($thang_nay, $total);
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
                          $hang_ban = $goldenlotus->getFoodSoldThisMonth($thang_nay);
                          $total = 0;
                          while ($r=sqlsrv_fetch_array($hang_ban)){ ?>
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
                                   $goldenlotus->getFoodSoldLastMonth ($thang_truoc, $total);
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
                                $hang_ban = $goldenlotus->getFoodSoldLastMonth($thang_truoc);
                                while ($r=sqlsrv_fetch_array($hang_ban)){ ?>
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
                              <div class="col-md-2" style="margin-bottom:5px">Tháng:</div>
                              <div class="col-md-3" style="margin-bottom:5px">
                                <input name="thang-khac" type="text"  value="" id="thang-khac" />
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

<script>

   $('form').on('submit', function (event){
    event.preventDefault();
    var thangKhac = $('#thang-khac').val();console.log(thangKhac);
    
    $.ajax({
      url:"tonghop-monan/theothang.php",
      method:"POST",
      data:{'thang-khac' : thangKhac},
      //dataType:"json",
      success:function(response)
      {  
        var result = JSON.parse(response);
        var total = result[0];
        
        /*
        *remove total (first value in array) from array
        */
         result.shift();


        $('#tab3primary .row.tong_doanh_thu .col-md-6 strong').html(total);
        $('#tab3primary table tbody').html(result);
        $('#custom_month').DataTable({ 
          "destroy": true, //use for reinitialize datatable
        });

      }
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
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});

$('#thang-khac').datepicker({ uiLibrary: 'bootstrap',format: "mm/yyyy"}); 

;
</script>
</body>
</html>
