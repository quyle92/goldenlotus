<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus;

$tungay = isset( $_POST['tu-ngay'] ) ? $_POST['tu-ngay'] :"";//16/10/2020
$tungay = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);

$denngay = isset( $_POST['den-ngay'] ) ? $_POST['den-ngay'] :"";
$denngay = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);

$nhb_doanh_thu_arr = array();

$sales_by_food_group = $goldenlotus->getSalesByFoodGroupBySelection( $tungay, $denngay );
foreach ( $sales_by_food_group as $r ) 
{
	$doanh_thu = $r['DoanhThu']; settype($doanh_thu, 'integer');
  	$nhb_doanh_thu_arr[] = !empty( $doanh_thu ) ? $doanh_thu : 0;
}

//var_dump($nhb_doanh_thu_arr); 
echo json_encode($nhb_doanh_thu_arr);