<?php 
$page_name = "BaoCaoQuanTri";
require_once('../helper/security.php');
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$today = date('yy/m/d');
$yesterday = date('yy/m/d',strtotime("-1 days"));
//$today = $yesterday = date('2020/12/01');

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
<?php include ('../head/head-tag.php');?>
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
            <h3 class="title">Đối chiếu SL bán và gọi</h3>

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
                                    <th>Tên món</th>
                                    <th>SL order</th>
                                    <th>SL bán</th>
                                    <th>SL bỏ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$today = ('2020/08/26');
                                //$today = date('yy/m/d');
                                $total_SLOrder = 0;
                                $total_SLBan = 0;
                                $total_SLBo = 0;
                                $doi_chieu_so_luong = $goldenlotus->getSoldvsCancelledItemsByDate( $today );
                                foreach ( $doi_chieu_so_luong as $r ) 
                                { 
                                  
                                  ?>
                                  <tr>
                                    <td><?=$r['TenHangBan']?></td>
                                    <td><?php echo $r['SLOrder']; $total_SLOrder += $r['SLOrder']?></td>
                                    <td><?php echo $r['SLBan'];  $total_SLBan += $r['SLBan']?></td>
                                    <td><?php echo $r['SLBo'];  $total_SLBo += $r['SLBo']?></td>
                                  </tr>
                                 <?php
                                } ?>
                                <tr>
                                  <td><strong>Tổng</strong></td>
                                  <td><strong><?=$total_SLOrder?></strong></td>
                                  <td><strong><?=$total_SLBan?></strong></td>
                                  <td><strong><?=$total_SLBo?></strong></td>
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
                                    <th>Tên món</th>
                                    <th>SL order</th>
                                    <th>SL bán</th>
                                    <th>SL bỏ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$date = ('2020/08/29');
                               // $yesterday = date('yy/m/d',strtotime("-1 days"));
                                $doi_chieu_so_luong = $goldenlotus->getSoldvsCancelledItemsByDate( $yesterday );
                                foreach ( $doi_chieu_so_luong as $r ) 
                                { 
                                  
                                  ?>
                                  <tr>
                                    <td><?=$r['TenHangBan']?></td>
                                    <td><?php echo $r['SLOrder']; $total_SLOrder += $r['SLOrder']?></td>
                                    <td><?php echo $r['SLBan'];  $total_SLBan += $r['SLBan']?></td>
                                    <td><?php echo $r['SLBo'];  $total_SLBo += $r['SLBo']?></td>
                                  </tr>
                                 <?php
                                } ?>
                                <tr>
                                  <td><strong>Tổng</strong></td>
                                  <td><strong><?=$total_SLOrder?></strong></td>
                                  <td><strong><?=$total_SLBan?></strong></td>
                                  <td><strong><?=$total_SLBo?></strong></td>
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
                                    <th>Tên món</th>
                                    <th>SL order</th>
                                    <th>SL bán</th>
                                    <th>SL bỏ</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$this_month = date('2016/03');
                                $this_month = date('yy/m');
                                $doi_chieu_so_luong = $goldenlotus->getSoldvsCancelledItemsByMonth( $this_month );
                                foreach ( $doi_chieu_so_luong as $r ) 
                                { 
                                 
                                  ?>
                                  <tr>
                                    <td><?=$r['TenHangBan']?></td>
                                    <td><?php echo $r['SLOrder']; $total_SLOrder += $r['SLOrder']?></td>
                                    <td><?php echo $r['SLBan'];  $total_SLBan += $r['SLBan']?></td>
                                    <td><?php echo $r['SLBo'];  $total_SLBo += $r['SLBo']?></td>
                                  </tr>
                                 <?php
                                } ?>
                                <tr>
                                  <td><strong>Tổng</strong></td>
                                  <td><strong><?=$total_SLOrder?></strong></td>
                                  <td><strong><?=$total_SLBan?></strong></td>
                                  <td><strong><?=$total_SLBo?></strong></td>
                                </tr>
                              </tbody>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">
                            <div class="row">
                                <?php require_once('../datetimepicker.php'); ?>

                              <div class="col-xs-12 col-sm-12 table-responsive">
                              <table class="table table-striped table-bordered" id="custom_month">
                                <thead>
                                  <tr>
                                    <th>Tên món</th>
                                    <th>SL order</th>
                                    <th>SL bán</th>
                                    <th>SL bỏ</th>
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
<?php require_once('../ajax-loading.php'); ?>
<script>

       $('form').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();console.log(tuNgay);
    var denNgay = $('#den-ngay').val();console.log(denNgay);
    
    $.ajax({
      url:"../doichieu-soluong-bangoi/khac.php",
      method:"POST",
      data:{'tu-ngay' : tuNgay, 'den-ngay' : denNgay},
      dataType:"json",
	  beforeSend :function(){
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(output)
      {
		 $('#custom_month').DataTable({ 
          "destroy": true, //use for reinitialize datatable
          "order": [],
          "columnDefs": [ {
          "targets"  : 0,
          "orderable": false,
          }]
        });
		  
        $('#tab4primary table tbody').html(output);
      },
		complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
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

</script>
</body>
</html>

