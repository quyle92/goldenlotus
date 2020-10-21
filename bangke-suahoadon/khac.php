<?php
require("../lib/db.php");
require("../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus;

$tungay = isset( $_POST['tu-ngay'] ) ? $_POST['tu-ngay'] :"";//16/10/2020
$tungay = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);

$denngay = isset( $_POST['den-ngay'] ) ? $_POST['den-ngay'] :"";
$denngay = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);

$output = "";

$bill_edit = $goldenlotus->getBillEditDetailsBySelection( $tungay, $denngay );
while( $r = sqlsrv_fetch_array($bill_edit) )
{ 
$output .= '<tr>
      <td>' . ( ( $r['ThoiGianSuaPhieu'] ) ? $r['ThoiGianSuaPhieu']->format('d-m-yy') : "" ). '</td>
      <td>' . $r['TenNV'] . ' </td>
      <td> ' . ( ( $r['ThoiGianSuaPhieu'] ) ? $r['ThoiGianSuaPhieu']->format('H:i') : ""  )  . '</td>
      <td> ' . $r['GhiChu'] . '</td>
      <td>' . $r['ThoiGianTaoPhieu']->format('d-m-yy') . '</td>
      <td>' . $r['MaLichSuPhieu'] . '</td>
      
      <td></td>
      <td></td>
      <td></td>
    </tr>';
}
//var_dump($nhb_doanh_thu_arr); 
echo json_encode($output);