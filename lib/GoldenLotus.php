<?php
class DbConnection {

	protected $serverName = "DELL-PC\SQLEXPRESS";
	protected $connectionInfo = array( "Database"=>"GOLDENLOTUS_Q3","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
	protected $conn;

	function __construct() {
			$this->conn =  sqlsrv_connect( $this->serverName, $this->connectionInfo) or die("Database Connection Error"."<br>". mssql_get_last_message()); 
    }
}

class GoldenLotus extends DbConnection{

	public function layMaNV() {
		$sql = "SELECT *  FROM [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien]";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function layTatCaBaoCao(){
		$sql = "SELECT * FROM [GOLDENLOTUS_Q3].[dbo].[tblDMBaoCao] ";
		try {
			$rs = sqlsrv_query($this->conn, $sql); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layDanhSachUsers() {
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [GOLDENLOTUS_Q3].[dbo].[tblDSNguoiSD] a,  [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien] b where a.MaNhanVien = b.MaNV 		";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function layBaoCao( $ma_bao_cao ){
		$sql = "SELECT * FROM [GOLDENLOTUS_Q3].[dbo].[tblDMBaoCao] WHERE [MaBaoCao] = '$ma_bao_cao' ";
		try {
			$rs = sqlsrv_query($this->conn, $sql);
			$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $r['TenBaoCao'];
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layTenUser($maNV) {
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [GOLDENLOTUS_Q3].[dbo].[tblDSNguoiSD] a,  [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien] b where a.MaNhanVien = b.MaNV and MaNV ='$maNV'	";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function changePassword( $maNV, $password, $repass, &$loi ) {

		$thanhcong=true;

		$maNV = htmlentities(trim(strip_tags($maNV)),ENT_QUOTES,'utf-8');
		$password = htmlentities(trim(strip_tags($password)),ENT_QUOTES,'utf-8');
		$repass = htmlentities(trim(strip_tags($repass)),ENT_QUOTES,'utf-8');

		if ($password=="") 	{$thanhcong=false; $loi[]="new password not entered";} 

		if ($repass=="") 	{$thanhcong=false; $loi[]="Pls re-enter new password";} 
		if ($repass != $password) 	{$thanhcong=false; $loi[]="new password does not match" . $repass . $repass;} 

		if ( $thanhcong==true )
		{
			$sql = "UPDATE [GOLDENLOTUS_Q3].[dbo].[tblDSNguoiSD] SET [MatKhau] = PWDENCRYPT('$password') where MaNV ='$maNV'";
			try
			{
				$rs = sqlsrv_query($this->conn, $sql);
				
			}

			catch ( PDOException $error ){
				echo $error->getMessage();
			}
		}

		return $thanhcong;
		
	}

	public function xoaUser( $maNV ){
		$sql = "DELETE FROM  [GOLDENLOTUS_Q3].[dbo].[tblDSNguoiSD] where [MaNhanVien] = '$maNV'";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countOccupiedTables() : int {
		$sql = "SELECT * FROM  [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] where [ThoiGianDongPhieu] IS NULL";
		try 
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array( "Scrollable" => 'static' ));

			if( sqlsrv_fetch( $rs ) === false) {
			     die( print_r( sqlsrv_errors(), true));
			}

			return $count = sqlsrv_num_rows($rs);

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countTotalTables() : int {
		$sql = "SELECT * FROM  [GOLDENLOTUS_Q3].[dbo].[tblDMBan]";
		try 
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array( "Scrollable" => 'static' ));
			
			if( sqlsrv_fetch( $rs ) === false) {
			     die( print_r( sqlsrv_errors(), true));
			}

			return $count = sqlsrv_num_rows($rs);

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}

	}

	public function getFoodSoldThisMonth ($thang_nay, &$total = null ) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_nay' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_nay' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);

			$rs_1 = sqlsrv_query($this->conn, $sql_1);
			$row_rs = sqlsrv_fetch_array( $rs_1 );
			$total=$row_rs[0];

			if(sqlsrv_has_rows($rs) != false) 
				return $rs;
			else die( print_r( sqlsrv_errors(), true ) );
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldLastMonth ($thang_truoc, &$total = null) {

		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_truoc' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_truoc' and SoLuong >0";

		try{
			$rs = sqlsrv_query($this->conn, $sql);

			$rs_1 = sqlsrv_query($this->conn, $sql_1);
			$row_rs = sqlsrv_fetch_array( $rs_1 );
			$total=$row_rs[0];

			if($rs != false) 
				return $rs;
			else die( print_r( sqlsrv_errors(), true ) );
		}

		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldAnotherMonth ($thang_khac, &$total = null) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_khac' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_khac' and SoLuong >0";

		try{

			$rs_1 = sqlsrv_query($this->conn, $sql_1);
			$row_rs = sqlsrv_fetch_array( $rs_1 );
			$total=$row_rs[0];

			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldToday($hom_nay, &$total) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_nay' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_nay' and SoLuong >0";

		try{

			$rs_1 = sqlsrv_query($this->conn, $sql_1);
			$row_rs = sqlsrv_fetch_array( $rs_1 );
			$total=$row_rs[0];

			$rs = sqlsrv_query($this->conn, $sql);
			
			if( $rs != false) 
				return $rs;
			else   die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldYesterday($hom_truoc, &$total = null) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_truoc' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_truoc' and SoLuong >0";

		try{

			$rs_1 = sqlsrv_query($this->conn, $sql_1);
			$row_rs = sqlsrv_fetch_array( $rs_1 );
			$total=$row_rs[0];

			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false)  
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldAnotherDay($hom_khac, &$total = null) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_khac' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_khac' and SoLuong >0";

		try{

			$rs_1 = sqlsrv_query($this->conn, $sql_1);
			$row_rs = sqlsrv_fetch_array( $rs_1 );
			$total=$row_rs[0];

			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsToday($today){
		 $sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a JOIN  [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$today' and SoLuong >0 ";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsYesterday( $yesterday ){
		 $sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a JOIN  [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$yesterday' and SoLuong >0"; 
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}


	public function getDatesHasBillOfThisMonth( $this_month ) {
		  $sql = "SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, count( * ) FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a JOIN  [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$this_month' and SoLuong >0 GROUP BY substring( Convert(varchar,ThoiGianBan,111),0,11 ) ";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}


	public function getDatesHasBillBySelection( $tungay, $denngay  ){
		$sql = "SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, count( * ) FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a , [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b, [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_CTThanhToan] c WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' AND SoLuong >0 AND a.MaLichSuPhieu=b.MaLichSuPhieu  GROUP BY substring( Convert(varchar,ThoiGianBan,111),0,11 )";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsByDayOfMonth( $date ){
		$sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a JOIN  [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0 ";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getPayMethodDetailsByDate( $date ){
		$sql = "SELECT  b.*, c.[MaLoaiThe] FROM  [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b  LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,111),0,11 ) ='$date' ";

		try{
			
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	 public function getFoodGroupsByDate( $date ){
		$sql = "select Ten from  [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a 
 LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] c 
ON b.[MaNhomHangBan] = c.[Ma] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0 group by Ten";
		try{
			$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
			
			if( $rs != false) 
				return $rs;
			else die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldByGroup( $date, &$nhom_hang_ban_arr, $nhom_hang_ban = "" ){

	 	$sql_2 = "select Ten from  [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a 
		 LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] c 
		ON b.[MaNhomHangBan] = c.[Ma] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0 group by Ten";
			try{
				$rs_2 = sqlsrv_query( $this->conn, $sql_2, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs_2 != false) 
					{
						//$nhom_hang_ban_arr = sqlsrv_fetch_array( $rs_2 );
						while( $row = sqlsrv_fetch_array( $rs_2, SQLSRV_FETCH_ASSOC ) )
							$nhom_hang_ban_arr[] = $row['Ten'];
					}
				else die(print_r(sqlsrv_errors(), true));
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}

		$sql = "  SELECT DISTINCT TenHangBan,MaHangBan, Ten, TotalOrderAmount as SoLuong, DonGia,TienGiamGia,SoTienDVPhi, SoTienVAT
	    FROM
	   ( SELECT Ten, MaHangBan, TenHangBan, DonGia, TienGiamGia,SoTienDVPhi,SoTienVAT,
	    SUM(SoLuong) OVER(PARTITION BY TenHangBan) AS TotalOrderAmount
	  	FROM
		  ( SELECT  c.[Ten] ,  a.MaHangBan, b.[TenHangBan] , a.SoLuong, a.DonGia,
		  p.TienGiamGia,p.SoTienDVPhi, p.SoTienVAT 	  
		  FROM [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] p 
		  JOIN [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] c 
		  ON b.[MaNhomHangBan] = c.[Ma] 
		  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and Ten=N'$nhom_hang_ban'
		  and SoLuong >0  ) x  
		  ) y Order by Ten
		 ";


			try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die(print_r(sqlsrv_errors(), true));
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getFoodSoldByGroup_Month( $month, &$nhom_hang_ban_arr, $nhom_hang_ban = "" ){

	 	$sql_2 = "select Ten from  [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a 
		 LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] c 
		ON b.[MaNhomHangBan] = c.[Ma] WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$month' and SoLuong >0 group by Ten";
			try{
				$rs_2 = sqlsrv_query( $this->conn, $sql_2, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs_2 != false) 
					{
						//$nhom_hang_ban_arr = sqlsrv_fetch_array( $rs_2 );
						while( $row = sqlsrv_fetch_array( $rs_2, SQLSRV_FETCH_ASSOC ) )
							$nhom_hang_ban_arr[] = $row['Ten'];
					}
				else die(print_r(sqlsrv_errors(), true));
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}

		$sql = "  SELECT DISTINCT TenHangBan,MaHangBan, Ten, TotalOrderAmount as SoLuong, DonGia,TienGiamGia,SoTienDVPhi, SoTienVAT
	    FROM
	   ( SELECT Ten, MaHangBan, TenHangBan, DonGia, TienGiamGia,SoTienDVPhi,SoTienVAT,
	    SUM(SoLuong) OVER(PARTITION BY TenHangBan) AS TotalOrderAmount
	  	FROM
		  ( SELECT  c.[Ten] ,  a.MaHangBan, b.[TenHangBan] , a.SoLuong, a.DonGia,
		  p.TienGiamGia,p.SoTienDVPhi, p.SoTienVAT 	  
		  FROM [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] p 
		  JOIN [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] c 
		  ON b.[MaNhomHangBan] = c.[Ma] 
		  WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$month' and Ten=N'$nhom_hang_ban'
		  and SoLuong >0  ) x  
		  ) y Order by Ten
		 ";


			try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die(print_r(sqlsrv_errors(), true));
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getFoodSoldByGroup_DateSelected( $tungay, $denngay, &$nhom_hang_ban_arr, $nhom_hang_ban = "" ){

	 	$sql_2 = "select Ten from  [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a 
		 LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] c 
		ON b.[MaNhomHangBan] = c.[Ma] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' and SoLuong >0 group by Ten";
			try{
				$rs_2 = sqlsrv_query( $this->conn, $sql_2, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs_2 != false) 
					{
						//$nhom_hang_ban_arr = sqlsrv_fetch_array( $rs_2 );
						while( $row = sqlsrv_fetch_array( $rs_2, SQLSRV_FETCH_ASSOC ) )
							$nhom_hang_ban_arr[] = $row['Ten'];
					}
				else die(print_r(sqlsrv_errors(), true));
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}

		$sql = "  SELECT DISTINCT TenHangBan,MaHangBan, Ten, TotalOrderAmount as SoLuong, DonGia,TienGiamGia,SoTienDVPhi, SoTienVAT
	    FROM
	   ( SELECT Ten, MaHangBan, TenHangBan, DonGia, TienGiamGia,SoTienDVPhi,SoTienVAT,
	    SUM(SoLuong) OVER(PARTITION BY TenHangBan) AS TotalOrderAmount
	  	FROM
		  ( SELECT  c.[Ten] ,  a.MaHangBan, b.[TenHangBan] , a.SoLuong, a.DonGia,
		  p.TienGiamGia,p.SoTienDVPhi, p.SoTienVAT 	  
		  FROM [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] p 
		  JOIN [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] c 
		  ON b.[MaNhomHangBan] = c.[Ma] 
		  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' and Ten=N'$nhom_hang_ban'
		  and SoLuong >0  ) x  
		  ) y Order by Ten
		 ";


			try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die(print_r(sqlsrv_errors(), true));
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesByFoodGroup( $date ){
		$sql = "select Ma, Ten, sum (TotalMoney) as DoanhThu  from [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] x
right Join 
(	select t1.[MaNhomHangBan], t1.MaHangBan, t2.SoLuong, t2.DonGia, 
	t2.SoLuong * t2.DonGia as TotalMoney
	from [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] t1
	left join (
		select MaHangBan, [TenHangBan], SoLuong, DonGia  from
		[GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan]
		where substring ( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' 
		and SoLuong >0 ) t2 
	on t2.MaHangBan = t1.MaHangBan 
) y
ON x.Ma = y.[MaNhomHangBan] group by Ma, Ten";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesByFoodGroupBySelection( $tungay, $denngay ){
		$sql = "select Ma, Ten, sum (TotalMoney) as DoanhThu  from [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] x
		right Join 
		(	select t1.[MaNhomHangBan], t1.MaHangBan, t2.SoLuong, t2.DonGia, 
			t2.SoLuong * t2.DonGia as TotalMoney
			from [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] t1
			left join (
				select MaHangBan, [TenHangBan], SoLuong, DonGia  from
				[GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan]
				where substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay'
				and SoLuong >0 ) t2 
			on t2.MaHangBan = t1.MaHangBan 
		) y
		ON x.Ma = y.[MaNhomHangBan] group by Ma, Ten";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSoldvsCancelledItemsByDate( $date ){
		$sql = "select TenHangBan,
		  	sum (CASE WHEN soluong > 0 THEN soluong
		END) AS SLOrder,
		 sum(soluong) as SLBan,
			sum (CASE WHEN soluong < 0 THEN soluong
		END) AS SLBo
		FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) = '$date' group by TenHangBan";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSoldvsCancelledItemsByMonth( $month ){
		$sql = "select TenHangBan,
		  	sum (CASE WHEN soluong > 0 THEN soluong
		END) AS SLOrder,
		 sum(soluong) as SLBan,
			sum (CASE WHEN soluong < 0 THEN soluong
		END) AS SLBo
		FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) = '$month' group by TenHangBan";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSoldvsCancelledItemsBySelection( $tungay, $denngay ){
		$sql = "select TenHangBan,
		  	sum (CASE WHEN soluong > 0 THEN soluong
		END) AS SLOrder,
		 sum(soluong) as SLBan,
			sum (CASE WHEN soluong < 0 THEN soluong
		END) AS SLBo
		FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' group by TenHangBan";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCurrencyReportByDate( $date ){
		$sql = "  select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] 
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'   group by [MaTienTe]";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCurrencyReportByMonth( $month ){
		$sql = "select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] 
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,8 ) = '$month'  group by [MaTienTe]";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCurrencyReportBySelection( $tungay, $denngay ){
		$sql = "select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] 
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) between '$tungay' and '$denngay' group by [MaTienTe]";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getBillEditDetailsByDate( $date ){	
		$sql = "select a.* , b.*  FROM [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] a LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien] b
			ON a.[NVTaoMaNV] = b.MaNV
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'  " ;

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getBillEditDetailsByMonth( $month ){	
		$sql = "select a.* , b.*  FROM [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] a LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien] b
			ON a.[NVTaoMaNV] = b.MaNV
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,8 ) = '$month'  " ;

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getBillEditDetailsBySelection( $tungay, $denngay ){
		$sql = "select a.* , b.*  FROM [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] a LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien] b
			ON a.[NVTaoMaNV] = b.MaNV
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) between '$tungay' and '$denngay' " ;

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItemByDate( $date ) {
		$sql = "SELECT a.*, b.*,c.* FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' ";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItemByMonth ( $month ) {
		$sql = "SELECT a.*, b.*,c.* FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month' ";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItemBySelection ( $tungay, $denngay ) {
		$sql = "SELECT a.*, b.*,c.* FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a LEFT JOIN [GOLDENLOTUS_Q3].[dbo].[tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) between '$tungay' and '$denngay' " ;
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSumFoodCancelledByDate( $date ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' group by TenHangBan ";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSumFoodCancelledByMonth ( $month ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month'  group by TenHangBan";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSumFoodCancelledBySelection ( $tungay, $denngay ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) between '$tungay' and '$denngay'  group by TenHangBan " ;
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesByTableID ( $date, $occupation = null ){
		if( $occupation == '0' && $occupation != null )
		{
			$sql = "SELECT a.MaBan, sum(TienThucTra) as DoanhThu  from  [GOLDENLOTUS_Q3].[dbo].[tblDMBan] a left join [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '2015/08/19' where [ThoiGianDongPhieu] IS NOT NULL  group by a.MaBan order by DoanhThu DESC";
		}
		elseif ( $occupation == '1' )
		{
			$sql = "SELECT a.MaBan, sum(TienThucTra) as DoanhThu  from  [GOLDENLOTUS_Q3].[dbo].[tblDMBan] a 
					left join [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan	
					and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
					= '2015/08/19' where [ThoiGianDongPhieu] is   null 
					group by a.MaBan order by DoanhThu DESC";
		}
		elseif ( $occupation == null)
		{
			$sql = "SELECT a.MaBan, sum(TienThucTra) as DoanhThu from  [GOLDENLOTUS_Q3].[dbo].[tblDMBan]a left join [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan	and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
				= '2015/08/19' group by a.MaBan order by DoanhThu DESC";
		}

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesByFoodNames ( $date, $table_id, $occupation = null ){

		if( $occupation == '0' && $occupation != null )
		{
		 	$sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
					sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
				 from [GOLDENLOTUS_Q3].[dbo].[tblDMBan] a
				 left join [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b
				 on a.[MaBan] = b.[MaBan]
				 join  [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] c
				 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
				 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'

				 and a.MaBan ='$table_id'";
		}
		elseif( $occupation == '1' )
		{
			$sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
				sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
			 from [GOLDENLOTUS_Q3].[dbo].[tblDMBan] a
			 left join [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b
			 on a.[MaBan] = b.[MaBan]
			 join  [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] c
			 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
			 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'

			 and a.MaBan ='$table_id'";
		}
		elseif ( $occupation == null)
		{
			$sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
				sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
			 from [GOLDENLOTUS_Q3].[dbo].[tblDMBan] a
			 left join [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b
			 on a.[MaBan] = b.[MaBan]
			 join  [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] c
			 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
			 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'
			 and a.MaBan ='$table_id'";
		}

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getQtyOrderSummary( $date ) {
		$sql = " SELECT SUM(CASE WHEN SoLuong<=1 THEN 1 ELSE 0 END) as LessThanOrEqualTo1,
			 SUM(CASE WHEN SoLuong between 1 and 2 THEN 1 ELSE 0 END) as From1To2,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From2To3,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From3To4,
			 SUM(CASE WHEN SoLuong >=4 THEN 1 ELSE 0 END) as GreaterThan4
			 from
				(select a.MaLichSuPhieu, sum (SoLuong) as SoLuong
				from [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] a Join
				[GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] b
				on   a.MaLichSuPhieu = b.MaLichSuPhieu Where 
				substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date'
				group by a.MaLichSuPhieu) t1";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesAmountSummary( $date ) {
		$sql = "SELECT SUM(CASE WHEN TienThucTra<=500000 THEN 1 ELSE 0 END) as LessThanOrEqualToHalfMil,
				 SUM(CASE WHEN TienThucTra between 500000 and 1000000 THEN 1 ELSE 0 END) as FromHalfMilTo1,
				 SUM(CASE WHEN TienThucTra between 1000000 and 2000000 THEN 1 ELSE 0 END) as From1To2,
				 SUM(CASE WHEN TienThucTra between 2000000 and 3000000 THEN 1 ELSE 0 END) as From2To3,
				 SUM(CASE WHEN TienThucTra between 3000000 and 4000000 THEN 1 ELSE 0 END) as From3To4,
				 SUM(CASE WHEN TienThucTra >=4000000 THEN 1 ELSE 0 END) as GreaterThan4
				 from
					(
					select a.MaLichSuPhieu, sum (TienThucTra) as TienThucTra
					from [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] a  Where 
					substring( Convert(varchar,ThoiGianTaoPhieu,111),0,11 ) ='$date'
					group by a.MaLichSuPhieu
					) t1
				";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getFoodSoldQtyByHour( $date, $nhom_hang_ban = null ){

		if( $nhom_hang_ban == null)
		{
			$sql = "select
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '08:00:00' and '08:59:59' THEN SoLuong ELSE 0 END) as '08h-09h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '09:00:00' and '09:59:59' THEN SoLuong ELSE 0 END) as '09h-10h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '10:00:00' and '10:59:59' THEN SoLuong ELSE 0 END) as '10h-11h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '11:00:00' and '11:59:59' THEN SoLuong ELSE 0 END) as '11h-12h',	
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '12:00:00' and '12:59:59' THEN SoLuong ELSE 0 END) as '12h-13h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '13:00:00' and '13:59:59' THEN SoLuong ELSE 0 END) as '13h-14h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '14:00:00' and '14:59:59' THEN SoLuong ELSE 0 END) as '14h-15h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '15:00:00' and '15:59:59' THEN SoLuong ELSE 0 END) as '15h-16h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '16:00:00' and '16:59:59' THEN SoLuong ELSE 0 END) as '16h-17h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '17:00:00' and '17:59:59' THEN SoLuong ELSE 0 END) as '17h-18h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '18:00:00' and '18:59:59' THEN SoLuong ELSE 0 END) as '18h-19h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '19:00:00' and '19:59:59' THEN SoLuong ELSE 0 END) as '19h-20h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '20h-21h'
				from [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan]
				where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'
				";
		}
		else 
		{
			 $sql = "select
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '08:00:00' and '08:59:59' THEN SoLuong ELSE 0 END) as '08h-09h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '09:00:00' and '09:59:59' THEN SoLuong ELSE 0 END) as '09h-10h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '10:00:00' and '10:59:59' THEN SoLuong ELSE 0 END) as '10h-11h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '11:00:00' and '11:59:59' THEN SoLuong ELSE 0 END) as '11h-12h',	
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '12:00:00' and '12:59:59' THEN SoLuong ELSE 0 END) as '12h-13h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '13:00:00' and '13:59:59' THEN SoLuong ELSE 0 END) as '13h-14h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '14:00:00' and '14:59:59' THEN SoLuong ELSE 0 END) as '14h-15h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '15:00:00' and '15:59:59' THEN SoLuong ELSE 0 END) as '15h-16h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '16:00:00' and '16:59:59' THEN SoLuong ELSE 0 END) as '16h-17h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '17:00:00' and '17:59:59' THEN SoLuong ELSE 0 END) as '17h-18h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '18:00:00' and '18:59:59' THEN SoLuong ELSE 0 END) as '18h-19h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '19:00:00' and '19:59:59' THEN SoLuong ELSE 0 END) as '19h-20h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '20h-21h'
				from [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a
					Left join [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] b
					on a.MaHangBan = b.MaHangBan
					left join [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] c
					on b.[MaNhomHangBan] = c.[Ma]
					where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'
					and b.[MaNhomHangBan]='$nhom_hang_ban'
				";
		}
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}

	}

	public function getSalesAmountByHour( $date, $nhom_hang_ban = null ){

		if( $nhom_hang_ban == null)
		{
			$sql = "select
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '08:00:00' and '08:59:59' THEN ThanhTien ELSE 0 END) as '08h-09h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '09:00:00' and '09:59:59' THEN ThanhTien ELSE 0 END) as '09h-10h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '10:00:00' and '10:59:59' THEN ThanhTien ELSE 0 END) as '10h-11h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '11:00:00' and '11:59:59' THEN ThanhTien ELSE 0 END) as '11h-12h',	
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '12:00:00' and '12:59:59' THEN ThanhTien ELSE 0 END) as '12h-13h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '13:00:00' and '13:59:59' THEN ThanhTien ELSE 0 END) as '13h-14h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '14:00:00' and '14:59:59' THEN ThanhTien ELSE 0 END) as '14h-15h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '15:00:00' and '15:59:59' THEN ThanhTien ELSE 0 END) as '15h-16h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '16:00:00' and '16:59:59' THEN ThanhTien ELSE 0 END) as '16h-17h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '17:00:00' and '17:59:59' THEN ThanhTien ELSE 0 END) as '17h-18h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '18:00:00' and '18:59:59' THEN ThanhTien ELSE 0 END) as '18h-19h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '19:00:00' and '19:59:59' THEN ThanhTien ELSE 0 END) as '19h-20h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '20h-21h'
							
						from [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan]

						where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'
				";
		}
		else 
		{
			$sql = "select
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '08:00:00' and '08:59:59' THEN ThanhTien ELSE 0 END) as '08h-09h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '09:00:00' and '09:59:59' THEN ThanhTien ELSE 0 END) as '09h-10h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '10:00:00' and '10:59:59' THEN ThanhTien ELSE 0 END) as '10h-11h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '11:00:00' and '11:59:59' THEN ThanhTien ELSE 0 END) as '11h-12h',	
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '12:00:00' and '12:59:59' THEN ThanhTien ELSE 0 END) as '12h-13h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '13:00:00' and '13:59:59' THEN ThanhTien ELSE 0 END) as '13h-14h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '14:00:00' and '14:59:59' THEN ThanhTien ELSE 0 END) as '14h-15h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '15:00:00' and '15:59:59' THEN ThanhTien ELSE 0 END) as '15h-16h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '16:00:00' and '16:59:59' THEN ThanhTien ELSE 0 END) as '16h-17h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '17:00:00' and '17:59:59' THEN ThanhTien ELSE 0 END) as '17h-18h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '18:00:00' and '18:59:59' THEN ThanhTien ELSE 0 END) as '18h-19h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '19:00:00' and '19:59:59' THEN ThanhTien ELSE 0 END) as '19h-20h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '20h-21h'
							
