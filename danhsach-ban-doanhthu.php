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

$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
$page_name = "BaoCaoBanHang";
if( $_SESSION['MaNV'] != 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>

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
</script>
</head>
<body>
<div id="wrapper ">
    <?php include 'menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Tồng hợp đồ bỏ</h3>

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
                        <div class="tab-pane fade in active" id="tab1primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                             <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Danh sách bàn + doanh thu</h3>
                                </div>
                                <?php
                                $date = date('2020/08/26');
                                $occupation = null;
                                $sales_by_table = $goldenlotus->getSalesByTableID ( $date, $occupation );
                                $i = 1;
                                while( $r = sqlsrv_fetch_array($sales_by_table) )
                                { ?>
                                <ul class="list-group danh-sach-ban">
                                    <li class="list-group-item">
                                        <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="all-<?=(( $r['DoanhThu'] )) ? $i : ''?>">
                                            <div class="col-xs-10">
                                              <div style="display:flex">
                                                <div class="tbl-image">
                                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                                                  </div> 
                                                  <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                    <strong>TABLE: <?=$r['MaBan']?></strong>
                                                    <br>
                                                    <span>Doanh thu: <?=( $r['DoanhThu'] ) ? number_format($r['DoanhThu'],0,",",".") : 0?><sup>đ</sup></span>
                                                  </div>
                                              </div>
                                            </div>
                                            <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                                        </div>
                                        <div id="all-<?=$i?>" aria-expanded="false" style="display:none;">
                                            <hr></hr>
                                            
                                            <?php
                                           // var_dump($occupation);
                                            $table_id = $r['MaBan'];
                                            $sales_details = $goldenlotus->getSalesByFoodNames ( $date, $table_id, $occupation);
                                            //var_dump($sales_details);
                                            while( $r1 = sqlsrv_fetch_array( $sales_details ) )
                                            { ?>
                                              <div class="container">
                                                <div class="fluid-row">
                                                    <div class="col-xs-1">
                                                       <div class="soluong">
                                                           <?=$r1['SoLuong']?>
                                                       </div>
                                                    </div>
                                                    <div class="col-xs-5">
                                                       <strong><?=$r1['MaHangBan']?>.  <?=$r1['TenHangBan']?> (<?=$r1['MaDVT']?>)</strong>
                                                       <br>
                                                       <span><?=( $r1['DoanhThu'] ) ? number_format($r1['DoanhThu'],0,",",".") : 0?> <sup>đ</sup></span>
                                                    </div>
                                                </div>
                                              </div>
                                               <hr>
                                            <?php 
                                            } $i++; ?>
                                           
                                        </div>
                                    </li>
                                </ul>
                                <?php
                                }
                                ?>
                             </div>
                           </div>
                      </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Danh sách bàn + doanh thu</h3>
                                </div>   
                                <?php
                                $date = date('2020/08/26');
                                $occupation = '1';
                                $sales_by_table = $goldenlotus->getSalesByTableID ( $date, $occupation );
                                $i = 1;
                                while( $r = sqlsrv_fetch_array($sales_by_table) )
                                { ?>
                                <ul class="list-group danh-sach-ban">
                                    <li class="list-group-item">
                                        <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="occupied-<?=(( $r['DoanhThu'] )) ? $i : ''?>">
                                            <div class="col-xs-10">
                                              <div style="display:flex">
                                                <div class="tbl-image">
                                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                                                  </div> 
                                                  <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                    <strong>TABLE: <?=$r['MaBan']?></strong>
                                                    <br>
                                                    <span>Doanh thu: <?=( $r['DoanhThu'] ) ? number_format($r['DoanhThu'],0,",",".") : 0?><sup>đ</sup></span>
                                                  </div>
                                              </div>
                                            </div>
                                            <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                                        </div>
                                        <div id="occupied-<?=$i?>" aria-expanded="false" style="display:none;">
                                            <hr></hr>
                                            
                                            <?php
                                           // var_dump($occupation);
                                            $table_id = $r['MaBan'];
                                            $sales_details = $goldenlotus->getSalesByFoodNames ( $date, $table_id, $occupation);
                                            //var_dump($sales_details);
                                            while( $r1 = sqlsrv_fetch_array( $sales_details ) )
                                            { ?>
                                              <div class="container">
                                                <div class="fluid-row">
                                                    <div class="col-xs-1">
                                                       <div class="soluong">
                                                           <?=$r1['SoLuong']?>
                                                       </div>
                                                    </div>
                                                    <div class="col-xs-5">
                                                       <strong><?=$r1['MaHangBan']?>.  <?=$r1['TenHangBan']?> (<?=$r1['MaDVT']?>)</strong>
                                                       <br>
                                                       <span><?=( $r1['DoanhThu'] ) ? number_format($r1['DoanhThu'],0,",",".") : 0?> <sup>đ</sup></span>
                                                    </div>
                                                </div>
                                              </div>
                                               <hr>
                                            <?php 
                                            } $i++; ?>
                                           
                                        </div>
                                    </li>
                                </ul>
                                <?php
                                }
                                ?>
                             </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Danh sách bàn + doanh thu</h3>
                                </div>   
                                <?php
                                $date = date('2020/08/26');
                                $occupation = '0';
                                $sales_by_table = $goldenlotus->getSalesByTableID ( $date, $occupation );
                                $i = 1;
                                while( $r = sqlsrv_fetch_array($sales_by_table) )
                                { ?>
                                <ul class="list-group danh-sach-ban">
                                    <li class="list-group-item">
                                        <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="vacant-<?=(( $r['DoanhThu'] )) ? $i : ''?>">
                                            <div class="col-xs-10">
                                              <div style="display:flex">
                                                <div class="tbl-image">
                                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                                                  </div> 
                                                  <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                    <strong>TABLE: <?=$r['MaBan']?></strong>
                                                    <br>
                                                    <span>Doanh thu: <?=( $r['DoanhThu'] ) ? number_format($r['DoanhThu'],0,",",".") : 0?><sup>đ</sup></span>
                                                  </div>
                                              </div>
                                            </div>
                                            <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                                        </div>
                                        <div id="vacant-<?=$i?>" aria-expanded="false" style="display:none;">
                                            <hr></hr>
                                            
                                            <?php
                                           // var_dump($occupation);
                                            $table_id = $r['MaBan'];
                                            $sales_details = $goldenlotus->getSalesByFoodNames ( $date, $table_id, $occupation);
                                            //var_dump($sales_details);
                                            while( $r1 = sqlsrv_fetch_array( $sales_details ) )
                                            { ?>
                                              <div class="container">
                                                <div class="fluid-row">
                                                    <div class="col-xs-1">
                                                       <div class="soluong">
                                                           <?=$r1['SoLuong']?>
                                                       </div>
                                                    </div>
                                                    <div class="col-xs-5">
                                                       <strong><?=$r1['MaHangBan']?>.  <?=$r1['TenHangBan']?> (<?=$r1['MaDVT']?>)</strong>
                                                       <br>
                                                       <span><?=( $r1['DoanhThu'] ) ? number_format($r1['DoanhThu'],0,",",".") : 0?> <sup>đ</sup></span>
                                                    </div>
                                                </div>
                                              </div>
                                               <hr>
                                            <?php 
                                            } $i++; ?>
                                           
                                        </div>
                                    </li>
                                </ul>
                                <?php
                                }
                                ?>
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