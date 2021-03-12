<?php
require("../lib/db.php");
require("../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tungay = isset( $_POST['tu-ngay'] ) ? $_POST['tu-ngay'] :"";//10/2020
 $tungay = substr($tungay,3) . "/" . substr($tungay,0,2) ;

$denngay = isset( $_POST['den-ngay'] ) ? $_POST['den-ngay'] :"";
$denngay = substr($denngay,3) . "/" . substr($denngay,0,2) ;

$nhb_doanh_thu_arr = array();
$doi_chieu_so_luong = $goldenlotus->getSoldvsCancelledItemsBySelection( $tungay, $denngay );
$total_SLOrder = 0;
$total_SLBan = 0;
$total_SLBo = 0;
$output = "";

foreach ( $doi_chieu_so_luong as $r ) 
{ 
  //var_dump($r);
   $output .= utf8_encode('<tr>
    <td>' . $r['TenHangBan'] . '</td>
    <td> ' . $r['SLOrder']); 
  $total_SLOrder += $r['SLOrder']; 

  $output .= '</td>
    <td>' . $r['SLBan'];
  $total_SLBan += $r['SLBan'];

  $output .= '</td>
    <td>' . $r['SLBo'];
  $total_SLBo += $r['SLBo'];

  $output .= '</td>
  </tr>';
 
} 
$output .= '
<tr>
  <td><strong>Tổng</strong></td>
  <td><strong>' . $total_SLOrder . '</strong></td>
  <td><strong>' . $total_SLBan . '</strong></td>
  <td><strong>' . $total_SLBo . '</strong></td>
</tr>';

//var_dump($output); 
echo json_encode($output);