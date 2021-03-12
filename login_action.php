<?php
require('lib/db.php');
session_start();
	$user= htmlentities(trim(strip_tags($_POST['username'])),ENT_QUOTES,'utf-8');
	$pass = htmlentities(trim(strip_tags($_POST['password'])),ENT_QUOTES,'utf-8');
	
	//Truy van DB de kiem tra
	 $sql="select PWDCOMPARE(:pass,MatKhau) as IsDungMatKhau, TenSD
	 , BaoCaoDuocXem
	 , b.MaNV,b.TenNV, b.MaTrungTam, c.TenTrungTam  
from tblDSNguoiSD a, tblDMNhanVien b, tblDMTrungTam c where a.MaNhanVien = b.MaNV and b.MaTrungTam = c.MaTrungTam and a.TenSD like :user";
	
	try
	{
		//lay ket qua query
		$stmt = $dbCon->prepare($sql);
		$stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
		$stmt->bindValue(':user', "%{$user}%");
		$stmt->execute();
		$result_dangnhap = $stmt->fetch();//var_dump($result_dangnhap);die;
		if($result_dangnhap != 1)
		{//var_dump($result_dangnhap);die;

			$_SESSION['TenSD']=$result_dangnhap['TenSD'];
			$_SESSION['MaNV']=$result_dangnhap['MaNV'];
			$_SESSION['TenNV']=$result_dangnhap['TenNV'];
			$_SESSION['MaTrungTam'] = $result_dangnhap['MaTrungTam'];
			$_SESSION['TenTrungTam']=$result_dangnhap['TenTrungTam'];
			$_SESSION['BaoCaoDuocXem']  = unserialize($r['BaoCaoDuocXem']);
			//https://phppot.com/php/php-login-script-with-remember-me/
			if(!empty($_POST["remember"])) 
			{
				setcookie ("username",$user,time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("password",$pass,time()+ (10 * 365 * 24 * 60 * 60));
			} else {
				if(isset($_COOKIE["username"])) {
					setcookie ("username","");
					setcookie ("password","");
				}
			}
			
			// var_dump($_SESSION['MaNV']);die;
			header('location:diemtong/index.php');
		}
		else
		{
?>
		<script>
			window.onload=function(){
		alert("Đăng nhập không thành công. Sai email hoặc mật khẩu");
			setTimeout('window.location="login.php"',0);
		}
		</script>
<?php
		}
	}
	catch (PDOException $e) 
	{	
	//loi ket noi db -> show exception
		echo $e->getMessage();
	}
?>
	
