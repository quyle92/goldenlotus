<?php
ini_set('mssql.charset', 'UTF-8');
$opt = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];
$dbCon = new PDO('odbc:Driver=FreeTDS; Server=14.161.7.235; Port=14333; Database=HOANGSEN; TDS_Version=8.0; Client Charset=UTF-8', 'hoangsen', 'golden@123', $opt);

class GoldenLotus{

	/* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
		$this->includeFile();//include_once('../helper/custom-function.php');
	}
	
	public function includeFile() {
		include_once(__DIR__ . '/../helper/custom-function.php');
	}
	
	public function layMaNV() {
		$sql = "SELECT *  FROM [HOANGSEN].[dbo].[tblDMNhanVien]";
		try{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			//$r=sqlsrv_fetch_array($rs); 
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
	
	public function insertBaoCao( $report_name, $report_name_eng ){

		$ma_bao_cao = changeTitle($report_name);
		$report_name_eng = ucwords($report_name_eng);
		$report_name = ucwords($report_name);
		$sql = "INSERT INTO [HOANGSEN].[dbo].[tblDMBaoCao] (MaBaoCao, TenBaoCao, TenBaoCaoNN) VALUES ('$ma_bao_cao', N'$report_name', '$report_name_eng' )";
		try {
			$rs = $this->conn->query($sql);
		
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	
	public function getMaTrungTam(){
		$sql = "SELECT * FROM [HOANGSEN].[dbo].[tblDMTrungTam] ";
		try {
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
			
				return $rs;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layTatCaBaoCao(){
		$sql = "SELECT * FROM [HOANGSEN].[dbo].[tblDMBaoCao] ";
		try {
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
			
				return $rs;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layDanhSachUsers() {
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [HOANGSEN].[dbo].[tblDSNguoiSD] a,  [HOANGSEN].[dbo].[tblDMNhanVien] b where a.MaNhanVien = b.MaNV 		";
		try{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			//$r=sqlsrv_fetch_array($rs); 
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
	
	public function updateUser( $maNV, $report_arr ){
		$sql = "UPDATE [HOANGSEN].[dbo].[tblDSNguoiSD] SET [BaoCaoDuocXem] = '$report_arr' where MaNhanVien ='$maNV'";
			try
			{
				$rs = $this->conn->query($sql);
				$_SESSION['update_success'] = 1;
				//header("Location : user-update.php?maNV=" . $maNV);exit();
				echo "<script>parent.history.go(-1);</script>";
				
			}

			catch ( PDOException $error ){
				echo $error->getMessage();
			}	
	}

	public function layBaoCao( $ma_bao_cao ){
		$sql = "SELECT * FROM [HOANGSEN].[dbo].[tblDMBaoCao] WHERE [MaBaoCao] = '$ma_bao_cao' ";
		try {
			$rs = $this->conn->query($sql)->fetchColumn();
						
				return $rs['TenBaoCao'];
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layTenUser($maNV) {
		 $sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [HOANGSEN].[dbo].[tblDSNguoiSD] a,  [HOANGSEN].[dbo].[tblDMNhanVien] b where a.MaNhanVien = b.MaNV and MaNV ='$maNV'";
		try{
			$rs = $this->conn->query($sql)->fetch();
			
				return $rs;
			
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
		if ($repass != $password) 	{$thanhcong=false; $loi[]="new password does not match";} 

		if ( $thanhcong==true )
		{
			$sql = "UPDATE [HOANGSEN].[dbo].[tblDSNguoiSD] SET [MatKhau] = PWDENCRYPT('$password') where MaNV ='$maNV'";
			try
			{
				$rs = $this->conn->query($sql);
				
			}

			catch ( PDOException $error ){
				echo $error->getMessage();
			}
		}

		return $thanhcong;
		
	}

	public function xoaUser( $maNV ){
		$sql = "DELETE FROM  [HOANGSEN].[dbo].[tblDSNguoiSD] where [MaNhanVien] = '$maNV'";
		try{
			$rs = $this->conn->query($sql);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countOccupiedTables() : int {
		$sql = "SELECT count(*) FROM  [HOANGSEN].[dbo].[tblLichSuPhieu] where [ThoiGianDongPhieu] IS NULL";
		try 
		{
			$nRows = $this->conn->query($sql)->fetchColumn();

			return $nRows;

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countTotalTables() : int {
		$sql = "SELECT count(*) FROM  [HOANGSEN].[dbo].[tblDMBan]";
		try 
		{
			$nRows = $this->conn->query($sql)->fetchColumn();

			return $nRows;

		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}

	}

	public function getFoodSoldThisMonth ($thang_nay, &$total = null ) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_nay' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_nay' and SoLuong >0";
		try{
			$rs_1 = $this->conn->query($sql)->fetchColumn();
			$total=$rs_1[0];

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldLastMonth ($thang_truoc, &$total = null) {

		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_truoc' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_truoc' and SoLuong >0";

		try{
			
			$rs_1 = $this->conn->query($sql)->fetchColumn();
			$total=$rs_1[0];

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;

		}

		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldAnotherMonth ($thang_khac, &$total = null) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_khac' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$thang_khac' and SoLuong >0";

		try{

			$rs_1 = $this->conn->query($sql)->fetchColumn();
			$total=$rs_1[0];

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldToday($hom_nay, &$total) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_nay' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_nay' and SoLuong >0";

		try{

			$rs_1 = $this->conn->query($sql)->fetchColumn();
			$total=$rs_1[0];
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldYesterday($hom_truoc, &$total = null) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_truoc' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_truoc' and SoLuong >0";

		try{

			$rs_1 = $this->conn->query($sql)->fetchColumn();
			$total=$rs_1[0];
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldAnotherDay($hom_khac, &$total = null) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_khac' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_khac' and SoLuong >0";

		try{

			$rs_1 = $this->conn->query($sql)->fetchColumn();
			$total=$rs_1[0];
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsToday($today, &$count ){
		 $sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a JOIN  [HOANGSEN].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [HOANGSEN].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$today' and SoLuong >0 ";
		try{

			$stmt = $this->conn->prepare( $sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();
			$count = (int) $stmt->rowCount();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsYesterday( $yesterday, &$count = null){
		 $sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a JOIN  [HOANGSEN].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [HOANGSEN].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$yesterday' and SoLuong >0"; 
		try{

			$stmt = $this->conn->prepare( $sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();
			$count = (int) $stmt->rowCount();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}


	public function getDatesHasBillOfThisMonth( $this_month, &$total_count = null ) {
		  $sql = "SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, count( * ) FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a JOIN  [HOANGSEN].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [HOANGSEN].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$this_month' and SoLuong >0 GROUP BY substring( Convert(varchar,ThoiGianBan,111),0,11 ) ";
		try{

			$stmt = $this->conn->prepare( $sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();
			$total_count = (int) $stmt->rowCount();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}


	public function getDatesHasBillBySelection( $tungay, $denngay, &$total_count = null   ){
		$sql = "SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, count( * ) FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a , [HOANGSEN].[dbo].[tblLichSuPhieu] b, [HOANGSEN].[dbo].[tblLSPhieu_CTThanhToan] c WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' AND SoLuong >0 AND a.MaLichSuPhieu=b.MaLichSuPhieu  GROUP BY substring( Convert(varchar,ThoiGianBan,111),0,11 )";
		try{

			$stmt = $this->conn->prepare( $sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();
			$total_count = (int) $stmt->rowCount();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsByDayOfMonth( $date, &$count ){
		$sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a JOIN  [HOANGSEN].[dbo].[tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [HOANGSEN].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0 ";
		try{

			$stmt = $this->conn->prepare( $sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt->execute();
			$total_count = (int) $stmt->rowCount();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getPayMethodDetailsByDate( $date ){
		$sql = "SELECT  b.*, c.[MaLoaiThe] FROM  [HOANGSEN].[dbo].[tblLichSuPhieu] b  LEFT JOIN [HOANGSEN].[dbo].[tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,111),0,11 ) ='$date' ";

		try{
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	 public function getFoodGroupsByDate( $date ){
		$sql = "select Ten from  [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a 
 LEFT JOIN [HOANGSEN].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [HOANGSEN].[dbo].[tblDMNhomHangBan] c 
ON b.[MaNhomHangBan] = c.[Ma] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0 group by Ten";
		try{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getFoodSoldByGroup( $date, &$nhom_hang_ban_arr, $nhom_hang_ban = "" ){

	 	$sql_2 = "select Ten from  [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a 
		 LEFT JOIN [HOANGSEN].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [HOANGSEN].[dbo].[tblDMNhomHangBan] c 
		ON b.[MaNhomHangBan] = c.[Ma] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0 group by Ten";
			try{
				$rs_2 = $this->conn->query($sql_2)->fetchAll(PDO::FETCH_ASSOC);
				
				if( $rs_2 != false) 
					{
						//$nhom_hang_ban_arr = sqlsrv_fetch_array( $rs_2 );
						foreach( $rs_2 as $row )
							$nhom_hang_ban_arr[] = $row['Ten'];
					}
				
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
		  FROM [HOANGSEN].[dbo].[tblLichSuPhieu] p 
		  JOIN [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [HOANGSEN].[dbo].[tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [HOANGSEN].[dbo].[tblDMNhomHangBan] c 
		  ON b.[MaNhomHangBan] = c.[Ma] 
		  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and Ten=N'$nhom_hang_ban'
		  and SoLuong >0  ) x  
		  ) y Order by Ten
		 ";

			try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
					return $rs;
				
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getFoodSoldByGroup_Month( $month, &$nhom_hang_ban_arr = "", $nhom_hang_ban = "" ){

	 	$sql_2 = "select Ten from  [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a 
		 LEFT JOIN [HOANGSEN].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [HOANGSEN].[dbo].[tblDMNhomHangBan] c 
		ON b.[MaNhomHangBan] = c.[Ma] WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$month' and SoLuong >0 group by Ten";
			try{
				$rs_2 = $this->conn->query($sql_2)->fetchAll(PDO::FETCH_ASSOC);
				
				if( $rs_2 != false) 
					{
						foreach( $rs_2 as $row )
							$nhom_hang_ban_arr[] = $row['Ten'];
				}
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
		  FROM [HOANGSEN].[dbo].[tblLichSuPhieu] p 
		  JOIN [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [HOANGSEN].[dbo].[tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [HOANGSEN].[dbo].[tblDMNhomHangBan] c 
		  ON b.[MaNhomHangBan] = c.[Ma] 
		  WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$month' and Ten=N'$nhom_hang_ban'
		  and SoLuong >0  ) x  
		  ) y Order by Ten
		 ";


			try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}

			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getFoodSoldByGroup_DateSelected( $tungay, $denngay, &$nhom_hang_ban_arr, $nhom_hang_ban = "" ){

	 	$sql_2 = "select Ten from  [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a 
		 LEFT JOIN [HOANGSEN].[dbo].[tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [HOANGSEN].[dbo].[tblDMNhomHangBan] c 
		ON b.[MaNhomHangBan] = c.[Ma] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' and SoLuong >0 group by Ten";
			try{
				$rs_2 = $this->conn->query($sql_2)->fetchAll(PDO::FETCH_ASSOC);
				
				if( $rs_2 != false) 
					{
						foreach( $rs_2 as $row )
							$nhom_hang_ban_arr[] = $row['Ten'];
				}
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
		  FROM [HOANGSEN].[dbo].[tblLichSuPhieu] p 
		  JOIN [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [HOANGSEN].[dbo].[tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [HOANGSEN].[dbo].[tblDMNhomHangBan] c 
		  ON b.[MaNhomHangBan] = c.[Ma] 
		  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' and Ten=N'$nhom_hang_ban'
		  and SoLuong >0  ) x  
		  ) y Order by Ten
		 ";


			try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesByFoodGroup( $date ){
		$sql = "select Ma, Ten, sum (TotalMoney) as DoanhThu  from [HOANGSEN].[dbo].[tblDMNhomHangBan] x
right Join 
(	select t1.[MaNhomHangBan], t1.MaHangBan, t2.SoLuong, t2.DonGia, 
	t2.SoLuong * t2.DonGia as TotalMoney
	from [HOANGSEN].[dbo].[tblDMHangBan] t1
	left join (
		select MaHangBan, [TenHangBan], SoLuong, DonGia  from
		[HOANGSEN].[dbo].[tblLSPhieu_HangBan]
		where substring ( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' 
		and SoLuong >0 ) t2 
	on t2.MaHangBan = t1.MaHangBan 
) y
ON x.Ma = y.[MaNhomHangBan] group by Ma, Ten";

			try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesByFoodGroupBySelection( $tungay, $denngay ){
		$sql = "select Ma, Ten, sum (TotalMoney) as DoanhThu  from [HOANGSEN].[dbo].[tblDMNhomHangBan] x
		right Join 
		(	select t1.[MaNhomHangBan], t1.MaHangBan, t2.SoLuong, t2.DonGia, 
			t2.SoLuong * t2.DonGia as TotalMoney
			from [HOANGSEN].[dbo].[tblDMHangBan] t1
			left join (
				select MaHangBan, [TenHangBan], SoLuong, DonGia  from
				[HOANGSEN].[dbo].[tblLSPhieu_HangBan]
				where substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay'
				and SoLuong >0 ) t2 
			on t2.MaHangBan = t1.MaHangBan 
		) y
		ON x.Ma = y.[MaNhomHangBan] group by Ma, Ten";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
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
		FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) = '$date' group by TenHangBan";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
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
		FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) = '$month' group by TenHangBan";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
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
		FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' group by TenHangBan";

		try{
				$rs = sqlsrv_query( $this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
				
				if( $rs != false) 
					return $rs;
				
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCurrencyReportByDate( $date ){
		$sql = "  select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [HOANGSEN].[dbo].[tblLichSuPhieu] 
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'   group by [MaTienTe]";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCurrencyReportByMonth( $month ){
		$sql = "select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [HOANGSEN].[dbo].[tblLichSuPhieu] 
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,8 ) = '$month'  group by [MaTienTe]";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCurrencyReportBySelection( $tungay, $denngay ){
		$sql = "select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [HOANGSEN].[dbo].[tblLichSuPhieu] 
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) between '$tungay' and '$denngay' group by [MaTienTe]";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getBillEditDetailsByDate( $date ){	
		$sql = "select a.* , b.*  FROM [HOANGSEN].[dbo].[tblLichSuPhieu] a LEFT JOIN [HOANGSEN].[dbo].[tblDMNhanVien] b
			ON a.[NVTaoMaNV] = b.MaNV
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'  " ;

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getBillEditDetailsByMonth( $month ){	
		$sql = "select a.* , b.*  FROM [HOANGSEN].[dbo].[tblLichSuPhieu] a LEFT JOIN [HOANGSEN].[dbo].[tblDMNhanVien] b
			ON a.[NVTaoMaNV] = b.MaNV
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,8 ) = '$month'  " ;

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getBillEditDetailsBySelection( $tungay, $denngay ){
		$sql = "select a.* , b.*  FROM [HOANGSEN].[dbo].[tblLichSuPhieu] a LEFT JOIN [HOANGSEN].[dbo].[tblDMNhanVien] b
			ON a.[NVTaoMaNV] = b.MaNV
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) between '$tungay' and '$denngay' " ;

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItemByDate( $date ) {
		$sql = "SELECT a.*, b.*,c.* FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a LEFT JOIN [HOANGSEN].[dbo].[tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [HOANGSEN].[dbo].[tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' ";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItemByMonth ( $month ) {
		$sql = "SELECT a.*, b.*,c.* FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a LEFT JOIN [HOANGSEN].[dbo].[tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [HOANGSEN].[dbo].[tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month' ";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItemBySelection ( $tungay, $denngay ) {
		$sql = "SELECT a.*, b.*,c.* FROM [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a LEFT JOIN [HOANGSEN].[dbo].[tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [HOANGSEN].[dbo].[tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) between '$tungay' and '$denngay' " ;
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSumFoodCancelledByDate( $date ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' group by TenHangBan ";

		try{
				$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSumFoodCancelledByMonth ( $month ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month'  group by TenHangBan";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSumFoodCancelledBySelection ( $tungay, $denngay ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [HOANGSEN].[dbo].[tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) between '$tungay' and '$denngay'  group by TenHangBan " ;
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesByTableID ( $date, $occupation = null ){
		if( $occupation == '0' && $occupation != null )
		{
			$sql = "SELECT count(*) FROM ( SELECT  a.MaBan, sum(TienThucTra) as DoanhThu  from  [HOANGSEN].[dbo].[tblDMBan] a left join [HOANGSEN].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date' where [ThoiGianDongPhieu] IS NOT NULL  group by a.MaBan order by DoanhThu DESC ) t1";
		}
		elseif ( $occupation == '1' )
		{
			$sql = "SELECT count(*) FROM ( SELECT a.MaBan, sum(TienThucTra) as DoanhThu  from  [HOANGSEN].[dbo].[tblDMBan] a 
					left join [HOANGSEN].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan	
					and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
					= '$date' where [ThoiGianDongPhieu] is   null 
					group by a.MaBan order by DoanhThu DESC ) t1";
		}
		elseif ( $occupation == null)
		{
			$sql = "SELECT count(*) FROM 
			( SELECT  a.MaBan, sum(TienThucTra) as DoanhThu from  [HOANGSEN].[dbo].[tblDMBan]a left join [HOANGSEN].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan	and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
				= '$date' group by a.MaBan ) t1";
		}

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$itemcount =(int) $stmt->fetchColumn();//var_dump($itemcount);
				
				$stmt->closeCursor();
				return $itemcount;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}
	
	public function getSalesByTableID_Paginate( $itemcount,  $date, $occupation ){

		$drop_proc_sql = "IF EXISTS (SELECT type_desc, type FROM sys.procedures WITH(NOLOCK)  WHERE NAME = 't1' AND type = 'P'  ) DROP PROCEDURE dbo.t1";
    	$drop_proc_query = $this->conn->query( $drop_proc_sql );
		
		
		if( $occupation == null)
		{
		$proc_sql = "CREATE PROCEDURE  t1  @offset int, @end Int
						AS
						BEGIN 
						SET NOCOUNT ON

						select * from ( SELECT  ROW_NUMBER() OVER 
						(ORDER BY a.MaBan DESC) AS rn, a.MaBan, sum(TienThucTra) as DoanhThu from  
						[HOANGSEN].[dbo].[tblDMBan] a 
						left join [HOANGSEN].[dbo].[tblLichSuPhieu] b on 
						 a.MaBan = b.MaBan	
						 and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'
						 group by a.MaBan  ) t1
						 where rn between  @offset and @end

						END

						
			";
		}
		
				
	
		
		$proc_query = $this->conn->query( $proc_sql );
		//if($occupation == 0) var_dump($proc_query);

		$runs = floor( $itemcount / 100 );
		
		$result = array();
		for ($i = 0; $i <=$runs; $i++) {
			$offset = $i * 100;
			$end = ($i + 1 ) *100;

			$sql = "EXEC t1  @offset = $offset, @end = $end";
		
		try{
				//$rs = $this->conn->query( $sql );
				//$row = $rs->fetchAll(PDO::FETCH_ASSOC);
				//var_dump($rs); 
				//die;
					
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);//var_dump($rs); die;
				//echo sizeof($rs); //var_dump($rs); die;
					foreach( $rs as $r  ){
					
					//while( $r = $stmt->fetch() ){
						 $result[] = array(
							 'MaBan' => $r['MaBan'],
							 'DoanhThu' => $r['DoanhThu'],
							 //'MaBan' => $r['MaBan'],
							 //'DoanhThu' => $r['DoanhThu']
						);
				
					}	
					
				if ( $i == $runs ) 
					//var_dump($result);
					return $result;
			
				
				//$result->closeCursor();
					//$result->finish();
			}

		catch ( PDOException $error ){
				echo $error->getMessage();
			}

		}

		
	}

	public function getSalesByFoodNames ( $date, $table_id, $occupation = null ){

		if( $occupation == '0' && $occupation != null )
		{
		 	$sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
					sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
				 from [HOANGSEN].[dbo].[tblDMBan] a
				 left join [HOANGSEN].[dbo].[tblLichSuPhieu] b
				 on a.[MaBan] = b.[MaBan]
				 join  [HOANGSEN].[dbo].[tblLSPhieu_HangBan] c
				 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
				 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'

				 and a.MaBan ='$table_id'";
		}
		elseif( $occupation == '1' )
		{
			$sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
				sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
			 from [HOANGSEN].[dbo].[tblDMBan] a
			 left join [HOANGSEN].[dbo].[tblLichSuPhieu] b
			 on a.[MaBan] = b.[MaBan]
			 join  [HOANGSEN].[dbo].[tblLSPhieu_HangBan] c
			 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
			 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'

			 and a.MaBan ='$table_id'";
		}
		elseif ( $occupation == null)
		{
			$sql = "SELECT  ROW_NUMBER() OVER (ORDER BY a.MaBan DESC) AS rn, a.MaBan, sum(TienThucTra) as DoanhThu from  [GOLDENLOTUS_Q3].[dbo].[tblDMBan] a left join [GOLDENLOTUS_Q3].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan	and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
= '$date' group by a.MaBan ";
		}

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
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
				from [HOANGSEN].[dbo].[tblLichSuPhieu] a Join
				[HOANGSEN].[dbo].[tblLSPhieu_HangBan] b
				on   a.MaLichSuPhieu = b.MaLichSuPhieu Where 
				substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date'
				group by a.MaLichSuPhieu) t1";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
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
					from [HOANGSEN].[dbo].[tblLichSuPhieu] a  Where 
					substring( Convert(varchar,ThoiGianTaoPhieu,111),0,11 ) ='$date'
					group by a.MaLichSuPhieu
					) t1
				";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
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
				from [HOANGSEN].[dbo].[tblLSPhieu_HangBan]
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
				from [HOANGSEN].[dbo].[tblLSPhieu_HangBan] a
					Left join [HOANGSEN].[dbo].[tblDMHangBan] b
					on a.MaHangBan = b.MaHangBan
					left join [HOANGSEN].[dbo].[tblDMNhomHangBan] c
					on b.[MaNhomHangBan] = c.[Ma]
					where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'
					and b.[MaNhomHangBan]='$nhom_hang_ban'
				";
		}
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
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
							
						from [HOANGSEN].[dbo].[tblLSPhieu_HangBan]

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
							
					from [HOANGSEN].[dbo].[tblLSPhieu_HangBan] b
						Left join [HOANGSEN].[dbo].[tblDMHangBan] c
						on b.MaHangBan = c.MaHangBan
						left join [HOANGSEN].[dbo].[tblDMNhomHangBan] d
						on c.[MaNhomHangBan] = d.[Ma]
					where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'
					and c.[MaNhomHangBan]='$nhom_hang_ban'
				";
		}
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}

	}

	public function getNDMNhomHangBan() {
		$sql = "select * from [HOANGSEN].[dbo].[tblDMNhomHangBan] order By Ten";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
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
				
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getAllFoodItems(){
		$sql=" SELECT a.MaHangBan, a.TenHangBan , b.MaHangBan, b.Gia FROM [HOANGSEN].[dbo].[tblDMHangBan] a   join [HOANGSEN].[dbo].[tblGiaBanHang] b ON a.[MaHangBan] = b.[MaHangBan] WHERE MaNhomHangBan IS NOT NULL";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getAllFoodGroups(){
		$sql="SELECT * FROM [HOANGSEN].[dbo].[tblDMNhomHangBan]  order by ten";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getFoodItemsByGroup( $food_group ) {
		$sql=" SELECT a.MaHangBan, a.TenHangBan , b.MaHangBan, b.Gia FROM [HOANGSEN].[dbo].[tblDMHangBan] a   join [HOANGSEN].[dbo].[tblGiaBanHang] b ON a.[MaHangBan] = b.[MaHangBan] AND MaNhomHangBan = '$food_group' AND MaNhomHangBan IS NOT NULL";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getTotalSales( $today ) {
		$sql="select sum(TienThucTra) as TienThucTra from [HOANGSEN].[dbo].[tblLichSuPhieu] where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null and substring( Convert(varchar,[GioVao],111),0,11 ) =  '$today'";
		try{
				$rs_1 = $this->conn->query($sql)->fetchColumn();
				$total = $rs_1[0];
				
				return $total;
				
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}


}