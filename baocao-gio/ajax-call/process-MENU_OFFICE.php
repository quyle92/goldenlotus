<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;

$date = $_POST['tungay'];
$date = substr($date,6) . "/" . substr($date,3,2) . "/" . substr($date,0,2);
$nhom_hang_ban_id =  $_POST['nhom_hang_ban_id'];
$nhom_hang_ban_ten =  $_POST['nhom_hang_ban_ten'];
$result = array();



/****************** Qty *********************/
${'qty_chart_' . $nhom_hang_ban_ten} = $goldenlotus->getFoodSoldQtyByHour( $date, $nhom_hang_ban_id  );

while($r = sqlsrv_fetch_array( ${'qty_chart_'. $nhom_hang_ban_ten} ) )
{
  ${'qty_sum_arr_' . $nhom_hang_ban_ten} = array();
  foreach ($r as $k => $v)
  {
     ${'qty_sum_arr_' . $nhom_hang_ban_ten}[] = $v;
  }
}

${'qty_sum_arr_new_'. $nhom_hang_ban_ten} = array();
for ( $i = 1; $i < count(${'qty_sum_arr_'. $nhom_hang_ban_ten}); $i++)
{ if( $i % 2)
     ${'qty_sum_arr_new_'. $nhom_hang_ban_ten}[] = number_format( ${'qty_sum_arr_' . $nhom_hang_ban_ten}[$i],0,",","." );
}
$result[] = ${'qty_sum_arr_new_'. $nhom_hang_ban_ten};
${'max_value_qty_' . $nhom_hang_ban_ten} = max(${'qty_sum_arr_new_' . $nhom_hang_ban_ten});
$result[] = ${'max_value_qty_' . $nhom_hang_ban_ten};




/**************** Money *********************/
${'sales_chart_' . $nhom_hang_ban_ten} = $goldenlotus->getSalesAmountByHour( $date, $nhom_hang_ban_id  );

while( $r1 = sqlsrv_fetch_array( ${'sales_chart_' . $nhom_hang_ban_ten} ) )
{
  $sales_sum_arr_nu001 = array();
  foreach ($r1 as $k=>$v)
  {
    $sales_sum_arr_nu001[] = $v;
  }
}

$sales_sum_arr_new_nu001 = array();
for ( $i = 1; $i < count($sales_sum_arr_nu001); $i++)
{ if( $i % 2)
    array_push( $sales_sum_arr_new_nu001, $sales_sum_arr_nu001[$i] );
}
$result[] = $sales_sum_arr_new_nu001;
$max_value_money_nu001 = max($sales_sum_arr_new_nu001);
$result[] = $max_value_money_nu001;

echo json_encode($result);
?>