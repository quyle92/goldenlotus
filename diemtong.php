<?php  
$page_name = "diemtong";
require_once('helper/security.php'); 
require('lib/db.php');
require('lib/goldenlotus.php');
require_once('helper/custom-function.php'); 
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$today = date('Y-m-d');
$yesterday =   date('Y-m-d',strtotime("-1 day"));
$last_week =   date('Y-m-d',strtotime("-7 days"));
// $today = date('2021-01-20');
// $yesterday =  date('2021-01-19');
// $last_week = date('2021-01-13');

$up = '<i class="fa fa-arrow-up" aria-hidden="true"></i>';
$down = '<i class="fa fa-arrow-down" aria-hidden="true"></i>';

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];


$rs = removeOuterArr( $goldenlotus->getDoanhThuSpa() ); 
//pr($rs[0]);

?>


<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>
<style>
.graphs {
    padding: 2em 1em;
    background: transparent;
    font-family: 'Roboto', sans-serif;
}
table {
	    text-transform: capitalize;
	    font-size: 18px;
}
/**
 * Striped table for popup
 */
.custab{
  border: 1px solid #ccc;
  padding: 5px;
  margin: 5% 0;
  box-shadow: 3px 3px 2px #ccc;
  transition: 0.5s;
  }
.custab:hover{
  box-shadow: 3px 3px 0px transparent;
  transition: 0.5s;
  }

.borderless td, .borderless th {
    border: none;
    color: #fff!important;
}

.well {
  background: #43C1FD !important;

}


/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 10px;
  margin-bottom: 20px;
  margin-left: 15px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5A55A3;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #5A55A3;
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #5A55A3;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
 /* padding-left: 20px;*/
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}

