<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);


$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";
$tenNhomHB = isset( $_POST['tenNhomHB'] ) ? $_POST['tenNhomHB'] : "";
echo $tuThang = isset( $_POST['tuThang']) ?  date_format( date_create( $_POST['tuThang'] ) , 'Y-m' ) : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = '';

$rs = $goldenlotus->getRevByGroup_Month( $tenQuay, $tenNhomHB, $tuThang );

foreach ( $rs as $r )
{ 
$output .= '
    <tr>
      <td>' . $r['MaHangBan'] . '</td>
      <td>' . $r['TenHangBan'] . ' </td>
      <td> ' . $r['MaDVT']  . '</td>
      <td> ' . $r['SoLuong']. '</td>
      <td>' . number_format(intval($r['ThanhTien']),0,",","") . '</td>
    </tr>';
}

echo json_encode($output);