<?php
require('../../lib/db.php');
@session_start();
if( isset($_POST['month-selected']) ){ 
  $month_selected = $_POST['month-selected'];//=>09/2020
}

$month_selected = substr($month_selected,3) . "/" . substr($month_selected,0,2);
$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";

  $sql = "";
  $sql .= "SELECT ";

  for ( $i = 1; $i <= 31; $i++ ){

    if($i <= 9){
     $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,11) like '" . $month_selected . "/0" . $i ."' Then TienThucTra  Else 0 END) as DoanhThu_0" . $i . ", "; 
   }

    if($i > 9){
      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,11) like '" . $month_selected . "/" . $i ."' Then TienThucTra  Else 0 END) as DoanhThu_" . $i . ", "; 
    }
  }

 $sql = rtrim($sql, ", ");

  $sql .=" FROM [tblLichSuPhieu] a LEFT JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1 ";
  if( ! empty($tenQuay) )
  {
      $sql .=" AND b.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
  }

  try
  {
    $rs = $dbCon->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if($rs != false)
    {
      foreach ( $rs as $r1 ) 
      {
        $r1['DoanhThu_01'];
        $r1['DoanhThu_02'];
        $r1['DoanhThu_03'];
        $r1['DoanhThu_04'];
        $r1['DoanhThu_05'];
        $r1['DoanhThu_06'];
        $r1['DoanhThu_07'];
        $r1['DoanhThu_08'];
        $r1['DoanhThu_09'];
        $r1['DoanhThu_10'];
        $r1['DoanhThu_11'];
        $r1['DoanhThu_12'];
        $r1['DoanhThu_13'];
        $r1['DoanhThu_14'];
        $r1['DoanhThu_15'];
        $r1['DoanhThu_16'];
        $r1['DoanhThu_17'];
        $r1['DoanhThu_18'];
        $r1['DoanhThu_19'];
        $r1['DoanhThu_20'];
        $r1['DoanhThu_21'];
        $r1['DoanhThu_22'];
        $r1['DoanhThu_23'];
        $r1['DoanhThu_24'];
        $r1['DoanhThu_25'];
        $r1['DoanhThu_26'];
        $r1['DoanhThu_27'];
        $r1['DoanhThu_28'];
        $r1['DoanhThu_29'];
        $r1['DoanhThu_30'];
        $r1['DoanhThu_31'];
      }
      
       $doanhthu_01 = $r1['DoanhThu_01'];settype( $doanhthu_01, "integer");
       $doanhthu_02 = $r1['DoanhThu_02'];settype( $doanhthu_02, "integer");
       $doanhthu_03 = $r1['DoanhThu_03'];settype( $doanhthu_03, "integer");
       $doanhthu_04 = $r1['DoanhThu_04'];settype( $doanhthu_04, "integer");
       $doanhthu_05 = $r1['DoanhThu_05'];settype( $doanhthu_05, "integer");
       $doanhthu_06 = $r1['DoanhThu_06'];settype( $doanhthu_06, "integer");
       $doanhthu_07 = $r1['DoanhThu_07'];settype( $doanhthu_07, "integer");
       $doanhthu_08 = $r1['DoanhThu_08'];settype( $doanhthu_08, "integer");
       $doanhthu_09 = $r1['DoanhThu_09'];settype( $doanhthu_09, "integer");
       $doanhthu_10 = $r1['DoanhThu_10'];settype( $doanhthu_10, "integer");
       $doanhthu_11 = $r1['DoanhThu_11'];settype( $doanhthu_11, "integer");
       $doanhthu_12 = $r1['DoanhThu_12'];settype( $doanhthu_12, "integer");
       $doanhthu_13 = $r1['DoanhThu_13'];settype( $doanhthu_13, "integer");
       $doanhthu_14 = $r1['DoanhThu_14'];settype( $doanhthu_14, "integer");
       $doanhthu_15 = $r1['DoanhThu_15'];settype( $doanhthu_15, "integer");
       $doanhthu_16 = $r1['DoanhThu_16'];settype( $doanhthu_16, "integer");
       $doanhthu_17 = $r1['DoanhThu_17'];settype( $doanhthu_17, "integer");
       $doanhthu_18 = $r1['DoanhThu_18'];settype( $doanhthu_18, "integer");
       $doanhthu_19 = $r1['DoanhThu_19'];settype( $doanhthu_19, "integer");
       $doanhthu_20 = $r1['DoanhThu_20'];settype( $doanhthu_20, "integer");
       $doanhthu_21 = $r1['DoanhThu_21'];settype( $doanhthu_21, "integer");
       $doanhthu_22 = $r1['DoanhThu_22'];settype( $doanhthu_22, "integer");
       $doanhthu_23 = $r1['DoanhThu_23'];settype( $doanhthu_23, "integer");
       $doanhthu_24 = $r1['DoanhThu_24'];settype( $doanhthu_24, "integer");
       $doanhthu_25 = $r1['DoanhThu_25'];settype( $doanhthu_25, "integer");
       $doanhthu_26 = $r1['DoanhThu_26'];settype( $doanhthu_26, "integer");
       $doanhthu_27 = $r1['DoanhThu_27'];settype( $doanhthu_27, "integer");
       $doanhthu_28 = $r1['DoanhThu_28'];settype( $doanhthu_28, "integer");
       $doanhthu_29 = $r1['DoanhThu_29'];settype( $doanhthu_29, "integer");
       $doanhthu_30 = $r1['DoanhThu_30'];settype( $doanhthu_30, "integer");
       $doanhthu_31 = $r1['DoanhThu_31'];settype( $doanhthu_31, "integer");

       $data = array (
          'doanhthu_01' =>  $doanhthu_01,
          'doanhthu_02' =>  $doanhthu_02,
          'doanhthu_03' =>  $doanhthu_03,
          'doanhthu_04' =>  $doanhthu_04,
          'doanhthu_05' =>  $doanhthu_05,
          'doanhthu_06' =>  $doanhthu_06,
          'doanhthu_07' =>  $doanhthu_07,
          'doanhthu_08' =>  $doanhthu_08,
          'doanhthu_09' =>  $doanhthu_09,
          'doanhthu_10' =>  $doanhthu_10,
          'doanhthu_11' =>  $doanhthu_11,
          'doanhthu_12' =>  $doanhthu_12,
          'doanhthu_13' =>  $doanhthu_13,
          'doanhthu_14' =>  $doanhthu_14,
          'doanhthu_15' =>  $doanhthu_15,
          'doanhthu_16' =>  $doanhthu_16,
          'doanhthu_17' =>  $doanhthu_17,
          'doanhthu_18' =>  $doanhthu_18,
          'doanhthu_19' =>  $doanhthu_19,
          'doanhthu_20' =>  $doanhthu_20,
          'doanhthu_21' =>  $doanhthu_21,
          'doanhthu_22' =>  $doanhthu_22,
          'doanhthu_23' =>  $doanhthu_23,
          'doanhthu_24' =>  $doanhthu_24,
          'doanhthu_25' =>  $doanhthu_25,
          'doanhthu_26' =>  $doanhthu_26,
          'doanhthu_27' =>  $doanhthu_27,
          'doanhthu_28' =>  $doanhthu_28,
          'doanhthu_29' =>  $doanhthu_29,
          'doanhthu_30' =>  $doanhthu_30,
          'doanhthu_31' =>  $doanhthu_31,
      );

       echo json_encode($data);
    }
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }