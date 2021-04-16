<?php
// ini_set('mssql.charset', 'UTF-8');
// $opt = [
//     \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
//     \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
//     \PDO::ATTR_EMULATE_PREPARES   => false,
// ];
// $dbCon = new PDO('odbc:Driver=FreeTDS; Server=14.161.7.235; Port=14333; Database=HOANGSEN; TDS_Version=8.0; Client Charset=UTF-8', 'hoangsen', 'golden@123', $opt);
require 'General.php';
class GoldenLotus extends General{

	/* Properties */
    private $conn;
    private $general;
    private $allowTbl = ['SPA_ALL', 'SPA', 'SNACKBAR', 'CAFE', 'GAME', 'GYM', 'RESTAURANT'];
    private $khu_nam = "(MaKhu = '03-NH1' or MaKhu = '03-NH2' or MaKhu = '03-NH3')";
	private $khu_nu = "(MaKhu = '03-NH4' or MaKhu = '01-NH5' or MaKhu = '01-NH6')";

    /* Get database access */
    public function __construct(\PDO $dbCon) {
        $this->conn = $dbCon;
		$this->includeFile();//include_once('../helper/custom-function.php');
		$this->general = new General($dbCon);
	}

	public function includeFile() {
		include_once(__DIR__ . '/../helper/custom-function.php');
	}

	public function layView( $ma_quay  )
	{	
		$ma_quay =  htmlentities(trim(strip_tags($ma_quay)),ENT_QUOTES,'utf-8');
		$this->general->taoView($ma_quay);
	}
	
