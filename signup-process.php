<?php
require('lib/db.php');
@session_start();

$username =  htmlentities(trim(strip_tags($_POST['username'])),ENT_QUOTES,'utf-8');
$password = htmlentities(trim(strip_tags($_POST['password'])),ENT_QUOTES,'utf-8');
$confirm_password = htmlentities(trim(strip_tags($_POST['confirm_password'])),ENT_QUOTES,'utf-8');
$maNV = htmlentities(trim(strip_tags($_POST['maNV'])),ENT_QUOTES,'utf-8');

if( $password !== $confirm_password ){
	$_SESSION['password_mismatch'] = 1;
	header('Location:signup.php');
	exit();
}

$report_arr = serialize( $_POST['report_arr'] );
$report_arr = htmlentities(trim(strip_tags($report_arr)),ENT_QUOTES,'utf-8');

if ( $username != "" && $password != "" && $report_arr != "" )
{
	$sql="INSERT INTO [GOLDENLOTUS_Q3].[dbo].[tblDSNguoiSD] ( [TenSD], [MaNhanVien],
	   [MatKhau],[KiemTraSD],[DangSD],[TamNgung],[KhongDoi],[SuDungDacBiet], [BaoCaoDuocXem]) VALUES ( '$username', '$maNV', PWDENCRYPT('$password'), 0,0,0,0,0, '$report_arr' )"; 

	try{
	 		$rs = sqlsrv_query($conn,$sql);
	 		$_SESSION['signup_success'] = 1;
			header('location:signup.php');
			
		}

	catch(Exception $e) 
		{ 	
			echo $e->getMessage();
			$_SESSION['signup_success'] = 0;
			header('location:signup.php');
		}

} else {
 	//throw new \Exception('Required field(s) missing. Please try again.');
 	$_SESSION['signup_success'] = 0;
 	header('location:signup.php');
}