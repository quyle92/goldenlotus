<?php  
$page_name = "BaoCaoQuanTri";
require_once('../helper/security.php'); 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id=isset($_SESSION['MaNV'])?$_SESSION['MaNV']:"";
$ten=isset($_SESSION['TenNV'])?$_SESSION['TenNV']:"";

$matrungtam = isset($_SESSION['MaTrungTam'])?$_SESSION['MaTrungTam']:"";
$trungtam = isset($_SESSION['TenTrungTam'])?$_SESSION['TenTrungTam']:"";


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

#bill_table td, #bill_table th{
   border: 1px solid black!important;
}

	
.h2-bg{
    margin: 30px 0;
    background: repeating-linear-gradient(
        -45deg,
        #e6f4ff,
        #e6f4ff 2px,
        #fff 3px,
        #fff 8px
);
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

  $(function () {

  /**
   * css for first bill_ID
   * 
   */
  var tr = $('table tbody tr[data-bill]');
  var style = {
      'color':'#43C1FD',
      'font-weight': 'bold'
  };
  tr.each(function() {
    if($(this).data('bill') != " "){//console.log($(this).data('bill'));
      $(this).find('td').css(style);
    }
  });


  /**
   * css for subtotal
   * 
   */
  var tr = $('table tbody tr[data-total]');
  var style = {
      'color':'red',
      'font-weight': 'bold'
  };
  tr.each(function() {
    if($(this).data('bill') != " "){//console.log($(this).data('bill'));
      $(this).find('td').css(style);
    }
  });

});
</script>
</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Danh Sách Bàn + Doanh Thu (Nhà Hàng)</h3>

  
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
                        <?php
                          require('../datetimepicker-day.php');
                        ?>
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
                                    if( ! empty($tenQuay))
                                    {
                                      $goldenlotus->layView( $tenQuay  );
                                    }

                                    $tenQuay = isset($_POST['tenQuay']) ? $_POST['tenQuay'] : "";
                                    $tuNgay = isset( $_POST['tuNgay'] ) ?  date_format( date_create( $_POST['tuNgay'] ) , 'Y-m-d' ) : "";
                                    $sales_by_table = $goldenlotus->getTablesAndBills( $tuNgay, $tenQuay );
                                    $sales_by_table = customizeArray_TablesBills( $sales_by_table );
                                    //var_dump($sales_by_table);//die;
                                    $q = 1;
                                    foreach ( $sales_by_table as $table ) 
                                    {?>
                                    <tr>
                                      <td>
                                          <ul class="list-group danh-sach-ban">
                                              <li class="list-group-item">
                                                  <div class="row toggle" id="dropdown-detail-<?=$q?>" data-toggle="all-<?=(( $table->TongDoanhThu )) ? str_replace('.','',$table->MaBan ) : ''?>">
                                                      <div class="col-xs-10">
                                                        <div style="display:flex">
                                                          <div class="tbl-image">
                                                              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                                                            </div> 
                                                            <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                              <strong>Key: <?=$table->MaBan?></strong>
                                                              <br>
                                                              <span>Tổng Doanh thu: <?=( $table->TongDoanhThu ) ? number_format($table->TongDoanhThu,0,",",".") : 0?><sup>đ</sup></span>
                                                            </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                                                  </div>
                                                  <div id="all-<?=str_replace('.','',$table->MaBan )?>" aria-expanded="false" style="display:none;">
                                                      <hr></hr>
                                                        
                                                     
                                                        <div class="container" style="width:100%">
                                                          <div class="fluid-row">

                                                            <table class="table table-bordred table-striped" id="bill_table">
                                                              <thead>
                                                                <?php
                                                                $total_th = 9;
                                                                ?>
                                                                <tr>
                                                                  <th>Mã lịch sử phiếu</th>
                                                                  <th>Nhân viên</th>
                                                                  <th>Ngày vào</th>
                                                                  <th>Tên hàng bán</th>
                                                                  <th>Đơn giá</th>
                                                                  <th>Số lượng</th>
                                                                  <th>Thành tiền</th>
                                                                 <!--  <th>Mã Lịch Sử Phiếu</th> -->
                                                                </tr>
                                                              </thead>
                                                              <tbody>
                                                               <?php
                                                              $k = 0; 
                                                              $font_style = 'color:#43C1FD;font-weight: bold;';
                                                              $subtotal = 0;
                                                              foreach ( $table->MaLichSuPhieu as $bill ) 
                                                              { 
                                                                if($k !=0 && $bill != " ") { ?>

                                                                <tr data-total="total">
                                                                  <td>Tổng</td>
                                                                  <?php
                                                                  for( $i=0; $i < $total_th-4; $i++)
                                                                    echo "<td></td>";
                                                                  ?>
                                                                  <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                                                                </tr>
                                                                <tr >
                                                                   <?php
                                                                  for( $i=0; $i < $total_th-2 ; $i++)
                                                                     echo "<td class=\"h2-bg\"></td>";
                                                                  ?>
                                                                </tr>
                                                              <?php $subtotal = 0;} ?>
                                                                <tr data-bill="<?=$bill?>" >
                                                                  <td>
                                                                    <?=$bill?>     
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->MaNhanVien[$k]?>
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->GioVao[$k]?>     
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->TenHangBan[$k]?>
                                                                  </td>
                                                                  <td>
                                                                    <?=number_format($table->DonGia[$k],0,",",".") . '<sup>đ</sup>'?>
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->SoLuong[$k]?>
                                                                  </td>
                                                                  <td>
                                                                    <?php echo number_format($table->ThanhTien[$k],0,",",".") . '<sup>đ</sup>'; $subtotal += $table->ThanhTien[$k]?>
                                                                  </td>
                                                                </tr>
                                                              <?php  $k++; 
                                                                if( $k == sizeof($table->MaLichSuPhieu) ){ ?> 
                                                                  <tr data-total="total">
                                                                    <td  >Tổng</td>
                                                                    <?php
                                                                  for( $i=0; $i < $total_th-4 ; $i++)
                                                                    echo "<td></td>";
                                                                  ?>
                                                                     <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                                                                  </tr>

                                                                <?php } ?>

                                                              <?php 
                                                              } 
                                                               ?>
                                                     
                                                              </tbody>
                                                            </table>

                                                          </div>
                                                        </div>
                                                         <hr>
                                                      
                                              </li>
                                          </ul>
                                                
                                             
                                     </td>
                                    </tr>
                                   <?php
                                    $q++;}
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
                      
                      <div class="tab-pane fade " id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <div class="panel panel-default">

                              <table id="occupied" class="display" style="width:100%">
                              <thead>
                                  <tr>
                                      <th></th>

                                  </tr>
                              </thead>
                              <tbody>
                                  
                                    <?php
                                    $sales_by_table = $goldenlotus->getTablesAndBills_Occupied( $tuNgay , $tenQuay  );
                                    $sales_by_table = customizeArray_TablesBills( $sales_by_table );
                                    //var_dump($sales_by_table);//die;
                                    $i = 1;
                                    foreach ( $sales_by_table as $table ) 
                                    { ?>
                                    <tr>
                                      <td>
                                                                                    
                                          <ul class="list-group danh-sach-ban">
                                              <li class="list-group-item">
                                                  <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="occupied-<?=(( $table->TongDoanhThu )) ? str_replace('.','',$table->MaBan ) : ''?>">
                                                      <div class="col-xs-10">
                                                        <div style="display:flex">
                                                          <div class="tbl-image">
                                                              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                                                            </div> 
                                                            <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                              <strong>Key: <?=$table->MaBan?></strong>
                                                              <br>
                                                              <span>Tổng Doanh thu: <?=( $table->TongDoanhThu ) ? number_format($table->TongDoanhThu,0,",",".") : 0?><sup>đ</sup></span>
                                                            </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                                                  </div>
                                                  <div id="occupied-<?=str_replace('.','',$table->MaBan )?>" aria-expanded="false" style="display:none;">
                                                      <hr></hr>
                                                        
                                                     
                                                        <div class="container" style="width:100%">
                                                          <div class="fluid-row">

                                                            <table class="table table-bordred table-striped" id="bill_table">
                                                              <thead>
                                                                <?php
                                                                $total_th = 9;
                                                                ?>
                                                                <tr>
                                                                  <th>Mã lịch sử phiếu</th>
                                                                  <th>Nhân viên</th>
                                                                  <th>Ngày vào</th>
                                                                  <th>Tên hàng bán</th>
                                                                  <th>Đơn giá</th>
                                                                  <th>Số lượng</th>
                                                                  <th>Thành tiền</th>
                                                                 <!--  <th>Mã Lịch Sử Phiếu</th> -->
                                                                </tr>
                                                              </thead>
                                                              <tbody>
                                                               <?php
                                                              $k = 0; 
                                                              $font_style = 'color:#43C1FD;font-weight: bold;';
                                                              $subtotal = 0;
                                                              foreach ( $table->MaLichSuPhieu as $bill ) 
                                                              { 
                                                                if($k !=0 && $bill != " ") { ?>

                                                                <tr data-total="total">
                                                                  <td>Tổng</td>
                                                                  <?php
                                                                  for( $i=0; $i < $total_th-4; $i++)
                                                                    echo "<td></td>";
                                                                  ?>
                                                                  <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                                                                </tr>
                                                                <tr >
                                                                   <?php
                                                                  for( $i=0; $i < $total_th-2 ; $i++)
                                                                     echo "<td class=\"h2-bg\"></td>";
                                                                  ?>
                                                                </tr>
                                                              <?php $subtotal = 0;} ?>
                                                                <tr data-bill="<?=$bill?>" >
                                                                  <td>
                                                                    <?=$bill?>     
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->MaNhanVien[$k]?>
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->GioVao[$k]?>     
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->TenHangBan[$k]?>
                                                                  </td>
                                                                  <td>
                                                                    <?=number_format($table->DonGia[$k],0,",",".") . '<sup>đ</sup>'?>
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->SoLuong[$k]?>
                                                                  </td>
                                                                  <td>
                                                                    <?php echo number_format($table->ThanhTien[$k],0,",",".") . '<sup>đ</sup>'; $subtotal += $table->ThanhTien[$k]?>
                                                                  </td>
                                                                </tr>
                                                              <?php  $k++; 
                                                                if( $k == sizeof($table->MaLichSuPhieu) ){ ?> 
                                                                  <tr data-total="total">
                                                                    <td  >Tổng</td>
                                                                    <?php
                                                                  for( $i=0; $i < $total_th-4 ; $i++)
                                                                    echo "<td></td>";
                                                                  ?>
                                                                     <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                                                                  </tr>

                                                                <?php } ?>

                                                              <?php 
                                                              } 
                                                              $i++; ?>
                                                     
                                                              </tbody>
                                                            </table>

                                                          </div>
                                                        </div>
                                                         <hr>
                                                      
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

                              <table id="empty" class="display" style="width:100%">
                              <thead>
                                  <tr>
                                      <th></th>

                                  </tr>
                              </thead>
                              <tbody>
                                  
                                    <?php
                                    $date = date('2015/08/26');
                                   // $date = date('yy/m/d');
                                  
                                    $sales_by_table = $goldenlotus->getTablesAndBills_Empty(  $tuNgay , $tenQuay );
                                    $sales_by_table = customizeArray_TablesBills( $sales_by_table );
                                    //var_dump($sales_by_table);//die;
                                    $i = 1;
                                    foreach ( $sales_by_table as $table ) 
                                    { ?>
                                    <tr>
                                      <td>
                                                                                    
                                          <ul class="list-group danh-sach-ban">
                                              <li class="list-group-item">
                                                  <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="empty-<?=(( $table->TongDoanhThu )) ? str_replace('.','',$table->MaBan ) : ''?>">
                                                      <div class="col-xs-10">
                                                        <div style="display:flex">
                                                          <div class="tbl-image">
                                                              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                                                            </div> 
                                                            <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                              <strong>Key: <?=$table->MaBan?></strong>
                                                              <br>
                                                              <span>Tổng Doanh thu: <?=( $table->TongDoanhThu ) ? number_format($table->TongDoanhThu,0,",",".") : 0?><sup>đ</sup></span>
                                                            </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                                                  </div>
                                                  <div id="empty-<?=str_replace('.','',$table->MaBan )?>" aria-expanded="false" style="display:none;">
                                                      <hr></hr>
                                                        
                                                     
                                                        <div class="container" style="width:100%">
                                                          <div class="fluid-row">

                                                            <table class="table table-bordred table-striped" id="bill_table">
                                                              <thead>
                                                                <?php
                                                                $total_th = 9;
                                                                ?>
                                                                <tr>
                                                                  <th>Mã lịch sử phiếu</th>
                                                                  <th>Nhân viên</th>
                                                                  <th>Ngày vào</th>
                                                                  <th>Tên hàng bán</th>
                                                                  <th>Đơn giá</th>
                                                                  <th>Số lượng</th>
                                                                  <th>Thành tiền</th>
                                                                 <!--  <th>Mã Lịch Sử Phiếu</th> -->
                                                                </tr>
                                                              </thead>
                                                              <tbody>
                                                               <?php
                                                              $k = 0; 
                                                              $font_style = 'color:#43C1FD;font-weight: bold;';
                                                              $subtotal = 0;
                                                              foreach ( $table->MaLichSuPhieu as $bill ) 
                                                              { 
                                                                if($k !=0 && $bill != " ") { ?>

                                                                <tr data-total="total">
                                                                  <td>Tổng</td>
                                                                  <?php
                                                                  for( $i=0; $i < $total_th-4; $i++)
                                                                    echo "<td></td>";
                                                                  ?>
                                                                  <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                                                                </tr>
                                                                <tr >
                                                                   <?php
                                                                  for( $i=0; $i < $total_th-2 ; $i++)
                                                                     echo "<td class=\"h2-bg\"></td>";
                                                                  ?>
                                                                </tr>
                                                              <?php $subtotal = 0;} ?>
                                                                <tr data-bill="<?=$bill?>" >
                                                                  <td>
                                                                    <?=$bill?>     
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->MaNhanVien[$k]?>
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->GioVao[$k]?>     
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->TenHangBan[$k]?>
                                                                  </td>
                                                                  <td>
                                                                    <?=number_format($table->DonGia[$k],0,",",".") . '<sup>đ</sup>'?>
                                                                  </td>
                                                                  <td>
                                                                    <?=$table->SoLuong[$k]?>
                                                                  </td>
                                                                  <td>
                                                                    <?php echo number_format($table->ThanhTien[$k],0,",",".") . '<sup>đ</sup>'; $subtotal += $table->ThanhTien[$k]?>
                                                                  </td>
                                                                </tr>
                                                              <?php  $k++; 
                                                                if( $k == sizeof($table->MaLichSuPhieu) ){ ?> 
                                                                  <tr data-total="total">
                                                                    <td  >Tổng</td>
                                                                    <?php
                                                                  for( $i=0; $i < $total_th-4 ; $i++)
                                                                    echo "<td></td>";
                                                                  ?>
                                                                     <td><?=number_format($subtotal,0,",",".")?><sup>đ</sup></td>
                                                                  </tr>

                                                                <?php } ?>

                                                              <?php 
                                                              } 
                                                              $i++; ?>
                                                     
                                                              </tbody>
                                                            </table>

                                                          </div>
                                                        </div>
                                                         <hr>
                                                      
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

