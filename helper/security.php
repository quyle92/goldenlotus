<?php
session_start();
$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
//var_dump($bao_cao_duoc_xem );var_dump($_SESSION['MaNV']);die;
if( !isset($_SESSION['MaNV'])  )
{
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
}

if( $_SESSION['MaNV'] !== 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
{
	die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
}
