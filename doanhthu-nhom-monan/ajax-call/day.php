<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNgay = isset( $_POST['tuNgay'] ) ? $_POST['tuNgay'] :"";//16/10/2020

$tuNgay = date('Y-m-d', strtotime($tuNgay) );

$totalSales = array();
$nhom_hang_ban = array();

$sales_by_food_group = $goldenlotus->getSalesByFoodGroup_Day( $tuNgay );
foreach ( $sales_by_food_group as $r ) 
{
	$totalSales[] = (int) $r['TotalSales']; 
	$nhom_hang_ban[] = $r['Ten'];
}

$output = array( 	$nhom_hang_ban,	$totalSales );

echo json_encode($output);