	public function layMaNV() {
		$sql = "SELECT *  FROM [tblDMNhanVien]";
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
		$sql = "INSERT INTO [tblDMBaoCao] (MaBaoCao, TenBaoCao, TenBaoCaoNN) VALUES (:ma_bao_cao, :report_name, :report_name_eng )";
		try 
		{	
			$stmt = $this->conn->prepare( $sql );

			$stmt->bindParam(':ma_bao_cao', $ma_bao_cao);
			$stmt->bindParam(':report_name', $report_name);
			$stmt->bindParam(':report_name_eng', $report_name_eng);
			
			$stmt->execute();
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	
	public function getMaTrungTam(){
		$sql = "SELECT * FROM [tblDMTrungTam] ";
		try {
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
			
				return $rs;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layTatCaBaoCao(){
		$sql = "SELECT * FROM [tblDMBaoCao] ";
		try {
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
			
				return $rs;
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layDanhSachUsers() {
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [tblDSNguoiSD] a,  [tblDMNhanVien] b where a.MaNhanVien = b.MaNV and [TenSD] <> 'Admin'";
		try{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			//$r=sqlsrv_fetch_array($rs); 
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
	
	public function updateUser( $tenSD, $report_arr )
	{	
		$tenSD =  htmlentities(trim(strip_tags($tenSD)),ENT_QUOTES,'utf-8');
		$report_arr = base64_encode(serialize($report_arr));
		$report_arr = htmlentities(trim(strip_tags($report_arr)),ENT_QUOTES,'utf-8');	
		
		if( empty($tenSD) ) 
		{
			throw new InvalidArgumentException();
		}

		$sql = "DECLARE @report_arr varchar(max), @tenSD varchar(max)
		SET @report_arr = :report_arr
		SET @tenSD = :tenSD
		UPDATE [tblDSNguoiSD] SET [BaoCaoDuocXem] = @report_arr where TenSD = @tenSD";
			try
			{	
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('report_arr', $report_arr);
				$stmt->bindParam('tenSD', $tenSD);
				
				$stmt->execute();
				$_SESSION['update_success'] = 1;
				//header("Location : user-update.php?maNV=" . $maNV);exit();
				echo "<script>parent.history.go(-1);</script>";
				
			}

			catch ( PDOException $error ){
				echo $error->getMessage();
			}	
	}

	public function layBaoCao( $ma_bao_cao )
	{
		$sql = "DECLARE @ma_bao_cao varchar(max)
		SET @ma_bao_cao = :ma_bao_cao
		SELECT * FROM [tblDMBaoCao] WHERE [MaBaoCao] = @ma_bao_cao";

		try 
		{	
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('ma_bao_cao', $ma_bao_cao);
			
			$stmt->execute();

			$rs = $stmt->fetch(PDO::FETCH_ASSOC);
					
			return $rs['TenBaoCao'];
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layTenUser($tenSD) 
	{
		$tenSD = htmlentities(trim(strip_tags($tenSD)),ENT_QUOTES,'utf-8');

		$sql = "DECLARE @tenSD varchar(max)
		SET @tenSD = :tenSD
		SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [tblDSNguoiSD] a,  [tblDMNhanVien] b where a.MaNhanVien = b.MaNV and tenSD = @tenSD";
		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tenSD', $tenSD);
			
			$stmt->execute();
			$rs =  $stmt->fetch(PDO::FETCH_ASSOC);
			return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getTenQuay()
	{
		$sql = "SELECT distinct TenQuay  FROM [tblDMNhomHangBan] ";
		try{
			$rs = $this->conn->query($sql)->fetchAll();
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getTenQuayTemp()
	{
		$sql = "SET NOCOUNT ON;
		CREATE TABLE TenQuayTemp
			(
			   TenQuay VARCHAR(100)

			) 
		

			INSERT INTO TenQuayTemp
			VALUES
			   ('SPA_ALL'),
			   ('RESTAURANT')

	

			SELECT * FROM TenQuayTemp

			DROP TAble TenQuayTemp";
		try{
			$rs = $this->conn->query($sql)->fetchAll();
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function changePassword( $tenSD, $password, $repass, &$loi ) 
	{
		$thanhcong=true;

		$tenSD = htmlentities(trim(strip_tags($tenSD)),ENT_QUOTES,'utf-8');
		$password = htmlentities(trim(strip_tags($password)),ENT_QUOTES,'utf-8');
		$repass = htmlentities(trim(strip_tags($repass)),ENT_QUOTES,'utf-8');

		if ( $this->general->checkUser( $tenSD ) === false ) 
		{
			throw new InvalidArgumentException('Please don\'t change username!');
		}

		if ($password=="") 	
		{
			$thanhcong=false; 
			$loi[]="new password not entered";
		} 

		if ($repass=="") 
		{
			$thanhcong=false; 
			$loi[]="Pls re-enter new password";
		} 

		if ($repass != $password) 	
		{
			$thanhcong=false; 
			$loi[]="new password does not match";
		} 

		if ( $thanhcong == true )
		{
			$sql = "DECLARE @password varchar(max)
			DECLARE @tenSD varchar(max)
			SET @password = :password
			SET @tenSD = :tenSD
			UPDATE [tblDSNguoiSD] SET [MatKhau] = PWDENCRYPT(@password) where [TenSD] = @tenSD";
			try
			{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('password', $password);
				$stmt->bindParam('tenSD', $tenSD);
				
				$stmt->execute();
				
			}

			catch ( PDOException $error ){
				echo $error->getMessage();
			}
		}

		return $thanhcong;
		
	}

	public function xoaUser( $tenSD ){
		$sql = "DECLARE @tenSD varchar(max)
		SET @tenSD = :tenSD
		DELETE FROM  [tblDSNguoiSD] where [TenSD] = @tenSD";
		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tenSD', $tenSD);
			
			$stmt->execute();

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countOccupiedTables_Day( $tenQuay = null , $tuNgay ) : int {

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}
		
		$sql = "SELECT count(DISTINCT MaBan) FROM  [tblLichSuPhieu] a 
		JOIN [tblLSPhieu_HangBan] b ON a.MaLichSuPhieu = b.MaLichSuPhieu
		JOIN [tblDMHangBan] c ON b.MaHangBan = c.MaHangBan
		where  substring(Convert(varchar,GioVao,126),0,11) = '$tuNgay' and [ThoiGianDongPhieu] IS NULL";

		if ( ! empty($tenQuay) )
		{	
			 $sql .= " AND c.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try 
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNam', $tuNam);
			
			$stmt->execute();

			$nRows = $stmt->fetchColumn();

			return $nRows;

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countOccupiedTables_Month( $tenQuay, $tuThang ) : int {

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "SELECT count(DISTINCT MaBan) FROM  [tblLichSuPhieu] a 
		JOIN [tblLSPhieu_HangBan] b ON a.MaLichSuPhieu = b.MaLichSuPhieu
		JOIN [tblDMHangBan] c ON b.MaHangBan = c.MaHangBan
		where  substring(Convert(varchar,GioVao,126),0,8) = '$tuThang' and [ThoiGianDongPhieu] IS NULL";

		if ( ! empty($tenQuay) )
		{	
			 $sql .= " AND c.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try 
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNam', $tuNam);
			
			$stmt->execute();

			$nRows = $stmt->fetchColumn();

			return $nRows;

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}
	
	public function countOccupiedTables_Year( $tenQuay, $tuNam ) : int {

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNam varchar(max)
		SET @tuNam = :tuNam
		SELECT count(DISTINCT MaBan) FROM  [tblLichSuPhieu] a 
		JOIN [tblLSPhieu_HangBan] b ON a.MaLichSuPhieu = b.MaLichSuPhieu
		JOIN [tblDMHangBan] c ON b.MaHangBan = c.MaHangBan
		where  substring(Convert(varchar,GioVao,126),0,5) = @tuNam and [ThoiGianDongPhieu] IS NULL";

		if ( ! empty($tenQuay) )
		{	
			$sql .= " AND c.TenHangBan IN ( SELECT * FROM {$tenQuay}View )";
		}

		try 
		{	
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNam', $tuNam);
			
			$stmt->execute();

			$nRows = $stmt->fetchColumn();

			return $nRows;

		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countTotalTables() : int {
		$sql = "SELECT count(*) FROM  [tblDMBan]";
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

	

	private function getFoodSoldThisMonth (  &$total = null, $ma_quay = '' ) 
	{
		$sql = "SELECT  distinct TenHangBan, MaDVT,  SUM(SoLuong) OVER(PARTITION BY TenHangBan) AS SoLuong, (DonGia * SUM(SoLuong) OVER(PARTITION BY TenHangBan)) as ThanhTien FROM
  			[tblLSPhieu_HangBan] 
			where substring( Convert(varchar,ThoiGianBan,126),0,8 ) = substring( Convert(varchar,getdate(),126),0,8 )  and SoLuong > 0 ";

		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,126),0,8 ) = substring( Convert(varchar,getdate(),126),0,8 )  and SoLuong > 0 ";

		if ( ! empty($ma_quay) )
		{	
			$sql .= "AND TenHangBan IN ( SELECT * FROM [{$ma_quay}View] )";
			$sql_1 .= "AND TenHangBan IN ( SELECT * FROM [{$ma_quay}View] )";
		}

		try
		{
			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$total = $rs_1;

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}


	private function getFoodSoldLastMonth ( &$total = null, $ma_quay = '' ) {

		$sql = "SELECT  distinct TenHangBan, MaDVT,  SUM(SoLuong) OVER(PARTITION BY TenHangBan) AS SoLuong, (DonGia * SUM(SoLuong) OVER(PARTITION BY TenHangBan)) as ThanhTien FROM
  			[tblLSPhieu_HangBan] 
			where substring( Convert(varchar,ThoiGianBan,126),0,8 ) = substring( Convert(varchar,DATEADD(m, -1, getdate()),126),0,8 )  and SoLuong > 0 ";

		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,126),0,8 ) = substring( Convert(varchar,DATEADD(m, -1, getdate()),126),0,8 )  and SoLuong > 0 ";

		if ( ! empty($ma_quay) )
		{	
			$sql .= "AND TenHangBan IN ( SELECT * FROM [{$ma_quay}View] )";
			$sql_1 .= "AND TenHangBan IN ( SELECT * FROM [{$ma_quay}View] )";
		}

		try
		{
			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$total = $rs_1;

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	private function getFoodSoldAnotherMonth ($tu_thang, $den_thang, &$total = null, $ma_quay = null ) {
		$sql = "SELECT  distinct TenHangBan, MaDVT,  SUM(SoLuong) OVER(PARTITION BY TenHangBan) AS SoLuong, (DonGia * SUM(SoLuong) OVER(PARTITION BY TenHangBan)) as ThanhTien FROM
  			[tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) between '$tu_thang' and '$den_thang' and SoLuong >0";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) between '$tu_thang' and '$den_thang' and SoLuong >0";

		if ( ! empty($ma_quay) )
		{	
			 $sql .= " AND TenHangBan IN ( SELECT * FROM [{$ma_quay}View] )";
			$sql_1 .= " AND TenHangBan IN ( SELECT * FROM [{$ma_quay}View] )";
		}

		try{

			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$total=$rs_1;

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	private function getFoodSoldToday($hom_nay, &$total) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_nay' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_nay' and SoLuong >0";

		try{

			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$total=$rs_1;
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	private function getFoodSoldYesterday($hom_truoc, &$total = null) {
		$sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_truoc' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$hom_truoc' and SoLuong >0";

		try{

			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$total=$rs_1;
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	private function getFoodSoldAnotherDay($tungay, $denngay, &$total = null) {
		 $sql = "SELECT  TenHangBan, MaDVT,SoLuong, (DonGia*SoLuong) as ThanhTien FROM
					( SELECT TenHangBan, MaDVT, sum(SoLuong) as SoLuong, DonGia
					 FROM [tblLSPhieu_HangBan] 
					 where substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' and SoLuong >0
					 Group By TenHangBan, MaDVT, DonGia ) t1 ";
		$sql_1 = "SELECT sum(ThanhTien) as Total FROM [tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay' and SoLuong >0";

		try{

			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$total=$rs_1;
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	private function getDatesHasBillOfThisMonth( $this_month, &$total_count = null ) {
		 $sql = "SELECT substring( Convert(varchar,GioVao,111),0,11 ) as NgayCoBill , count(*) as total
     FROM [tblLichSuPhieu] a
      JOIN  [tblLSPhieu_CTThanhToan] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu 
     WHERE substring( Convert(varchar,GioVao,111),0,8 ) ='$this_month' 
    GROUP BY substring( Convert(varchar,GioVao,111),0,11 )  ";
    
    $sql_1 = "SELECT count(*) FROM ( 
	   	SELECT substring( Convert(varchar,GioVao,111),0,11 ) as NgayCoBill , count(*) as total
	    FROM [tblLichSuPhieu] a
	    JOIN  [tblLSPhieu_CTThanhToan] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu 
	    WHERE substring( Convert(varchar,GioVao,111),0,8 ) ='$this_month' 
	    GROUP BY substring( Convert(varchar,GioVao,111),0,11 )  
    ) t1";
		try{

			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$total_count = $rs_1;

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}


	private function getDatesHasBillBySelection( $tungay, $denngay, &$total_count = null   ){
		 $sql = "SELECT substring( Convert(varchar,GioVao,111),0,11 ) as NgayCoBill , count(*) as total
     FROM [tblLichSuPhieu] a
      JOIN  [tblLSPhieu_CTThanhToan] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu 
     WHERE substring( Convert(varchar,GioVao,111),0,8 )  between '$tungay' and '$denngay'
    GROUP BY substring( Convert(varchar,GioVao,111),0,11 )  ";
    
    $sql_1 = "SELECT count(*) FROM ( 
	   	SELECT substring( Convert(varchar,GioVao,111),0,11 ) as NgayCoBill , count(*) as total
	    FROM [tblLichSuPhieu] a
	    JOIN  [tblLSPhieu_CTThanhToan] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu 
	    WHERE substring( Convert(varchar,GioVao,111),0,8 ) between '$tungay' and '$denngay'
	    GROUP BY substring( Convert(varchar,GioVao,111),0,11 )  
    ) t1";
		try{

			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$total_count = $rs_1;

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	private function getBillDetailsByDayOfMonth( $date, &$count = null ){
		$sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [tblLSPhieu_HangBan] a JOIN  [tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0 ";
		 $sql_1 = "SELECT count(*) FROM ( SELECT  c.[MaLoaiThe] FROM [tblLSPhieu_HangBan] a JOIN  [tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0) t1 ";
		try{

			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$count = $rs_1;
			
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
	
	public function getBillDetails_Rec_Day( $tenQuay, $tuNgay, $where , $paginating )
	{
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		if( empty($paginating) || strpos($paginating, 'RowNum') === false) 
		{
			throw new InvalidArgumentException('paginating missing');
		}

	   $sql = "SET NOCOUNT ON;
	   IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END
	   	DECLARE @tuNgay varchar(max)
		SET @tuNgay = :tuNgay
		select * into #temp_t1 FROM ( SELECT a.MaLichSuPhieu, substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, b.ThoiGianBan, b.TenHangBan, b.DonGia, b.SoLuong, a.TienGiamGia, a.NVTinhTienMaNV, a.SoTienDVPhi, a.SoTienVAT,  c.[MaLoaiThe], null as Discount, ThanhTien = DonGia * b.SoLuong - TienGiamGia -SoTienDVPhi - SoTienVAT, RowNum = row_number() over (order by a.MaLichSuPhieu),
	   	   Tongtien =  DonGia * b.SoLuong, CheckIn = substring( Convert(varchar,GioVao,126),12,5 ),  CheckOut = substring( Convert(varchar,ThoiGianDongPhieu,126),12,5 ) 
		FROM [tblLichSuPhieu] a 
		JOIN [tblLSPhieu_HangBan] b
		ON a.MaLichSuPhieu=b.MaLichSuPhieu  
		JOIN [tblLSPhieu_CTThanhToan] c
		ON b.MaLichSuPhieu=c.MaLichSuPhieu 
		WHERE substring( Convert(varchar,b.ThoiGianBan,126),0,11) = @tuNgay and b.SoLuong > 0
		 ";

		if ( ! empty($tenQuay) )
		{	
			$sql .= " AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		if ( $where == '')
	    {
	    	$sql .= ' ) t1 SELECT * FROM   #temp_t1 WHERE ' . $paginating;
	    	$sql .= " UNION ALL SELECT MaLichSuPhieu, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, SUM(ThanhTien), NULL, NULL FROM #temp_t1 ";
	    	$sql .= " WHERE ". $paginating ;
	    	$sql .= " GROUP BY MaLichSuPhieu ORDER BY MaLichSuPhieu, TenHangBan";
	    	 $sql .= " SELECT GrandTotal = sum(Tongtien) FROM  #temp_t1
	    	DROP TABLE #temp_t1";
	    } 
	    else
	    {	
	    	$sql .= '  ) t1
	with cte_1 as (
		SELECT  RowNum = row_number() over (order by MaLichSuPhieu), NgayCoBill, ThoiGianBan, MaLichSuPhieu, TenHangBan, DonGia, SoLuong, TienGiamGia, NVTinhTienMaNV, SoTienDVPhi, SoTienVAT,  [MaLoaiThe],  null as Discount, ThanhTien , Tongtien, CheckIn, CheckOut
		FROM #temp_t1 
		WHERE ' . $where . '
	)

	SELECT * FROM   cte_1';

	    	 $sql .= " WHERE " .  $paginating ;
	    	 $sql .= " SELECT GrandTotal = sum(Tongtien) FROM  #temp_t1
	    	DROP TABLE #temp_t1";
	    }
	  
		try{

	     	$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNgay', $tuNgay);
			
			$stmt->execute();
			$rowset =  array();
			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($stmt->nextRowset());

			return $rowset;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetails_Tot_Day(  $tenQuay, $tuNgay, $where )
	{
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		 WITH cte AS ( SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, b.ThoiGianBan, a.MaLichSuPhieu,b.TenHangBan, b.DonGia, b.SoLuong, a.TienGiamGia, a.NVTinhTienMaNV, a.SoTienDVPhi, a.SoTienVAT,  c.[MaLoaiThe], null AS Floor, null AS Note, null as Discount, ThanhTien = DonGia * SoLuong - TienGiamGia -SoTienDVPhi - SoTienVAT, Tongtien,  RowNum = row_number() over (order by a.MaLichSuPhieu)
			FROM [tblLichSuPhieu] a 
			JOIN [tblLSPhieu_HangBan] b
			ON a.MaLichSuPhieu=b.MaLichSuPhieu  
			JOIN [tblLSPhieu_CTThanhToan] c
			ON b.MaLichSuPhieu=c.MaLichSuPhieu
			WHERE substring( Convert(varchar, b.ThoiGianBan,126),0,11) = @tuNgay and SoLuong >0 
			";

		if ( ! empty($tenQuay) )
		{	
			 $sql .= " AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		 $sql .= " ) SELECT count(*) FROM   cte  ";

		if( $where != "" ){

	     	$sql .= " WHERE ";

	     	$sql .= $where;

     	}

		try{ //var_dump($sql);die;

	     	$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNgay', $tuNgay);
			
			$stmt->execute();

			$rs = $stmt->fetchColumn();
		
			return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetails_Rec_Month( $tenQuay, $tuThang, $where , $paginating )
	{
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		if( empty($paginating) || strpos($paginating, 'RowNum') === false) 
		{
			throw new InvalidArgumentException('paginating missing');
		}

	   $sql = "SET NOCOUNT ON;
	   IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END
	   	DECLARE @tuThang varchar(max)
		SET @tuThang = :tuThang
		select * into #temp_t1 FROM ( SELECT a.MaLichSuPhieu, substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, b.ThoiGianBan, b.TenHangBan, b.DonGia, b.SoLuong, a.TienGiamGia, a.NVTinhTienMaNV, a.SoTienDVPhi, a.SoTienVAT,  c.[MaLoaiThe], null as Discount, ThanhTien = DonGia * b.SoLuong - TienGiamGia -SoTienDVPhi - SoTienVAT, RowNum = row_number() over (order by a.MaLichSuPhieu),
	   	   Tongtien =  DonGia * b.SoLuong, CheckIn = substring( Convert(varchar,GioVao,126),12,5 ),  CheckOut = substring( Convert(varchar,ThoiGianDongPhieu,126),12,5 ) 
		FROM [tblLichSuPhieu] a 
		JOIN [tblLSPhieu_HangBan] b
		ON a.MaLichSuPhieu=b.MaLichSuPhieu  
		JOIN [tblLSPhieu_CTThanhToan] c
		ON b.MaLichSuPhieu=c.MaLichSuPhieu 
		WHERE substring( Convert(varchar,b.ThoiGianBan,126),0,8) = @tuThang and b.SoLuong > 0
		 ";

		if ( ! empty($tenQuay) )
		{	
			$sql .= " AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		if ( $where == '')
	    {
	    	$sql .= ' ) t1 SELECT * FROM   #temp_t1 WHERE ' . $paginating;
	    	$sql .= " UNION ALL SELECT MaLichSuPhieu, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, SUM(ThanhTien), NULL, NULL FROM #temp_t1 ";
	    	$sql .= " WHERE ". $paginating ;
	    	$sql .= " GROUP BY MaLichSuPhieu ORDER BY MaLichSuPhieu, TenHangBan";
	    	 $sql .= " SELECT GrandTotal = sum(Tongtien) FROM  #temp_t1
	    	DROP TABLE #temp_t1";
	    } 
	    else
	    {	
	    	$sql .= '  ) t1
	with cte_1 as (
		SELECT  RowNum = row_number() over (order by MaLichSuPhieu), NgayCoBill, ThoiGianBan, MaLichSuPhieu, TenHangBan, DonGia, SoLuong, TienGiamGia, NVTinhTienMaNV, SoTienDVPhi, SoTienVAT,  [MaLoaiThe],  null as Discount, ThanhTien , Tongtien, CheckIn, CheckOut
		FROM #temp_t1 
		WHERE ' . $where . '
	)

	SELECT * FROM   cte_1';

	    	 $sql .= " WHERE " .  $paginating ;
	    	 $sql .= " SELECT GrandTotal = sum(Tongtien) FROM  #temp_t1
	    	DROP TABLE #temp_t1";
	    }
	  
		try{

	     	$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuThang', $tuThang);
			
			$stmt->execute();
			$rowset =  array();
			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($stmt->nextRowset());

			return $rowset;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetails_Tot_Month(  $tenQuay, $tuThang, $where )
	{
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuThang varchar(max)
		 SET @tuThang = :tuThang
		 WITH cte AS ( SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, b.ThoiGianBan, a.MaLichSuPhieu,b.TenHangBan, b.DonGia, b.SoLuong, a.TienGiamGia, a.NVTinhTienMaNV, a.SoTienDVPhi, a.SoTienVAT,  c.[MaLoaiThe], null AS Floor, null AS Note, null as Discount, ThanhTien = DonGia * SoLuong - TienGiamGia -SoTienDVPhi - SoTienVAT, Tongtien,  RowNum = row_number() over (order by a.MaLichSuPhieu)
			FROM [tblLichSuPhieu] a 
			JOIN [tblLSPhieu_HangBan] b
			ON a.MaLichSuPhieu=b.MaLichSuPhieu  
			JOIN [tblLSPhieu_CTThanhToan] c
			ON b.MaLichSuPhieu=c.MaLichSuPhieu
			WHERE substring( Convert(varchar, b.ThoiGianBan,126),0,8) = @tuThang and SoLuong >0 
			";

		if ( ! empty($tenQuay) )
		{	
			 $sql .= " AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		 $sql .= " ) SELECT count(*) FROM   cte  ";

		if( $where != "" ){

	     	$sql .= " WHERE ";

	     	$sql .= $where;

     	}

		try
		{ //var_dump($sql);die;

	     	$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuThang', $tuThang);
			
			$stmt->execute();

			$rs = $stmt->fetchColumn();
		
			return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetails_Rec_Year( $tenQuay, $tuNam, $where , $paginating )
	{
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		if( empty($paginating) || strpos($paginating, 'RowNum') === false) 
		{
			throw new InvalidArgumentException('paginating missing');
		}

	   $sql = "SET NOCOUNT ON;
	   IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END
	   	DECLARE @tuNam varchar(max)
		SET @tuNam = :tuNam
		select * into #temp_t1 FROM ( SELECT a.MaLichSuPhieu, substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, b.ThoiGianBan, b.TenHangBan, b.DonGia, b.SoLuong, a.TienGiamGia, a.NVTinhTienMaNV, a.SoTienDVPhi, a.SoTienVAT,  c.[MaLoaiThe], null as Discount, ThanhTien = DonGia * b.SoLuong - TienGiamGia -SoTienDVPhi - SoTienVAT, RowNum = row_number() over (order by a.MaLichSuPhieu),
	   	   Tongtien =  DonGia * b.SoLuong, CheckIn = substring( Convert(varchar,GioVao,126),12,5 ),  CheckOut = substring( Convert(varchar,ThoiGianDongPhieu,126),12,5 ) 
		FROM [tblLichSuPhieu] a 
		JOIN [tblLSPhieu_HangBan] b
		ON a.MaLichSuPhieu=b.MaLichSuPhieu  
		JOIN [tblLSPhieu_CTThanhToan] c
		ON b.MaLichSuPhieu=c.MaLichSuPhieu 
		WHERE substring( Convert(varchar,b.ThoiGianBan,126),0,5) = @tuNam and b.SoLuong > 0
		 ";

		if ( ! empty($tenQuay) )
		{	
			$sql .= " AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		if ( $where == '')
	    {
	    	$sql .= ' ) t1 SELECT * FROM   #temp_t1 WHERE ' . $paginating;
	    	$sql .= " UNION ALL SELECT MaLichSuPhieu, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, SUM(ThanhTien), NULL, NULL FROM #temp_t1 ";
	    	$sql .= " WHERE ". $paginating ;
	    	$sql .= " GROUP BY MaLichSuPhieu ORDER BY MaLichSuPhieu, TenHangBan";
	    	 $sql .= " SELECT GrandTotal = sum(Tongtien) FROM  #temp_t1
	    	DROP TABLE #temp_t1";
	    } 
	    else
	    {	
	    	$sql .= '  ) t1
	with cte_1 as (
		SELECT  RowNum = row_number() over (order by MaLichSuPhieu), NgayCoBill, ThoiGianBan, MaLichSuPhieu, TenHangBan, DonGia, SoLuong, TienGiamGia, NVTinhTienMaNV, SoTienDVPhi, SoTienVAT,  [MaLoaiThe],  null as Discount, ThanhTien , Tongtien, CheckIn, CheckOut
		FROM #temp_t1 
		WHERE ' . $where . '
	)

	SELECT * FROM   cte_1';

	    	 $sql .= " WHERE " .  $paginating ;
	    	 $sql .= " SELECT GrandTotal = sum(Tongtien) FROM  #temp_t1
	    	DROP TABLE #temp_t1";
	    }
	  
		try{

	     	$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNam', $tuNam);
			
			$stmt->execute();
			$rowset =  array();
			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($stmt->nextRowset());

			return $rowset;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetails_Tot_Year(  $tenQuay, $tuNam, $where )
	{
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNam varchar(max)
		 SET @tuNam = :tuNam
		 WITH cte AS ( SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, b.ThoiGianBan, a.MaLichSuPhieu,b.TenHangBan, b.DonGia, b.SoLuong, a.TienGiamGia, a.NVTinhTienMaNV, a.SoTienDVPhi, a.SoTienVAT,  c.[MaLoaiThe], null AS Floor, null AS Note, null as Discount, ThanhTien = DonGia * SoLuong - TienGiamGia -SoTienDVPhi - SoTienVAT, Tongtien,  RowNum = row_number() over (order by a.MaLichSuPhieu)
			FROM [tblLichSuPhieu] a 
			JOIN [tblLSPhieu_HangBan] b
			ON a.MaLichSuPhieu=b.MaLichSuPhieu  
			JOIN [tblLSPhieu_CTThanhToan] c
			ON b.MaLichSuPhieu=c.MaLichSuPhieu
			WHERE substring( Convert(varchar, b.ThoiGianBan,126),0,5) = @tuNam and SoLuong >0 
			";

		if ( ! empty($tenQuay) )
		{	
			 $sql .= " AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		 $sql .= " ) SELECT count(*) FROM   cte  ";

		if( $where != "" ){

	     	$sql .= " WHERE ";

	     	$sql .= $where;

     	}

		try{ //var_dump($sql);die;

	     	$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNam', $tuNam);
			
			$stmt->execute();

			$rs = $stmt->fetchColumn();
		
			return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
	
	private function getBillDetailsThisMonth( $month, &$total = NULL ){
		$sql = "SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, a.*,b.*,   c.[MaLoaiThe] 
				FROM [tblLichSuPhieu] a 
				JOIN [tblLSPhieu_HangBan] b
				ON a.MaLichSuPhieu=b.MaLichSuPhieu  
				JOIN [tblLSPhieu_CTThanhToan] c
				ON b.MaLichSuPhieu=c.MaLichSuPhieu 
				WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$month' and SoLuong >0";

		$sql_1 = "SELECT count(*) FROM ( SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, c.MaLichSuPhieu
				FROM [tblLichSuPhieu] a 
				JOIN [tblLSPhieu_HangBan] b
				ON a.MaLichSuPhieu=b.MaLichSuPhieu  
				JOIN [tblLSPhieu_CTThanhToan] c
				ON b.MaLichSuPhieu=c.MaLichSuPhieu 
				WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) ='$month' and SoLuong >0) t1";
		try{

			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
	     	$total=$rs_1;

	     	$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	       		
	       		return $rs;
			}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
			
		}

	private function getPayMethodDetailsByDate( $date, &$count = null ){
		 $sql = "SELECT   b.MaLichSuPhieu, b.GioVao, b.TienThucTra, c.[MaLoaiThe] FROM  [tblLichSuPhieu] b  JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,111),0,11 ) ='$date' ";
		
		 $sql_1 = "SELECT count(*) FROM ( SELECT  b.MaLichSuPhieu FROM  [tblLichSuPhieu] b  JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,111),0,11 ) ='$date' ) t1 ";

		try{
			
			$rs_1 = $this->conn->query($sql_1)->fetchColumn();
			$count = $rs_1;

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
	
	private function getPayMethodDetailsByMonth( $month, &$total = null ){
     $sql = "
			SELECT substring( Convert(varchar,GioVao,111),0,11 ) as NgayCoBill,
			b.MaLichSuPhieu, b.GioVao, b.TienThucTra, c.[MaLoaiThe] 
			FROM  [tblLichSuPhieu] b   
			JOIN [tblLSPhieu_CTThanhToan] c 
			ON b.MaLichSuPhieu=c.MaLichSuPhieu  
			WHERE substring( Convert(varchar,GioVao,111),0,8 ) ='$month' ";

	$sql_1 = " SELECT count(*) FROM 
			( SELECT substring( Convert(varchar,GioVao,111),0,11 ) as NgayCoBill
			FROM  [tblLichSuPhieu] b   
			JOIN [tblLSPhieu_CTThanhToan] c 
			ON b.MaLichSuPhieu=c.MaLichSuPhieu  
			WHERE substring( Convert(varchar,GioVao,111),0,8 ) ='$month' ) t1";

    try{

    	$rs_1 = $this->conn->query($sql_1)->fetchColumn();
     	$total = $rs_1;

      $rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $rs;;
    }
    catch ( PDOException $error ){
      echo $error->getMessage();
    }
  }
	
	public function getPayMethodDetails_Rec_Day( $tenQuay, $tuNgay,  $where , $paginating )
	{
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		if( empty($paginating) || strpos($paginating, 'RowNum') === false) 
		{
			throw new InvalidArgumentException('paginating missing');
		}

  	$sql = "";
    $sql .= "DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
    With cte_1 as 
	( SELECT distinct b.MaLichSuPhieu, MaKhachHang , TongTien , MaKhu,  MaBan, TienGiamGia , b.SoTienDVPhi , b. SoTienVAT , b.GioVao, b.ThoiGianDongPhieu, b.TienThucTra, c.[MaLoaiThe] FROM  [tblLichSuPhieu] b   JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu JOIN [tblLSPhieu_HangBan] d ON b.MaLichSuPhieu = d.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,126),0,11 ) = @tuNgay 
	  ";

    if( ! empty($tenQuay) )
	{
		$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
	}

    if ( $where == '')
    {	
    	$sql .= ' ) SELECT  * from 
(
	SELECT RowNum = row_number() over (order by MaLichSuPhieu), * FROM cte_1 
) t1';
    	 $sql .= " WHERE " . $paginating ;
    } 
    else
    {	
    	$sql .= ' ) ,
	cte_2 as (
		SELECT  RowNum = row_number() over (order by MaLichSuPhieu), MaLichSuPhieu, MaKhachHang , TongTien , MaKhu, MaBan, TienGiamGia , SoTienDVPhi , SoTienVAT , GioVao,ThoiGianDongPhieu, TienThucTra, [MaLoaiThe] 
		FROM cte_1 
		WHERE ' . $where . '
	)

	SELECT * FROM   cte_2';

    	  $sql .= " WHERE " . $paginating;

   }
      
    try
    {
      	$stmt = $this->conn->prepare($sql);
		$stmt->bindParam('tuNgay', $tuNgay);
		
		$stmt->execute();

		$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		return $rs;

    }
    catch ( PDOException $error ){
      echo $error->getMessage();
    }
  }

  public function getPayMethodDetails_Tot_Day(  $tenQuay, $tuNgay,  $where )
  {
  	if( empty($tuNgay) ) 
	{
		throw new InvalidArgumentException('date missing');
	}

	if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
	{
		throw new InvalidArgumentException('Your input was not valid!');
	}

  	$sql = "";
    $sql .= "DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		 With cte as 
	( SELECT RowNum = row_number() over (order by b.MaLichSuPhieu), b.MaLichSuPhieu, MaKhachHang , TongTien , MaKhu,  MaBan, TienGiamGia , b.SoTienDVPhi , b. SoTienVAT , b.GioVao, b.ThoiGianDongPhieu, b.TienThucTra, c.[MaLoaiThe] FROM  [tblLichSuPhieu] b   JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu JOIN [tblLSPhieu_HangBan] d ON b.MaLichSuPhieu = d.MaLichSuPhieu WHERE substring( Convert(varchar,GioVao,126),0,11 ) = @tuNgay 
	";

	if( ! empty($tenQuay) )
	{
		$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
	}

	$sql .= " ) 
	SELECT count(*) FROM   cte";

     if( $where != "" ){

     	//if( stripos($sql, 'WHERE') !== false )  $sql .= "AND";  else  
     	$sql .= " WHERE ";

     	$sql .= $where;

     }

    try{
      
      	$stmt = $this->conn->prepare($sql);
		$stmt->bindParam('tuNgay', $tuNgay);
		
		$stmt->execute();

		$rs = $stmt->fetchColumn();
	
		return $rs;

    }
    catch ( PDOException $error ){
      echo $error->getMessage();
    }
  }

  	public function getPayMethodDetails_Rec_Month( $tenQuay, $tuThang,  $where , $paginating )
  	{
  		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		if( empty($paginating) || strpos($paginating, 'RowNum') === false) 
		{
			throw new InvalidArgumentException('paginating missing');
		}

	  	$sql = "";
	    $sql .= "DECLARE @tuThang varchar(max)
		 SET @tuThang = :tuThang
		With cte_1 as 
	( SELECT distinct b.MaLichSuPhieu, MaKhachHang , TongTien , MaKhu,  MaBan, TienGiamGia , b.SoTienDVPhi , b. SoTienVAT , b.GioVao, b.ThoiGianDongPhieu, b.TienThucTra, c.[MaLoaiThe] FROM  [tblLichSuPhieu] b   JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu JOIN [tblLSPhieu_HangBan] d ON b.MaLichSuPhieu = d.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,126),0,8 ) = @tuThang 
	  ";

	    if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

	    if ( $where == '')
	    {	
	    	$sql .= ' ) SELECT  * from 
	(
		SELECT RowNum = row_number() over (order by MaLichSuPhieu), * FROM cte_1 
	) t1';
	    	 $sql .= " WHERE " . $paginating ;
	    } 
	    else
	    {	
	    	$sql .= ' ),
		cte_2 as (
			SELECT  RowNum = row_number() over (order by MaLichSuPhieu), MaLichSuPhieu, MaKhachHang , TongTien , MaKhu, MaBan, TienGiamGia , SoTienDVPhi , SoTienVAT , GioVao,ThoiGianDongPhieu, TienThucTra, [MaLoaiThe] 
			FROM cte_1 
			WHERE ' . $where . '
		)

		SELECT * FROM  cte_2';

	    	$sql .= " WHERE " . $paginating;

	   }
	      
	    try{//var_dump($sql);die;
	      
	      	$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuThang', $tuThang);
			
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			return $rs;

	    }
	    catch ( PDOException $error ){
	      echo $error->getMessage();
	    }
  }

  public function getPayMethodDetails_Tot_Month(  $tenQuay, $tuThang,  $where )
  {
  	if( empty($tuThang) ) 
	{
		throw new InvalidArgumentException('date missing');
	}

	if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
	{
		throw new InvalidArgumentException('Your input was not valid!');
	}

  	$sql = "";
    $sql .= "DECLARE @tuThang varchar(max)
		 SET @tuThang = :tuThang
		 With cte as 
	( SELECT RowNum = row_number() over (order by b.MaLichSuPhieu), b.MaLichSuPhieu, MaKhachHang , TongTien , MaKhu,  MaBan, TienGiamGia , b.SoTienDVPhi , b. SoTienVAT , b.GioVao, b.ThoiGianDongPhieu, b.TienThucTra, c.[MaLoaiThe] FROM  [tblLichSuPhieu] b   JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu JOIN [tblLSPhieu_HangBan] d ON b.MaLichSuPhieu = d.MaLichSuPhieu WHERE substring( Convert(varchar,GioVao,126),0,5 ) = @tuThang
	";

	if( ! empty($tenQuay) )
	{
		$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
	}

	$sql .= " ) 
	SELECT count(*) FROM   cte";

     if( $where != "" ){

     	//if( stripos($sql, 'WHERE') !== false )  $sql .= "AND";  else  
     	$sql .= " WHERE ";

     	$sql .= $where;

     }

    try{
      
      	$stmt = $this->conn->prepare($sql);
		$stmt->bindParam('tuThang', $tuThang);
		
		$stmt->execute();

		$rs = $stmt->fetchColumn();
	
		return $rs;	

    }
    catch ( PDOException $error ){
      echo $error->getMessage();
    }
  }


	public function getPayMethodDetails_Rec_Year( $tenQuay, $tuNam,  $where , $paginating )
	{	
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		if( empty($paginating) || strpos($paginating, 'RowNum') === false) 
		{
			throw new InvalidArgumentException('paginating missing');
		}

	  	$sql = "";
	    $sql .= "DECLARE @tuNam varchar(max)
		 SET @tuNam = :tuNam
		With cte_1 as 
		( SELECT distinct b.MaLichSuPhieu, MaKhachHang , TongTien , MaKhu,  MaBan, TienGiamGia , b.SoTienDVPhi , b. SoTienVAT , b.GioVao, b.ThoiGianDongPhieu, b.TienThucTra, c.[MaLoaiThe] FROM  [tblLichSuPhieu] b   JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu JOIN [tblLSPhieu_HangBan] d ON b.MaLichSuPhieu = d.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,126),0,5 ) = @tuNam 
		  ";

	    if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

	    if ( $where == '')
	    {	
	    	$sql .= ' ) SELECT  * from 
		(
			SELECT RowNum = row_number() over (order by MaLichSuPhieu), * FROM cte_1 
		) t1';
	    	 $sql .= " WHERE " . $paginating ;
	    } 
	    else
	    {	
	    	$sql .= ' ),
		cte_2 as (
			SELECT  RowNum = row_number() over (order by MaLichSuPhieu), MaLichSuPhieu, MaKhachHang , TongTien , MaKhu, MaBan, TienGiamGia , SoTienDVPhi , SoTienVAT , GioVao,ThoiGianDongPhieu, TienThucTra, [MaLoaiThe] 
			FROM cte_1 
			WHERE ' . $where . '
		)

		SELECT * FROM  cte_2';

	    	$sql .= " WHERE " . $paginating;

	   }
	      
	    try{//var_dump($sql);die;
	      
	      	$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNam', $tuNam);
			
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rs;

	    }
	    catch ( PDOException $error ){
	      echo $error->getMessage();
	    }
  }

  public function getPayMethodDetails_Tot_Year(  $tenQuay, $tuNam,  $where )
  {
  	if( empty($tuNam) ) 
	{
		throw new InvalidArgumentException('date missing');
	}

	if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
	{
		throw new InvalidArgumentException('Your input was not valid!');
	}

  	$sql = "";
    $sql .= "DECLARE @tuNam varchar(max)
		 SET @tuNam = :tuNam
		 With cte as 
	( SELECT RowNum = row_number() over (order by b.MaLichSuPhieu), b.MaLichSuPhieu, MaKhachHang , TongTien , MaKhu,  MaBan, TienGiamGia , b.SoTienDVPhi , b. SoTienVAT , b.GioVao, b.ThoiGianDongPhieu, b.TienThucTra, c.[MaLoaiThe] FROM  [tblLichSuPhieu] b   JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu JOIN [tblLSPhieu_HangBan] d ON b.MaLichSuPhieu = d.MaLichSuPhieu WHERE substring( Convert(varchar,GioVao,126),0,5 ) = @tuNam 
	";

	if( ! empty($tenQuay) )
	{
		$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
	}

	$sql .= " ) 
	SELECT count(*) FROM   cte";

     if( $where != "" ){

     	//if( stripos($sql, 'WHERE') !== false )  $sql .= "AND";  else  
     	$sql .= " WHERE ";

     	$sql .= $where;

     }

    try{
      
     	$stmt = $this->conn->prepare($sql);
		$stmt->bindParam('tuNam', $tuNam);
		
		$stmt->execute();

		$rs = $stmt->fetchColumn();
	
		return $rs;

    }
    catch ( PDOException $error ){
      echo $error->getMessage();
    }
  }

	 private function getFoodGroupsByDate( $date ){
		$sql = "select Ten from  [tblLSPhieu_HangBan] a 
 LEFT JOIN [tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [tblDMNhomHangBan] c 
ON b.[MaNhomHangBan] = c.[Ma] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$date' and SoLuong >0 group by Ten";
		try{
			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				return $rs;
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	private function getFoodSoldByGroup( $date, &$nhom_hang_ban_arr, $nhom_hang_ban = "" ){

	 	$sql_2 = "select Ten from  [tblLSPhieu_HangBan] a 
		 LEFT JOIN [tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [tblDMNhomHangBan] c 
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
		  FROM [tblLichSuPhieu] p 
		  JOIN [tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [tblDMNhomHangBan] c 
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

	private function getFoodSoldByGroup_Month( $month, &$nhom_hang_ban_arr = "", $nhom_hang_ban = "" ){

	 	$sql_2 = "select top 1 Ten from  [tblLSPhieu_HangBan] a 
		 LEFT JOIN [tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [tblDMNhomHangBan] c 
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
		  FROM [tblLichSuPhieu] p 
		  JOIN [tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [tblDMNhomHangBan] c 
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

	private function getFoodSoldByGroup_DateSelected( $tungay, $denngay, &$nhom_hang_ban_arr, $nhom_hang_ban = "" ){

	 	$sql_2 = "select  Ten from  [tblLSPhieu_HangBan] a 
		 LEFT JOIN [tblDMHangBan] b ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [tblDMNhomHangBan] c 
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
		  FROM [tblLichSuPhieu] p 
		  JOIN [tblLSPhieu_HangBan] a 
		  ON p.MaLichSuPhieu = a.MaLichSuPhieu 
		  LEFT JOIN [tblDMHangBan] b 
		  ON a.[MaHangBan]=b.[MaHangBan] LEFT JOIN [tblDMNhomHangBan] c 
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


	public function getDMNhomHangBan( $tenQuay = null )
	{
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		if( ! empty( $tenQuay ) )
		{	
			$sql="select * from [tblDMNhomHangBan] where [TenQuay] = '$tenQuay' order by Ten ";
		}
		else
		{
			$sql="select * from [tblDMNhomHangBan] order by Ten";
		}
		

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}

	}
	
	public function getSalesByFoodGroup_Day( $tuNgay )
	{
		$tuNgay = htmlentities(trim(strip_tags($tuNgay)),ENT_QUOTES,'utf-8');
		  $sql = "Declare @tuNgay varchar(max)
		  SET @tuNgay = :tuNgay
		 with cte_1 as 
		(
		select  distinct Ten, b.TenHangBan, Sales = DonGia * SUM(SoLuong) OVER ( Partition By b.TenHangBan )  FROM [tblDMNhomHangBan] a LEFT JOIN [tblDMHangBan] b ON a.Ma = b.MaNhomHangBan
		left join [tblLSPhieu_HangBan] c ON b.MaHangBan = c.MaHangBan  
		and substring( Convert(varchar,ThoiGianBan,126),0,11 ) = @tuNgay
		WHERE TenQuay = 'RESTAURANT' 
		) 
		SELECT Ten, TotalSales = SUM(CASE WHEN Sales >0 THEN Sales ELSE 0 END) FROM cte_1 GROUP BY Ten ORDER BY Ten";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesByFoodGroup_Month( $tuThang )
	{	
		$tuThang = htmlentities(trim(strip_tags($tuThang)),ENT_QUOTES,'utf-8');

		  $sql = "Declare @tuThang varchar(max)
		  SET @tuThang = :tuThang
		 with cte_1 as 
		(
		select  distinct Ten, b.TenHangBan, Sales = DonGia * SUM(SoLuong) OVER ( Partition By b.TenHangBan )  FROM [tblDMNhomHangBan] a LEFT JOIN [tblDMHangBan] b ON a.Ma = b.MaNhomHangBan
		left join [tblLSPhieu_HangBan] c ON b.MaHangBan = c.MaHangBan  
		and substring( Convert(varchar,ThoiGianBan,126),0,8 ) = @tuThang
		WHERE TenQuay = 'RESTAURANT' 
		) 
		SELECT Ten, TotalSales = SUM(CASE WHEN Sales >0 THEN Sales ELSE 0 END) FROM cte_1 GROUP BY Ten ORDER BY Ten";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuThang', $tuThang);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesByFoodGroup_Year( $tuNam )
	{	
		$tuNam = htmlentities(trim(strip_tags($tuNam)),ENT_QUOTES,'utf-8');
		
		  $sql = "Declare @tuNam varchar(max)
		  SET @tuNam = :tuNam
		 with cte_1 as 
		(
		select  distinct Ten, b.TenHangBan, Sales = DonGia * SUM(SoLuong) OVER ( Partition By b.TenHangBan )  FROM [tblDMNhomHangBan] a LEFT JOIN [tblDMHangBan] b ON a.Ma = b.MaNhomHangBan
		left join [tblLSPhieu_HangBan] c ON b.MaHangBan = c.MaHangBan  
		and substring( Convert(varchar,ThoiGianBan,126),0,5 ) = @tuNam
		WHERE TenQuay = 'RESTAURANT' 
		) 
		SELECT Ten, TotalSales = SUM(CASE WHEN Sales >0 THEN Sales ELSE 0 END) FROM cte_1 GROUP BY Ten ORDER BY Ten";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNam', $tuNam);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSoLuongHangBanTheoNhom_Day( $tuNgay, $tenNhom  )
	{	
		$tuNgay =  htmlentities(trim(strip_tags($tuNgay)),ENT_QUOTES,'utf-8');
		$tenNhom = htmlentities(trim(strip_tags($tenNhom)),ENT_QUOTES,'utf-8');

		 $sql = "DECLARE @tuNgay varchar(max), @tenNhom varchar(max)
		 SET @tuNgay = :tuNgay
		 SET @tenNhom = :tenNhom

		select Distinct b.MaHangBan, b.TenHangBan
		, TongSoLuong = SUM( SoLuong )  
		FROM [tblLSPhieu_HangBan] a 
		right join [tblDMHangBan] b ON a.MaHangBan = b.MaHangBan AND substring( Convert(varchar,ThoiGianBan,126),0,11 ) = @tuNgay
		left JOIN  [tblDMNhomHangBan] c ON b.MaNhomHangBan = c.Ma
		WHERE Ma = @tenNhom
		GROUP BY b.MaHangBan, b.TenHangBan, MaNhomHangBan  order by  TongSoLuong DESC";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				$stmt->bindParam('tenNhom', $tenNhom);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSoLuongHangBanTheoNhom_Month( $tuThang, $tenNhom  )
	{	
		$tuThang =  htmlentities(trim(strip_tags($tuThang)),ENT_QUOTES,'utf-8');
		$tenNhom = htmlentities(trim(strip_tags($tenNhom)),ENT_QUOTES,'utf-8');
		 $sql = "DECLARE @tuThang varchar(max), @tenNhom varchar(max)
		 SET @tuThang = :tuThang
		 SET @tenNhom = :tenNhom

		select Distinct b.MaHangBan, b.TenHangBan
		, TongSoLuong = SUM( SoLuong )  
		FROM [tblLSPhieu_HangBan] a 
		right join [tblDMHangBan] b ON a.MaHangBan = b.MaHangBan AND substring( Convert(varchar,ThoiGianBan,126),0,8 ) = @tuThang
		left JOIN  [tblDMNhomHangBan] c ON b.MaNhomHangBan = c.Ma
		WHERE Ma = @tenNhom
		GROUP BY b.MaHangBan, b.TenHangBan, MaNhomHangBan  order by  TongSoLuong DESC";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuThang', $tuThang);
				$stmt->bindParam('tenNhom', $tenNhom);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSoLuongHangBanTheoNhom_Year( $tuNam, $tenNhom  )
	{	
		$tuNam =  htmlentities(trim(strip_tags($tuNam)),ENT_QUOTES,'utf-8');
		$tenNhom = htmlentities(trim(strip_tags($tenNhom)),ENT_QUOTES,'utf-8');
		 $sql = "DECLARE @tuNam varchar(max), @tenNhom varchar(max)
		 SET @tuNam = :tuNam
		 SET @tenNhom = :tenNhom

		select Distinct b.MaHangBan, b.TenHangBan
		, TongSoLuong = SUM( SoLuong )  
		FROM [tblLSPhieu_HangBan] a 
		right join [tblDMHangBan] b ON a.MaHangBan = b.MaHangBan AND substring( Convert(varchar,ThoiGianBan,126),0,5 ) = @tuNam
		left JOIN  [tblDMNhomHangBan] c ON b.MaNhomHangBan = c.Ma
		WHERE Ma = @tenNhom
		GROUP BY b.MaHangBan, b.TenHangBan, MaNhomHangBan  order by  TongSoLuong DESC";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNam', $tuNam);
				$stmt->bindParam('tenNhom', $tenNhom);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getSoldvsCancelledItemsByDate( $date ){
		 $sql = "select TenHangBan,
		  	sum (CASE WHEN soluong > 0 THEN soluong
		END) AS SLOrder,
		 sum(soluong) as SLBan,
			sum (CASE WHEN soluong < 0 THEN soluong
		END) AS SLBo
		FROM [tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) = '$date' group by TenHangBan";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getSoldvsCancelledItemsByMonth( $month ){
		 $sql = "select TenHangBan,
		  	sum (CASE WHEN soluong > 0 THEN soluong
		END) AS SLOrder,
		 sum(soluong) as SLBan,
			sum (CASE WHEN soluong < 0 THEN soluong
		END) AS SLBo
		FROM [tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) = '$month' group by TenHangBan";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getSoldvsCancelledItemsBySelection( $tungay, $denngay ){
		 $sql = "select TenHangBan,
		  	sum (CASE WHEN soluong > 0 THEN soluong
		END) AS SLOrder,
		 sum(soluong) as SLBan,
			sum (CASE WHEN soluong < 0 THEN soluong
		END) AS SLBo
		FROM [tblLSPhieu_HangBan] where substring( Convert(varchar,ThoiGianBan,111),0,8 ) between '$tungay' and '$denngay' group by TenHangBan";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				
				if( $rs != false) 
					return $rs;
				
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getCurrencyReportByDate( $date ){
		$sql = "  select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [tblLichSuPhieu] 
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'   group by [MaTienTe]";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getCurrencyReportByMonth( $month ){
		$sql = "select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [tblLichSuPhieu] 
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,8 ) = '$month'  group by [MaTienTe]";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getCurrencyReportBySelection( $tungay, $denngay ){
		$sql = "select [MaTienTe], sum([TienThucTra]) as ThucThu FROM [tblLichSuPhieu] 
  			WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) between '$tungay' and '$denngay' group by [MaTienTe]";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getBillEditDetailsByDate( $date ){	
		 $sql = "select a.* , b.*  FROM [tblLichSuPhieu] a LEFT JOIN [tblDMNhanVien] b
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

	private function getBillEditDetailsByMonth( $month ){	
		 $sql = "select a.* , b.*  FROM [tblLichSuPhieu] a LEFT JOIN [tblDMNhanVien] b
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

	public function getBillEditDetailsBySelection_Day( $tuNgay, $tenQuay )
	{	
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		with cte as 
		( 
		SELECT distinct a.MaLichSuPhieu, MaHangBan, TenHangBan ,ThoiGianSuaPhieu
		,DonGia
		, TenSuCo, NVTinhTienMaNV
		 , PaybackQty =  sum(case when SoLuong < 0  then SoLuong else 0 end)  over ( partition by MaHangBan, TenHangBan, a.MaLichSuPhieu )
		, InitalQty =  sum(case when SoLuong > 0   then SoLuong else 0 end)  over ( partition by MaHangBan, TenHangBan, a.MaLichSuPhieu  )
		from [tblLSPhieu_HangBan] a LEFT JOIN tblDMSuCoBanHang b ON a.MaSuCo = b.MaSuCo 
		LEFT JOIN tblLichSuPhieu c ON a.MaLichSuPhieu = c.MaLichSuPhieu
		WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) =  @tuNgay
		 )
		 select distinct MaLichSuPhieu, TenSuCo, NVTinhTienMaNV,ThoiGianSuaPhieu,
		 Payback  = PaybackQty * DonGia,
		 Initial  = InitalQty * DonGia,
		 Diff = InitalQty * DonGia - Abs(PaybackQty * DonGia)
		 from cte where TenSuCo IS NOT NULL";

  		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getBillEditDetailsBySelection_Month( $tuThang, $tenQuay )
	{	
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuThang varchar(max)
		 SET @tuThang = :tuThang
		with cte as 
		( 
		SELECT distinct a.MaLichSuPhieu, MaHangBan, TenHangBan, ThoiGianSuaPhieu
		,DonGia
		, TenSuCo, NVTinhTienMaNV
		 , PaybackQty =  sum(case when SoLuong < 0  then SoLuong else 0 end)  over ( partition by MaHangBan, TenHangBan, a.MaLichSuPhieu )
		, InitalQty =  sum(case when SoLuong > 0   then SoLuong else 0 end)  over ( partition by MaHangBan, TenHangBan, a.MaLichSuPhieu  )
		from [tblLSPhieu_HangBan] a LEFT JOIN tblDMSuCoBanHang b ON a.MaSuCo = b.MaSuCo 
		LEFT JOIN tblLichSuPhieu c ON a.MaLichSuPhieu = c.MaLichSuPhieu
		WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,8 ) = '$tuThang'
		 )
		 select distinct MaLichSuPhieu, TenSuCo, NVTinhTienMaNV, ThoiGianSuaPhieu,
		 Payback  = PaybackQty * DonGia,
		 Initial  = InitalQty * DonGia,
		 Diff = InitalQty * DonGia - Abs(PaybackQty * DonGia)
		 from cte where TenSuCo IS NOT NULL";

  		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuThang', $tuThang);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getBillEditDetailsBySelection_Year( $tuNam, $tenQuay )
	{	
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNam varchar(max)
		 SET @tuNam = :tuNam
		with cte as 
		( 
		SELECT distinct a.MaLichSuPhieu, MaHangBan, TenHangBan , ThoiGianSuaPhieu
		,DonGia
		, TenSuCo, NVTinhTienMaNV
		 , PaybackQty =  sum(case when SoLuong < 0  then SoLuong else 0 end)  over ( partition by MaHangBan, TenHangBan, a.MaLichSuPhieu )
		, InitalQty =  sum(case when SoLuong > 0   then SoLuong else 0 end)  over ( partition by MaHangBan, TenHangBan, a.MaLichSuPhieu  )
		from [tblLSPhieu_HangBan] a LEFT JOIN tblDMSuCoBanHang b ON a.MaSuCo = b.MaSuCo 
		LEFT JOIN tblLichSuPhieu c ON a.MaLichSuPhieu = c.MaLichSuPhieu
		WHERE substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,5 ) = @tuNam
		 )
		 select distinct MaLichSuPhieu, TenSuCo, NVTinhTienMaNV, ThoiGianSuaPhieu,
		 Payback  = PaybackQty * DonGia,
		 Initial  = InitalQty * DonGia,
		 Diff = InitalQty * DonGia - Abs(PaybackQty * DonGia)
		 from cte where TenSuCo IS NOT NULL";

  		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNam', $tuNam);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}


	private function getCancelledFoodItemByDate( $date ) {
		$sql = "SELECT a.*, b.*,c.* FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' ";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getCancelledFoodItemByMonth ( $month ) {
		$sql = "SELECT a.*, b.*,c.* FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month' ";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getQtyByHour_Day( $tuNgay )
	{	
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}
		$tuNgay =  htmlentities(trim(strip_tags($tuNgay)),ENT_QUOTES,'utf-8');

		$sql = "SET NOCOUNT ON;
		DECLARE @tuNgay varchar(max)
		SET @tuNgay = :tuNgay
	select 
T8h_9h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T08:00' AND @tuNgay + 'T09:00'  then a.MaLichSuPhieu end) ),
T9h_10h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T09:00' AND @tuNgay + 'T10:00'  then a.MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T10:00' AND @tuNgay + 'T11:00'  then a.MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T11:00' AND @tuNgay + 'T12:00'  then a.MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T12:00' AND @tuNgay + 'T13:00'  then a.MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T13:00' AND @tuNgay + 'T14:00'  then a.MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T14:00' AND @tuNgay + 'T15:00'  then a.MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T15:00' AND @tuNgay + 'T16:00'  then a.MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T16:00' AND @tuNgay + 'T17:00'  then a.MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T17:00' AND @tuNgay + 'T18:00'  then a.MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T18:00' AND @tuNgay + 'T19:00'  then a.MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T19:00' AND @tuNgay + 'T20:00'  then a.MaLichSuPhieu end) )
from tblLichSuPhieu a left join tblLSPhieu_HangBan b ON a.MaLichSuPhieu = b.MaLichSuPhieu
where 
 MaBan Like '%M%'
AND TenHangBan IN ( SELECT * FROM [SPA_ALLView] where  TenHangBan  not like '%Child%' or  TenHangBan not like '%Baby%' or  TenHangBan not like '%tre em%')

	select 
T8h_9h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T08:00' AND @tuNgay + 'T09:00'  then a.MaLichSuPhieu end) ),
T9h_10h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T09:00' AND @tuNgay + 'T10:00'  then a.MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T10:00' AND @tuNgay + 'T11:00'  then a.MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T11:00' AND @tuNgay + 'T12:00'  then a.MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T12:00' AND @tuNgay + 'T13:00'  then a.MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T13:00' AND @tuNgay + 'T14:00'  then a.MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T14:00' AND @tuNgay + 'T15:00'  then a.MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T15:00' AND @tuNgay + 'T16:00'  then a.MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T16:00' AND @tuNgay + 'T17:00'  then a.MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T17:00' AND @tuNgay + 'T18:00'  then a.MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T18:00' AND @tuNgay + 'T19:00'  then a.MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T19:00' AND @tuNgay + 'T20:00'  then a.MaLichSuPhieu end) )
from tblLichSuPhieu a left join tblLSPhieu_HangBan b ON a.MaLichSuPhieu = b.MaLichSuPhieu
where 
 MaBan Like '%M%'
AND TenHangBan IN ( SELECT * FROM [SPA_ALLView] where  TenHangBan   like '%Child%' or  TenHangBan  like '%Baby%' or  TenHangBan  like '%tre em%')

	select 
T8h_9h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T08:00' AND @tuNgay + 'T09:00'  then a.MaLichSuPhieu end) ),
T9h_10h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T09:00' AND @tuNgay + 'T10:00'  then a.MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T10:00' AND @tuNgay + 'T11:00'  then a.MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T11:00' AND @tuNgay + 'T12:00'  then a.MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T12:00' AND @tuNgay + 'T13:00'  then a.MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T13:00' AND @tuNgay + 'T14:00'  then a.MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T14:00' AND @tuNgay + 'T15:00'  then a.MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T15:00' AND @tuNgay + 'T16:00'  then a.MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T16:00' AND @tuNgay + 'T17:00'  then a.MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T17:00' AND @tuNgay + 'T18:00'  then a.MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T18:00' AND @tuNgay + 'T19:00'  then a.MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T19:00' AND @tuNgay + 'T20:00'  then a.MaLichSuPhieu end) )
from tblLichSuPhieu a left join tblLSPhieu_HangBan b ON a.MaLichSuPhieu = b.MaLichSuPhieu
where 
 MaBan Like '%W%'
AND TenHangBan IN ( SELECT * FROM [SPA_ALLView] where  TenHangBan  not like '%Child%' or  TenHangBan not like '%Baby%' or  TenHangBan not like '%tre em%')

	select 
T8h_9h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T08:00' AND @tuNgay + 'T09:00'  then a.MaLichSuPhieu end) ),
T9h_10h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T09:00' AND @tuNgay + 'T10:00'  then a.MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T10:00' AND @tuNgay + 'T11:00'  then a.MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T11:00' AND @tuNgay + 'T12:00'  then a.MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T12:00' AND @tuNgay + 'T13:00'  then a.MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T13:00' AND @tuNgay + 'T14:00'  then a.MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T14:00' AND @tuNgay + 'T15:00'  then a.MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T15:00' AND @tuNgay + 'T16:00'  then a.MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T16:00' AND @tuNgay + 'T17:00'  then a.MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T17:00' AND @tuNgay + 'T18:00'  then a.MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T18:00' AND @tuNgay + 'T19:00'  then a.MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when  substring(Convert(varchar,GioVao,126),0,17) BETWEEN @tuNgay + 'T19:00' AND @tuNgay + 'T20:00'  then a.MaLichSuPhieu end) )
from tblLichSuPhieu a left join tblLSPhieu_HangBan b ON a.MaLichSuPhieu = b.MaLichSuPhieu
where 
 MaBan Like '%W%'
AND TenHangBan IN ( SELECT * FROM [SPA_ALLView] where  TenHangBan   like '%Child%' or  TenHangBan  like '%Baby%' or  TenHangBan  like '%tre em%')
";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				
				$stmt->execute();
				$rowset =  array();
				do {

				    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
				    
				} while ($stmt->nextRowset());

				return $rowset;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getQtyByHour_Month( $tuThang )
	{	
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}
		$tuThang =  htmlentities(trim(strip_tags($tuThang)),ENT_QUOTES,'utf-8');

		$sql = "SET NOCOUNT ON;
	IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END

		DECLARE @tuThang varchar(max)
		SET @tuThang = :tuThang

select * into #temp_t1 FROM
(
select  a.MaLichSuPhieu, GioVao, MaBan, TenHangBan,
     substring(Convert(varchar,GioVao,126),0,11) as Ngay, 
    CONVERT( TIME, substring(Convert(varchar,GioVao,126),12,5) ) as Gio

from tblLichSuPhieu a left join tblLSPhieu_HangBan b ON a.MaLichSuPhieu = b.MaLichSuPhieu
AND TenHangBan IN ( SELECT * FROM [SPA_ALLView] )  
) t1

select T8h_9h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '08:00') and CONVERT( TIME,'09:00' ) then MaLichSuPhieu end) ), 
T9h_10h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '09:00') and CONVERT( TIME,'10:00' ) then MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '10:00') and CONVERT( TIME,'11:00' ) then MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '11:00') and CONVERT( TIME,'12:00' ) then MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '12:00') and CONVERT( TIME,'13:00' ) then MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '13:00') and CONVERT( TIME,'14:00' ) then MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '14:00') and CONVERT( TIME,'15:00' ) then MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '15:00') and CONVERT( TIME,'16:00' ) then MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '16:00') and CONVERT( TIME,'17:00' ) then MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '17:00') and CONVERT( TIME,'18:00' ) then MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '18:00') and CONVERT( TIME,'19:00' ) then MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '19:00') and CONVERT( TIME,'20:00' ) then MaLichSuPhieu end) )
from #temp_t1 where  MaBan Like '%M%' and  TenHangBan  not like '%Child%' or  TenHangBan not like '%Baby%' or  TenHangBan  not like '%tre em%'

select T8h_9h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '08:00') and CONVERT( TIME,'09:00' ) then MaLichSuPhieu end) ), 
T9h_10h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '09:00') and CONVERT( TIME,'10:00' ) then MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '10:00') and CONVERT( TIME,'11:00' ) then MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '11:00') and CONVERT( TIME,'12:00' ) then MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '12:00') and CONVERT( TIME,'13:00' ) then MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '13:00') and CONVERT( TIME,'14:00' ) then MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '14:00') and CONVERT( TIME,'15:00' ) then MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '15:00') and CONVERT( TIME,'16:00' ) then MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '16:00') and CONVERT( TIME,'17:00' ) then MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '17:00') and CONVERT( TIME,'18:00' ) then MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '18:00') and CONVERT( TIME,'19:00' ) then MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '19:00') and CONVERT( TIME,'20:00' ) then MaLichSuPhieu end) )
from #temp_t1 where  MaBan Like '%M%' and  TenHangBan   like '%Child%' or  TenHangBan  like '%Baby%' or  TenHangBan  like '%tre em%'

select T8h_9h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '08:00') and CONVERT( TIME,'09:00' ) then MaLichSuPhieu end) ), 
T9h_10h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '09:00') and CONVERT( TIME,'10:00' ) then MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '10:00') and CONVERT( TIME,'11:00' ) then MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '11:00') and CONVERT( TIME,'12:00' ) then MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '12:00') and CONVERT( TIME,'13:00' ) then MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '13:00') and CONVERT( TIME,'14:00' ) then MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '14:00') and CONVERT( TIME,'15:00' ) then MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '15:00') and CONVERT( TIME,'16:00' ) then MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '16:00') and CONVERT( TIME,'17:00' ) then MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '17:00') and CONVERT( TIME,'18:00' ) then MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '18:00') and CONVERT( TIME,'19:00' ) then MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '19:00') and CONVERT( TIME,'20:00' ) then MaLichSuPhieu end) )
from #temp_t1 where  MaBan Like '%W%' and  TenHangBan  not like '%Child%' or  TenHangBan not like '%Baby%' or  TenHangBan  not like '%tre em%'

select T8h_9h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '08:00') and CONVERT( TIME,'09:00' ) then MaLichSuPhieu end) ), 
T9h_10h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '09:00') and CONVERT( TIME,'10:00' ) then MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '10:00') and CONVERT( TIME,'11:00' ) then MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '11:00') and CONVERT( TIME,'12:00' ) then MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '12:00') and CONVERT( TIME,'13:00' ) then MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '13:00') and CONVERT( TIME,'14:00' ) then MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '14:00') and CONVERT( TIME,'15:00' ) then MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '15:00') and CONVERT( TIME,'16:00' ) then MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '16:00') and CONVERT( TIME,'17:00' ) then MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '17:00') and CONVERT( TIME,'18:00' ) then MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '18:00') and CONVERT( TIME,'19:00' ) then MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when substring(Ngay,0,8) = @tuThang AND  Gio between  CONVERT( TIME, '19:00') and CONVERT( TIME,'20:00' ) then MaLichSuPhieu end) )
from #temp_t1 where  MaBan Like '%W%' and  TenHangBan   like '%Child%' or  TenHangBan  like '%Baby%' or  TenHangBan   like '%tre em%'

";
		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuThang', $tuThang);
				
				$stmt->execute();
				$rowset =  array();
				do {

				    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
				    
				} while ($stmt->nextRowset());

				return $rowset;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getQtyByHour_Year( $tuNam )
	{	
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}
		$tuNam =  htmlentities(trim(strip_tags($tuNam)),ENT_QUOTES,'utf-8');
		
		$sql = "SET NOCOUNT ON;
	IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END

		DECLARE @tuNam varchar(max)
		SET @tuNam = :tuNam

select * into #temp_t1 FROM
(
select  a.MaLichSuPhieu, GioVao, MaBan, TenHangBan,
     substring(Convert(varchar,GioVao,126),0,11) as Ngay, 
    CONVERT( TIME, substring(Convert(varchar,GioVao,126),12,5) ) as Gio

from tblLichSuPhieu a left join tblLSPhieu_HangBan b ON a.MaLichSuPhieu = b.MaLichSuPhieu
AND TenHangBan IN ( SELECT * FROM [SPA_ALLView] )  
) t1

select T8h_9h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '08:00') and CONVERT( TIME,'09:00' ) then MaLichSuPhieu end) ), 
T9h_10h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '09:00') and CONVERT( TIME,'10:00' ) then MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '10:00') and CONVERT( TIME,'11:00' ) then MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '11:00') and CONVERT( TIME,'12:00' ) then MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '12:00') and CONVERT( TIME,'13:00' ) then MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '13:00') and CONVERT( TIME,'14:00' ) then MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '14:00') and CONVERT( TIME,'15:00' ) then MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '15:00') and CONVERT( TIME,'16:00' ) then MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '16:00') and CONVERT( TIME,'17:00' ) then MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '17:00') and CONVERT( TIME,'18:00' ) then MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '18:00') and CONVERT( TIME,'19:00' ) then MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '19:00') and CONVERT( TIME,'20:00' ) then MaLichSuPhieu end) )
from #temp_t1 where  MaBan Like '%M%' and  TenHangBan not like '%Child%' or  TenHangBan not like '%Baby%' or  TenHangBan  not like '%tre em%'

select T8h_9h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '08:00') and CONVERT( TIME,'09:00' ) then MaLichSuPhieu end) ), 
T9h_10h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '09:00') and CONVERT( TIME,'10:00' ) then MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '10:00') and CONVERT( TIME,'11:00' ) then MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '11:00') and CONVERT( TIME,'12:00' ) then MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '12:00') and CONVERT( TIME,'13:00' ) then MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '13:00') and CONVERT( TIME,'14:00' ) then MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '14:00') and CONVERT( TIME,'15:00' ) then MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '15:00') and CONVERT( TIME,'16:00' ) then MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '16:00') and CONVERT( TIME,'17:00' ) then MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '17:00') and CONVERT( TIME,'18:00' ) then MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '18:00') and CONVERT( TIME,'19:00' ) then MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '19:00') and CONVERT( TIME,'20:00' ) then MaLichSuPhieu end) )
from #temp_t1 where  MaBan Like '%M%' and  TenHangBan   like '%Child%' or  TenHangBan  like '%Baby%' or  TenHangBan   like '%tre em%'

select T8h_9h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '08:00') and CONVERT( TIME,'09:00' ) then MaLichSuPhieu end) ), 
T9h_10h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '09:00') and CONVERT( TIME,'10:00' ) then MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '10:00') and CONVERT( TIME,'11:00' ) then MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '11:00') and CONVERT( TIME,'12:00' ) then MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '12:00') and CONVERT( TIME,'13:00' ) then MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '13:00') and CONVERT( TIME,'14:00' ) then MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '14:00') and CONVERT( TIME,'15:00' ) then MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '15:00') and CONVERT( TIME,'16:00' ) then MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '16:00') and CONVERT( TIME,'17:00' ) then MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '17:00') and CONVERT( TIME,'18:00' ) then MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '18:00') and CONVERT( TIME,'19:00' ) then MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '19:00') and CONVERT( TIME,'20:00' ) then MaLichSuPhieu end) )
from #temp_t1 where  MaBan Like '%W%' and  TenHangBan not like '%Child%' or  TenHangBan not like '%Baby%' or  TenHangBan  not like '%tre em%'

