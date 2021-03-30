<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
require('../../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNam = isset( $_POST['tuNam']) ?   htmlspecialchars(strip_tags($_POST['tuNam'])) : "";
$tenQuay = isset( $_POST['tenQuay']) ?    htmlspecialchars(strip_tags($_POST['tenQuay']))  : "";
$rs = $goldenlotus->getDoanhThuNamKhac( $tenQuay, $tuNam );
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