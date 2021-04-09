<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuThang = isset( $_POST['tuThang'] ) ? $_POST['tuThang'] :"";
$tuThang = isset( $tuThang ) ?  date_format( date_create( $tuThang ) , 'Y-m' ) : "";
$tenNhom = isset( $_POST['tenNhom'] ) ? $_POST['tenNhom'] :"";

$totalSales = array();
$output = '';

$rs = $goldenlotus->getSoLuongHangBanTheoNhom_Month( $tuThang, $tenNhom  );
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