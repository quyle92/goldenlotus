<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tenQuay = ( isset( $_POST['tenQuay'] ) && $_POST['tenQuay'] !== 'Tất cả') ? $_POST['tenQuay'] : "" ;
$tuNgay = isset( $_POST['tuNgay'] ) ?  date_format( date_create( $_POST['tuNgay'] ) , 'Y-m-d' ) : "";

$output = [];

$qty = removeOuterArr( $goldenlotus->getQtyByHour_Day( $tuNgay ) );

echo  json_encode( $qty  );
?>