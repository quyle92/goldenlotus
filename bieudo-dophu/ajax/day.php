<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNgay = isset( $_POST['tuNgay'] ) ?  date_format( date_create( $_POST['tuNgay'] ) , 'Y-m-d' ) : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = [];
$tong_so_ban = $goldenlotus->countTotalTables();
$co_nguoi = $goldenlotus->countOccupiedTables_Day( $tenQuay, $tuNgay );
$ban_trong = $tong_so_ban - $co_nguoi;
echo json_encode(
	 $output = [
		'total' => $tong_so_ban,
		'coNguoi' => $co_nguoi,
		'banTrong' => $ban_trong,
	]
);
?>