select T8h_9h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '08:00') and CONVERT( TIME,'09:00' ) then MaLichSuPhieu end) ), 
T9h_10h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '09:00') and CONVERT( TIME,'10:00' ) then MaLichSuPhieu end) ),
T10h_11h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '10:00') and CONVERT( TIME,'11:00' ) then MaLichSuPhieu end) ),
T11_12h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '11:00') and CONVERT( TIME,'12:00' ) then MaLichSuPhieu end) ),
T12h_13h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '12:00') and CONVERT( TIME,'13:00' ) then MaLichSuPhieu end) ),
T13h_14h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '13:00') and CONVERT( TIME,'14:00' ) then MaLichSuPhieu end) ),
T14h_15h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '14:00') and CONVERT( TIME,'15:00' ) then MaLichSuPhieu end) ),
T15h_16h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '15:00') and CONVERT( TIME,'16:00' ) then MaLichSuPhieu end) ),
T16h_17h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '16:00') and CONVERT( TIME,'17:00' ) then MaLichSuPhieu end) ),
T17h_18h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '17:00') and CONVERT( TIME,'18:00' ) then MaLichSuPhieu end) ),
T18h_19h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '18:00') and CONVERT( TIME,'19:00' ) then MaLichSuPhieu end) ),
T19h_20h =  count(distinct (case when substring(Ngay,0,5) = @tuNam AND  Gio between  CONVERT( TIME, '19:00') and CONVERT( TIME,'20:00' ) then MaLichSuPhieu end) )
from #temp_t1 where  MaBan Like '%W%' and  TenHangBan  like '%Child%' or  TenHangBan  like '%Baby%' or  TenHangBan   like '%tre em%'
";
		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNam', $tuNam);
				
				$stmt->execute();
				$rowset =  array();
				do {

				    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
				    
				} while ($stmt->nextRowset());

				return $rowset;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}


	public function getCancelledFoodItem_Day ( $tuNgay, $tenQuay ) 
	{	

		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNgay varchar(max)
		SET @tuNgay = :tuNgay
		SELECT a.*, b.*,c.* FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],126),0,11 ) = @tuNgay  " ;

		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNgay', $tuNgay);
			
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			return $rs;
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItem_Month ( $tuThang, $tenQuay ) 
	{	
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuThang varchar(max)
		SET @tuThang = :tuThang
		SELECT a.*, b.*,c.* FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],126),0,8 ) = @tuThang " ;

		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}
		
		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuThang', $tuThang);
			
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			return $rs;
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItem_Year ( $tuNam, $tenQuay ) 
	{	
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNam varchar(max)
		SET @tuNam = :tuNam
		SELECT a.*, b.*,c.* FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],126),0,5 ) = @tuNam " ;

		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}
		
		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNam', $tuNam);
			
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			return $rs;
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getSumFoodCancelledByDate( $date ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' group by TenHangBan ";

		try{
				$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getSumFoodCancelledByMonth ( $month ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month'  group by TenHangBan";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getSumFoodCancelledBySelection ( $tungay, $denngay ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) between '$tungay' and '$denngay'  group by TenHangBan " ;
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	private function getSalesByTableID ( $date, $occupation = null ){
		if( $occupation == '0' && $occupation != null )
		{
			$sql = "SELECT count(*) FROM ( SELECT  a.MaBan, sum(TienThucTra) as DoanhThu  from  [tblDMBan] a left join [tblLichSuPhieu] b on  a.MaBan = b.MaBan and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date' where [ThoiGianDongPhieu] IS NOT NULL  group by a.MaBan order by DoanhThu DESC ) t1";
		}
		elseif ( $occupation == '1' )
		{
			$sql = "SELECT count(*) FROM ( SELECT a.MaBan, sum(TienThucTra) as DoanhThu  from  [tblDMBan] a 
					left join [tblLichSuPhieu] b on  a.MaBan = b.MaBan	
					and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
					= '$date' where [ThoiGianDongPhieu] is   null 
					group by a.MaBan order by DoanhThu DESC ) t1";
		}
		elseif ( $occupation == null)
		{
			$sql = "SELECT count(*) FROM 
			( SELECT  a.MaBan, sum(TienThucTra) as DoanhThu from  [tblDMBan]a left join [tblLichSuPhieu] b on  a.MaBan = b.MaBan	and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
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
	
	private function getSalesByTableID_Paginate( $itemcount,  $date, $occupation ){

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
						[tblDMBan] a 
						left join [tblLichSuPhieu] b on 
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

	private function getSalesByFoodNames ( $date, $table_id, $occupation = null ){

		if( $occupation == '0' && $occupation != null )
		{
		 	$sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
					sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
				 from [tblDMBan] a
				 left join [tblLichSuPhieu] b
				 on a.[MaBan] = b.[MaBan]
				 join  [tblLSPhieu_HangBan] c
				 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
				 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'

				 and a.MaBan ='$table_id'";
		}
		elseif( $occupation == '1' )
		{
			$sql = "SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
				sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
			 from [tblDMBan] a
			 left join [tblLichSuPhieu] b
			 on a.[MaBan] = b.[MaBan]
			 join  [tblLSPhieu_HangBan] c
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
	
	

	public function getQtyOrderSummary_Day( $tuNgay, $tenQuay ) 
	{	
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		 $sql = " DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		  SELECT SUM(CASE WHEN SoLuong<=1 THEN 1 ELSE 0 END) as LessThanOrEqualTo1,
			 SUM(CASE WHEN SoLuong between 1 and 2 THEN 1 ELSE 0 END) as From1To2,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From2To3,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From3To4,
			 SUM(CASE WHEN SoLuong >=4 THEN 1 ELSE 0 END) as GreaterThan4
			 from
				(select a.MaLichSuPhieu, sum (SoLuong) as SoLuong
				from [tblLichSuPhieu] a Join
				[tblLSPhieu_HangBan] b
				on   a.MaLichSuPhieu = b.MaLichSuPhieu Where 
				substring( Convert(varchar,ThoiGianBan,126),0,11 ) = @tuNgay
				";

	 		
		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		$sql .= " group by a.MaLichSuPhieu) t1";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesAmountSummary_Day( $tuNgay, $tenQuay ) 
	{
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		SELECT SUM(CASE WHEN TienThucTra<=500000 THEN 1 ELSE 0 END) as LessThanOrEqualToHalfMil,
				 SUM(CASE WHEN TienThucTra between 500000 and 1000000 THEN 1 ELSE 0 END) as FromHalfMilTo1,
				 SUM(CASE WHEN TienThucTra between 1000000 and 2000000 THEN 1 ELSE 0 END) as From1To2,
				 SUM(CASE WHEN TienThucTra between 2000000 and 3000000 THEN 1 ELSE 0 END) as From2To3,
				 SUM(CASE WHEN TienThucTra between 3000000 and 4000000 THEN 1 ELSE 0 END) as From3To4,
				 SUM(CASE WHEN TienThucTra >=4000000 THEN 1 ELSE 0 END) as GreaterThan4
				 from
					(
					select a.MaLichSuPhieu, sum (TienThucTra) as TienThucTra
					from [tblLichSuPhieu] a  Where 
					substring( Convert(varchar,ThoiGianTaoPhieu,126),0,11 ) = @tuNgay
				";

		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		$sql .= " group by a.MaLichSuPhieu) t1";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getQtyOrderSummary_Month( $tuThang, $tenQuay ) 
	{	
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		 $sql = " DECLARE @tuThang varchar(max)
		 SET @tuThang = :tuThang
		 SELECT SUM(CASE WHEN SoLuong<=1 THEN 1 ELSE 0 END) as LessThanOrEqualTo1,
			 SUM(CASE WHEN SoLuong between 1 and 2 THEN 1 ELSE 0 END) as From1To2,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From2To3,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From3To4,
			 SUM(CASE WHEN SoLuong >=4 THEN 1 ELSE 0 END) as GreaterThan4
			 from
				(select a.MaLichSuPhieu, sum (SoLuong) as SoLuong
				from [tblLichSuPhieu] a Join
				[tblLSPhieu_HangBan] b
				on   a.MaLichSuPhieu = b.MaLichSuPhieu Where 
				substring( Convert(varchar,ThoiGianBan,126),0,8 ) = @tuThang
				";

	if( ! empty($tenQuay) )
	{
		$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
	}

		 $sql .= " group by a.MaLichSuPhieu) t1";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuThang', $tuThang);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesAmountSummary_Month( $tuThang, $tenQuay ) 
	{	
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuThang varchar(max)
		 SET @tuThang = :tuThang
		 SELECT SUM(CASE WHEN TienThucTra<=500000 THEN 1 ELSE 0 END) as LessThanOrEqualToHalfMil,
				 SUM(CASE WHEN TienThucTra between 500000 and 1000000 THEN 1 ELSE 0 END) as FromHalfMilTo1,
				 SUM(CASE WHEN TienThucTra between 1000000 and 2000000 THEN 1 ELSE 0 END) as From1To2,
				 SUM(CASE WHEN TienThucTra between 2000000 and 3000000 THEN 1 ELSE 0 END) as From2To3,
				 SUM(CASE WHEN TienThucTra between 3000000 and 4000000 THEN 1 ELSE 0 END) as From3To4,
				 SUM(CASE WHEN TienThucTra >=4000000 THEN 1 ELSE 0 END) as GreaterThan4
				 from
					(
					select a.MaLichSuPhieu, sum (TienThucTra) as TienThucTra
					from [tblLichSuPhieu] a  Where 
					substring( Convert(varchar,ThoiGianTaoPhieu,126),0,8 ) = @tuThang
				";
		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		$sql .= " group by a.MaLichSuPhieu) t1";

		try{
				
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuThang', $tuThang);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getQtyOrderSummary_Year( $tuNam, $tenQuay ) 
	{
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		 $sql = "DECLARE @tuNam varchar(max)
		 SET @tuNam = :tuNam
		  SELECT SUM(CASE WHEN SoLuong<=1 THEN 1 ELSE 0 END) as LessThanOrEqualTo1,
			 SUM(CASE WHEN SoLuong between 1 and 2 THEN 1 ELSE 0 END) as From1To2,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From2To3,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From3To4,
			 SUM(CASE WHEN SoLuong >=4 THEN 1 ELSE 0 END) as GreaterThan4
			 from
				(select a.MaLichSuPhieu, sum (SoLuong) as SoLuong
				from [tblLichSuPhieu] a Join
				[tblLSPhieu_HangBan] b
				on   a.MaLichSuPhieu = b.MaLichSuPhieu Where 
				substring( Convert(varchar,ThoiGianBan,126),0,5 ) = @tuNam
				";

	if( ! empty($tenQuay) )
	{
		$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
	}

		 $sql .= " group by a.MaLichSuPhieu) t1";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNam', $tuNam);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSalesAmountSummary_Year( $tuNam, $tenQuay ) 
	{	
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNam varchar(max)
		 SET @tuNam = :tuNam
		 SELECT SUM(CASE WHEN TienThucTra<=500000 THEN 1 ELSE 0 END) as LessThanOrEqualToHalfMil,
				 SUM(CASE WHEN TienThucTra between 500000 and 1000000 THEN 1 ELSE 0 END) as FromHalfMilTo1,
				 SUM(CASE WHEN TienThucTra between 1000000 and 2000000 THEN 1 ELSE 0 END) as From1To2,
				 SUM(CASE WHEN TienThucTra between 2000000 and 3000000 THEN 1 ELSE 0 END) as From2To3,
				 SUM(CASE WHEN TienThucTra between 3000000 and 4000000 THEN 1 ELSE 0 END) as From3To4,
				 SUM(CASE WHEN TienThucTra >=4000000 THEN 1 ELSE 0 END) as GreaterThan4
				 from
					(
					select a.MaLichSuPhieu, sum (TienThucTra) as TienThucTra
					from [tblLichSuPhieu] a  Where 
					substring( Convert(varchar,ThoiGianTaoPhieu,126),0,5 ) = @tuNam
				";

		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		$sql .= " group by a.MaLichSuPhieu) t1";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNam', $tuNam);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getFoodSoldQtyByHour_Day( $tenQuay, $tuNgay )
	{
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		 $sql = "DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		 select
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
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '20h-21h',
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '21h-22h',
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '22h-23h',
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '23h-24h'
			from [tblLSPhieu_HangBan]
			where substring( Convert(varchar,[ThoiGianBan],126),0,11 ) = @tuNgay
			";

		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}


		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}

	}

	public function getSalesAmountByHour_Day( $tenQuay, $tuNgay )
	{
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}
		
		$sql = "DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		select
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
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '20h-21h',
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '21h-22h',
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '22h-23h',
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '23h-24h'
						
					from [tblLSPhieu_HangBan]

					where substring( Convert(varchar,[ThoiGianBan],126),0,11 ) = @tuNgay
			";
		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}
	
		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}

	}

	public function getFoodSoldQtyByHour_Month( $tenQuay, $tuThang )
	{
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuThang varchar(max)
		 SET @tuThang = :tuThang
		select
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
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '20h-21h',
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '21h-22h',
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '22h-23h',
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '23h-24h'
			from [tblLSPhieu_HangBan]
			where substring( Convert(varchar,[ThoiGianBan],126),0,8 ) = @tuThang
			";

		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}


		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuThang', $tuThang);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}

	}

	public function getSalesAmountByHour_Month( $tenQuay, $tuThang )
	{
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}
		
		$sql = "DECLARE @tuThang varchar(max)
		 SET @tuThang = :tuThang
		select
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
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '20h-21h',
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '21h-22h',
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '22h-23h',
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '23h-24h'
						
					from [tblLSPhieu_HangBan]

					where substring( Convert(varchar,[ThoiGianBan],126),0,8 ) = @tuThang
			";
		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}
	
		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuThang', $tuThang);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}

	}

	public function getFoodSoldQtyByHour_Year( $tenQuay, $tuNam )
	{
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		 $sql = "DECLARE @tuNam varchar(max)
		 SET @tuNam = :tuNam
		 select
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
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '20h-21h',
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '21h-22h',
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '22h-23h',
				SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
				between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '23h-24h'
			from [tblLSPhieu_HangBan]
			where substring( Convert(varchar,[ThoiGianBan],126),0,5 ) = @tuNam
			";

		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}


		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNam', $tuNam);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}

	}

	public function getSalesAmountByHour_Year( $tenQuay, $tuNam )
	{
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}
		
		$sql = "DECLARE @tuNam varchar(max)
		 SET @tuNam = :tuNam
		select
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
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '20h-21h',
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '21h-22h',
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '22h-23h',
						SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
						between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '23h-24h'
						
					from [tblLSPhieu_HangBan]

					where substring( Convert(varchar,[ThoiGianBan],126),0,5 ) = @tuNam
			";
		if( ! empty($tenQuay) )
		{
			$sql .=" AND TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}
	
		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNam', $tuNam);
				
				$stmt->execute();

				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}

	}


	public function getNDMNhomHangBan( $tenQuay ) 
	{	
		$tenQuay = htmlentities(trim(strip_tags($tenQuay)),ENT_QUOTES,'utf-8');

		$sql = "DECLARE @tenQuay varchar(max)
		SET @tenQuay = :tenQuay
		select * from [tblDMNhomHangBan] where TenQuay = @tenQuay order By Ten";
		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tenQuay', $tenQuay);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getChiNhanh(){
		$sql="SELECT * FROM tblDMTrungTam Order by MaTrungTam";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
				
				if( $rs != false) 
					return $rs;
				
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getAllFoodItems(){
		$sql=" SELECT a.MaHangBan, a.TenHangBan , b.MaHangBan, b.Gia FROM [tblDMHangBan] a   join [tblGiaBanHang] b ON a.[MaHangBan] = b.[MaHangBan] WHERE MaNhomHangBan IS NOT NULL";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getAllFoodGroups(){
		$sql="SELECT * FROM [tblDMNhomHangBan]  order by ten";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getFoodItemsByGroup( $food_group ) 
	{	
		$food_group = htmlentities(trim(strip_tags($food_group)),ENT_QUOTES,'utf-8');

		$sql=" SELECT a.MaHangBan, a.TenHangBan , b.MaHangBan, b.Gia FROM [tblDMHangBan] a   join [tblGiaBanHang] b ON a.[MaHangBan] = b.[MaHangBan] AND MaNhomHangBan = '$food_group' AND MaNhomHangBan IS NOT NULL";
		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('food_group', $food_group);
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function layDSQuay() {
		$sql="select * from [tblDMQuay]";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
								
				return $rs;
				
				
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getTotalSales( $tuNgay ) 
	{
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		 $sql="DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		 SELECT sum(TienThucTra) as TienThucTra from [tblLichSuPhieu]  a  join [tblDMKhu] b on a.MaKhu = b.Makhu join [tblDMQuay] c on b.MaQuay = c.MaQuay  where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null and substring( Convert(varchar,[GioVao],126),0,11 ) = @tuNgay";

		try
		{		
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNgay', $tuNgay);
			
			$stmt->execute();

			$rs = $stmt->fetchColumn();
			return $rs;
				
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getBillAmount( $tuNgay , $ma_quay = null) 
	{
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( $ma_quay == null )
		{
			 $sql="DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		 SELECT count(*) from [tblLichSuPhieu]  a  join [tblDMKhu] b on a.MaKhu = b.Makhu join [tblDMQuay] c on b.MaQuay = c.MaQuay  where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null and substring( Convert(varchar,[GioVao],126),0,11 ) = @tuNgay";
		}
		else
		{
		 $sql="DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		 SELECT count(*) from [tblLichSuPhieu]  a  join [tblDMKhu] b on a.MaKhu = b.Makhu join [tblDMQuay] c on b.MaQuay = c.MaQuay  where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null and substring( Convert(varchar,[GioVao],126),0,11 ) = @tuNgay and c.MaQuay = '$ma_quay'";
		}

		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNgay', $tuNgay);
			
			$stmt->execute();

			$rs = $stmt->fetchColumn();
			return $rs;
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getDoanhThuNamNay( $tenQuay )
	{
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "";

		$sql .= "Declare @year varchar(max)
		     SET @year = YEAR(GETDATE())
		  SELECT ";

		for ( $i = 1; $i <= 12; $i++ ){

		    if($i <= 9){
		     $sql .= "
		     SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,8) like @year + '-0$i' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
		   }

		    if($i > 9){
		      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,8) like @year + '-$i' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
		    }
		}
		  
		$sql = rtrim($sql, ", ");

		$sql .=" FROM [tblLichSuPhieu] a LEFT JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
		    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1 ";

		if( ! empty($tenQuay) )
		{
		    $sql .=" AND b.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try
		{
			$stmt = $this->conn->prepare($sql);
			
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			return $rs;
		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}
	
	public function getDoanhThuNamTruoc( $tenQuay )
	{
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "";

		$sql .= "Declare @year varchar(max)
		     SET @year = YEAR( DATEADD(year, -1, GETDATE() ) )
		  SELECT ";

		for ( $i = 1; $i <= 12; $i++ ){

		    if($i <= 9){
		     $sql .= "
		     SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,8) like @year + '-0$i' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
		   }

		    if($i > 9){
		      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,8) like @year + '-$i' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
		    }
		}
		  
		$sql = rtrim($sql, ", ");

		$sql .=" FROM [tblLichSuPhieu] a LEFT JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
		    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1 ";

		if( ! empty($tenQuay) )
		{
		    $sql .=" AND b.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try
		{
			$stmt = $this->conn->prepare($sql);
			
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			return $rs;
		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}

	public function getDoanhThuNamKhac( $tenQuay, $tuNam )
	{
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl ) )
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}
		$sql = "";

		$sql .= "Declare @year varchar(max)
		SET @year = :year
		  SELECT ";

		for ( $i = 1; $i <= 12; $i++ ){

		    if($i <= 9){
		     $sql .= "
		     SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,8) like  @year + '-0$i' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
		   }

		    if($i > 9){
		      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,8) like  @year + '-$i' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
		    }
		}
		  
		$sql = rtrim($sql, ", ");

		$sql .=" FROM [tblLichSuPhieu] a LEFT JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
		    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1 ";

		if( ! empty($tenQuay) )
		{
		     $sql .=" AND b.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try
		{
			$stmt = $this->conn->prepare($sql);
			//$yearArr = array_pad( array(), 12, $tuNam );
			// for ( $i = 1; $i <= 12; $i++ )
			// {
			// 	$stmt->bindValue($i, $tuNam, PDO::PARAM_INT);
			// }
			$stmt->bindParam('year', $tuNam);
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			return $rs;
		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}

	public function getDoanhThuThangNay( $tenQuay )
	{
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "";
		$date = date('Y-m');
		$sql .= "Declare @date varchar(max)
		     SET @date = :date
		SELECT ";

		for ( $i = 1; $i <= 31; $i++ )
		{

			if($i <= 9)
			{
			    $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,11) like @date + '-0$i' Then TienThucTra  Else 0 END) as DoanhThu_0" . $i . ", "; 
			}

			if($i > 9)
			{
			    $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,11) like @date + '-$i' Then TienThucTra  Else 0 END) as DoanhThu_" . $i . ", "; 
			}
		}

		$sql = rtrim($sql, ", ");

		$sql .=" FROM [tblLichSuPhieu] a LEFT JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
		    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1 ";

		if( ! empty($tenQuay) )
		{
		    $sql .=" AND b.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('date', $date);
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rs;
		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}

	public function getDoanhThuThangTruoc( $tenQuay )
	{
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "";
		$date = date('Y-m',strtotime("first day of last month"));
		$sql .= "Declare @date varchar(max)
		     SET @date = :date
		SELECT ";

		for ( $i = 1; $i <= 31; $i++ )
		{

			if($i <= 9)
			{
			    $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,11) like @date + '-0$i' Then TienThucTra  Else 0 END) as DoanhThu_0" . $i . ", "; 
			}

			if($i > 9)
			{
			    $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,11) like @date + '-$i' Then TienThucTra  Else 0 END) as DoanhThu_" . $i . ", "; 
			}
		}

		$sql = rtrim($sql, ", ");

		$sql .=" FROM [tblLichSuPhieu] a LEFT JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
		    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1 ";

		if( ! empty($tenQuay) )
		{
		    $sql .=" AND b.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('date', $date);
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rs;
		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}

	public function getDoanhThuThangKhac( $tenQuay, $date  )
	{	
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "";
		$sql .= "Declare @date varchar(max)
		     SET @date = :date
		SELECT ";

		for ( $i = 1; $i <= 31; $i++ )
		{

			if($i <= 9)
			{
			    $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,11) like @date + '-0$i' Then TienThucTra  Else 0 END) as DoanhThu_0" . $i . ", "; 
			}

			if($i > 9)
			{
			    $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,126),0,11) like @date + '-$i' Then TienThucTra  Else 0 END) as DoanhThu_" . $i . ", "; 
			}
		}

		$sql = rtrim($sql, ", ");

		$sql .=" FROM [tblLichSuPhieu] a LEFT JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
		    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1 ";

		if( ! empty($tenQuay) )
		{
		    $sql .=" AND b.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}

		try
		{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('date', $date);
			$stmt->execute();

			$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $rs;
		}
		catch ( PDOException $error )
		{
			echo $error->getMessage();
		}
	}
	public function getTablesAndBills( $tuNgay,  $tenQuay = null ){

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "SET NOCOUNT ON;
		IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END
		declare @tuNgay varchar(max)
		set @tuNgay = :tuNgay
			select *
			  into #temp_t1 FROM(
			SELECT distinct b.MaBan, c.MaLichSuPhieu, GioVao,
						TenHangBan, DonGia	
						, sum( SoLuong ) OVER(PARTITION BY TenHangBan) AS SoLuong
						, ThanhTien = sum( SoLuong ) OVER(PARTITION BY TenHangBan) * DonGia
						, TongDoanhThu =  sum( Thanhtien ) OVER(PARTITION BY b.MaBan),
						MaNhanVien 
						FROM 
						[tblDMKhu] a
						join 	[tblDMBan] b 
						on a.[MaKhu] = b.[MaKhu]
						left join [tblLichSuPhieu] c
						on b.[MaBan] = c.[MaBan]
						and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = @tuNgay
						left JOIN [tblLSPhieu_HangBan] d
						on c.[MaLichSuPhieu] = d.[MaLichSuPhieu] 
		";

		if( ! empty($tenQuay) )
		{
			$sql .=" WHERE  d.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
		}		

		$sql .=" ) t1


				select MaBan, case when i.rnk=1 THEN i.MaLichSuPhieu  ELSE ' ' 	END as MaLichSuPhieu, 
				GioVao, TenHangBan, DonGia, SoLuong, ThanhTien, TongDoanhThu, MaNhanVien
				FROM (
					select *
					, row_number() over (partition by MaLichSuPhieu order by MaBan) as rnk
					from #temp_t1
				) i 
				order by MaBan DESC

			drop table #temp_t1 
			 
			";
			try
			{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}

	}

	public function getTablesAndBills_Occupied( $tuNgay, $tenQuay )
	{	
		$tuNgay = htmlentities(trim(strip_tags($tuNgay)),ENT_QUOTES,'utf-8');

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ){
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "SET NOCOUNT ON;
		IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END

			Declare @tuNgay varchar(max)
			SET @tuNgay = :tuNgay
			select *
			  into #temp_t1 FROM(
			SELECT distinct b.MaBan, c.MaLichSuPhieu, GioVao, ThoiGianDongPhieu,
				TenHangBan, DonGia	
				, sum( SoLuong ) OVER(PARTITION BY TenHangBan) AS SoLuong
				, ThanhTien = sum( SoLuong ) OVER(PARTITION BY TenHangBan) * DonGia
				, TongDoanhThu =  sum( Thanhtien ) OVER(PARTITION BY b.MaBan),
				MaNhanVien 
				FROM 
				[tblDMKhu] a
				join 	[tblDMBan] b 
				on a.[MaKhu] = b.[MaKhu]
				left join [tblLichSuPhieu] c
				on b.[MaBan] = c.[MaBan]
				and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = @tuNgay
				left JOIN [tblLSPhieu_HangBan] d
				on c.[MaLichSuPhieu] = d.[MaLichSuPhieu]

				WHERE c.MaLichSuPhieu IS NOT NULL and [ThoiGianDongPhieu] IS NULL 
			";

			if( ! empty($tenQuay) )
			{
				$sql .=" AND  d.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
			}

			 $sql .= " ) t1 select MaBan, case when i.rnk=1 THEN i.MaLichSuPhieu  ELSE ' ' 	END as MaLichSuPhieu, 
				GioVao,  TenHangBan, DonGia, SoLuong, ThanhTien, TongDoanhThu, MaNhanVien
				FROM (
					select *
					, row_number() over (partition by MaLichSuPhieu order by MaBan) as rnk
					from #temp_t1
				) i order by MaBan DESC

			drop table #temp_t1 
			 
			";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}

	}

	public function getTablesAndBills_Empty( $tuNgay, $tenQuay )
	{	
		$tuNgay = htmlentities(trim(strip_tags($tuNgay)),ENT_QUOTES,'utf-8');

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ){
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "SET NOCOUNT ON;
		IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END

			Declare @tuNgay varchar(max)
			SET @tuNgay = :tuNgay
			select *
			  into #temp_t1 FROM(
			SELECT distinct b.MaBan, c.MaLichSuPhieu, GioVao, ThoiGianDongPhieu,
						TenHangBan, DonGia	
						, sum( SoLuong ) OVER(PARTITION BY TenHangBan) AS SoLuong
						, ThanhTien = sum( SoLuong ) OVER(PARTITION BY TenHangBan) * DonGia
						, TongDoanhThu =  sum( Thanhtien ) OVER(PARTITION BY b.MaBan),
						MaNhanVien 
						FROM 
						[tblDMKhu] a
						join 	[tblDMBan] b 
						on a.[MaKhu] = b.[MaKhu]
						left join [tblLichSuPhieu] c
						on b.[MaBan] = c.[MaBan]
						and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = @tuNgay
						left JOIN [tblLSPhieu_HangBan] d
						on c.[MaLichSuPhieu] = d.[MaLichSuPhieu]

						WHERE ( c.MaLichSuPhieu IS  NULL 
							or ( c.MaLichSuPhieu IS  not NULL  and [ThoiGianDongPhieu] is not null )

						)
		";

			if( ! empty($tenQuay) )
			{
				$sql .="  AND  d.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] ) ";
			}
				$sql .= " ) t1 select MaBan, case when i.rnk=1 THEN i.MaLichSuPhieu  ELSE ' ' 	END as MaLichSuPhieu, 
				GioVao, TenHangBan, DonGia, SoLuong, ThanhTien, TongDoanhThu, MaNhanVien
				FROM (
					select *
					, row_number() over (partition by MaLichSuPhieu order by MaBan) as rnk
					from #temp_t1
				) i order by MaBan DESC

			drop table #temp_t1 
			 
			";

		try{
				$stmt = $this->conn->prepare($sql);		
				$stmt->bindParam('tuNgay', $tuNgay);
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}

	}
	
	public function getSalesSpa_KhuNam()
	{
		$sql = "SET NOCOUNT ON;
		IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END

			select * into #temp_t1 FROM (
			SELECT distinct a.MaKhu, b.MaLichSuPhieu, GioVao, ThoiGianDongPhieu,
				TenHangBan ,DonGia	
				, SoLuong = sum( SoLuong ) OVER(PARTITION BY TenHangBan)
				, ThanhTien = sum( SoLuong ) OVER(PARTITION BY TenHangBan) * DonGia
				, TongDoanhThu =  sum( Thanhtien ) OVER(PARTITION BY a.MaKhu)
				,MaNhanVien 
				FROM 
				[tblDMKhu] a
				--join 	[tblDMBan] b 
				--on a.[MaKhu] = b.[MaKhu]
				left join [tblLichSuPhieu] b
				on a.MaKhu = b.MaKhu
				and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = convert(varchar, getdate(), 126)
				left JOIN [tblLSPhieu_HangBan] c
				on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]
				
				where (a.MaKhu = '03-NH1' or a.MaKhu = '03-NH2' or a.MaKhu = '03-NH3')
				--and b.MaLichSuPhieu='03-1-20150826-0014' 
				--or b.MaLichSuPhieu='03-1-20150826-0003'
				--or b.MaLichSuPhieu='03-1-20191211-1507'
				--or b.MaLichSuPhieu='03-1-20191211-1508'
				--and [ThoiGianDongPhieu] IS NOT NULL
			) t1
			
			select distinct MaKhu,
			TotalQty = SUM(CASE WHEN [MaLichSuPhieu] <> ' ' then 1 else 0 end)
			from #temp_t1 group by MaKhu

			SELECT MaKhu, case when i.rnk=1 then MaLichSuPhieu else ' ' END as MaLichSuPhieu,
			 TenHangBan, GioVao, DonGia , SoLuong , ThanhTien , MaNhanVien ,TongDoanhThu FROM
			 ( SELECT *, row_number() over(partition by MaLichSuPhieu order by MaLichSuPhieu )
			  as rnk from #temp_t1 ) i  ORDER BY Makhu

			  drop table #temp_t1";

		$stmt = $this->conn->query($sql);
	  	$rowset =  array();

		do {

		    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    
		} while ($stmt->nextRowset());

		return $rowset;

	}

	public function getSalesSpa_KhuNu()
	{
		$sql = "SET NOCOUNT ON;
		IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END

			select * into #temp_t1 FROM (
			SELECT distinct a.MaKhu, b.MaLichSuPhieu, GioVao, ThoiGianDongPhieu,
				TenHangBan ,DonGia	
				, SoLuong = sum( SoLuong ) OVER(PARTITION BY TenHangBan)
				, ThanhTien = sum( SoLuong ) OVER(PARTITION BY TenHangBan) * DonGia
				, TongDoanhThu =  sum( Thanhtien ) OVER(PARTITION BY a.MaKhu)
				,MaNhanVien 
				FROM 
				[tblDMKhu] a
				--join 	[tblDMBan] b 
				--on a.[MaKhu] = b.[MaKhu]
				left join [tblLichSuPhieu] b
				on a.MaKhu = b.MaKhu
				and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) =  convert(varchar, getdate(), 126)
				left JOIN [tblLSPhieu_HangBan] c
				on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]
				
				where (a.MaKhu = '03-NH4' or a.MaKhu = '03-NH5' or a.MaKhu = '03-NH6')
				--and b.MaLichSuPhieu='03-1-20150826-0014' 
				--or b.MaLichSuPhieu='03-1-20150826-0003'
				--or b.MaLichSuPhieu='03-1-20191211-1507'
				--or b.MaLichSuPhieu='03-1-20191211-1508'
				--and [ThoiGianDongPhieu] IS NOT NULL
			) t1
			
			select distinct MaKhu,
			TotalQty = SUM(CASE WHEN [MaLichSuPhieu] <> ' ' then 1 else 0 end)
			from #temp_t1 group by MaKhu


			SELECT MaKhu, case when i.rnk=1 then MaLichSuPhieu else ' ' END as MaLichSuPhieu,
			 TenHangBan, GioVao, DonGia , SoLuong , ThanhTien , MaNhanVien ,TongDoanhThu FROM
			 ( SELECT *, row_number() over(partition by MaLichSuPhieu order by MaLichSuPhieu )
			  as rnk from #temp_t1 ) i  ORDER BY Makhu

			  drop table #temp_t1";

		$stmt = $this->conn->query($sql);
	  	$rowset =  array();

		do {

		    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		    
		} while ($stmt->nextRowset());

		return $rowset;
	}
	
	public function getSalesSpa_Advanced_Rec( $ma_khu,  $tuNgay, $denNgay, $where, $paginating )
	{	
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( empty($denNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( empty($paginating) || strpos($paginating, 'RowNum') === false) 
		{
			throw new InvalidArgumentException('paginating missing');
		}

		if( $ma_khu ==='nam' )
		{
			$ma_khu = $this->khu_nam;
		}
		elseif( $ma_khu === 'nu' )
		{
			$ma_khu = $this->khu_nu;
		}
		else
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "SET NOCOUNT ON;
		DECLARE @tuNgay varchar(max)
		DECLARE @denNgay varchar(max)
		SET @tuNgay = :tuNgay
		SET @denNgay = :denNgay
		IF OBJECT_ID(N'tempdb..#temp_t1') IS NOT NULL BEGIN DROP TABLE #temp_t1 END 

			select * into #temp_t1 FROM ( SELECT distinct a.MaKhu, a.MaLichSuPhieu, 
			GioVao, ThoiGianDongPhieu, TenHangBan ,DonGia , SoLuong = sum( SoLuong ) 
			OVER(PARTITION BY a.MaLichSuPhieu, TenHangBan) , 
			ThanhTien = sum( SoLuong ) 	OVER(PARTITION BY a.MaLichSuPhieu, TenHangBan) * DonGia , 
			TongDoanhThu = sum( ThanhTien ) OVER(PARTITION BY a.MaKhu) ,MaNhanVien ,
			CheckIn = substring( Convert(varchar,GioVao,126),12,5 ),  CheckOut = substring( Convert(varchar,ThoiGianDongPhieu,126),12,5 ) 
			FROM [tblLichSuPhieu] a 
			left JOIN [tblLSPhieu_HangBan] b 
			on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
			where substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) 
			between @tuNgay and @denNgay  and  $ma_khu
			 AND a.MaLichSuPhieu IS NOT NULL AND TenHangBan IN ( SELECT * FROM [SPA_ALLView] )
			)
			 t1 
 
			 ; WITH cte_1 AS ( SELECT MaKhu, case when i.rnk=1 then MaLichSuPhieu else MaLichSuPhieu END as 
			 MaLichSuPhieu, TenHangBan, GioVao, CheckIn, CheckOut, DonGia , SoLuong , ThanhTien , MaNhanVien 
			 ,TongDoanhThu, RowNum = row_number() over (order by MaLichSuPhieu) 
			 FROM ( SELECT *, row_number() 
			 over(partition by MaLichSuPhieu order by MaLichSuPhieu ) as rnk from #temp_t1 ) i )
			";

		if ( $where == "" )
		{
			$sql .= 'SELECT MaLichSuPhieu, MaNhanVien, GioVao,  TenHangBan, DonGia, SoLuong, ThanhTien, CheckIn, CheckOut FROM   cte_1';
	    	$sql .= " WHERE ". $paginating ;
	    	$sql .= "UNION ALL SELECT MaLichSuPhieu, NULL, NULL, NULL, NULL,  SUM (SoLuong), SUM (ThanhTien), NULL, NULL FROM cte_1 WHERE  $paginating   GROUP BY MaLichSuPhieu
 				ORDER BY MaLichSuPhieu, TenHangBan";
		}
		else
		{
			$sql .= ' ,
				cte_2 as (
					SELECT  RowNum = row_number() over (order by MaKhu), MaKhu, MaLichSuPhieu, TenHangBan, GioVao, DonGia , SoLuong , ThanhTien , MaNhanVien ,  TotalWhere = sum(ThanhTien)OVER(PARTITION BY MaKhu ) , TongDoanhThu, CheckIn, CheckOut
					FROM cte_1 
				WHERE ' . $where . '	
				)

				SELECT * FROM   cte_2';

			 $sql .= " WHERE " .  $paginating ;

			//WHERE ' . $where . '
		}

		      $sql .= " drop table #temp_t1";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				$stmt->bindParam('denNgay', $denNgay);
				
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}

	}


	public function getSalesSpa_Advanced_Tot( $ma_khu, $tuNgay, $denNgay, $where)
	{	
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( empty($denNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( $ma_khu ==='nam' )
		{
			$ma_khu = $this->khu_nam;
		}
		elseif( $ma_khu === 'nu' )
		{
			$ma_khu = $this->khu_nu;
		}
		else
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		 $sql = "SET NOCOUNT ON;
		DECLARE @tuNgay varchar(max)
		DECLARE @denNgay varchar(max)
		SET @tuNgay = :tuNgay
		SET @denNgay = :denNgay
		 IF OBJECT_ID(N'tempdb..#temp_t1') IS NOT NULL BEGIN DROP TABLE #temp_t1 END 

			select * into #temp_t1 FROM ( SELECT distinct a.MaKhu, a.MaLichSuPhieu, 
			GioVao, ThoiGianDongPhieu, TenHangBan ,DonGia , SoLuong = sum( SoLuong ) 
			OVER(PARTITION BY a.MaLichSuPhieu, TenHangBan) , 
			ThanhTien = sum( SoLuong ) 	OVER(PARTITION BY a.MaLichSuPhieu, TenHangBan) * DonGia , 
			TongDoanhThu = sum( ThanhTien ) OVER(PARTITION BY a.MaKhu) ,MaNhanVien , CheckIn = substring( Convert(varchar,GioVao,126),12,5 ),  CheckOut = substring( Convert(varchar,ThoiGianDongPhieu,126),12,5 ) 
			FROM [tblLichSuPhieu] a 
			left JOIN [tblLSPhieu_HangBan] b 
			on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
			where substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) 
			between  @tuNgay and @denNgay and  $ma_khu  AND TenHangBan IN ( SELECT * FROM [SPA_ALLView] )
			AND a.MaLichSuPhieu IS NOT NULL ) t1 ;

 
			SELECT count(*) FROM #temp_t1";

		if( $where != "" )
		{

	     	//if( stripos($sql, 'WHERE') !== false )  $sql .= "AND";  else  
	     	$sql .= " WHERE ";

	     	$sql .= $where;

     	}

			 $sql .= " drop table #temp_t1";

		try{	
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				$stmt->bindParam('denNgay', $denNgay);
				
				$stmt->execute();
				$rs = $stmt->fetchColumn();
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}

	}

	public function getSalesSpa_Advanced_TotalRev(  $ma_khu = null, $tuNgay, $denNgay )
	{	
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( empty($denNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if ($ma_khu !== null)
		{
			switch( $ma_khu ) 
			{
				case 'nam':
					$ma_khu = $this->khu_nam;
					break;
				case 'nu':
					$ma_khu = $this->khu_nu;
					break;
				default:
					throw new InvalidArgumentException('Your input was not valid!');
			}
		}

		$sql ="DECLARE @tuNgay varchar(max)
		DECLARE @denNgay varchar(max)
		SET @tuNgay = :tuNgay
		SET @denNgay = :denNgay
		SELECT  TongDoanhThu = sum( Thanhtien ) 
			FROM [tblLichSuPhieu] a 
			left JOIN [tblLSPhieu_HangBan] b 
			on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
			where substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) 
			between @tuNgay and @denNgay  ";

		if ( isset($ma_khu) )
		{
			$sql .=" and $ma_khu";
		}

		 $sql .= " AND TenHangBan IN ( SELECT * FROM [SPA_ALLView] )
			AND a.MaLichSuPhieu IS NOT NULL ";

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				$stmt->bindParam('denNgay', $denNgay);
				
				$stmt->execute();
				$rs = $stmt->fetchColumn();
		
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}
	
	public function getKhuList()
	{
		$sql = "select * FROM [tblDMKhu]";

		try{

			$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC); 
			
			return $rs;		
				
		}
		catch ( PDOException $error ){
			
			echo $error->getMessage();
	
		}

	}

	public function getDoanhThuSpa()
	{
		$sql = "
  SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'SPA' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,GETDATE() ,126),0,11 )

    SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'SPA' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -1, GETDATE()),126),0,11 )

      SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'SPA' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -7, GETDATE()),126),0,11 )";
  		try{

			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
		  	$rowset =  array();

			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($stmt->nextRowset());

			return $rowset;		
				
		}
		catch ( PDOException $error ){
			
			echo $error->getMessage();
	
		}
	} 

	public function getDoanhThuSnackBar()
	{
		$sql = "
  SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'SNACKBAR' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,GETDATE() ,126),0,11 )

    SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'SNACKBAR' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -1, GETDATE()),126),0,11 )

      SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'SNACKBAR' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -7, GETDATE()),126),0,11 )";
  		try{
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
		  	$rowset =  array();

			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($stmt->nextRowset());

			return $rowset;		
				
		}
		catch ( PDOException $error ){
			
			echo $error->getMessage();
	
		}
	}

	public function getDoanhThuCafeteria()
	{
		$sql = "
  SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'CAFE' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,GETDATE() ,126),0,11 )

    SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'CAFE' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -1, GETDATE()),126),0,11 )

      SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'CAFE' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -7, GETDATE()),126),0,11 )";
  		try{

			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
		  	$rowset =  array();

			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($stmt->nextRowset());

			return $rowset;		
				
		}
		catch ( PDOException $error ){
			
			echo $error->getMessage();
	
		}
	}

	public function getDoanhThuGame()
	{
		$sql = "
  SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'GAME' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,GETDATE() ,126),0,11 )

    SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'GAME' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -1, GETDATE()),126),0,11 )

      SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'GAME' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -7, GETDATE()),126),0,11 )";
  		try{

			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
		  	$rowset =  array();

			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($stmt->nextRowset());

			return $rowset;		
				
		}
		catch ( PDOException $error ){
			
			echo $error->getMessage();
	
		}
	}

	public function getDoanhThuNhaHang()
	{
		$sql = "
  SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'RESTAURANT' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,GETDATE() ,126),0,11 )

    SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'RESTAURANT' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -1, GETDATE()),126),0,11 )

      SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'RESTAURANT' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -7, GETDATE()),126),0,11 )";

  		try{

			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
		  	$rowset =  array();

			do {

			    $rowset[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($stmt->nextRowset());

			return $rowset;		
				
		}
		catch ( PDOException $error ){
			
			echo $error->getMessage();
	
		}
	}

	public function getRevByGroup_Day( $tenQuay, $tenNhom = null, $tuNgay )
	{	
		if( empty($tuNgay) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNgay varchar(max)
		SET @tuNgay = :tuNgay
		  SELECT distinct a.[MaHangBan], a.[TenHangBan], [MaDVT], SUM( [SoLuong]  ) OVER ( Partition BY a.[MaHangBan] ) as [SoLuong],
  (DonGia * SUM(SoLuong) OVER(PARTITION BY a.TenHangBan)) as ThanhTien, [Ten] as TenNhom
  FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMHangBan] b ON a.MaHangBan = b.MaHangBan LEFT JOIN [tblDMNhomHangBan] c ON b.MaNhomHangBan = c.Ma 
  WHERE substring( Convert(varchar,ThoiGianBan,126),0,11 ) = @tuNgay AND SoLuong > 0
   AND a.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";

		if( ! empty($tenNhom) )
		{
			 $sql .=" AND Ten ='$tenNhom' ";
		}

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNgay', $tuNgay);
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getRevByGroup_Month( $tenQuay, $tenNhom = null, $tuThang )
	{	
		if( empty($tuThang) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		 $sql = "DECLARE @tuThang varchar(max)
		SET @tuThang = :tuThang
		  SELECT distinct a.[MaHangBan], a.[TenHangBan], [MaDVT], SUM( [SoLuong]  ) OVER ( Partition BY a.[MaHangBan] ) as [SoLuong],
  (DonGia * SUM(SoLuong) OVER(PARTITION BY a.TenHangBan)) as ThanhTien, [Ten] as TenNhom
  FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMHangBan] b ON a.MaHangBan = b.MaHangBan LEFT JOIN [tblDMNhomHangBan] c ON b.MaNhomHangBan = c.Ma 
  WHERE substring( Convert(varchar,ThoiGianBan,126),0,8 ) = @tuThang AND SoLuong > 0
   AND a.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";

		if( ! empty($tenNhom) )
		{
			 $sql .=" AND Ten ='$tenNhom' ";
		}

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuThang', $tuThang);
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getRevByGroup_Year( $tenQuay, $tenNhom = null, $tuNam )
	{	
		if( empty($tuNam) ) 
		{
			throw new InvalidArgumentException('date missing');
		}

		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		 $sql = "DECLARE @tuNam varchar(max)
		SET @tuNam = :tuNam  
		 SELECT distinct a.[MaHangBan], a.[TenHangBan], [MaDVT], SUM( [SoLuong]  ) OVER ( Partition BY a.[MaHangBan] ) as [SoLuong],
  (DonGia * SUM(SoLuong) OVER(PARTITION BY a.TenHangBan)) as ThanhTien, [Ten] as TenNhom
  FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMHangBan] b ON a.MaHangBan = b.MaHangBan LEFT JOIN [tblDMNhomHangBan] c ON b.MaNhomHangBan = c.Ma 
  WHERE substring( Convert(varchar,ThoiGianBan,126),0,5 ) = @tuNam 
   AND a.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] ) AND SoLuong > 0";

		if( ! empty($tenNhom) )
		{
			 $sql .=" AND Ten ='$tenNhom' ";
		}

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->bindParam('tuNam', $tuNam);
				$stmt->execute();

				$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSoLuongVeKey_Day( $tuNgay, $tenQuay = null, $ma_khu)
	{	
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		if( $ma_khu === 'nam' )
		{
			$ma_khu = $this->khu_nam;
		}
		elseif( $ma_khu === 'nu' )
		{
			$ma_khu = $this->khu_nu;
		}
		else
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNgay varchar(max)
		 SET @tuNgay = :tuNgay
		SELECT  TotalKey = count(a.MaLichSuPhieu),
		TotalVe = sum (SoLuong), 
		ChenhLech = sum (SoLuong) - count(a.MaLichSuPhieu)
	 FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblLichSuPhieu] b ON a.MaLichSuPhieu = b.MaLichSuPhieu
	 where substring( Convert(varchar,ThoiGianBan,126),0,11 ) = @tuNgay and $ma_khu";

		if( ! empty($tenQuay) )
		{
			$sql .="  AND  TenHangBan IN ( SELECT * FROM [{$tenQuay}View] ) ";
		}

		try{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNgay', $tuNgay);
			
			$stmt->execute();

			$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		
			return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSoLuongVeKey_Month( $tuThang, $tenQuay, $ma_khu)
	{	
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}
		
		if( $ma_khu === 'nam' )
		{
			 $ma_khu = $this->khu_nam;
		}
		elseif( $ma_khu === 'nu' )
		{
			$ma_khu = $this->khu_nu;
		}
		else
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuThang varchar(max)
		 SET @tuThang = :tuThang
		SELECT  TotalKey = count(a.MaLichSuPhieu),
		TotalVe = sum (SoLuong), 
		ChenhLech = sum (SoLuong) - count(a.MaLichSuPhieu)
	 FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblLichSuPhieu] b ON a.MaLichSuPhieu = b.MaLichSuPhieu
	 where substring( Convert(varchar,ThoiGianBan,126),0,8 ) = @tuThang and $ma_khu";

		if( ! empty($tenQuay) )
		{
			$sql .="  AND  TenHangBan IN ( SELECT * FROM [{$tenQuay}View] ) ";
		}

		try{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuThang', $tuThang);
			
			$stmt->execute();

			$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		
			return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSoLuongVeKey_Year( $tuNam, $tenQuay, $ma_khu)
	{	
		if( ! empty($tenQuay) && ! in_array($tenQuay, $this->allowTbl) ) 
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}
		
		if( $ma_khu ==='nam' )
		{
			$ma_khu = $this->khu_nam;
		}
		elseif( $ma_khu === 'nu' )
		{
			$ma_khu = $this->khu_nu;
		}
		else
		{
			throw new InvalidArgumentException('Your input was not valid!');
		}

		$sql = "DECLARE @tuNam varchar(max)
		 SET @tuNam = :tuNam  SELECT  TotalKey = count(a.MaLichSuPhieu),
		TotalVe = sum (SoLuong), 
		ChenhLech = sum (SoLuong) - count(a.MaLichSuPhieu)
	 FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblLichSuPhieu] b ON a.MaLichSuPhieu = b.MaLichSuPhieu
	 where substring( Convert(varchar,ThoiGianBan,126),0,5 ) = @tuNam and $ma_khu";

		if( ! empty($tenQuay) )
		{
			$sql .="  AND  TenHangBan IN ( SELECT * FROM [{$tenQuay}View] ) ";
		}

		try{
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam('tuNam', $tuNam);
			
			$stmt->execute();

			$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		
			return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}



}

/**Note**/
