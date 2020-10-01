<?php
require('lib/db.php');
session_start();
	$user=$_POST['username'];
	$pass=$_POST['password'];
	
	//Truy van DB de kiem tra
	 $sql="select PWDCOMPARE('$pass',MatKhau) as IsDungMatKhau, TenSD, b.MaNV,b.TenNV, b.MaTrungTam, b.NhomNhanVien, c.TenTrungTam  
from tblDSNguoiSD a, tblDMNhanVien b, tblDMTrungTam c where a.MaNhanVien = b.MaNV and b.MaTrungTam = c.MaTrungTam and a.TenSD like '$user'";
	
	$dungmatkhau = 0; $tensd = ""; $manv = ""; $tennv = ""; $matrungtam = ""; $tentrungtam = ""; $manhomnhanvien = ""; $smsbrandname = "";
	
	try
	{
		//lay ket qua query
		$result_dangnhap = $dbCon->query($sql);
		if($result_dangnhap != false)
		{
			foreach ($result_dangnhap as $r)
			{
				$dungmatkhau = $r['IsDungMatKhau'];
				$tensd = $r['TenSD'];
				$manv = $r['MaNV'];				
				$tennv = $r['TenNV'];
				$matrungtam = $r['MaTrungTam'];
				$tentrungtam = $r['TenTrungTam'];
				$manhomnhanvien = $r['NhomNhanVien'];
			}
			
			if($dungmatkhau == 1)
			{
				$_SESSION['TenSD']=$tensd;
				$_SESSION['MaNV']=$manv;
				$_SESSION['TenNV']=$tennv;
				$_SESSION['MaTrungTam'] = $matrungtam;
				$_SESSION['TenTrungTam']=$tentrungtam;
				$_SESSION['NhomNhanVien']=$manhomnhanvien;
			
				header('location:home.php');
			}//end if dung mat khau
			else
			{
?>
				<script>
					window.onload=function(){
					alert("Đăng nhập không thành công. Sai user hoặc mật khẩu");
						setTimeout('window.location="login.php"',0);
					}
				</script>
<?php
			}//end else sai mat khau
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
		}//else ko co ket qua tra ve
	}
	catch (PDOException $e) 
	{	
	//loi ket noi db -> show exception
		echo $e->getMessage();
	}
?>
	
		
	