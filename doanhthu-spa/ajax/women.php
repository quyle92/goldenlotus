<?php
require('../../lib/db.php');
require('../../lib/goldenlotus.php');
require('../../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

// initilize all variable
$params = $columns = $totalRecords = $data = array();
$params = $_REQUEST;

$tuNgay = isset( $params['tuNgay']) ? date('Y-m-d', strtotime( $params['tuNgay']) ) : "";
$denNgay = isset( $params['denNgay']) ? date('Y-m-d', strtotime( $params['denNgay']) ) : "";
$ma_khu = "nu";

//define index of column name
$columns = array(
    0 =>'MaLichSuPhieu',
    1 =>'MaNhanVien',
    2 =>'GioVao',
    3 =>'TenHangBan',
    4 =>'DonGia',
    5 => 'SoLuong',
    6 => 'ThanhTien'
);
//var_dump($params['time']);die;
$where = $sqlTot = $sqlRec = "";

// check search value exist
if( !empty($params['search']['value']) ) {
   // echo "(";
    $i = 0;
    foreach( $columns as $col )
    {
        if( $col == 'GioVao')
        {
            $where .=" OR substring( Convert(varchar, {$col} ,126),0,11 ) LIKE '%".$params['search']['value']."%' ";
        }
        else
        {
            $where .=  ( ($i == 0) ? " ( " : "OR " ). $col . " LIKE '%".$params['search']['value']."%' ";
        }
        $i++;

       if( $i == sizeof ($columns) ) $where .=')';
    }
    
}

$paginating = "RowNum BETWEEN {$params['start']}  AND  ( {$params['start']} + {$params['length']} ) ";
if( $params['draw'] > 1 ) $paginating = "RowNum BETWEEN ( {$params['start']} + 1 ) AND  ( {$params['start']} + {$params['length']} ) ";

/**
 * [$sqlRec description]
 * @var string
 */
$sqlRec = $goldenlotus->getSalesSpa_Advanced_Rec( $ma_khu, $tuNgay, $denNgay, $where, $paginating );
//var_dump($sqlRec);die;
    
foreach( $sqlRec as $r )
{
    $data[] = array(
        $columns[0] =>$r['MaLichSuPhieu'],
        $columns[1] => $r['MaNhanVien'],
        $columns[2] =>  substr($r['GioVao'],0,10),
        $columns[3]=>$r['TenHangBan'],
        $columns[4]=> $r['DonGia'] ? number_format($r['DonGia'],0,",",".").'<sup>đ</sup>' : '',
        $columns[5]=> number_format($r['SoLuong'],0,",","."),
        $columns[6]=>  number_format($r['ThanhTien'],0,",",".").'<sup>đ</sup>',
    );

}

if(isset($sqlRec[0]["TotalWhere"])) 
{
    $total_rev = $sqlRec[0]["TotalWhere"];
    $data[] = array(
        $columns[0] => "totalFilter",
        $columns[1] =>"",
        $columns[2] => "",
        $columns[3]=>"",
        $columns[4]=> "",
        $columns[5]=> "",
        $columns[6]=>   number_format($total_rev,0,",",".")
    );
}
/**
 * $sqlTot
 */
$nRows = $goldenlotus->getSalesSpa_Advanced_Tot( $ma_khu, $tuNgay, $denNgay, $where );



$json_data = array(
        "draw"            => intval( $params['draw'] ),
        "recordsTotal"    => intval( $nRows ),
        "recordsFiltered" => intval($nRows),
        "data"            => $data   // total data array
        );

echo json_encode($json_data);  // send data as json format