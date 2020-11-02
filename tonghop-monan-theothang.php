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
 
</script>   
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
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Tháng nay</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Tháng qua</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Khác</a></li>

                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                         <table class="table table-striped table-bordered" width="100%" id="sailorTable">
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
                          $hang_ban = $goldenlotus->getFoodSoldThisMonth($thang_nay);
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
                        <div class="tab-pane fade" id="tab2primary">
                          <table class="table table-striped table-bordered" width="100%" id="sailorTable">
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
                         <table class="table table-striped table-bordered" width="100%" id="sailorTable">
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
    var thangKhac = $('#thang-khac').val();console.log(homKhac);
    
    $.ajax({
      url:"tonghop-monan/theothang.php",
      method:"POST",
      data:{'thang-khac' : thangKhac},
      dataType:"json",
      success:function(data)
      {
        $('#tab3primary table tbody').html(data);
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

$('#thang-khac').datepicker({ uiLibrary: 'bootstrap',format: "dd/mm/yyyy"}); 

;
</script>
</body>
</html>
