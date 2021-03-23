<?php
require("../../lib/db.php");
require("../../lib/goldenlotus.php");
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$tuThang = isset( $_POST['tuThang']) ?  date_format( date_create( $_POST['tuThang'] ) , 'Y-m' ) : "";
$tenQuay = isset( $_POST['tenQuay'] ) ? $_POST['tenQuay'] : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}

$output = "";

$bill_edit = $goldenlotus->getBillEditDetailsBySelection_Month( $tuThang, $tenQuay );
foreach ( $bill_edit as $r )
{ 
$output .= '<tr>
      <td>' . ( ( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 0, 10) : "" ). '</td>
      <td>' . ($r['NVTinhTienMaNV']) . ' </td>
      <td> ' . ( ( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 11, 5) : ""  )  . '</td>
      <td> ' . ($r['TenSuCo']) . '</td>
      <td>' . ( ( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 0, 10) : "" ). '</td>
      <td>' . $r['MaLichSuPhieu'] . '</td>
      
      <td>' . number_format($r['Initial'],0,",",".") . '</td>
      <td>' . number_format($r['Payback'],0,",",".") .  '</td>
      <td>' . number_format($r['Diff'],0,",",".") .  '</td>
    </tr>';
}
// var_dump($output); 
echo json_encode($output);