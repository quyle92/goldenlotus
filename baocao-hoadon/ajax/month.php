<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tenQuay = ( isset( $_POST['tenQuay'] ) && $_POST['tenQuay'] !== 'Tất cả') ? $_POST['tenQuay'] : "" ;
$tuThang = isset( $_POST['tuThang'] ) ?  date_format( date_create( $_POST['tuThang'] ) , 'Y-m' ) : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay );
}

$output = [];
$qty = $goldenlotus->getQtyOrderSummary_Month( $tuThang, $tenQuay );
array_walk($qty, function(&$value,$key){
	 if($value == null) $value = 0;
});

$amt = $goldenlotus-> getSalesAmountSummary_Month( $tuThang, $tenQuay );
array_walk($amt, function(&$value,$key){
	 if($value == null) $value = 0;
});
$output = [];
$output = [
	"qty" => $qty,
	"amt" => $amt
];

echo json_encode( $output );
?>