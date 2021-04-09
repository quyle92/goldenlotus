<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
require('../../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNgay = date('Y-m-d', strtotime( $_POST['tuNgay']) );
$denNgay = date('Y-m-d', strtotime( $_POST['denNgay']) );
$ma_khu = "(a.MaKhu = '03-NH4' or a.MaKhu = '03-NH5' or a.MaKhu = '03-NH6')";

$output = "";

$rs = $goldenlotus->getSalesSpa_Advanced_TotalRev( $ma_khu, $tuNgay, $denNgay );
$total_rev = 'Tổng doanh thu: ' . number_format($rs,0,",",".") .' <sup>đ</sup>';	
echo json_encode( $total_rev  );