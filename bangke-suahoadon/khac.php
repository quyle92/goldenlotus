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

$bill_edit = $goldenlotus->getBillEditDetailsBySelection( $tungay, $denngay );
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