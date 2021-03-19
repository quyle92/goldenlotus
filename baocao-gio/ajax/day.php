<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tenQuay = ( isset( $_POST['tenQuay'] ) && $_POST['tenQuay'] !== 'Tất cả') ? $_POST['tenQuay'] : "" ;
$tuNgay = isset( $_POST['tuNgay'] ) ?  date_format( date_create( $_POST['tuNgay'] ) , 'Y-m-d' ) : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = [];

$qty = $goldenlotus->getFoodSoldQtyByHour_Day( $tenQuay, $tuNgay );
array_walk($qty, function(&$value,$key){
	 if($value == null) $value = 0;
	 $value = intval( $value );
});


$amt =  $goldenlotus->getSalesAmountByHour_Day( $tenQuay, $tuNgay  );
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