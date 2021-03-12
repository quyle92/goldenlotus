<?php
require('../lib/db.php');
require('../lib/goldenlotus.php');
require('../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;

$tungay = dateConverter($params['tuNgay']);
$denngay = dateConverter($params['denNgay']);

//define index of column name
$columns = array(
    0 =>'NgayCoBill',
    1 =>'NVTinhTienMaNV',
    2 =>'TenHangBan',
    3 =>'SoLuong',
    4 =>'Tongtien'
);
//var_dump($params['time']);die;
$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
//  $where .=" WHERE ";
    $where .=" ( substring( Convert(varchar,[ThoiGianBan],111),0,11 ) LIKE '%".$params['search']['value']."%' ";
    $where .=" OR NVTinhTienMaNV LIKE '%".$params['search']['value']."%' ";
    $where .=" OR TenHangBan LIKE '%".$params['search']['value']."%' ";
    $where .=" OR SoLuong LIKE '%".$params['search']['value']."%' ";
    $where .=" OR Tongtien LIKE '%".$params['search']['value']."%' )";
   // $where .= " AND RowNum BETWEEN $params['start']  AND  $params['length'] ORDER BY $columns[$params['order'][0]['column']]";
}

$paginating = "RowNum BETWEEN {$params['start']}  AND  ( {$params['start']} + {$params['length']} ) ORDER BY {$columns[$params['order'][0]['column']]} {$params['order'][0]['dir']}";

/**
 * [$sqlRec description]
 * @var string
 */
$sqlRec = $goldenlotus->getBillDetailsByMonthRange_Rec( $tungay, $denngay, $where , $paginating ); 
//var_dump($sqlRec);die;
    
$tong_tien = 0;
foreach( $sqlRec as $r )
{
    $data[] = array(
        'NgayCoBill' => substr( $r['NgayCoBill'],0,10 ),
        'NVTinhTienMaNV' => $r['NVTinhTienMaNV'],
        'TenHangBan' => $r['TenHangBan'],
        'SoLuong' => $r['SoLuong'],
        // 'Tongtien' => $r['Tongtien'],
        'Tongtien' => number_format($r['Tongtien'],0,",",".") . '<sup>đ</sup>'
    );

  //$tong_tien  += $r['TienThucTra'];
}

// $data[] = array(
//     'MaLoaiThe' => "Tổng",
//     'GioVao' => "",
//     'MaLichSuPhieu' => "",
//     'TienThucTra' => $tong_tien
// );
 //var_dump($data);die;


/**
 * $sqlTot
 */
$nRows = $goldenlotus->getBillDetailsByMonthRange_Tot(   $tungay, $denngay, $where ); 



$json_data = array(
        "draw"            => intval( $params['draw'] ),
        "recordsTotal"    => intval( $nRows ),
        "recordsFiltered" => intval($nRows),
        "data"            => $data   // total data array
        );

echo json_encode($json_data);  // send data as json format