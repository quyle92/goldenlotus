<?php
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;

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

$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
$page_name = "BaoCaoBanHang";
if( $_SESSION['MaNV'] != 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<style>


</style>

</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Báo cáo tiền tệ</h3>

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
                                    <th>Loại tiền</th>
                                    <th>Khách đưa</th>
                                    <th>Tiền thừa</th>
                                    <th>Thực thu</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$today = ('2020/08/26');
                                $today = date('yy/m/d');
                                $currency_report = $goldenlotus->getCurrencyReportByDate( $today );
                                foreach ( $currency_report as $r ) 
                                { ?>
                                <tr>
                                  <td><?=$r['MaTienTe']?></td>
                                  <td></td>
                                  <td></td>
                                  <td><?=number_format($r['ThucThu'],0,".",".")?><sup>đ</sup></td>
                                </tr>
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
                                    <th>Loại tiền</th>
                                    <th>Khách đưa</th>
                                    <th>Tiền thừa</th>
                                    <th>Thực thu</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$date = ('2020/08/29');
                                $yesterday = date('yy/m/d',strtotime("-1 days"));;
                                $currency_report = $goldenlotus->getCurrencyReportByDate( $yesterday );
                                foreach ( $currency_report as $r ) 
                                { ?>
                                <tr>
                                  <td><?=$r['MaTienTe']?></td>
                                  <td></td>
                                  <td></td>
                                  <td><?=number_format($r['ThucThu'],0,".",".")?><sup>đ</sup></td>
                                </tr>
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
                                    <th>Loại tiền</th>
                                    <th>Khách đưa</th>
                                    <th>Tiền thừa</th>
                                    <th>Thực thu</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                $month = ('2020/08');
                                $currency_report = $goldenlotus->getCurrencyReportByMonth( $month );
                                foreach ( $currency_report as $r ) 
                                { ?>
                                <tr>
                                  <td><?=$r['MaTienTe']?></td>
                                  <td></td>
                                  <td></td>
                                  <td><?=number_format($r['ThucThu'],0,".",".")?><sup>đ</sup></td>
                                </tr>
                                <?php 
                                } ?>
                              </tbody>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">
                            <div class="row">
                              <form method="POST" action="">
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
                                    <th>Loại tiền</th>
                                    <th>Khách đưa</th>
                                    <th>Tiền thừa</th>
                                    <th>Thực thu</th>
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
      url:"../baocao-tiente/khac.php",
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
