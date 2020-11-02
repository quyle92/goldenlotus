<?php
require('lib/db.php');
session_start();
	$user=$_POST['username'];
	$password=$_POST['password'];

	//Truy van DB de kiem tra
	$sql="select PWDCOMPARE('$password',MatKhau) as IsDungMatKhau, TenSD, b.MaNV,b.TenNV, b.MaTrungTam, b.NhomNhanVien, c.TenTrungTam, a.[BaoCaoDuocXem]  
from [GOLDENLOTUS_Q3].[dbo].[tblDSNguoiSD] a, [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien] b, 
[GOLDENLOTUS_Q3].[dbo].[tblDMTrungTam] c 
 where a.MaNhanVien = b.MaNV and b.MaTrungTam = c.MaTrungTam and a.TenSD like '$user'";
	
	$dungmatkhau = 0; $tensd = ""; $manv = ""; $tennv = ""; $matrungtam = ""; $tentrungtam = ""; $manhomnhanvien = ""; $smsbrandname = "";
	
	try
	{
		//lay ket qua query
		$rs = sqlsrv_query($conn,$sql, array(), array( "Scrollable" => 'static' ));
		$r=sqlsrv_fetch_array($rs); //var_dump( sqlsrv_num_rows($rs) );var_dump(sqlsrv_has_rows($rs) );
		if(sqlsrv_has_rows($rs) != false)
		{
			//foreach ($result_dangnhap as $r)
			//{
				$dungmatkhau = $r['IsDungMatKhau'];
				$tensd = $r['TenSD'];
				$manv = $r['MaNV'];				
				$tennv = $r['TenNV'];
				$matrungtam = $r['MaTrungTam'];
				$tentrungtam = $r['TenTrungTam'];
				$manhomnhanvien = $r['NhomNhanVien'];
				$bao_cao_duoc_xem = unserialize($r['BaoCaoDuocXem']);
			//}
			
			if($dungmatkhau == 1)
			{
				$_SESSION['TenSD']=$tensd;
				$_SESSION['MaNV']=$manv;
				$_SESSION['TenNV']=$tennv;
				$_SESSION['MaTrungTam'] = $matrungtam;
				$_SESSION['TenTrungTam']=$tentrungtam;
				$_SESSION['NhomNhanVien']=$manhomnhanvien;
				$_SESSION['BaoCaoDuocXem']=$bao_cao_duoc_xem;
			
				header('location:signup.php');
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
	
		
	