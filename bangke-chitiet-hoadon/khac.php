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
$dates_has_bill_by_selection = $goldenlotus->getDatesHasBillBySelection( $tungay, $denngay  );
$k = 0;
$total_count = sqlsrv_num_rows($dates_has_bill_by_selection);

$grand_total_tong_tien = 0;
$grand_total_giam_gia_mon = 0;
$grand_total_thuc_thu = 0;
while ($rs = sqlsrv_fetch_array( $dates_has_bill_by_selection ))
{
  $date = $rs['NgayCoBill'];
  $bill_details_by_date_of_month = $goldenlotus->getBillDetailsByDayOfMonth( $date );
  $count = sqlsrv_num_rows($bill_details_by_date_of_month);// $a= 0 ;$a += $count; echo "+". $a;
  $total_tong_tien = 0;
  $total_giam_gia_mon = 0;
  $total_thuc_thu = 0;

  for ($i = 0; $i < sqlsrv_num_rows($bill_details_by_date_of_month); $i++) 
  {
	$r = sqlsrv_fetch_array($bill_details_by_date_of_month, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
	$output .='
	     <tr>
	          <td> ' . $r['MaLichSuPhieu'] . '</td>
	          <td>' .( !empty( $r['NVTinhTienMaNV'] ) ? $r['NVTinhTienMaNV'] : "" ) . '</td>
	          <td>' . $r['GioVao']->format('H:i') . '</td>
	          <td>'. ( ( $r['ThoiGianDongPhieu'] ) ? $r['ThoiGianDongPhieu']->format('H:i') : "" ) . '</td>
	          <td>'. $r['MaKhachHang'] . '</td>
	          <td>'. $r['MaKhu'] . '</td>
	          <td>' . $r['MaBan'] . '</td>
	          <td>' . $r['TongTien'];
	$total_tong_tien += $r['TongTien']; 
	$output .= '</td>
	          <td> ' . $r['TienGiamGia'];
	$total_giam_gia_mon += $r['TienGiamGia'];
	$output .='</td>
	          <td></td>
	          <td></td>
	          <td></td>
	          <td></td>
	          <td> ' . $r['SoTienDVPhi'] . '</td>
	          <td> ' . $r['SoTienVAT'] . '</td>
	          <td> ' . number_format($r['TienThucTra'],0,",",".");
	$total_thuc_thu += $r['TienThucTra'];
	$output .= '<sup>đ</sup>
	          </td>
	          <td></td>
	          <td> ' . number_format($r['TienThucTra'],0,",",".") . '<sup>đ</sup></td>
	          <td> ' . $r['MaKhachHang'] . '</td>
	        </tr> ';
	}

	$k++; 
	$grand_total_tong_tien += $total_tong_tien;
	$grand_total_giam_gia_mon += $total_giam_gia_mon;
	$grand_total_thuc_thu += $total_thuc_thu;
	if ($k == $total_count ) $output .= ' <tr><td>Tổng</td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td>'. number_format($grand_total_tong_tien,0,",",".") . '<sup>đ</sup></td>
	    <td>'. number_format($grand_total_giam_gia_mon,0,",",".") . '<sup>đ</sup></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td>' . number_format($grand_total_thuc_thu,0,",",".") . '<sup>đ</sup>
	    </td
	    <td></td>
	    <td></td>
	    <td></td>                                  
	</tr>';
    	
}



echo json_encode($output);