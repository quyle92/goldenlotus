<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
require('../../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;

$tuNgay = date('Y-m-d', strtotime($params['tuNgay']) );
$tenQuay = isset( $params['tenQuay'] ) ? $params['tenQuay'] : "";

if( ! empty($tenQuay))
{
    $goldenlotus->layView( $tenQuay  );
}


//define index of column name
$columns = array(
    0 =>'MaLichSuPhieu',
    1 =>'NgayCoBill',
    2 =>'MaLoaiThe',
    3 =>'NVTinhTienMaNV',
    4 =>'TenHangBan',
    5 =>'DonGia',
    6 =>'SoLuong',
    7 =>'TienGiamGia',
    8 =>'Discount',
    9 =>'SoTienDVPhi',
    10 => 'SoTienVAT',
    11 => 'ThanhTien'
);
//var_dump($params['time']);die;
$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
    
    $where .="  ( substring( Convert(varchar,ThoiGianBan,111),0,11) LIKE '%".$params['search']['value']."%' ";
    $where .=" OR MaLoaiThe LIKE '%" . $params['search']['value']."%' ";
    $where .=" OR MaLichSuPhieu LIKE '%".$params['search']['value']."%' ";
    $where .=" OR NVTinhTienMaNV LIKE '%".$params['search']['value']."%' ";
    $where .=" OR TenHangBan LIKE '%".$params['search']['value']."%' ";
    $where .=" OR DonGia LIKE '%".$params['search']['value']."%' ";
    $where .=" OR SoLuong LIKE '%".$params['search']['value']."%' ";
    $where .=" OR TienGiamGia LIKE '%".$params['search']['value']."%' ";
    $where .=" OR Discount LIKE '%".$params['search']['value']."%' ";
    $where .=" OR SoTienDVPhi LIKE '%".$params['search']['value']."%' ";
    $where .=" OR SoTienVAT LIKE '%".$params['search']['value']."%' ";
    $where .=" OR ThanhTien LIKE '%".$params['search']['value']."%' )";
}

$paginating = "RowNum BETWEEN {$params['start']}  AND  ( {$params['start']} + {$params['length']} )";
//$orderBy = " ORDER BY {$columns[$params['order'][0]['column']]} {$params['order'][0]['dir']}";

/**
 * [$sqlRec description]
 * @var string
 */

$sqlRec = $goldenlotus->getBillDetails_Rec_Day( $tenQuay, $tuNgay, $where , $paginating ); 
//var_dump($sqlRec);die;

$tong_tien = 0;
foreach( $sqlRec as $r )
{
	$data[] = array(
        'NgayCoBill' => substr($r['NgayCoBill'],0,10),
        'MaLoaiThe' =>  isset($r['TenHangBan']) ?  (   isset($r['MaLoaiThe'])  ? $r['MaLoaiThe']  : "Tiền Mặt" ) : '',
        'MaLichSuPhieu' => $r['MaLichSuPhieu'],
        'NVTinhTienMaNV' =>$r['NVTinhTienMaNV'],
		'TenHangBan' => $r['TenHangBan'],
        'DonGia' => $r['DonGia'],
        'SoLuong' => $r['SoLuong'],
        'TienGiamGia' => $r['TienGiamGia'],
        'Discount' => $r['Discount'],
        'SoTienDVPhi' => $r['SoTienDVPhi'],
        'SoTienVAT' => $r['SoTienVAT'],
        'ThanhTien' => number_format($r['Tongtien'],0,",",".") . '<sup>đ</sup>'
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
$nRows = $goldenlotus->getBillDetails_Tot_Day(  $tenQuay, $tuNgay, $where ); 

$json_data = array(
        "draw"            => intval( $params['draw'] ),
        "recordsTotal"    => intval( $nRows ),
        "recordsFiltered" => intval($nRows),
        "data"            => $data   // total data array
        );

echo json_encode($json_data);  // send data as json format