<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNam = isset( $_POST['tuNam'] ) ? $_POST['tuNam'] :"";
$tenNhom = isset( $_POST['tenNhom'] ) ? $_POST['tenNhom'] :"";

$totalSales = array();
$output = '';

$rs = $goldenlotus->getSoLuongHangBanTheoNhom_Year( $tuNam, $tenNhom  );
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