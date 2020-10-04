<?php
require('../../lib/db.php');
@session_start();
if($_POST['year'] != "") $year = $_POST['year'];
if( isset($_POST['year']) ){ 
  $year = $_POST['year'];
  $tungay = "01-".$year;
}

  //
  //---------chuyển sang chuỗi tháng -> để query sql
  //
  $tuthang_converted = "";
  $denthang_converted = "";
  if($tungay != "")
  {
    $tuthang_converted = substr($tungay,3) . "/" . substr($tungay,3,2);
  }
  //
  //----loc doanh thu tung thang-----//
  //
  $doanhthu_t1 = 0; $doanhthu_t2 = 0; $doanhthu_t3 = 0; $doanhthu_t4 = 0; $doanhthu_t5 = 0; $doanhthu_t6 = 0;
  $doanhthu_t7 = 0; $doanhthu_t8 = 0; $doanhthu_t9 = 0; $doanhthu_t10 = 0; $doanhthu_t11 = 0; 
  $doanhthu_t12 = 0;
  //
  //---thang
  //
  //echo substr($tungay,3);
  $sql="SELECT SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '".substr($tungay,3)."/01' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT1, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/02' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT2, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/03' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT3, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/04' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT4, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".  substr($tungay,3)."/05' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT5, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/06' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT6, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/07' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT7, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/08' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT8, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/09' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT9, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/10' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT10, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/11' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT11, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,3)."/12' Then (c.[SoLuong] * c.[DonGia])  Else 0 END) as DoanhThuT12 
     FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] a 
 Join [NH_STEAK_PIZZA].[dbo].[tblOrder] b 
 ON a.[MaLichSuPhieu] = b.[MaLichSuPhieu]
 join [NH_STEAK_PIZZA].[dbo].[tblOrderChiTiet] c 
 ON b.[OrderID] = c.[OrderID]
 where a.DangNgoi = 0 and a.PhieuHuy = 0 and a.DaTinhTien = 1";

  try
  {
    $result_dt = sqlsrv_query( $conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
    if($result_dt != false)
    {
      for ($i = 0; $i < sqlsrv_num_rows($result_dt); $i++)
      {
        $r1 = sqlsrv_fetch_array($result_dt, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
        $r1['DoanhThuT1'];
        $r1['DoanhThuT2'];
        $r1['DoanhThuT3'];
        $r1['DoanhThuT4'];
        $r1['DoanhThuT5'];
        $r1['DoanhThuT6'];
        $r1['DoanhThuT7'];
        $r1['DoanhThuT8'];
        $r1['DoanhThuT9'];
        $r1['DoanhThuT10'];
        $r1['DoanhThuT11'];
        $r1['DoanhThuT12'];
      }
      
      $doanhthu_t1 = $r1['DoanhThuT1'];settype($doanhthu_t1, "integer");
      $doanhthu_t2 = $r1['DoanhThuT2'];settype($doanhthu_t2, "integer");
      $doanhthu_t3 = $r1['DoanhThuT3'];settype($doanhthu_t3, "integer");
      $doanhthu_t4 = $r1['DoanhThuT4'];settype($doanhthu_t4, "integer");
      $doanhthu_t5 = $r1['DoanhThuT5'];settype($doanhthu_t5, "integer");
      $doanhthu_t6 = $r1['DoanhThuT6'];settype($doanhthu_t6, "integer");
      $doanhthu_t7 = $r1['DoanhThuT7'];settype($doanhthu_t7, "integer");
      $doanhthu_t8 = $r1['DoanhThuT8'];settype($doanhthu_t8, "integer");
      $doanhthu_t9 = $r1['DoanhThuT9'];settype($doanhthu_t9, "integer");
      $doanhthu_t10 = $r1['DoanhThuT10'];settype($doanhthu_t10, "integer");
      $doanhthu_t11 = $r1['DoanhThuT11'];settype($doanhthu_t11, "integer");
      $doanhthu_t12 = $r1['DoanhThuT12'];settype($doanhthu_t12, "integer");

     $data = array (
          'doanhthu_t1' => $doanhthu_t1,
          'doanhthu_t2' => $doanhthu_t2,
          'doanhthu_t3' => $doanhthu_t3,
          'doanhthu_t4' => $doanhthu_t4,
          'doanhthu_t5' => $doanhthu_t5,
          'doanhthu_t6' => $doanhthu_t6,
          'doanhthu_t7' => $doanhthu_t7,
          'doanhthu_t8' => $doanhthu_t8,
          'doanhthu_t9' => $doanhthu_t9,
          'doanhthu_t10' => $doanhthu_t10,
          'doanhthu_t11' => $doanhthu_t11,
          'doanhthu_t12' => $doanhthu_t12,
      );//var_dump	($data);
      echo json_encode($data);			
    }
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }