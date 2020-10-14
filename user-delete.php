<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;
$maNV = isset($_GET['maNV'])? $_GET['maNV'] :"";
$goldenlotus->xoaUser($maNV);
header('location:users.php');
exit();