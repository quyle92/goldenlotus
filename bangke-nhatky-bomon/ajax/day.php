<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNgay = date('Y-m-d', strtotime($_POST['tuNgay']) );
$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = "";

$nhat_ky_bo_mon = $goldenlotus->getCancelledFoodItem_Day ( $tuNgay, $tenQuay );
foreach ( $nhat_ky_bo_mon as $r )
{ 
$output .= ' 
<tr>
	<td>' . ( isset( $r['ThoiGianBan'] ) ? substr($r['ThoiGianSuaPhieu'],0,10) : "" ) . '</td>
	<td> ' .  $r['TenNV'] . '</td>
	<td>' .$r['TenHangBan'] . '</td>
	<td>' .$r['MaBan'] . '</td>
	<td>' . ( isset( $r['ThoiGianBan'] ) ? substr($r['ThoiGianSuaPhieu'],11,5) : "" ) . '</td>
	<td>' .$r['SoLuong'] . '</td>
</tr>';
}
//var_dump($nhb_doanh_thu_arr); 
echo json_encode($output);