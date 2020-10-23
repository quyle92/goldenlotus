<?php
class DbConnection {

	protected $serverName = "DELL-PC\SQLEXPRESS";
	protected $connectionInfo = array( "Database"=>"NH_STEAK_PIZZA","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
	protected $conn;

	function __construct() {
			$this->conn =  sqlsrv_connect( $this->serverName, $this->connectionInfo) or die("Database Connection Error"."<br>". mssql_get_last_message()); 
    }
}

class GoldenLotus extends DbConnection{

	public function layMaNV() {
		$sql = "SELECT *  FROM [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien]";
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
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblDMBaoCao] ";
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
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [NH_STEAK_PIZZA].[dbo].[tblDSNguoiSD] a,  [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b where a.MaNhanVien = b.MaNV 		";
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
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblDMBaoCao] WHERE [MaBaoCao] = '$ma_bao_cao' ";
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
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [NH_STEAK_PIZZA].[dbo].[tblDSNguoiSD] a,  [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b where a.MaNhanVien = b.MaNV and MaNV ='$maNV'	";
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

	public function xoaUser( $maNV ){
		$sql = "DELETE FROM  [NH_STEAK_PIZZA].[dbo].[tblDSNguoiSD] where [MaNhanVien] = '$maNV'";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countOccupiedTables() : int {
		$sql = "SELECT * FROM  [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] where [ThoiGianDongPhieu] IS NULL";
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
		$sql = "SELECT * FROM  [NH_STEAK_PIZZA].[dbo].[tblDMBan]";
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

	public function getFoodSoldThisMonth ($thang_nay) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_nay' and SoLuong >0";
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

	public function getFoodSoldLastMonth ($thang_truoc) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_truoc' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if($rs != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldAnotherMonth ($thang_khac) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_khac' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			//$r=sqlsrv_fetch_array($rs); 
			if( $rs != false) 
				return $rs;
			else throw new \Exception('Sth wrong. Please try again.');
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldToday($hom_nay) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_nay' and SoLuong >0";
		try{
			$rs = sqlsrv_query($this->conn, $sql);
			
			if( $rs != false) 
				return $rs;
			else   die(print_r(sqlsrv_errors(), true));
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldYesterday($hom_truoc) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_truoc' and SoLuong >0";
		try{
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

	public function getFoodSoldAnotherDay($hom_khac) {
		$sql = "SELECT * FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_khac' and SoLuong >0";
		try{
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

	public function getBillDetailsToday($today){
		 $sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a JOIN  [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$today' and SoLuong >0 ";
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
		 $sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a JOIN  [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$yesterday' and SoLuong >0"; 
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
		  $sql = "SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, count( * ) FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a JOIN  [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='2020/08' and SoLuong >0 GROUP BY substring( Convert(varchar,ThoiGianBan,111),0,11 ) ";
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
		$sql = "SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, count( * ) FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a , [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b, [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_CTThanhToan] c WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' AND SoLuong >0 AND a.MaLichSuPhieu=b.MaLichSuPhieu  GROUP BY substring( Convert(varchar,ThoiGianBan,111),0,11 )";
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
		$sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a JOIN  [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0 ";
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
		$sql = "SELECT  b.*, c.[MaLoaiThe] FROM  [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b  LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,111),0,11 ) ='$date' ";
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
		$sql = "select Ten from  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a 
 LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhomHangBan] c 
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

	 	$sql_2 = "select Ten from  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a 
		 LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhomHangBan] c 
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
		  FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] p 
		  JOIN [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhomHangBan] c 
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

	 	$sql_2 = "select Ten from  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a 
		 LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhomHangBan] c 
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
		  FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] p 
		  JOIN [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhomHangBan] c 
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

	 	$sql_2 = "select Ten from  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a 
		 LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhomHangBan] c 
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
		  FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] p 
		  JOIN [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhomHangBan] c 
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
		$sql = "select Ma, Ten, sum (TotalMoney) as DoanhThu  from [NH_STEAK_PIZZA].[dbo].[tblDMNhomHangBan] x
right Join 
(	select t1.[MaNhomHangBan], t1.MaHangBan, t2.SoLuong, t2.DonGia, 
	t2.SoLuong * t2.DonGia as TotalMoney
	from [NH_STEAK_PIZZA].[dbo].[tblDMHangBan] t1
	left join (
		select MaHangBan, [TenHangBan], SoLuong, DonGia  from
		[NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan]
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
		$sql = "select Ma, Ten, sum (TotalMoney) as DoanhThu  from [NH_STEAK_PIZZA].[dbo].[tblDMNhomHangBan] x
		right Join 
		(	select t1.[MaNhomHangBan], t1.MaHangBan, t2.SoLuong, t2.DonGia, 
			t2.SoLuong * t2.DonGia as TotalMoney
			from [NH_STEAK_PIZZA].[dbo].[tblDMHangBan] t1
			left join (
				select MaHangBan, [TenHangBan], SoLuong, DonGia  from
				[NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan]
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
		FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) = '$date' group by TenHangBan";

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
		FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) = '$month' group by TenHangBan";

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
		FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' group by TenHangBan";

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
		$sql = "  select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] 
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
		$sql = "select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] 
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
		$sql = "select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] 
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
		$sql = "select a.* , b.*  FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] a LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b
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
		$sql = "select a.* , b.*  FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] a LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b
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
		$sql = "select a.* , b.*  FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] a LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b
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
		$sql = "SELECT a.*, b.*,c.* FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' ";

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
		$sql = "SELECT a.*, b.*,c.* FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month' ";

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
		$sql = "SELECT a.*, b.*,c.* FROM [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] a LEFT JOIN [NH_STEAK_PIZZA].[dbo].[tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) between '$tungay' and '$denngay' " ;
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
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' group by TenHangBan ";

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
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month'  group by TenHangBan";

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
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) between '$tungay' and '$denngay'  group by TenHangBan " ;
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
			$sql = "SELECT MaBan, sum(DoanhThu) as DoanhThu FROM
					( select  distinct TenHangBan, a.MaBan, b.[MaLichSuPhieu], 
					sum(SoLuong*DonGia)  OVER(PARTITION BY a.MaBan, b.[MaLichSuPhieu],TenHangBan) AS DoanhThu
					from [NH_STEAK_PIZZA].[dbo].[tblDMBan] a
					left join [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b on  a.[MaBan] = b.[MaBan]
					left join  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] c on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
					 and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
					= '$date' 
					Where [ThoiGianDongPhieu] IS  NULL) t1
				Group By MaBan";
		}
		elseif ( $occupation == '1' )
		{
			$sql = "SELECT MaBan, sum(DoanhThu) as DoanhThu FROM
					( select  distinct TenHangBan, a.MaBan, b.[MaLichSuPhieu], 
					sum(SoLuong*DonGia)  OVER(PARTITION BY a.MaBan, b.[MaLichSuPhieu],TenHangBan) AS DoanhThu
					from [NH_STEAK_PIZZA].[dbo].[tblDMBan] a
					left join [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b on  a.[MaBan] = b.[MaBan]
					left join  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] c on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
					 and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
					= '$date' 
					 Where [ThoiGianDongPhieu] IS NOT NULL) t1
				Group By MaBan";
		}
		elseif ( $occupation == null)
		{
			$sql = "SELECT MaBan, sum(DoanhThu) as DoanhThu FROM
					( select  distinct TenHangBan, a.MaBan, b.[MaLichSuPhieu], 
					sum(SoLuong*DonGia)  OVER(PARTITION BY a.MaBan, b.[MaLichSuPhieu],TenHangBan) AS DoanhThu
					from [NH_STEAK_PIZZA].[dbo].[tblDMBan] a
					left join [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b on  a.[MaBan] = b.[MaBan]
					left join  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] c on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
					 and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
					= '$date' ) t1
				Group By MaBan";
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
		echo	 $sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
					sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
				 from [NH_STEAK_PIZZA].[dbo].[tblDMBan] a
				 left join [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b
				 on a.[MaBan] = b.[MaBan]
				 join  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] c
				 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
				 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '2020/08/26'
				 and [ThoiGianDongPhieu] IS  NULL
				 and a.MaBan ='$table_id'";
		}
		elseif( $occupation == '1' )
		{
			$sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
				sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
			 from [NH_STEAK_PIZZA].[dbo].[tblDMBan] a
			 left join [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b
			 on a.[MaBan] = b.[MaBan]
			 join  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] c
			 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
			 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '2020/08/26'
			 and [ThoiGianDongPhieu] IS NOT NULL
			 and a.MaBan ='$table_id'";
		}
		elseif ( $occupation == null)
		{
			$sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
				sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
			 from [NH_STEAK_PIZZA].[dbo].[tblDMBan] a
			 left join [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] b
			 on a.[MaBan] = b.[MaBan]
			 join  [NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] c
			 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
			 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '2020/08/26'
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
				from [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] a Join
				[NH_STEAK_PIZZA].[dbo].[tblLSPhieu_HangBan] b
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
					from [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu] a  Where 
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








}