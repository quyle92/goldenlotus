<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuThang = isset( $_POST['tuThang'] ) ? $_POST['tuThang'] :"";
$tuThang = isset( $tuThang ) ?  date_format( date_create( $tuThang ) , 'Y-m' ) : "";


$totalSales = array();
$nhom_hang_ban = array();

$sales_by_food_group = $goldenlotus->getSalesByFoodGroup_Month( $tuThang );
foreach ( $sales_by_food_group as $r ) 
{
	$totalSales[] = (int) $r['TotalSales']; 
	$nhom_hang_ban[] = $r['Ten'];
}

$output = array( $nhom_hang_ban, $totalSales );

echo json_encode($output);