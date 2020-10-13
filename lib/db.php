<?php
// ini_set('mssql.charset', 'UTF-8');
// $dbCon = new PDO('odbc:Driver=FreeTDS; Server=14.161.35.228; Port=14330; Database=SPA_HOANGSENQ3; TDS_Version=8.0; Client Charset=UTF-8', 'hoangsen', 'hoangsen@123');

$serverName = "DELL-PC\SQLEXPRESS";
$connectionInfo = array( "Database"=>"NH_STEAK_PIZZA","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

// $serverName = "DELL-PC\SQLEXPRESS";
// $connectionInfo = array( "Database"=>"GOLDENLOTUS_Q3","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
// $dbCon =  new PDO('odbc:Driver=FreeTDS; Server=DELL-PC\SQLEXPRESS; Port=14330; Database=GOLDENLOTUS_Q3; TDS_Version=8.0; Client Charset=UTF-8', 'sa', '123');



?>