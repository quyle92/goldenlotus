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
$nhom_hang_ban_arr = array();
$food_sold_by_group = $goldenlotus->getFoodSoldByGroup_DateSelected( $tungay, $denngay, $nhom_hang_ban_arr, $nhom_hang_ban = "" );
                               
foreach ( $nhom_hang_ban_arr as $nhom_hang_ban)
{ 
  $food_sold_by_group = $goldenlotus->getFoodSoldByGroup_DateSelected( $tungay, $denngay, $nhom_hang_ban_arr, $nhom_hang_ban);
  $i = 0;
  foreach ( $food_sold_by_group as $r ) 
  {
     
  $output .=' <tr>
      <td>' . ( ($i==0) ? $r['Ten'] : "" ) . '</td>
      <td>' . $r['MaHangBan'] . '</td>
      <td> ' . $r['TenHangBan'] . '</td>
      <td> ' . $r['SoLuong']. '</td>
      <td></td>
      <td> ' .number_format($r['DonGia'],0,",","."). '<sup>đ</sup></td>
      <td>' . $r['TienGiamGia'] . '</td>
      <td></td>
      <td>' .$r['SoTienDVPhi'] . '</td>
      <td>' . $r['SoTienVAT'] . '</td>
      <td>' . number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".") . '
          <sup>đ</sup></td>
      <td>' . number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".") . '
          <sup>đ</sup></td>
    </tr>';
    
  //$i++; 
  } 
}



echo json_encode($output);