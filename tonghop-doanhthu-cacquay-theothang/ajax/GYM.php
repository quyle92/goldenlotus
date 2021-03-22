<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);


$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";
$tenNhomHB = isset( $_POST['tenNhomHB'] ) ? $_POST['tenNhomHB'] : "";
$tuThang = isset( $_POST['tuThang']) ?  date_format( date_create( $_POST['tuThang'] ) , 'Y-m' ) : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = [];
$totalQty = $totalRev = 0;

$rs = $goldenlotus->getRevByGroup_Month( $tenQuay, $tenNhomHB, $tuThang );
$data = "";
$total = 0;
foreach ( $rs as $r )
{ 
$data .= '
    <tr>
      <td>' . $r['MaHangBan'] . '</td>
      <td>' . $r['TenHangBan'] . ' </td>
      <td> ' . $r['MaDVT']  . '</td>
      <td> ' . $r['SoLuong']. '</td>
      <td>' . number_format(intval($r['ThanhTien']),0,",","") . '</td>
    </tr>';
$totalQty += intval($r['SoLuong']);
$totalRev += intval($r['ThanhTien']);
}
$output = [
	'data' => $data,
	'totalQty' => $totalQty,
	'totalRev' => $totalRev,
];
echo json_encode($output);