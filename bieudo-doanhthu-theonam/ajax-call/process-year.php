<?php
require('../../lib/db.php');
@session_start();
if($_POST['year'] != "") $year_selected = $_POST['year'];

  //
  //---thang
  //
  //echo substr($tungay,3);
  $sql = "";

  $sql .= "SELECT ";

for ( $i = 1; $i <= 12; $i++ ){

    if($i <= 9){
     $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $year_selected . "/0" . $i ."' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
   }

    if($i > 9){
      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $year_selected . "/" . $i ."' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
    }
}
  
  $sql = rtrim($sql, ", ");

 $sql .=" FROM [tblLichSuPhieu]
    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1";
  try
  {
    //$result_dt = sqlsrv_query( $conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
    $rs = $dbCon->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if($rs != false)
    {
      foreach ( $rs as $r1 ) 
      {
       
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