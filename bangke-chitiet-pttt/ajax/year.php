<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
require('../../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;

$tuNam = isset( $params['tuNam'] ) ?  date_format( date_create( $params['tuNam'] ) , 'Y' ) : "";
$tenQuay = isset( $params['tenQuay'] ) ? $params['tenQuay'] : "";

if( ! empty($tenQuay))
{
	$goldenlotus->layView( $tenQuay  );
}
// var_dump($tenQuay);
// var_dump($tuNam);
//define index of column name
$columns = array(
    0 =>'MaLoaiThe',
    1 =>'GioVao',
    2 =>'MaLichSuPhieu',
    3 =>'TienThucTra'
);
//var_dump($params['time']);die;
$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
//  $where .=" WHERE ";
    $where .=" ( MaLoaiThe LIKE '%".$params['search']['value']."%' ";
    $where .=" OR substring( Convert(varchar,[GioVao],111),0,11 ) LIKE '%".$params['search']['value']."%' ";
    $where .=" OR MaLichSuPhieu LIKE '%".$params['search']['value']."%' ";
    $where .=" OR TienThucTra LIKE '%".$params['search']['value']."%' )";
   // $where .= " AND RowNum BETWEEN $params['start']  AND  $params['length'] ORDER BY $columns[$params['order'][0]['column']]";
}

$paginating = "RowNum BETWEEN {$params['start']}  AND  ( {$params['start']} + {$params['length']} ) ORDER BY {$columns[$params['order'][0]['column']]} {$params['order'][0]['dir']}";

/**
 * [$sqlRec description]
 * @var string
 */

// var_dump($where);
// var_dump($paginating);
$sqlRec = $goldenlotus->getPayMethodDetails_Rec_Year( $tenQuay, $tuNam,  $where , $paginating); 
//var_dump($sqlRec);die;
    
$tong_tien = 0;
foreach( $sqlRec as $r )
{
    $data[] = array(
        'MaLoaiThe' => isset($r['MaLoaiThe']) ? $r['MaLoaiThe'] : "Tiền Mặt",
        'GioVao' => substr($r['GioVao'],0,10),
        'MaLichSuPhieu' => $r['MaLichSuPhieu'],
        'TienThucTra' => number_format($r['TienThucTra'],0,",",".").'<sup>đ</sup>'
    );

  //$tong_tien  += $r['TienThucTra'];
}

// $data[] = array(
//     'MaLoaiThe' => "Tổng",
//     'GioVao' => "",
//     'MaLichSuPhieu' => "",
//     'TienThucTra' => $tong_tien
// );
// var_dump($rs);die;


/**
 * $sqlTot
 */
$nRows = $goldenlotus->getPayMethodDetails_Tot_Year(  $tenQuay, $tuNam,  $where ); 



$json_data = array(
        "draw"            => intval( $params['draw'] ),
        "recordsTotal"    => intval( $nRows ),
        "recordsFiltered" => intval($nRows),
        "data"            => $data   // total data array
        );

echo json_encode($json_data);  // send data as json format