.textCenter tr td, .textCenter tr th {
  text-align: center;
  vertical-align: middle;
}
</style>
<!-- Bootstrap iOS toggle https://www.bootstraptoggle.com/ -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
<div id="wrapper">
    <?php include 'menu.php'; ?>
  <div id="page-wrapper">
     <div class="container">  
      <div class="col-md-6 col-md-offset-2 well">
        <table class="table borderless">
                      <thead  class="textCenter">
                        <tr>
                          <th nowrap="nowrap">Điểm tổng</th>
                          <th >So sánh</th>
                        </tr>
                      </thead>
                      <tbody class="textCenter">
                      <?php
                      $sales_today = $goldenlotus->getTotalSales($today);//$today
                      $sales_yesterday = $goldenlotus->getTotalSales($yesterday); 
                      $sales_last_week = $goldenlotus->getTotalSales($last_week);

                      $bill_amount_today = $goldenlotus->getBillAmount( $today);

                      ?>
                        <tr>
                          <td><?=number_format($sales_today,0,",",".");?><sup>đ</sup></td>
                          <td>
                            <small class="pull-left">
                          <?php
                              so_sanh_diem_tong_hom_qua( $sales_today, $sales_yesterday )
                          ?>
                            </small>
                            <small class="pull-left">
                              <?php 
                                so_sanh_diem_tong_tuan_truoc( $sales_today, $sales_last_week )
                                ?>
                            </small>
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo $bill_amount_today; ?> hóa đơn</td>
                          <td>
                          </td>
                        </tr>
                        <tr>
                          <td><?=$bill_amount_today != 0  ? ( number_format( round($sales_today/$bill_amount_today),0,",",".") ) : 0?><sup>đ</sup>/hóa đơn</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
      </div>
     
        <div class="row">
          <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 bhoechie-tab-container">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 bhoechie-tab-menu">
              <div class="list-group">
                <a href="#" class="list-group-item active text-center">
                  <h2 class="glyphicon glyphicon-plane"></h2><br/> <h4> 27 Phạm Ngọc Thạch </h4>
                    <table class="table borderless">
                      <thead class="textCenter">
                        <tr>
                          <th nowrap="nowrap">Điểm tổng</th>
                          <th>So sánh</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      $sales_today = $goldenlotus->getTotalSales($today);//$today
                      $sales_yesterday = $goldenlotus->getTotalSales($yesterday); 
                      $sales_last_week = $goldenlotus->getTotalSales($last_week);

                      $bill_amount_today = $goldenlotus->getBillAmount( $today);

                      ?>
                        <tr>
                          <td><?=number_format($sales_today,0,",",".");?><sup>đ</sup></td>
                          <td>
                            <small class="pull-left">
                          <?php
                              so_sanh_diem_tong_hom_qua( $sales_today, $sales_yesterday )
                          ?>
                            </small>
                            <small class="pull-left">
                              <?php 
                                so_sanh_diem_tong_tuan_truoc( $sales_today, $sales_last_week )
                                ?>
                            </small>
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo $bill_amount_today; ?> hóa đơn</td>
                          <td>
                          </td>
                        </tr>
                        <tr>
                          <td><?=$bill_amount_today != 0  ? ( number_format( round($sales_today/$bill_amount_today),0,",",".") ) : 0?><sup>đ</sup>/hóa đơn</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                </a>
                
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 bhoechie-tab">
                <!-- flight section -->
                <div class="bhoechie-tab-content active">
                  

                  <div class="col-md-12">
                    <table class="table table-striped table-hover custab">
                      <thead>
                        <tr>
                          <th>Quầy</th>
                          <th nowrap="nowrap">Doanh thu</th>
                          <th>So sánh</th>
                          <th nowrap="nowrap">Chi Tiết</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Spa</td>
                          <td nowrap="nowrap">
                            <?php 
                            $spa = removeOuterArr( $goldenlotus->getDoanhThuSpa() ); 
                            echo $spa_today = number_format( $spa[0]['DoanhThu'],0,",",".");
                            ?>
                             <sup>đ</sup>
                          </td>
                          <td>
                            <small class="pull-left">
                              <?php 
                              $spa_yesterday =  $spa[1]['DoanhThu'];
                              compareYesterday( $spa_today, $spa_yesterday );
                              ?>
                            </small>
                            <small class="pull-left">
                              <?php 
                              $spa_lastWeek  = $spa[2]['DoanhThu'];
                              compareLastWeek( $spa_today, $spa_lastWeek );
                              ?>
                            </small>
                          </td>
                          <td> 
                            <?php if( $_SESSION['MaNV'] === 'HDQT' ||  in_array($page_name, $_SESSION['BaoCaoDuocXem']) ) { ?>
                            <a href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?><?=( ( $_SERVER['SERVER_NAME'] !== 'localhost' ) ? "" : "/goldenlotus" )?>/tonghop-doanhthu-cacquay-theongay/index.php#tab_SPA" target="_blank"> <span class="glyphicon glyphicon-new-window"></span></a>
                          <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td nowrap="nowrap">Snack bar</td>
                          <td>
                            <?php 
                            $snack_bar = removeOuterArr( $goldenlotus->getDoanhThuSnackBar() ); 
                            echo $snack_bar_today = number_format( $snack_bar[0]['DoanhThu'],0,",",".");
                            ?>
                             <sup>đ</sup>
                          </td>
                           <td>
                            <small class="pull-left">
                              <?php 
                              $snack_bar_yesterday =  $snack_bar[1]['DoanhThu'];
                              compareYesterday( $snack_bar_today, $snack_bar_yesterday );
                              ?>
                            </small>
                            <small class="pull-left">
                              <?php 
                              $snack_bar_lastWeek  = $snack_bar[2]['DoanhThu'];
                              compareLastWeek( $snack_bar_today, $snack_bar_lastWeek );
                              ?>
                            </small>
                          </td>
                          <td> <?php if( $_SESSION['MaNV'] === 'HDQT' ||  in_array($page_name, $_SESSION['BaoCaoDuocXem']) ) { ?>
                            <a href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?><?=( ( $_SERVER['SERVER_NAME'] !== 'localhost' ) ? "" : "/goldenlotus" )?>/tonghop-doanhthu-cacquay-theongay/index.php#tab_SNACKBAR" target="_blank"> <span class="glyphicon glyphicon-new-window" ></span></a>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Cafeteria</td>
                          <td>
                            <?php 
                            $cafeteria = removeOuterArr( $goldenlotus->getDoanhThuCafeteria() ); 
                            echo $cafeteria_today = number_format( $cafeteria[0]['DoanhThu'],0,",",".");
                            ?>
                             <sup>đ</sup>
                          </td>
                           <td>
                            <small class="pull-left">
                              <?php  
                              $cafeteria_yesterday =  $cafeteria[1]['DoanhThu'];
                              compareYesterday( $cafeteria_today, $cafeteria_yesterday );
                              ?>
                            </small>
                            <small class="pull-left">
                              <?php 
                              $cafeteria_lastWeek  = $cafeteria[2]['DoanhThu'];
                              compareLastWeek( $cafeteria_today, $cafeteria_yesterday );
                              ?>
                            </small>
                          </td>
                          <td> <?php if( $_SESSION['MaNV'] === 'HDQT' ||  in_array($page_name, $_SESSION['BaoCaoDuocXem']) ) { ?>
                            <a href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?><?=( ( $_SERVER['SERVER_NAME'] !== 'localhost' ) ? "" : "/goldenlotus" )?>/tonghop-doanhthu-cacquay-theongay/index.php#tab_CAFE" target="_blank"> <span class="glyphicon glyphicon-new-window" ></span></a>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Game</td>
                          <td>
                            <?php 
                            $game = removeOuterArr( $goldenlotus->getDoanhThuGame() ); 
                            echo $game_today = number_format( $game[0]['DoanhThu'],0,",",".");
                            ?>
                             <sup>đ</sup>
                          </td>
                           <td>
                            <small class="pull-left">
                              <?php  
                              $game_yesterday =  $game[1]['DoanhThu'];
                              compareYesterday( $game_today, $game_yesterday );
                              ?>
                            </small>
                            <small class="pull-left">
                              <?php 
                              $game_lastWeek  = $game[2]['DoanhThu'];
                              compareLastWeek( $game_today, $game_lastWeek );
                              ?>
                            </small>
                          </td>
                          <td>  
                            <?php if( $_SESSION['MaNV'] === 'HDQT' ||  in_array($page_name, $_SESSION['BaoCaoDuocXem']) ) { ?>
                            <a href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?><?=( ( $_SERVER['SERVER_NAME'] !== 'localhost' ) ? "" : "/goldenlotus" )?>/tonghop-doanhthu-cacquay-theongay/index.php#tab_GAME" target="_blank"> <span class="glyphicon glyphicon-new-window" ></span></a>
                            <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td nowrap="nowrap">Nhà hàng</td>
                          <td>
                            <?php 
                            $nha_hang = removeOuterArr( $goldenlotus->getDoanhThuNhaHang() ); 
                            echo $nha_hang_today = number_format( $nha_hang[0]['DoanhThu'],0,",",".");
                            ?>
                             <sup>đ</sup>
                          </td>
                           <td>
                            <small class="pull-left">
                              <?php  
                              $nha_hang_yesterday =  $nha_hang[1]['DoanhThu'];
                              compareYesterday( $nha_hang_today, $nha_hang_yesterday );
                              ?>
                            </small>
                            <small class="pull-left">
                              <?php 
                              $nha_hang_lastWeek  = $nha_hang[2]['DoanhThu'];
                              compareLastWeek( $nha_hang_today, $nha_hang_lastWeek );
                              ?>
                            </small>
                          </td>
                          <td> 
                            <?php if( $_SESSION['MaNV'] === 'HDQT' ||  in_array($page_name, $_SESSION['BaoCaoDuocXem']) ) { ?>
                              <a href="<?=( isset($_SERVER['HTTPS']) ? "https://" : "http://" )?><?=$_SERVER['SERVER_NAME']?><?=( ( $_SERVER['SERVER_NAME'] !== 'localhost' ) ? "" : "/goldenlotus" )?>/tonghop-doanhthu-cacquay-theongay/index.php#tab_RESTAURANT" target="_blank"> <span class="glyphicon glyphicon-new-window" ></span></a>
                              <?php } ?>
                            </td>
                        </tr>
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


</body>

</html>

