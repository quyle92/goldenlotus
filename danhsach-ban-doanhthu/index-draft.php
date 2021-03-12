<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require('../lib/db.php');
require('../lib/goldenlotus-new.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

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

$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
$page_name = "BaoCaoBanHang";
if( $_SESSION['MaNV'] != 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
  // die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>

<style>
.danh-sach-ban .soluong{
text-align: center;
border: 1px solid #333;
border-radius: 100%;
height: 45px;
width: 45px;
display: flex;
align-items: center;
justify-content: center;
}


</style>
<script>
  $(document).ready(function() {
    $('[id^=detail-]').hide();
    $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
    });
});

  $(document).ready(function() {
    $('#all').DataTable();
} );
  $(document).ready(function() {
    $('#occupied').DataTable();
} );
  $(document).ready(function() {
    $('#empty').DataTable();
} );
</script>
</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Danh Sách Bàn + Doanh Thu</h3>

            <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Tất cả</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Bàn có người</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Bàn trống</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">

                      <div class="tab-pane fade active in" id="tab1primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <div class="panel panel-default">

                              <table id="all" class="display" style="width:100%">
                              <thead>
                                  <tr>
                                      <th></th>

                                  </tr>
                              </thead>
                              <tbody>
                                  
                                    <?php
                                    //$date = date('2015/08/19');
									$date = date('yy/m/d');
                                  
                                    $sales_by_table = $goldenlotus->getAllTables( $date );
                                    $sales_by_table = customizeArray( $sales_by_table );

                                    $i = 1;
                                    foreach ( $sales_by_table as $k => $v ) 
                                    { ?>
                                    <tr>
                                      <td>
                                                                                    
                                                <ul class="list-group danh-sach-ban">
                                                    <li class="list-group-item">
                                                        <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="all-<?=(( $v->TongDoanhThu )) ? $i : ''?>">
                                                            <div class="col-xs-10">
                                                              <div style="display:flex">
                                                                <div class="tbl-image">
                                                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                                                                  </div> 
                                                                  <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                                    <strong>Key: <?=$k?></strong>
                                                                    <br>
                                                                    <span>Tổng Doanh thu: <?=( $v->TongDoanhThu ) ? number_format($v->TongDoanhThu,0,",",".") : 0?><sup>đ</sup></span>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                                                        </div>
                                                        <div id="all-<?=$i?>" aria-expanded="false" style="display:none;">
                                                            <hr></hr>
                                                              
                                                            <?php
                                                            $k = 0; 
                                                            foreach ( $v->TenHangBan as $hb ) 
                                                            { ?>
                                                              <div class="container" style="width:100%">
                                                                <div class="fluid-row">
                                                                    <div class="col-xs-3">
                                                                       <div class="soluong">
                                                                          <?=( $k == 0 ) ? $v->SoLuong[$k] : $v->SoLuong[$k][0] ?>
                                                                       </div>
                                                                    </div>
                                                                    <div class="col-xs-9">
                                                                       <strong> <?=( $k == 0 ) ? $v->MaHangBan[$k] : $v->MaHangBan[$k][0] ?> .   <?=( $k == 0 ) ? $hb : $hb[0] ?> (<?=( $k == 0 ) ? $v->MaDVT[$k] : $v->MaDVT[$k][0] ?>) </strong>
                                                                       <br>
                                                                       <span><?=( $k == 0 ) ? number_format($v->ThanhTien[$k],0,",",".") : number_format($v->ThanhTien[$k][0],0,",",".")?> <sup>đ</sup></span>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                               <hr>
                                                            <?php  $k++;
                                                            } $i++; ?>
                                                           
                                                        </div>
                                                    </li>
                                                </ul>
                                                
                                             
                                     </td>
                                    </tr>
                                   <?php
                                    }
                                    ?>

                                

                                     
                                </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>

                                        </tr>
                                    </tfoot>
                                </table>
                              </div>
                           </div>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <div class="panel panel-default">
                                <!-- <div class="panel-heading">
                                    <h3 class="panel-title">Danh sách bàn + doanh thu</h3>
                                </div>    -->
                                <table id="occupied" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                               // $date = date('2020/08/26');

                                $sales_by_table = $goldenlotus->getAllTables_Occupied( $date );
                                $sales_by_table = customizeArray( $sales_by_table );
                                
                                $i = 1; 
                                foreach ( $sales_by_table  as $k => $v )  
                                { ?>
                                    <tr>
                                      <td>
                                                                                    
                                                <ul class="list-group danh-sach-ban">
                                                    <li class="list-group-item">
                                                        <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="all-<?=(( $v->TongDoanhThu )) ? $i : ''?>">
                                                            <div class="col-xs-10">
                                                              <div style="display:flex">
                                                                <div class="tbl-image">
                                                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                                                                  </div> 
                                                                  <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                                    <strong>Key: <?=$k?></strong>
                                                                    <br>
                                                                    <span>Tổng Doanh thu: <?=( $v->TongDoanhThu ) ? number_format($v->TongDoanhThu,0,",",".") : 0?><sup>đ</sup></span>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                                                        </div>
                                                        <div id="all-<?=$i?>" aria-expanded="false" style="display:none;">
                                                            <hr></hr>
                                                              
                                                            <?php
                                                            $k = 0; 
                                                            foreach ( $v->TenHangBan as $hb ) 
                                                            { ?>
                                                              <div class="container" style="width:100%">
                                                                <div class="fluid-row">
                                                                    <div class="col-xs-3">
                                                                       <div class="soluong">
                                                                          <?=( $k == 0 ) ? $v->SoLuong[$k] : $v->SoLuong[$k][0] ?>
                                                                       </div>
                                                                    </div>
                                                                    <div class="col-xs-9">
                                                                       <strong> <?=( $k == 0 ) ? $v->MaHangBan[$k] : $v->MaHangBan[$k][0] ?> .   <?=( $k == 0 ) ? $hb : $hb[0] ?> (<?=( $k == 0 ) ? $v->MaDVT[$k] : $v->MaDVT[$k][0] ?>) </strong>
                                                                       <br>
                                                                       <span><?=( $k == 0 ) ? number_format($v->ThanhTien[$k],0,",",".") : number_format($v->ThanhTien[$k][0],0,",",".")?> <sup>đ</sup></span>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                               <hr>
                                                            <?php  $k++;
                                                            } $i++; ?>
                                                           
                                                        </div>
                                                    </li>
                                                </ul>
                                                
                                             
                                     </td>
                                    </tr>
                                   <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>

                                    </tr>
                                </tfoot>
                            </table>

                             </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <div class="panel panel-default">
                                <!-- <div class="panel-heading">
                                    <h3 class="panel-title">Danh sách bàn + doanh thu</h3>
                                </div> -->   
                                <table id="empty" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$date = date('2020/08/26');

								                $sales_by_table = $goldenlotus->getAllTables_Empty( $date );
                                $sales_by_table = customizeArray( $sales_by_table );
                                
                                $i = 1; 
                                foreach ( $sales_by_table  as $k => $v )  
                                { ?>
                                    <tr>
                                      <td>
                                                                                    
                                                <ul class="list-group danh-sach-ban">
                                                    <li class="list-group-item">
                                                        <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="all-<?=(( $v->TongDoanhThu )) ? $i : ''?>">
                                                            <div class="col-xs-10">
                                                              <div style="display:flex">
                                                                <div class="tbl-image">
                                                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                                                                  </div> 
                                                                  <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                                    <strong>Key: <?=$k?></strong>
                                                                    <br>
                                                                    <span>Tổng Doanh thu: <?=( $v->TongDoanhThu ) ? number_format($v->TongDoanhThu,0,",",".") : 0?><sup>đ</sup></span>
                                                                  </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                                                        </div>
                                                        <div id="all-<?=$i?>" aria-expanded="false" style="display:none;">
                                                            <hr></hr>
                                                              
                                                            <?php
                                                            $k = 0; 
                                                            foreach ( $v->TenHangBan as $hb ) 
                                                            { ?>
                                                              <div class="container" style="width:100%">
                                                                <div class="fluid-row">
                                                                    <div class="col-xs-3">
                                                                       <div class="soluong">
                                                                          <?=( $k == 0 ) ? $v->SoLuong[$k] : $v->SoLuong[$k][0] ?>
                                                                       </div>
                                                                    </div>
                                                                    <div class="col-xs-9">
                                                                       <strong> <?=( $k == 0 ) ? $v->MaHangBan[$k] : $v->MaHangBan[$k][0] ?> .   <?=( $k == 0 ) ? $hb : $hb[0] ?> (<?=( $k == 0 ) ? $v->MaDVT[$k] : $v->MaDVT[$k][0] ?>) </strong>
                                                                       <br>
                                                                       <span><?=( $k == 0 ) ? number_format($v->ThanhTien[$k],0,",",".") : number_format($v->ThanhTien[$k][0],0,",",".")?> <sup>đ</sup></span>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                               <hr>
                                                            <?php  $k++;
                                                            } $i++; ?>
                                                           
                                                        </div>
                                                    </li>
                                                </ul>
                                                
                                             
                                     </td>
                                    </tr>
                                   <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>

                                    </tr>
                                </tfoot>
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
</body>

<script>

var dropdown = document.getElementsByClassName("dropdown-btn");
var i;
console.log(dropdown);  
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