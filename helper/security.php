<?php
session_start();
$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );

if( ! isset($_SESSION['MaNV'])  )
{	
   if( $page_name === "diemtong")
	{
		die('<script> 
	   	alert("Bạn ko được quyền truy cập vào đây!");
	   	 setTimeout(
	        function(){
	            window.location = "login.php" 
	        },
	    100);
	   	</script>');
	}
	else
	{

		die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
	}
}

if($_SESSION['MaNV'] !== 'HDQT')
{
	if( !in_array('diemtong', $bao_cao_duoc_xem) )
	{
		array_push($bao_cao_duoc_xem, 'diemtong');
	}

	if(  !in_array($page_name, $bao_cao_duoc_xem) )
	{
		die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
	}
}