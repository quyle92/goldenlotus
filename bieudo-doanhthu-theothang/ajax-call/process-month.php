<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
require('../../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$date = isset( $_POST['month-selected']) ? date_format( date_create( htmlspecialchars(strip_tags($_POST['month-selected']) ) ) , 'Y-m' ) : "";
$tenQuay = isset( $_POST['tenQuay']) ? htmlspecialchars(strip_tags($_POST['tenQuay']))  : "";
$rs = $goldenlotus->getDoanhThuThangKhac( $tenQuay, $date );
if($rs != false)
{
 
  $doanh_thu = array();
  foreach ( $rs[0] as $k => $v ) 
  {
    $doanh_thu[] = intval($v);
  }

}

echo json_encode($doanh_thu);
?>