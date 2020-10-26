<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;

$date = $_POST['tungay'];
$date = substr($date,6) . "/" . substr($date,3,2) . "/" . substr($date,0,2);
$nhom_hang_ban_id =  $_POST['nhom_hang_ban_id'];
$result = array();
/****************** Qty *********************/
$qty_chart_nu011 = $goldenlotus->getFoodSoldQtyByHour( $date, $nhom_hang_ban_id  );

while($r = sqlsrv_fetch_array( $qty_chart_nu011))
{
  $qty_sum_arr_nu011 = array();
  foreach ($r as $k=>$v)
  {
    $qty_sum_arr_nu011[] = $v;
  }
}

$qty_sum_arr_new_nu011 = array();
for ( $i = 1; $i < count($qty_sum_arr_nu011); $i++)
{ if( $i % 2)
    array_push( $qty_sum_arr_new_nu011, number_format( $qty_sum_arr_nu011[$i],0,",","." ) );
}
$result[] = $qty_sum_arr_new_nu011;
$max_value_qty_nu011 = max($qty_sum_arr_new_nu011);
$result[] = $max_value_qty_nu011;

/**************** Money *********************/
$sales_chart_nu011 = $goldenlotus->getSalesAmountByHour( $date, $nhom_hang_ban_id  );

while($r1 = sqlsrv_fetch_array( $sales_chart_nu011))
{
  $sales_sum_arr_nu011 = array();
  foreach ($r1 as $k=>$v)
  {
    $sales_sum_arr_nu011[] = $v;
  }
}

$sales_sum_arr_new_nu011 = array();
for ( $i = 1; $i < count($sales_sum_arr_nu011); $i++)
{ if( $i % 2)
    array_push( $sales_sum_arr_new_nu011, $sales_sum_arr_nu011[$i] );
}
$result[] = $sales_sum_arr_new_nu011;
$max_value_money_nu011 = max($sales_sum_arr_new_nu011);
$result[] = $max_value_money_nu011;

echo json_encode($result);
?>