					from [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] b
						Left join [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] c
						on b.MaHangBan = c.MaHangBan
						left join [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] d
						on c.[MaNhomHangBan] = d.[Ma]
					where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'
					and c.[MaNhomHangBan]='$nhom_hang_ban'
				";
		}
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}

	}

	public function getNDMNhomHangBan() {
		$sql = "select * from [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan] order By Ten";
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getChiNhanh(){
		$sql="SELECT * FROM tblDMTrungTam Order by MaTrungTam";
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getAllFoodItems(){
		$sql=" SELECT a.MaHangBan, a.TenHangBan , b.MaHangBan, b.Gia FROM [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] a   join [GOLDENLOTUS_Q3].[dbo].[tblGiaBanHang] b ON a.[MaHangBan] = b.[MaHangBan] WHERE MaNhomHangBan IS NOT NULL";
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getAllFoodGroups(){
		$sql="SELECT * FROM [GOLDENLOTUS_Q3].[dbo].[tblDMNhomHangBan]  order by ten";
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getFoodItemsByGroup( $food_group ) {
		$sql=" SELECT a.MaHangBan, a.TenHangBan , b.MaHangBan, b.Gia FROM [GOLDENLOTUS_Q3].[dbo].[tblDMHangBan] a   join [GOLDENLOTUS_Q3].[dbo].[tblGiaBanHang] b ON a.[MaHangBan] = b.[MaHangBan] AND MaNhomHangBan = '$food_group' AND MaNhomHangBan IS NOT NULL";
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				else die( print_r( sqlsrv_errors(), true ) );
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getTotalSales( $today ) {
		$sql="select sum(TienThucTra) as TienThucTra from [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null and substring( Convert(varchar,[GioVao],111),0,11 ) =  '$today'";
		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				//while
				$r = sqlsrv_fetch_array( $rs );

				if( $rs != false) 
					return $r;
				else die( print_r( sqlsrv_errors(), true ) );
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}


}