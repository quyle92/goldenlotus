<?php
function dateConverter($date){
   return substr($date,6) . '/' . substr($date,3,2) . '/'.  substr($date,0,2) ;
}

function stripSpecial($str){
    $arr = array(",","$","!","?","&","'",'"',"+", "(", ")");
    $str = str_replace($arr,"",$str);
    $str = trim($str);
   while (strpos($str,"  ")>0) $str = str_replace("  "," ",$str);
    $str = str_replace(" ","_",$str);
    return $str;
}

function stripUnicode($str){
    if(!$str) return false;
    $unicode = array(
     'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
     'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
     'd'=>'đ','D'=>'Đ',
     'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ', 'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
     'i'=>'í|ì|ỉ|ĩ|ị', 'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
     'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
     'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
     'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự', 'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
     'y'=>'ý|ỳ|ỷ|ỹ|ỵ', 'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
    );
    foreach($unicode as $khongdau=>$codau) {
      $arr = explode("|",$codau);
      $str = str_replace($arr,$khongdau,$str);
    }
    return $str;
}

function transformArray( $tbl ){
    //credit: https://stackoverflow.com/questions/45653938/php-array-merge-recursive-with-foreach-loop
    $collection = array_merge_recursive(...$tbl);
    //var_dump($collection);die;
    foreach($collection as &$item) 
    {

        if( $collection['MaBan'] == $item && is_array( $collection['MaBan'] ) || 
            $collection['TongDoanhThu'] == $item && is_array( $collection['TongDoanhThu'] ))
        {   
            //var_dump($item);die;
            $item = array_unique( $item );
           // $item = implode("", $item );
        }

        // if( $collection['MaBan'] !== $item && $collection['TongDoanhThu'] !== $item && $collection['TenHangBan'] !== $item
        //      && !is_array($item) )
        // {
        //     $item = explode(" ", $item );
        // }

        if( $collection['TenHangBan'] == $item && !is_array( $collection['TenHangBan'] ) ) 
        {
          //$tbl_transformed['TenHangBan'] = array();
          $item = array($item);
          //var_dump($tbl_transformed['TenHangBan']);die;
        }
        
    }
     //var_dump($collection);die;
    return $collection; //die;

}

function changeTitle($str){
    $str = stripUnicode($str);

    $str = ucwords($str);
    while (strpos($str,"  ")>0) $str = str_replace("  "," ",$str);
    $str = str_replace(" ","",$str);

    return $str;
}

function customizeArray( $arr ){

    $all_tables =  $arr;
    $result = array();
   // var_dump($all_tables);
    foreach ( $all_tables as &$tb){

        $tb['MaHangBan'] = array( $tb['MaHangBan'] );
        $tb['MaDVT'] = array( $tb['MaDVT'] );
        $tb['TenHangBan'] = array( $tb['TenHangBan'] );
        $tb['SoLuong'] = array( $tb['SoLuong'] );
        $tb['ThanhTien'] = array( $tb['ThanhTien'] );
        
     }

    // convert all rows as object
    foreach ( $all_tables as &$tb){

        $tb = (object) $tb;
       
    }

    //var_dump($all_tables);
    foreach ( $all_tables as $entry ){

        if ( !isset($result[$entry->MaBan]) ) {

            $result[$entry->MaBan] = $entry;
        }
        else {
            foreach ($entry as $key => $value) { //var_dump( $key);echo "<hr>"
               if($key != 'MaBan' && $key !='TongDoanhThu')
               {
                  //var_dump( $value );echo "<hr>";
                  array_push( $result[$entry->MaBan]->$key , $value );
               } 
            }
        }

     
    }

    return $result;

}

