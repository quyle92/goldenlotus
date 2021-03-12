<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require('../lib/db.php');
require('../lib/goldenlotus.php');
require('../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$spa_sales = $goldenlotus->getSalesSpa();
$spa_sales = customizeArray_SpaZone($spa_sales);
$ma_khu_arr = array();

foreach( $spa_sales as $k => $v )
{
	$ma_khu_arr[] = $k;
}

$man_1 = $spa_sales[$ma_khu_arr[0]];
$man_2 = $spa_sales[$ma_khu_arr[1]];
var_dump($man_1);