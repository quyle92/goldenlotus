<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNam = isset( $_POST['tuNam'] ) ? $_POST['tuNam'] :"";

$totalSales = array();
$nhom_hang_ban = array();

$sales_by_food_group = $goldenlotus->getSalesByFoodGroup_Year( $tuNam );
foreach ( $sales_by_food_group as $r ) 
{
	$totalSales[] = (int) $r['TotalSales']; 
	$nhom_hang_ban[] = $r['Ten'];
}

$output = array( $nhom_hang_ban, $totalSales );

echo json_encode($output);