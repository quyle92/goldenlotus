<?php
// ini_set('mssql.charset', 'UTF-8');
// $opt = [
//     \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
//     \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
//     \PDO::ATTR_EMULATE_PREPARES   => false,
// ];

// $dbCon = new PDO('odbc:Driver=FreeTDS; Server=14.161.7.235; Port=14333; Database=HOANGSEN; TDS_Version=8.0; Client Charset=UTF-8', 'hoangsen', 'golden@123', $opt);
try
{
ini_set('mssql.charset', 'UTF-8');
$opt = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];

$dbCon = new PDO("odbc:Driver={SQL Server}; Server=QDELL\SQLEXPRESS; Port=14330; Database=SPA_HOANGSENQ3; Client Charset=UTF-8,  Uid=sa;Pwd=123;");
$dbCon->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
	$dbCon->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
	$dbCon->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$dbCon->setAttribute( PDO::ODBC_ATTR_ASSUME_UTF8 , true );
	$dbCon->setAttribute( PDO::ODBC_ATTR_ASSUME_UTF8 , true );
	if(!$dbCon) print_r($dbCon->errorinfo());
}
catch (PDOException $e) {
  echo $e->getMessage();

 
 } 


?>