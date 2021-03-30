<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuNam = isset( $_POST['tuNam']) ?  $_POST['tuNam'] : "";
$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";

if( ! empty($tenQuay))
{
      $goldenlotus->layView( $tenQuay  );
}

$output = "";

$rs_men = $goldenlotus->getSoLuongVeKey_Year( $tuNam, $tenQuay, $ma_khu = 'nam' );
$rs_women = $goldenlotus->getSoLuongVeKey_Year( $tuNam, $tenQuay, $khu_nu = 'nu' );

$output .= '<tr>
      <td>Khu nam</td>
      <td>' .  number_format($rs_men['TotalKey'],0,",","."). ' </td>
      <td> ' . number_format($rs_men['TotalVe'] ,0,",","."). '</td>
      <td> ' . number_format($rs_men['ChenhLech'],0,",",".")  . '</td>
    </tr>
    <tr>
      <td>Khu nữ</td>
      <td>' .  number_format($rs_women['TotalKey'],0,",",".") . ' </td>
      <td> ' . number_format($rs_women['TotalVe'],0,",",".")  . '</td>
      <td> ' . number_format($rs_women['ChenhLech'],0,",",".")   . '</td>
    </tr>';

echo json_encode($output);