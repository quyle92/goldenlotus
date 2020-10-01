<?php
	session_start();
	unset($_SESSION['TenSD']);
	unset($_SESSION['MaNV']);
	unset($_SESSION['TenNV']);
	unset($_SESSION['MaTrungTam']);
	unset($_SESSION['TenTrungTam']);
	unset($_SESSION['NhomNhanVien']);
	unset($_SESSION['SMSBrandName']);
	unset($_SESSION['MaKhachHang']);	
	unset($_SESSION['TenDoiTuong']);

	header('location:login.php');
?>