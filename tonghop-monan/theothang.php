<?php
require("../lib/db.php");
require("../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus;

$thang_khac = isset($_POST['thang-khac']) ? $_POST['thang-khac'] : "";//10/2020
$thang_khac = substr($thang_khac,3) . "/" . substr($thang_khac,0,2);
$thang_khac  = date('2016/09');

$hang_ban = $goldenlotus->getFoodSoldAnotherMonth($thang_khac, $total);
$data = array();
$data[] = 'Tổng doanh thu: ' . number_format($total,0,",",".")  . '<sup>đ</sup>';


for ($i = 0; $i < sqlsrv_num_rows($hang_ban); $i++) 
{ 
	$r=sqlsrv_fetch_array($hang_ban);
	
   	$data []= '<tr>
    <td class="sorting_1">' . $r["TenHangBan"]  .' </td>
    <td>'. $r["MaDVT"] . '</td>
    <td>' .$r["SoLuong"] .'</td>
    <td>' . number_format($r["ThanhTien"],0,",",".") . '<sup>đ</sup></td>
  </tr>';
}

echo json_encode($data);
