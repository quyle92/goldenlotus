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
$dates_has_bill_of_this_month = $goldenlotus->getDatesHasBillOfThisMonth( $tungay, $denngay  );

while ($rs = sqlsrv_fetch_array( $dates_has_bill_of_this_month ))
{
  $date = $rs['NgayCoBill'];
  $food_sold_by_group = $goldenlotus->getFoodSoldByGroup( $date );

  for ($i = 0; $i < sqlsrv_num_rows($food_sold_by_group); $i++) 
  {
	$r = sqlsrv_fetch_array($food_sold_by_group, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
	$output .='
	    <tr>
            <td>' . $r['Ten'] . '</td>
            <td>' . $r['MaHangBan'] . '</td>
            <td>'. $r['TenHangBan'] . '</td>
            <td>' . $r['SoLuong'] . '</td>
            <td></td>
            <td>' . number_format($r['DonGia'],0,",",".") . '<sup>đ</sup></td>
            <td>' . $r['TienGiamGia'] . '</td>
            <td></td>
            <td> ' . $r['SoTienDVPhi'] . '</td>
            <td> ' . $r['SoTienVAT'] . '</td>
            <td> ' . number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".")
              . '<sup>đ</sup></td>
            <td>' . number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".")
               	 .  '<sup>đ</sup></td>
        </tr>
	   ';
   } 
 	
}



echo json_encode($output);