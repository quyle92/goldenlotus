<?php
require("../lib/db.php");
require("../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus;

$thang_khac = isset($_POST['thang-khac']) ? $_POST['thang-khac'] : "";//16/10/2020
$thang_khac = substr($thang_khac,6) . "/" . substr($thang_khac,3,2);

$hang_ban = $goldenlotus->getFoodSoldAnotherMonth($thang_khac);
$data = "";

while ($r=sqlsrv_fetch_array($hang_ban))
{ 
   $data .= '<tr>
    <td>' . $r["TenHangBan"]  .' </td>
    <td>'. $r["MaDVT"] . '</td>
    <td>' .$r["SoLuong"] .'</td>
    <td>' . number_format($r["ThanhTien"],0,",",".") . '<sup>đ</sup></td>
  </tr>';
}

echo json_encode($data);
