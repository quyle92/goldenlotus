<?php
require("../lib/db.php");
require("../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus;

$hom_khac = isset($_POST['hom-khac']) ? $_POST['hom-khac'] : "";// 16/10/2020
$hom_khac = substr($hom_khac,6) . "/" . substr($hom_khac,3,2) . "/" . substr($hom_khac,0,2);

$hang_ban = $goldenlotus->getFoodSoldAnotherDay($hom_khac);
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