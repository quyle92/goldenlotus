<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tungay = isset( $_POST['tuNgay'] ) ? $_POST['tuNgay'] :"";//16/10/2020

$tungay = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);

$denngay = isset( $_POST['denNgay'] ) ? $_POST['denNgay'] :"";
$denngay = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);

$nhb_doanh_thu_arr = array();

$sales_by_food_group = $goldenlotus->getSalesByFoodGroupBySelection( $tungay, $denngay );
foreach ( $sales_by_food_group as $r ) 
{
	$doanh_thu = $r['DoanhThu']; settype($doanh_thu, 'integer');
  	$nhb_doanh_thu_arr[] = !empty( $doanh_thu ) ? $doanh_thu : 0;
}

$nhom_hang_ban = $goldenlotus->getDMNhomHangBan();
$nhb_arr = array();
//var_dump($nhom_hang_ban);
foreach( $nhom_hang_ban as $nhb ){

	$nhb_arr[] = $nhb['Ten'];
}
$output = array( 	$nhb_arr,	$nhb_doanh_thu_arr );

//var_dump( json_encode($nhb_arr) );
echo json_encode($output);