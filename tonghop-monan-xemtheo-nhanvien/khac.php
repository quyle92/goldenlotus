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
$grand_total = 0;settype($total,"integer");
$dates_has_bill_of_this_month = $goldenlotus->getDatesHasBillOfThisMonth( $tungay, $denngay  );
$total_count = sqlsrv_num_rows($dates_has_bill_of_this_month);
$k = 0;
while ($rs = sqlsrv_fetch_array( $dates_has_bill_of_this_month ))
{
  $date = $rs['NgayCoBill'];
  $payment_details_by_date = $goldenlotus->getBillDetailsByDayOfMonth( $date );
  $count = sqlsrv_num_rows($payment_details_by_date);
  $total = 0;settype($total,"integer");

  for ($i = 0; $i < sqlsrv_num_rows($payment_details_by_date); $i++) 
  {
	$r = sqlsrv_fetch_array($payment_details_by_date, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
	$output .='
	    <tr>
	      <td>' . ( ($i==0) ? $r['GioVao']->format('d-m-Y') : "" ) . ' </td>
	      <td>' . $r['MaNhanVien'] . '</td>
	      <td>' . $r['TenHangBan'] . '</td>
	      <td>' . $r['SoLuong'] . '</td>
	      <td>' . number_format($r['DonGia']*$r['SoLuong'],0,",","."). '<sup>đ</sup></td>
	      </tr>
	   ';
	$total += $r['DonGia']*$r['SoLuong'];
 	if( $i == $count -1 )
 	{ $output .='<tr><td>Tổng</td>
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
	      <td>' . number_format($grand_total,0,",",".") . '<sup>đ</sup></td>
	    </tr>
   ';
 	
}



echo json_encode($output);