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
$total = 0;
$tong_hop_do_bo = $goldenlotus->getSumFoodCancelledBySelection ( $tungay, $denngay );
while( $r = sqlsrv_fetch_array($tong_hop_do_bo) )
{ 
$output .= ' <tr>
              <td>' . $r['TenHangBan'] . '</td>
              <td>' . $r['SoLuong']. '</td>
            </tr>';
$total += $r['SoLuong'];

		
}
$output .= ' <tr><td><strong>Tổng</strong></td>
			<td><strong>' . $total . '</strong></td>';
//var_dump($nhb_doanh_thu_arr); 
echo json_encode($output);