function customizeArray_TablesBills( array $arr ){

    $all_tables =  $arr;
    $result = array();
    //var_dump($all_tables);die;

    foreach ( $all_tables as &$tb){

        $tb['MaLichSuPhieu'] = array( $tb['MaLichSuPhieu'] );
        $tb['GioVao'] = array( $tb['GioVao'] );
        $tb['TenHangBan'] = array( $tb['TenHangBan'] );
        $tb['DonGia'] = array( $tb['DonGia'] );
        $tb['SoLuong'] = array( $tb['SoLuong'] );
        $tb['ThanhTien'] = array( $tb['ThanhTien'] );
        $tb['MaNhanVien'] = array( $tb['MaNhanVien'] );       

    }
    unset($tb);
    // convert all rows as object
    foreach ( $all_tables as &$tb){

        $tb = (object) $tb;
       
    }
    unset($tb);
   // var_dump($all_tables);die;echo "<hr>";
    //$i = 0;
    foreach ( $all_tables as $entry ){

        if ( !isset($result[$entry->MaBan])  ) {

            $result[$entry->MaBan] = $entry;
        }
        else {
            foreach ($entry as $key => $value) { //var_dump($entry);die;
               if($key != 'MaBan' && $key !='TongDoanhThu')
               {
                  //var_dump( $value );echo "<hr>";
                 array_push( $result[$entry->MaBan]->$key , implode("",$value) );
               } 
               // $result[$entry->MaBan]->MaLichSuPhieu[] = implode("",$entry->MaLichSuPhieu);
               // $result[$entry->MaBan]->TenHangBan[] = implode("",$entry->TenHangBan);

               
            }

        }
         //$i++;
        //if($i == 2) { break;}
       
    }
    // var_dump($result);die;
    return $result;

}

function pr($array = null) { echo "<pre>" . print_r($array, true) . "</pre>"; } 

function customizeArray_SpaZone( array $arr ){

    $all_rows =  $arr;
    $result = array();
    //var_dump($all_rows);die;

    foreach ( $all_rows as &$row){

        $row['MaLichSuPhieu'] = array( $row['MaLichSuPhieu'] );
        $row['GioVao'] = array( $row['GioVao'] );
        $row['TenHangBan'] = array( $row['TenHangBan'] );
        $row['DonGia'] = array( $row['DonGia'] );
        $row['SoLuong'] = array( $row['SoLuong'] );
        $row['ThanhTien'] = array( $row['ThanhTien'] );
        $row['MaNhanVien'] = array( $row['MaNhanVien'] );      

    }
    unset($row);
    // convert all rows as object
    foreach ( $all_rows as &$row){

        $row = (object) $row;
       
    }
    unset($row);
   // var_dump($all_rows);die;echo "<hr>";
    //$i = 0;
    foreach ( $all_rows as $row ){

        if ( !isset($result[$row->MaKhu])  ) {

            $man_1 = $row->MaKhu;
            $result[$row->MaKhu] = $row; //var_dump($result);die;
        }
        else {
            foreach ($row as $key => $value) { //var_dump($row);die;
               if($key != 'MaKhu' && $key !='TongDoanhThu')
               {
                  //var_dump( $value );echo "<hr>";
                 array_push( $result[$row->MaKhu]->$key , implode("",$value) );
               } 
               // $result[$entry->MaBan]->MaLichSuPhieu[] = implode("",$entry->MaLichSuPhieu);
               // $result[$entry->MaBan]->TenHangBan[] = implode("",$entry->TenHangBan);

               
            }

        }
         //$i++;
        //if($i == 2) { break;}
       
    }
    // var_dump($result);die;
    return $result;

  }

  function removeOuterArr( array $input) {
    //pr($input);//die;
    $output = [];
    foreach($input as $item)
    { //pr($item[0]); die;
        $output[] = ($item[0]);
    }
    //pr($output); die;
    return $output;

}

function compareYesterday( $sales_today, $sales_yesterday ){
    $up = '<i class="fa fa-arrow-up" aria-hidden="true"></i>';
    $down = '<i class="fa fa-arrow-down" aria-hidden="true"></i>';
    $sales_today = intval( $sales_today );
    $sales_yesterday = intval( $sales_yesterday ) ;
    
    if ( $sales_today !== 0 && $sales_yesterday !== 0 )
    {
      $today_vs_yesterday_diff =  round( abs( ($sales_today - $sales_yesterday) * 100 / $sales_yesterday ) );
    }


    if( $sales_today !== 0 && $sales_yesterday !== 0 )
    {
      echo ( $sales_today > $sales_yesterday ? $up : $down ) . ' ' . $today_vs_yesterday_diff . '% vs hôm qua';
    }
    elseif ( $sales_today == 0 && $sales_yesterday == 0 )
    {
       echo "D/thu hôm nay = D/thu hôm qua = 0";
    }
    elseif ( $sales_today == 0 || $sales_yesterday == 0 )
    {
      echo ( $sales_today == 0 ? $down : $up ) . ' ' . '100% vs hôm qua';
    }

}

