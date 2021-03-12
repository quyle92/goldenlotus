<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$date = $_POST['tuNgay'];
$date = substr($date,6) . "/" . substr($date,3,2) . "/" . substr($date,0,2);
$nhom_hang_ban_id =  $_POST['nhom_hang_ban_id'];
$nhom_hang_ban_ten =  $_POST['nhom_hang_ban_ten'];
$result = array();



/****************** Qty *********************/
${'qty_chart_' . $nhom_hang_ban_ten} = $goldenlotus->getFoodSoldQtyByHour( $date, $nhom_hang_ban_id  );

foreach ( ${'qty_chart_'. $nhom_hang_ban_ten} as $r )
{
  $qty_sum_arr = array();
  foreach ($r as $k => $v)
  {
    if ($v < 0){
    $qty_sum_arr[] = 0;
   }
     $qty_sum_arr[] = $v;
  }
}

// ${'qty_sum_arr_new_'. $nhom_hang_ban_ten} = array();
// for ( $i = 1; $i < count(${'qty_sum_arr_'. $nhom_hang_ban_ten}); $i++)
// { if( $i % 2)
//      ${'qty_sum_arr_new_'. $nhom_hang_ban_ten}[] = number_format( ${'qty_sum_arr_' . $nhom_hang_ban_ten}[$i],0,",","." );
// }
$result[] = $qty_sum_arr;
$max_value_qty_ = max($qty_sum_arr);
$result[] = $max_value_qty_;




/**************** Money *********************/
${'sales_chart_' . $nhom_hang_ban_ten} = $goldenlotus->getSalesAmountByHour( $date, $nhom_hang_ban_id  );

foreach ( ${'sales_chart_' . $nhom_hang_ban_ten} as $r1 )
{
  $sales_sum_arr = array();
  foreach ($r1 as $k=>$v)
  {
    $sales_sum_arr[] = $v;
  }
}
//var_dump($sales_sum_arr);
//$sales_sum_arr_new = array();
// for ( $i = 1; $i < count($sales_sum_arr); $i++)
// { if( $i % 2)
//     array_push( $sales_sum_arr_new, $sales_sum_arr[$i] );
// }
$result[] = $sales_sum_arr;
$max_value_money = max($sales_sum_arr);
$result[] = $max_value_money;

echo json_encode($result);
?>