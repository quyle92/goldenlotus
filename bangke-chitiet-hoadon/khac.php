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
$grand_total = 0;settype($total,"integer");

$k = 0;

$grand_total_tong_tien = 0;
$grand_total_giam_gia_mon = 0;
$grand_total_thuc_thu = 0;


  $bill_details_by_date_of_month = $goldenlotus-> getPayMethodDetailsByMonthRange(  $tungay, $denngay, $total );

  $total_tong_tien = 0;
  $total_giam_gia_mon = 0;
  $total_thuc_thu = 0;

  foreach ( $bill_details_by_date_of_month as $r ) {
  {
	$output .='
	     <tr>
	          <td> ' . $r['MaLichSuPhieu'] . '</td>
	          <td>' .( !empty( $r['NVTinhTienMaNV'] ) ? $r['NVTinhTienMaNV'] : "" ) . '</td>
	          <td>' . substr($r['GioVao'],11,5) . '</td>
	          <td>'. ( ( $r['ThoiGianDongPhieu'] ) ? substr($r['ThoiGianDongPhieu'],11,5): "" ) . '</td>
	          <td>'. $r['MaKhachHang'] . '</td>
	          <td>'. $r['MaKhu'] . '</td>
	          <td>' . $r['MaBan'] . '</td>
	          <td>' . number_format($r['TongTien'],0,",",".");
	$grand_total_tong_tien += $r['TongTien']; 
	$output .= '</td>
	          <td> ' . number_format($r['TienGiamGia'],0,",",".");
	$grand_total_giam_gia_mon += $r['TienGiamGia'];
	$output .='</td>
	          <td></td>
	          <td></td>
	          <td></td>
	          <td></td>
	          <td> ' . $r['SoTienDVPhi'] . '</td>
	          <td> ' . $r['SoTienVAT'] . '</td>
	          <td> ' . number_format($r['TienThucTra'],0,",",".");
	$grand_total_thuc_thu += $r['TienThucTra'];
	$output .= '<sup>đ</sup>
	          </td>
	          <td></td>
	          <td> ' . number_format($r['TienThucTra'],0,",",".") . '<sup>đ</sup></td>
	          <td> ' . $r['MaKhachHang'] . '</td>
	        </tr> ';
	}

	$k++; 

	if ($k == $total ) $output .= ' <tr><td>Tổng</td>
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
		<td></td>
	</tr>';
    	

}


echo json_encode($output);