<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNgay = isset( $_POST['tuNgay'] ) ? $_POST['tuNgay'] :"";//16/10/2020
$tuNgay = date('Y-m-d', strtotime($tuNgay) );
$tenNhom = isset( $_POST['tenNhom'] ) ? $_POST['tenNhom'] :"";

$totalSales = array();
$output = '';

$rs = $goldenlotus->getSoLuongHangBanTheoNhom_Day( $tuNgay, $tenNhom  );
foreach ( $rs as $r ) 
{
	//$totalSales[] = (int) $r['TotalSales']; 
	$output.= '<tr>
      <td>' . $r['MaHangBan'] . '</td>
      <td>' . $r['TenHangBan'] . '</td>
      <td>' . number_format($r['TongSoLuong'],0,",",".") . '</td>
    </tr>';
}
// var_dump($output);
echo json_encode($output);