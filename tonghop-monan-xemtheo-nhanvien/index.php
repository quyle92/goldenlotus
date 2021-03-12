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
<style type="text/css">


</style>  
</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
    <div id="page-wrapper">

    <div class="col-md-12 graphs">
 <h3 class="title">Tổng hợp món ăn bán theo ngày (Xem theo nhân viên)</h3>

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
                         <table class="table table-striped table-bordered" width="100%" id="today">
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
                            //$today = date('2020/08/26');
                           
                            $total = 0;
                            $food_sold_by_staff = $goldenlotus->getBillDetailsToday( $today );
                            $i = 0;
                            foreach ( $food_sold_by_staff as $r )  
                            {
                             
                            ?>
                              <tr>
                                <td><?=substr($r['GioVao'],0, 10)?></td>
                                <td><?=$r['MaNhanVien']?></td>
                                <td><?=$r['TenHangBan']?></td>
                                <td><?=$r['SoLuong']?></td>
                                <td><?php echo number_format($r['DonGia']*$r['SoLuong'],0,",",".");
                                    $total += $r['DonGia']*$r['SoLuong'] ?><sup>đ</sup></td>
                              </tr>
                            <?php
                            $i++;  
                            }
                            ?>
                            
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
                          <table class="table table-striped table-bordered" width="100%" id="yesterday">
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
                            //$yesterday  = ('2020/08/29');
                          
                            $total = 0;
                            $i = 0;
                            $food_sold_by_staff = $goldenlotus->getBillDetailsYesterday( $yesterday );
                            foreach ( $food_sold_by_staff as $r )  
                            {
                   
                            ?>
                              <tr>
                                <td><?= substr($r['GioVao'],0,10)?></td>
                                <td><?=$r['MaNhanVien']?></td>
                                <td><?=$r['TenHangBan']?></td>
                                <td><?=$r['SoLuong']?></td>
                                <td><?php echo number_format($r['DonGia']*$r['SoLuong'],0,",",".");
                                    $total += $r['DonGia']*$r['SoLuong'] ?><sup>đ</sup></td>
                              </tr>
                            <?php
                            $i++;  
                            } 
                            ?>
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
                         <table class="table table-striped table-bordered" width="100%" id="this_month">
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
                                $this_month = date('yy/m');
                                $dates_has_bill_of_this_month = $goldenlotus->getDatesHasBillOfThisMonth( $this_month, $total_count );
                                $k = 0;
                                //$total_count = sqlsrv_num_rows($dates_has_bill_of_this_month);
                                $grand_total = 0;settype($grand_total,"integer");
                                foreach ( $dates_has_bill_of_this_month as $rs ) 
                                {
                                $date = $rs['NgayCoBill'];
                                $payment_details_by_date = $goldenlotus->getBillDetailsByDayOfMonth( $date, $count );
                               
                                $total = 0;settype($total,"integer");
                                $i = 0;
                                foreach ( $payment_details_by_date as $r )
                                { 
                                ?>
                                  <tr>
                                    <td><?=substr($r['GioVao'],0,10)?></td>
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
      
                                  $i++;  }
                                    $k++;  
                                } 
                                
                                //if (!empty($_SESSION['grand_total'])) unset($_SESSION['grand_total']); ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">
                             <?php require_once('../datetimepicker.php'); ?>
                          <table class="table table-striped table-bordered" width="100%" id="custom_month">
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

 //$('#custom_month').DataTable();
    $('form').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();//console.log(tuNgay);
    var denNgay = $('#den-ngay').val();//console.log(denNgay);
    
    $('#custom_month').DataTable({
            columns: [
                { data: "NgayCoBill"  },
                { data: "NVTinhTienMaNV" },
                { data: "TenHangBan" },
                { data: "SoLuong" },
                { data: "Tongtien" }
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

