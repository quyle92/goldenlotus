<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);
$tenSD = isset($_GET['tenSD'])? $_GET['tenSD'] :"";
$goldenlotus->xoaUser($tenSD);
header('location:users.php');
exit();