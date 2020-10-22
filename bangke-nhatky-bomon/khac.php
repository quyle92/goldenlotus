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

$nhat_ky_bo_mon = $goldenlotus->getCancelledFoodItemBySelection ( $tungay, $denngay );
while( $r = sqlsrv_fetch_array($nhat_ky_bo_mon) )
{ 
$output .= ' <tr>
                <td>' . ( isset( $r['ThoiGianBan'] ) ? $r['ThoiGianBan']->format('d-m-yy') : "" ) . '</td>
                <td> ' .  $r['TenNV'] . '</td>
                <td>' .$r['TenHangBan'] . '</td>
                <td>' .$r['MaBan'] . '</td>
                <td>' . ( isset( $r['ThoiGianBan'] ) ? $r['ThoiGianBan']->format('H:i') : "" ) . '</td>
                <td>' .$r['SoLuong'] . '</td>
              </tr>';
}
//var_dump($nhb_doanh_thu_arr); 
echo json_encode($output);