function  compareLastWeek( $sales_today, $sales_last_week ){
    $up = '<i class="fa fa-arrow-up" aria-hidden="true"></i>';
    $down = '<i class="fa fa-arrow-down" aria-hidden="true"></i>';
    $sales_today = intval( $sales_today );
    $sales_last_week = intval( $sales_last_week ) ;

    if ( $sales_today !== 0 && $sales_last_week !== 0 )
    {
      $today_vs_lastWeek_diff =  round( abs( ($sales_today - $sales_last_week) * 100 / $sales_last_week ) );
    }


    if( $sales_today !== 0 && $sales_last_week !== 0 )
    {
      echo ( $sales_today > $sales_last_week ? $up : $down ) . ' ' . $today_vs_lastWeek_diff . '% vs cùng ngày tuần trước';
    }
    elseif (  $sales_today == 0 && $sales_last_week == 0 )
    {
      echo "D/thu hôm nay = D/thu tuần trước = 0";
    }
    elseif ( $sales_today == 0 || $sales_last_week == 0 )
    {
      echo ( $sales_today == 0 ? $down : $up ) . ' ' . '100% vs  cùng ngày tuần trước';
    }
}

function so_sanh_diem_tong_hom_qua( $sales_today, $sales_yesterday ){

    $up = '<i class="fa fa-arrow-up" aria-hidden="true"></i>';
    $down = '<i class="fa fa-arrow-down" aria-hidden="true"></i>';
    $sales_today = intval( $sales_today );

    if ( $sales_today !== 0 && $sales_yesterday !== 0 )
    {
      $today_vs_yesterday_diff =  round( abs( ($sales_today - $sales_yesterday) * 100 / $sales_yesterday ) );
    }

    if( $sales_today !== 0 && $sales_yesterday !== 0 )
    {
      echo ( $sales_today > $sales_yesterday ? $up : $down ) . ' ' . $today_vs_yesterday_diff . '% vs hôm qua';
    }
    elseif ( $sales_today == 0 && $sales_yesterday == 0 )
    {
      echo "D/thu hôm nay = D/thu hôm qua = 0";
    }
    elseif ( $sales_today == 0 || $sales_yesterday == 0 )
    {
      echo ( $sales_today == 0 ? $down : $up ) . ' ' . '100% vs hôm qua';
    }
}

function so_sanh_diem_tong_tuan_truoc( $sales_today, $sales_last_week ){

    $up = '<i class="fa fa-arrow-up" aria-hidden="true"></i>';
    $down = '<i class="fa fa-arrow-down" aria-hidden="true"></i>';
    $sales_today = intval( $sales_today );
    $sales_last_week = intval( $sales_last_week );

    if ( $sales_today !== 0 && $sales_last_week !== 0 )
    {
      $today_vs_lastWeek_diff =  round( abs( ($sales_today - $sales_last_week) * 100 / $sales_last_week ) );
    }

    if( $sales_today !== 0 && $sales_last_week !== 0 )
    {
      echo ( $sales_today > $sales_last_week ? $up : $down ) . ' ' . $today_vs_lastWeek_diff . '% vs cùng ngày tuần trước';
    }
    elseif (  $sales_today == 0 && $sales_last_week == 0 )
    {
      echo "D/thu hôm nay = D/thu tuần trước = 0";
    }
    elseif ( $sales_today == 0 || $sales_last_week == 0 )
    {
      echo ( $sales_today == 0 ? $down : $up ) . ' ' . '100% vs  cùng ngày tuần trước';
    }
}