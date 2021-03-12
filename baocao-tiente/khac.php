<?php
require("../lib/db.php");
require("../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tungay = isset( $_POST['tu-ngay'] ) ? $_POST['tu-ngay'] :"";//16/10/2020
$tungay = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);

$denngay = isset( $_POST['den-ngay'] ) ? $_POST['den-ngay'] :"";
$denngay = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);

$output = "";

$currency_report = $goldenlotus->getCurrencyReportBySelection( $tungay, $denngay );
foreach ( $currency_report as $r ) 
{ 
$output .= '<tr>
  <td>' . $r['MaTienTe'] . '</td>
  <td></td>
  <td></td>
  <td>' . number_format($r['ThucThu'],0,",",".") . '<sup>đ</sup></td>
</tr>';
}
//var_dump($nhb_doanh_thu_arr); 
echo json_encode($output);