<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuThang = isset( $_POST['tuThang'] ) ?  date_format( date_create( $_POST['tuThang'] ) , 'Y-m' ) : "";

$output = [];

$qty = removeOuterArr( $goldenlotus->getQtyByHour_Month( $tuThang ) );

echo  json_encode( $qty  );
?>