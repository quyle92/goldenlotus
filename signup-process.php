<?php
require('lib/db.php');
@session_start();

$username =  $_POST['username'];
$password = $_POST['password'];
$report_arr = serialize( $_POST['report_arr'] );

if ( $username != "" && $password != "" & $report_arr != "" ){
	$sql="INSERT INTO [NH_STEAK_PIZZA].[dbo].[tblDSNguoiSD] ( [TenSD], [MaNhanVien],
	   [MatKhau],[KiemTraSD],[DangSD],[TamNgung],[KhongDoi],[SuDungDacBiet], [BaoCaoDuocXem]) VALUES ( '$username', 'NH02', PWDENCRYPT('$password'), 0,0,0,0,0, '$report_arr' )"; 

	 try{
	 		$rs = sqlsrv_query($conn,$sql);
	 		$_SESSION['signup_success']=1;
			header('location:signup.php');
			
		}

	catch(Exception $e) 
		{ 
			echo $e->getMessage();
			$_SESSION['signup_success']=0;
			header('location:signup.php');
		}

} else {
 	//throw new \Exception('Required field(s) missing. Please try again.');
 	$_SESSION['signup_success'] = 0;
 	header('location:signup.php');
}