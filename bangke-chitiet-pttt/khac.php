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
$grand_total = 0;

  $payment_details_by_date = $goldenlotus->getPayMethodDetailsByMonthRange( $tungay, $denngay, $total );
   
   $i = 0;
  foreach ( $payment_details_by_date as $r )
  {
	
	$output .='
	    <tr>
	      <td>' . ( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" ) . ' </td>
	      <td>' .  substr($r['GioVao'],10,5) . '</td>
	      <td>' . $r['MaLichSuPhieu'] . '</td>
	      <td>' . number_format($r['TienThucTra'],0,",","."). '<sup>đ</sup></td>
	      </tr>
	   ';
	$grand_total += $r['TienThucTra'];

	  $i++;
   } 
	
 
   if( $i == $total)
   	$output .='
   		<tr>
	      <td><strong>Grand Total</strong></td>
	      <td></td>
	      <td></td>
	      <td>' . number_format($grand_total,0,",",".") . '<sup>đ</sup></td>
	    </tr>
   ';
 	




echo json_encode($output);