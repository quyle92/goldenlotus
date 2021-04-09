<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tenQuay = isset( $_GET['tenQuay'] ) ? $_GET['tenQuay'] :"";//16/10/2020

$output = '';

$rs = $goldenlotus->getNDMNhomHangBan( $tenQuay );
foreach ( $rs as $r ) 
{
	$output.= '<option value="' . $r['Ma'] .'">' . $r['Ten'] . '</option>';
}

echo ($output);