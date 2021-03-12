<?php
require("../lib/db.php");
require("../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);
//var_dump($_POST['tu-thang']);
$tu_thang = isset( $_POST['tu-thang'] ) ? $_POST['tu-thang'] :"";//10/2020
$tu_thang = substr($tu_thang,3) . "/" . substr($tu_thang,0,2);

$den_thang = isset( $_POST['den-thang'] ) ? $_POST['den-thang'] :"";
$den_thang = substr($den_thang,3) . "/" . substr($den_thang,0,2);

$ma_quay = isset( $_POST['ma_quay'] ) ? $_POST['ma_quay'] :"";

$hang_ban = $goldenlotus->getFoodSoldAnotherMonth($tu_thang, $den_thang, $total, $ma_quay );
$data = array();
$data[] = 'Tổng số tiền: ' . number_format($total,0,",",".")  . '<sup>đ</sup>';


foreach ( $hang_ban as $r ) 
{ 	
   	$data []= '<tr>
    <td class="sorting_1">' . $r["TenHangBan"]  .' </td>
    <td>'. $r["MaDVT"] . '</td>
    <td>' .$r["SoLuong"] .'</td>
    <td>' . number_format($r["ThanhTien"],0,",",".") . '<sup>đ</sup></td>
  </tr>';
}

echo json_encode($data);
