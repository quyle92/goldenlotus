<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNam = isset( $_POST['tuNam'] ) ?  date_format( date_create( $_POST['tuNam'] ) , 'Y' ) : "";

$output = [];

$qty = removeOuterArr( $goldenlotus->getQtyByHour_Year( $tuNam ) );

echo  json_encode( $qty  );
?>