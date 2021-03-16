<?php 
$page_name = "BaoCaoBanHang";
require_once('../helper/security.php');
include_once( '../lib/db.php');
include_once( '../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id = isset($_SESSION['MaNV'])? $_SESSION['MaNV']:"";
$ten = isset($_SESSION['TenNV'])? $_SESSION['TenNV']:"";

$matrungtam = isset($_SESSION['MaTrungTam'])? $_SESSION['MaTrungTam']:"";
$trungtam = isset($_SESSION['TenTrungTam'])? $_SESSION['TenTrungTam']:"";

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
  
//    $(document).ready(function() {
//     $('#custom_month').DataTable();
// } );



</script>
<style>


</style>

</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Bảng kê chi tiết phương thức thanh toán</h3>

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
                                $today =  date('Y/m/d');
                                $total = 0;
                                $payment_method_details_by_date = $goldenlotus->getPayMethodDetailsByDate( $today );
                
                                foreach ( $payment_method_details_by_date as $r ) { //var_dump($r);die;
                                ?>
                                <tr>
                                  <td><?=( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" )?></td>
                                  <td><?=substr($r['GioVao'],0, 10)?></td>
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
                               $yesterday =  date('Y/m/d', strtotime('-1 day'));
                               
                                $total = 0;
                                $payment_method_details_by_date = $goldenlotus->getPayMethodDetailsByDate( $yesterday );
                                foreach ( $payment_method_details_by_date as $r ) { ?>
                                <tr>
                                  <td><?=( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" )?></td>
                                  <td><?=substr($r['GioVao'], 0, 10)?></td>
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
                                $this_month = date('yy/m');
                                $payment_details_by_date = $goldenlotus->getPayMethodDetailsByMonth( $this_month, $total);
                                $i = 0;
                                $grand_total = 0;
                                foreach ( $payment_details_by_date as $r )
                                {
                               
                                ?>
                                  <tr>
                                  <td><?=( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" )?></td>
                                  <td><?=substr($r['GioVao'], 0, 10)?></td>
                                  <td><?=$r['MaLichSuPhieu']?></td>
                                  <td><?php echo number_format($r['TienThucTra'],0,",","."); $grand_total += $r['TienThucTra'];?><sup>đ</sup></td>
                                  </tr>
                                <?php
                                 $i++;
                                } 
                      
                                if($i == $total){ ?>
                                  <tr>
                                  <td><strong>Grand Total</strong></td>
                                  <td></td>
                                  <td></td>
     
                                  <td><?=number_format($grand_total,0,",",".")?><sup>đ</sup></td>
                                </tr>
                                <?php }
                                 ?>
                               
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
 //$('#custom_month').DataTable();
    $('form').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();console.log(tuNgay);
    var denNgay = $('#den-ngay').val();console.log(denNgay);
    
    $('#custom_month').DataTable({
            columns: [
                { data: "MaLoaiThe"  },
                { data: "GioVao" },
                { data: "MaLichSuPhieu" },
                { data: "TienThucTra" }
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


</script>

</body>
</html>

