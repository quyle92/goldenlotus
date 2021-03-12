<?php
require("../lib/db.php");
require("../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tungay = isset( $_POST['tuNgay'] ) ? $_POST['tuNgay'] :"";//16/10/2020
$tungay = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);

$denngay = isset( $_POST['denNgay'] ) ? $_POST['denNgay'] :"";
$denngay = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);


$hang_ban = $goldenlotus->getFoodSoldAnotherDay($tungay, $denngay, $total);
$data = array();
$data[] = 'Tổng doanh thu: ' . number_format($total,0,",",".")  . '<sup>đ</sup>';


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