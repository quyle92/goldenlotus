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
$grand_total = 0;settype($grand_total,"integer");
$dates_has_bill_by_selection = $goldenlotus->getDatesHasBillBySelection( $tungay, $denngay, $total_count   );

$k = 0;
foreach ( $dates_has_bill_by_selection as $rs )
{
  $date = $rs['NgayCoBill'];
  $bill_details_by_date_of_month = $goldenlotus->getBillDetailsByDayOfMonth( $date, $count );

  $total = 0;settype($total,"integer");

  foreach ( $bill_details_by_date_of_month as $r )
  {

	$output .='
	    <tr>
	      <td>' . ( ($i==0) ? $r['ThoiGianBan']->format('d-m-Y') : "" ) . ' </td>
	      <td>' . ( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" ) . '</td>
	      <td>' . $r['MaLichSuPhieu'] . '</td>
	      <td></td>
	      <td></td>
	      <td>' . $r['TenHangBan'] . '</td>
	      <td></td>
	      <td>' . number_format($r['DonGia'],0,",",".") . '<sup>đ</sup></td>
	      <td>' . $r['SoLuong'] . '</td>
	      <td>' . $r['TienGiamGia'] . '</td>
	      <td></td>
	      <td>' . $r['SoTienDVPhi'] . '</td>
	      <td>' . $r['SoTienVAT'] . '</td>
	      <td>'  .  number_format($r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'],0,",",".") . '<sup>đ</sup></td></tr>
	   ';
	$total += $r['DonGia']*$r['SoLuong']-$r['TienGiamGia']+$r['SoTienDVPhi']+$r['SoTienVAT'];
 	if( $i == $count -1 )
 	{ $output .='<tr><td>Tổng</td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td> ' .  number_format($total,0,",",".") . '<sup>đ</sup></td></tr>';
	 	$grand_total +=$total;
 	}
   } 
	
   $k++;
   if( $k == $total_count)
   	$output .='
   		<tr>
	      <td><strong>Grand Total</strong></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td></td>
	      <td>' . number_format($grand_total,0,",",".") . '<sup>đ</sup></td>
	    </tr>
   ';
 	
}



echo json_encode($output);