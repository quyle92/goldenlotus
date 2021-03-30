<?php  
$page_name = "TongHopSoLuongBan";
require_once('../helper/security.php'); 
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>


</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Bảng kê sửa hóa đơn</h3>

            <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                          <?php
                            $rs = $goldenlotus->getTenQuay();
                            $i = 0;
                            foreach ( $rs as $r )
                            { ?>
                              <li <?=($i === 0) ? 'class="active"' : ""?>><a href="#<?=$r['TenQuay']?>" data-toggle="tab"><?=$r['TenQuay']?></a></li>
                            <?php $i++;
                            }
                            
                          ?>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        
                        <?php
                            $rs = $goldenlotus->getTenQuay();
                            $i = 0;
                            foreach ( $rs as $r )
                            { ?>
                              <div class="tab-pane  <?=($i === 0) ? 'fade in active' : ""?>" id="<?=$r['TenQuay']?>">
                                <?php
                                  $tenQuay = $r['TenQuay'];
                                  $file_name = __DIR__ . '/' . $tenQuay . '.php';

                                  if( file_exists($file_name)  )
                                  {
                                    unlink($file_name);
                                  }

                                  if( !( file_exists($file_name) ) ){
                                      $file_contents = file_get_contents(__DIR__ ."/template.php");
                                      file_put_contents( $file_name , $file_contents );
                                  }

                                  ob_start();
                                  include($file_name);
                                  echo ob_get_clean();

                                  $file_name_ajax =  __DIR__ .  '/ajax/' . $tenQuay . '.php';

                                  if(  file_exists($file_name_ajax) )
                                  {
                                    unlink($file_name_ajax);
                                  }

                                  if( !( file_exists($file_name_ajax) ) )
                                  {
                                    $file_contents = file_get_contents(__DIR__ .  "/ajax/ajax_template.php");
                                    file_put_contents( $file_name_ajax , $file_contents );
                                  }
                                ?>
                              </div>
                            <?php $i++;
                            }
                            
                          ?>
         
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

</body>
</html>
