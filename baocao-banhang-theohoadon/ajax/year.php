<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
require('../../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;

$tuNam = $params['tuNam'];
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
    3 =>'CheckIn',
    4 =>'CheckOut',
    5 =>'NVTinhTienMaNV',
    6 =>'TenHangBan',
    7 =>'DonGia',
    8 =>'SoLuong',
    9 =>'TienGiamGia',
    10 =>'Discount',
    11 =>'SoTienDVPhi',
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

$result = $goldenlotus->getBillDetails_Rec_Year( $tenQuay, $tuNam, $where , $paginating ) ; 
$sqlRec = $result[0];
// var_dump($goldenlotus->getBillDetails_Rec_Month( $tenQuay, $tuNam, $where , $paginating ));die;

$grandTotal = $result[1][0]['GrandTotal'];

$tong_tien = 0;
foreach( $sqlRec as $r )
{
	$data[] = array(
        'NgayCoBill' => substr($r['NgayCoBill'],0,10),
        'MaLoaiThe' =>  isset($r['TenHangBan']) ?  (   isset($r['MaLoaiThe'])  ? $r['MaLoaiThe']  : "Tiền Mặt" ) : '',
        'CheckIn' => $r['CheckIn'],
        'CheckOut' => $r['CheckOut'],
        'MaLichSuPhieu' => $r['MaLichSuPhieu'],
        'NVTinhTienMaNV' =>$r['NVTinhTienMaNV'],
        'TenHangBan' => $r['TenHangBan'],
        'DonGia' => $r['DonGia'],
        'SoLuong' => $r['SoLuong'],
        'TienGiamGia' => $r['TienGiamGia'],
        'Discount' => $r['Discount'],
        'SoTienDVPhi' => $r['SoTienDVPhi'],
        'SoTienVAT' => $r['SoTienVAT'],
        'ThanhTien' => $r['Tongtien']
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
$nRows = $goldenlotus->getBillDetails_Tot_Year(  $tenQuay, $tuNam, $where ); 

$json_data = array(
        "draw"            => intval( $params['draw'] ),
        "recordsTotal"    => intval( $nRows ),
        "recordsFiltered" => intval($nRows),
        "data"            => $data ,
        'grandTotal' => number_format( $grandTotal,0,",",".") . '<sup>đ</sup>'
        );

echo json_encode($json_data);  // send data as json format