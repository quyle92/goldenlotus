<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNam = isset( $_POST['tuNam']) ?  $_POST['tuNam'] : "";
$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = "";

$bill_edit = $goldenlotus->getBillEditDetailsBySelection_Year( $tuNam, $tenQuay );
foreach ( $bill_edit as $r )
{ 
$output .= '<tr>
      <td>' . ( ( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 0, 10) : "" ). '</td>
      <td>' . utf8_encode($r['TenNV']) . ' </td>
      <td> ' . ( ( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 11, 5) : ""  )  . '</td>
      <td> ' . utf8_encode($r['GhiChu']) . '</td>
      <td>' . substr($r['ThoiGianTaoPhieu'],0, 10) . '</td>
      <td>' . $r['MaLichSuPhieu'] . '</td>
      
      <td></td>
      <td></td>
      <td></td>
    </tr>';
}
// var_dump($output); 
echo json_encode($output);