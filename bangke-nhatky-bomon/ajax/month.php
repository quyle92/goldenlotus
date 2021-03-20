<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuThang = isset( $_POST['tuThang']) ?  date_format( date_create( $_POST['tuThang'] ) , 'Y-m' ) : "";
$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";
//var_dump($tenQuay );die;
if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = "";

$nhat_ky_bo_mon = $goldenlotus->getCancelledFoodItem_Month ( $tuThang, $tenQuay );
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