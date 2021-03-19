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
    1 =>'MaLoaiThe',
    2 =>'MaLichSuPhieu',
    3 =>'NVTinhTienMaNV',
    4 =>'Floor',
    5 =>'TenHangBan',
    6 =>'Note',
    7 =>'DonGia',
    8 =>'SoLuong',
    9 =>'TienGiamGia',
    10 =>'Discount',
    11=>'SoTienDVPhi',
    12 => 'SoTienVAT',
    13 => 'ThanhTien'
);
//var_dump($params['time']);die;
$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
    
    $where .="  ( substring( Convert(varchar,ThoiGianBan,111),0,11) LIKE '%".$params['search']['value']."%' ";
    $where .=" OR MaLoaiThe LIKE '%" . $params['search']['value']."%' ";
    $where .=" OR MaLichSuPhieu LIKE '%".$params['search']['value']."%' ";
    $where .=" OR NVTinhTienMaNV LIKE '%".$params['search']['value']."%' ";
    $where .=" OR Floor LIKE '%".$params['search']['value']."%' ";
    $where .=" OR TenHangBan LIKE '%".$params['search']['value']."%' ";
    $where .=" OR Note LIKE '%".$params['search']['value']."%' ";
    $where .=" OR DonGia LIKE '%".$params['search']['value']."%' ";
    $where .=" OR SoLuong LIKE '%".$params['search']['value']."%' ";
    $where .=" OR TienGiamGia LIKE '%".$params['search']['value']."%' ";
    $where .=" OR Discount LIKE '%".$params['search']['value']."%' ";
    $where .=" OR SoTienDVPhi LIKE '%".$params['search']['value']."%' ";
    $where .=" OR SoTienVAT LIKE '%".$params['search']['value']."%' ";
    $where .=" OR ThanhTien LIKE '%".$params['search']['value']."%' )";
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
        'NgayCoBill' => substr($r['NgayCoBill'],0,10),
        'MaLoaiThe' => isset($r['MaLoaiThe']) ? $r['MaLoaiThe'] : "Tiền Mặt",
        'MaLichSuPhieu' => $r['MaLichSuPhieu'],
        'NVTinhTienMaNV' =>$r['NVTinhTienMaNV'],
		'Floor' => $r['Floor'],
		'TenHangBan' => $r['TenHangBan'],
		'Note' => $r['Note'],
        'DonGia' => $r['DonGia'],
        'SoLuong' => $r['SoLuong'],
        'TienGiamGia' => $r['TienGiamGia'],
        'Discount' => $r['Discount'],
        'SoTienDVPhi' => $r['SoTienDVPhi'],
        'SoTienVAT' => $r['SoTienVAT'],
        'ThanhTien' => number_format($r['ThanhTien'],0,",",".") . '<sup>đ</sup>'
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
$nRows = $goldenlotus->getBillDetailsByMonthRange_Tot(   $tungay, $denngay, $where ); 



$json_data = array(
        "draw"            => intval( $params['draw'] ),
        "recordsTotal"    => intval( $nRows ),
        "recordsFiltered" => intval($nRows),
        "data"            => $data   // total data array
        );

echo json_encode($json_data);  // send data as json format