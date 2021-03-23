<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuThang = isset( $_POST['tuThang']) ?  date_format( date_create( $_POST['tuThang'] ) , 'Y-m' ) : "";
$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";
$khu_nam = "(b.MaKhu = '03-NH1' or b.MaKhu = '03-NH2' or b.MaKhu = '03-NH3')";
$khu_nu = "(b.MaKhu = '03-NH4' or b.MaKhu = '01-NH5' or b.MaKhu = '01-NH6')";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = "";

$rs_men = $goldenlotus->getSoLuongVeKey_Month( $tuThang, $tenQuay, $khu_nam );
$rs_women = $goldenlotus->getSoLuongVeKey_Month( $tuThang, $tenQuay, $khu_nu );

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