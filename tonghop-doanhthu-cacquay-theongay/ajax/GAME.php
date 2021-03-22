<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNgay = date('Y-m-d', strtotime($_POST['tuNgay']) );
$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";
$tenNhomHB = isset( $_POST['tenNhomHB'] ) ? $_POST['tenNhomHB'] : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = [];

$rs = $goldenlotus->getRevByGroup_Day( $tenQuay, $tenNhomHB, $tuNgay );
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
}

echo json_encode($data);