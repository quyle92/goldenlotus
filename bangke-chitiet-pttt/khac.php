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
$dates_has_bill_by_selection = $goldenlotus->getDatesHasBillBySelection( $tungay, $denngay, $total_count  );

$k = 0;
foreach ( $dates_has_bill_by_selection as $rs )
{
  $date = $rs['NgayCoBill'];
  $payment_details_by_date = $goldenlotus->getPayMethodDetailsByDate( $date,$count );
 
  $total = 0;settype($total,"integer");

  foreach ( $payment_details_by_date as $r )
  {
	
	$output .='
	    <tr>
	      <td>' . ( !empty( $r['MaLoaiThe'] ) ? $r['MaLoaiThe'] : "Tiền Mặt" ) . ' </td>
	      <td>' . ( ($i==0) ? $r['GioVao']->format('d-m-Y') : "" ) . '</td>
	      <td>' . $r['MaLichSuPhieu'] . '</td>
	      <td>' . number_format($r['TienThucTra'],0,",","."). '<sup>đ</sup></td>
	      </tr>
	   ';
	$total += $r['TienThucTra'];
 	if( $i == $count -1 )
 	{ $output .='<tr><td>Tổng</td>
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
	      <td>' . number_format($grand_total,0,",",".") . '<sup>đ</sup></td>
	    </tr>
   ';
 	
}



echo json_encode($output);