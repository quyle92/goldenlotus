<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tenQuay = ( isset( $_POST['tenQuay'] ) && $_POST['tenQuay'] !== 'Tất cả') ? $_POST['tenQuay'] : "" ;
$tuNam = isset( $_POST['tuNam'] ) ?  date_format( date_create( $_POST['tuNam'] ) , 'Y' ) : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = [];

$qty = $goldenlotus->getFoodSoldQtyByHour_Year( $tenQuay, $tuNam );
array_walk($qty, function(&$value,$key){
	 if($value == null) $value = 0;
	 $value = intval( $value );
});


$amt =  $goldenlotus->getSalesAmountByHour_Year( $tenQuay, $tuNam  );
array_walk($amt, function(&$value,$key){
	 if($value == null) $value = 0;
	 $value = intval( $value );
});

echo $output[] = json_encode(  [
	'qty' => $qty,
	'maxQty' => max($qty),
	'amt' =>$amt,
	'maxAmt' =>max($amt),
] );
?>