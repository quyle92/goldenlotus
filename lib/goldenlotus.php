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
		$sql = "INSERT INTO [tblDMBaoCao] (MaBaoCao, TenBaoCao, TenBaoCaoNN) VALUES ('$ma_bao_cao', N'$report_name', '$report_name_eng' )";
		try {
			$rs = $this->conn->query($sql);
		
			
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
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [tblDSNguoiSD] a,  [tblDMNhanVien] b where a.MaNhanVien = b.MaNV 		";
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
		$sql = "UPDATE [tblDSNguoiSD] SET [BaoCaoDuocXem] = '$report_arr' where MaNhanVien ='$maNV'";
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
		$sql = "SELECT * FROM [tblDMBaoCao] WHERE [MaBaoCao] = '$ma_bao_cao' ";
		try {
			$rs = $this->conn->query($sql)->fetch();
						
				return $rs['TenBaoCao'];
			
		}
		catch ( PDOException $error ) {
			echo $error->getMessage();
		}
	}

	public function layTenUser($maNV) {
		$sql = "SELECT TenSD, b.MaNV,b.TenNV, BaoCaoDuocXem FROM [tblDSNguoiSD] a,  [tblDMNhanVien] b where a.MaNhanVien = b.MaNV and MaNV ='$maNV'";
		try{
			$rs = $this->conn->query($sql)->fetch();
			
				return $rs;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getTenQuay()
	{
		$sql = "SELECT distinct TenQuay  FROM [SPA_HOANGSENQ3].[dbo].[tblDMNhomHangBan] ";
		try{
			$rs = $this->conn->query($sql)->fetchAll();
			
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
			$sql = "UPDATE [tblDSNguoiSD] SET [MatKhau] = PWDENCRYPT('$password') where MaNV ='$maNV'";
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
		$sql = "DELETE FROM  [tblDSNguoiSD] where [MaNhanVien] = '$maNV'";
		try{
			$rs = $this->conn->query($sql);
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}

	}

	public function countOccupiedTables( $tenQuay, $tuNgay ) : int {
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
			$nRows = $this->conn->query($sql)->fetchColumn();

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

	

	public function getFoodSoldThisMonth (  &$total = null, $ma_quay = '' ) 
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


	public function getFoodSoldLastMonth ( &$total = null, $ma_quay = '' ) {

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

	public function getFoodSoldAnotherMonth ($tu_thang, $den_thang, &$total = null, $ma_quay = null ) {
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

	public function getFoodSoldToday($hom_nay, &$total) {
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

	public function getFoodSoldYesterday($hom_truoc, &$total = null) {
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

	public function getFoodSoldAnotherDay($tungay, $denngay, &$total = null) {
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

	public function getBillDetailsToday($today, &$count = null ){
		  $sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [tblLSPhieu_HangBan] a JOIN  [tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$today' and SoLuong >0 ";
		 $sql_1 = "SELECT count(*) FROM ( SELECT  c.[MaLoaiThe] FROM [tblLSPhieu_HangBan] a JOIN  [tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$today' and SoLuong >0) t1 ";
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

	public function getBillDetailsYesterday( $yesterday, &$count = null){
		   $sql = "SELECT a.*, b.*, c.[MaLoaiThe] FROM [tblLSPhieu_HangBan] a JOIN  [tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$yesterday' and SoLuong >0 ";
		 $sql_1 = "SELECT count(*) FROM ( SELECT  c.[MaLoaiThe] FROM [tblLSPhieu_HangBan] a JOIN  [tblLichSuPhieu] b  ON a.MaLichSuPhieu=b.MaLichSuPhieu LEFT JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) ='$yesterday' and SoLuong >0) t1 ";
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


	public function getDatesHasBillOfThisMonth( $this_month, &$total_count = null ) {
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


	public function getDatesHasBillBySelection( $tungay, $denngay, &$total_count = null   ){
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

	public function getBillDetailsByDayOfMonth( $date, &$count = null ){
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
	
	public function getBillDetailsByMonthRange_Rec( $tungay, $denngay, $where , $paginating ){

		   $sql = "WITH cte_1 AS ( SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, b.ThoiGianBan, a.MaLichSuPhieu,b.TenHangBan, b.DonGia, b.SoLuong, a.TienGiamGia, a.NVTinhTienMaNV, a.SoTienDVPhi, a.SoTienVAT,  c.[MaLoaiThe], null AS Floor, null AS Note, null as Discount, ThanhTien = DonGia * SoLuong - TienGiamGia -SoTienDVPhi - SoTienVAT, RowNum = row_number() over (order by a.MaLichSuPhieu),
		   	   Tongtien =  DonGia * SoLuong
			FROM [tblLichSuPhieu] a 
			JOIN [tblLSPhieu_HangBan] b
			ON a.MaLichSuPhieu=b.MaLichSuPhieu  
			JOIN [tblLSPhieu_CTThanhToan] c
			ON b.MaLichSuPhieu=c.MaLichSuPhieu 
			WHERE substring( Convert(varchar,ThoiGianBan,111),0,11) between '$tungay' and '$denngay' and SoLuong >0 )
			 ";

		if ( $where == '')
	    {
	    	$sql .= 'SELECT * FROM   cte_1';
	    	$sql .= " WHERE ". $paginating ;
	    } 
	    else
	    {	
	    	$sql .= ' ,
	cte_2 as (
		SELECT  RowNum = row_number() over (order by MaLichSuPhieu), NgayCoBill, ThoiGianBan, MaLichSuPhieu, TenHangBan, DonGia, SoLuong, TienGiamGia, NVTinhTienMaNV, SoTienDVPhi, SoTienVAT,  [MaLoaiThe], null AS Floor, null AS Note, null as Discount, ThanhTien , Tongtien
		FROM cte_1 
		WHERE ' . $where . '
	)

	SELECT * FROM   cte_2';

	    	$sql .= " WHERE " .  $paginating ;



	    }
	  
		try{

	     	$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	       		
	       		return $rs;;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}

	public function getBillDetailsByMonthRange_Tot( $tungay, $denngay, $where ){
	
		$sql = "WITH cte AS ( SELECT substring( Convert(varchar,ThoiGianBan,111),0,11 ) as NgayCoBill, b.ThoiGianBan, a.MaLichSuPhieu,b.TenHangBan, b.DonGia, b.SoLuong, a.TienGiamGia, a.NVTinhTienMaNV, a.SoTienDVPhi, a.SoTienVAT,  c.[MaLoaiThe], null AS Floor, null AS Note, null as Discount, ThanhTien = DonGia * SoLuong - TienGiamGia -SoTienDVPhi - SoTienVAT, Tongtien,  RowNum = row_number() over (order by a.MaLichSuPhieu)
			FROM [tblLichSuPhieu] a 
			JOIN [tblLSPhieu_HangBan] b
			ON a.MaLichSuPhieu=b.MaLichSuPhieu  
			JOIN [tblLSPhieu_CTThanhToan] c
			ON b.MaLichSuPhieu=c.MaLichSuPhieu 
			WHERE substring( Convert(varchar,ThoiGianBan,111),0,11) between '$tungay' and '$denngay' and SoLuong >0 )

			SELECT count(*) FROM   cte  ";

		if( $where != "" ){

	     	//if( stripos($sql, 'WHERE') !== false )  $sql .= "AND";  else  
	     	$sql .= " WHERE ";

	     	 $sql .= $where;

     	}

		try{ //var_dump($sql);die;

	     	$rs = $this->conn->query($sql)->fetchColumn();
	       		
	       		return $rs;;
			
		}
		catch ( PDOException $error ){
			echo $error->getMessage();
		}
	}
	
	public function getBillDetailsThisMonth( $month, &$total = NULL ){
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

	public function getPayMethodDetailsByDate( $date, &$count = null ){
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
	
	public function getPayMethodDetailsByMonth( $month, &$total = null ){
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
	
	 public function getPayMethodDetailsByMonthRange_Rec(  $tungay, $denngay, $where , $paginating ){

  	$sql = "";
    $sql .= "With cte_1 as 
	( SELECT RowNum = row_number() over (order by b.MaLichSuPhieu), b.MaLichSuPhieu, MaKhachHang , TongTien , MaKhu,  MaBan, TienGiamGia , b.SoTienDVPhi , b. SoTienVAT , b.GioVao, b.ThoiGianDongPhieu, b.TienThucTra, c.[MaLoaiThe] FROM  [tblLichSuPhieu] b   JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,111),0,11 ) between '$tungay' and '$denngay'
	)  ";
    
    if ( $where == '')
    {	
    	$sql .= 'SELECT * FROM   cte_1';
    	$sql .= " WHERE " . $paginating ;
    } 
    else
    {	
    	$sql .= ' ,
	cte_2 as (
		SELECT  RowNum = row_number() over (order by MaLichSuPhieu), MaLichSuPhieu, MaKhachHang , TongTien , MaKhu, MaBan, TienGiamGia , SoTienDVPhi , SoTienVAT , GioVao,ThoiGianDongPhieu, TienThucTra, [MaLoaiThe] 
		FROM cte_1 
		WHERE ' . $where . '
	)

	SELECT * FROM   cte_2';

    	$sql .= " WHERE " . $paginating;

   }
      
    try{//var_dump($sql);die;
      
      	$rs = $this->conn->query($sql)->fetchAll();
      	return $rs;

    }
    catch ( PDOException $error ){
      echo $error->getMessage();
    }
  }

  public function getPayMethodDetailsByMonthRange_Tot(  $params, $tungay, $denngay, $where ){

  	$sql = "";
    $sql .= "With cte as 
	( SELECT RowNum = row_number() over (order by b.MaLichSuPhieu), b.MaLichSuPhieu, MaKhachHang , TongTien , MaKhu,  MaBan, TienGiamGia , b.SoTienDVPhi , b. SoTienVAT , b.GioVao, b.ThoiGianDongPhieu, b.TienThucTra, c.[MaLoaiThe] FROM  [tblLichSuPhieu] b   JOIN [tblLSPhieu_CTThanhToan] c ON b.MaLichSuPhieu=c.MaLichSuPhieu  WHERE substring( Convert(varchar,GioVao,111),0,11 ) between '$tungay' and '$denngay'
	) 
	SELECT count(*) FROM   cte";

     if( $where != "" ){

     	//if( stripos($sql, 'WHERE') !== false )  $sql .= "AND";  else  
     	$sql .= " WHERE ";

     	$sql .= $where;

     }

    try{
      
      $rs = $this->conn->query($sql)->fetchColumn();
      return $rs;

    }
    catch ( PDOException $error ){
      echo $error->getMessage();
    }
  }


	 public function getFoodGroupsByDate( $date ){
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

	public function getFoodSoldByGroup( $date, &$nhom_hang_ban_arr, $nhom_hang_ban = "" ){

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

	public function getFoodSoldByGroup_Month( $month, &$nhom_hang_ban_arr = "", $nhom_hang_ban = "" ){

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

	public function getFoodSoldByGroup_DateSelected( $tungay, $denngay, &$nhom_hang_ban_arr, $nhom_hang_ban = "" ){

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

	public function getSalesByFoodGroup( $date ){
		 $sql = "select Ma, Ten, sum (TotalMoney) as DoanhThu  from [tblDMNhomHangBan] x
right Join 
(	select t1.[MaNhomHangBan], t1.MaHangBan, t2.SoLuong, t2.DonGia, 
	t2.SoLuong * t2.DonGia as TotalMoney
	from [tblDMHangBan] t1
	left join (
		select MaHangBan, [TenHangBan], SoLuong, DonGia  from
		[tblLSPhieu_HangBan]
		where substring ( Convert(varchar,ThoiGianBan,111),0,8 ) ='$date' 
		and SoLuong >0 ) t2 
	on t2.MaHangBan = t1.MaHangBan 
) y
ON x.Ma = y.[MaNhomHangBan] where Ma IS NOT NULL group by Ma, Ten order by Ten";

			try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
			catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getDMNhomHangBan(){
		$sql="select * from [tblDMNhomHangBan] order by Ten";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}

	}
	
	public function getSalesByFoodGroupBySelection( $tungay, $denngay ){
		  $sql = "select Ma, Ten, sum (TotalMoney) as DoanhThu  from [tblDMNhomHangBan] x
		right Join 
		(	select t1.[MaNhomHangBan], t1.MaHangBan, t2.SoLuong, t2.DonGia, 
			t2.SoLuong * t2.DonGia as TotalMoney
			from [tblDMHangBan] t1
			left join (
				select MaHangBan, [TenHangBan], SoLuong, DonGia  from
				[tblLSPhieu_HangBan]
				where substring( Convert(varchar,ThoiGianBan,111),0,11 ) between '$tungay' and '$denngay'
				and SoLuong >0 ) t2 
			on t2.MaHangBan = t1.MaHangBan 
		) y
		ON x.Ma = y.[MaNhomHangBan] where Ma IS NOT NULL group by Ma, Ten order by Ten";

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
		FROM [tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,11 ) = '$date' group by TenHangBan";

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
		FROM [tblLSPhieu_HangBan] WHERE substring( Convert(varchar,ThoiGianBan,111),0,8 ) = '$month' group by TenHangBan";

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

	public function getCurrencyReportByDate( $date ){
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

	public function getCurrencyReportByMonth( $month ){
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

	public function getCurrencyReportBySelection( $tungay, $denngay ){
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

	public function getBillEditDetailsByDate( $date ){	
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

	public function getBillEditDetailsByMonth( $month ){	
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

	public function getBillEditDetailsBySelection( $tungay, $denngay ){
		$sql = "select a.* , b.*  FROM [tblLichSuPhieu] a LEFT JOIN [tblDMNhanVien] b
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
		$sql = "SELECT a.*, b.*,c.* FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' ";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItemByMonth ( $month ) {
		$sql = "SELECT a.*, b.*,c.* FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0 and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month' ";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getCancelledFoodItemBySelection ( $tungay, $denngay ) {
		$sql = "SELECT a.*, b.*,c.* FROM [tblLSPhieu_HangBan] a LEFT JOIN [tblDMNhanVien] b ON a.[MaNhanVien] = b.[MaNV] JOIN [tblLichSuPhieu] c on a.[MaLichSuPhieu] = c.[MaLichSuPhieu] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) between '$tungay' and '$denngay' " ;
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSumFoodCancelledByDate( $date ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date' group by TenHangBan ";

		try{
				$rs = $this->conn->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSumFoodCancelledByMonth ( $month ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,8 ) = '$month'  group by TenHangBan";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}

	public function getSumFoodCancelledBySelection ( $tungay, $denngay ) {
		$sql = "SELECT TenHangBan, sum (SoLuong) as SoLuong from [tblLSPhieu_HangBan] where soluong < 0  and substring( Convert(varchar,[ThoiGianBan],111),0,11 ) between '$tungay' and '$denngay'  group by TenHangBan " ;
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

	public function getSalesByFoodNames ( $date, $table_id, $occupation = null ){

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
	
	

	public function getQtyOrderSummary( $date ) {
		 $sql = " SELECT SUM(CASE WHEN SoLuong<=1 THEN 1 ELSE 0 END) as LessThanOrEqualTo1,
			 SUM(CASE WHEN SoLuong between 1 and 2 THEN 1 ELSE 0 END) as From1To2,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From2To3,
			 SUM(CASE WHEN SoLuong between 2 and 3 THEN 1 ELSE 0 END) as From3To4,
			 SUM(CASE WHEN SoLuong >=4 THEN 1 ELSE 0 END) as GreaterThan4
			 from
				(select a.MaLichSuPhieu, sum (SoLuong) as SoLuong
				from [tblLichSuPhieu] a Join
				[tblLSPhieu_HangBan] b
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
					from [tblLichSuPhieu] a  Where 
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
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '20h-21h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '21h-22h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '22h-23h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '23h-24h'
				from [tblLSPhieu_HangBan]
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
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '20h-21h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '21h-22h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '22h-23h',
					SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
					between '20:00:00' and '20:59:59' THEN SoLuong ELSE 0 END) as '23h-24h'
				from [tblLSPhieu_HangBan] a
					Left join [tblDMHangBan] b
					on a.MaHangBan = b.MaHangBan
					left join [tblDMNhomHangBan] c
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
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '20h-21h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '21h-22h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '22h-23h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '23h-24h'
							
						from [tblLSPhieu_HangBan]

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
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '20h-21h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '21h-22h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '22h-23h',
							SUM(CASE WHEN  substring( Convert(varchar,[ThoiGianBan],114),1,8 ) 
							between '20:00:00' and '20:59:59' THEN ThanhTien ELSE 0 END) as '23h-24h'
							
					from [tblLSPhieu_HangBan] b
						Left join [tblDMHangBan] c
						on b.MaHangBan = c.MaHangBan
						left join [tblDMNhomHangBan] d
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
		$sql = "select * from [tblDMNhomHangBan] order By Ten";
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

	public function getFoodItemsByGroup( $food_group ) {
		$sql=" SELECT a.MaHangBan, a.TenHangBan , b.MaHangBan, b.Gia FROM [tblDMHangBan] a   join [tblGiaBanHang] b ON a.[MaHangBan] = b.[MaHangBan] AND MaNhomHangBan = '$food_group' AND MaNhomHangBan IS NOT NULL";
		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
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

	public function getTotalSales( $date ) {

		$sql="SELECT sum(TienThucTra) as TienThucTra from [tblLichSuPhieu]  a  join [tblDMKhu] b on a.MaKhu = b.Makhu join [tblDMQuay] c on b.MaQuay = c.MaQuay  where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null and substring( Convert(varchar,[GioVao],126),0,11 ) = '$date'";


		try
		{
				$rs_1 = $this->conn->query($sql)->fetchColumn();
				$doanh_thu = $rs_1;
				
				return $doanh_thu;
				
				
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}

	public function getBillAmount( $date , $ma_quay = null) {

		if( $ma_quay == null )
		{
			 $sql="SELECT count(*) from [tblLichSuPhieu]  a  join [tblDMKhu] b on a.MaKhu = b.Makhu join [tblDMQuay] c on b.MaQuay = c.MaQuay  where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null and substring( Convert(varchar,[GioVao],126),0,11 ) = '$date'";
		}

		else{
		 $sql="SELECT count(*) from [tblLichSuPhieu]  a  join [tblDMKhu] b on a.MaKhu = b.Makhu join [tblDMQuay] c on b.MaQuay = c.MaQuay  where PhieuHuy = 0 and DaTinhTien = 1 and ThoiGianDongPhieu is not null and substring( Convert(varchar,[GioVao],126),0,11 ) = '$date' and c.MaQuay = '$ma_quay'";
		}
		try{
				$rs_1 = $this->conn->query($sql)->fetchColumn();
				$count = $rs_1;
				
				return $count;
				
				
		}
		catch ( PDOException $error ){
				echo $error->getMessage();
	
		}
	}
	
	public function getTablesAndBills( $date ){

		$sql = "IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END

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
						and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'
						left JOIN [tblLSPhieu_HangBan] d
						on c.[MaLichSuPhieu] = d.[MaLichSuPhieu]
						
						where a.MaKhu = '04-NH'
						--where b.MaBan='W.3' or b.MaBan='W.13'
			) t1


				select MaBan, case when i.rnk=1 THEN i.MaLichSuPhieu  ELSE ' ' 	END as MaLichSuPhieu, 
				GioVao, TenHangBan, DonGia, SoLuong, ThanhTien, TongDoanhThu, MaNhanVien
				FROM (
					select *
					, row_number() over (partition by MaLichSuPhieu order by MaBan) as rnk
					from #temp_t1
				) i order by MaBan DESC

			drop table #temp_t1 
			 
			";

		$rs = $this->conn->query($sql)->fetchAll();

		return $rs;

	}

	public function getTablesAndBills_Occupied( $date ){

		$sql = "IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END

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
						and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'
						left JOIN [tblLSPhieu_HangBan] d
						on c.[MaLichSuPhieu] = d.[MaLichSuPhieu]
						
						where a.MaKhu = '04-NH'
						--where (b.MaBan='W.3' or b.MaBan='W.13')
						and c.MaLichSuPhieu IS NOT NULL and [ThoiGianDongPhieu] IS NULL 
			) t1


				select MaBan, case when i.rnk=1 THEN i.MaLichSuPhieu  ELSE ' ' 	END as MaLichSuPhieu, 
				GioVao,  TenHangBan, DonGia, SoLuong, ThanhTien, TongDoanhThu, MaNhanVien
				FROM (
					select *
					, row_number() over (partition by MaLichSuPhieu order by MaBan) as rnk
					from #temp_t1
				) i order by MaBan DESC

			drop table #temp_t1 
			 
			";

		$rs = $this->conn->query($sql)->fetchAll();

		return $rs;

	}

	public function getTablesAndBills_Empty( $date ){

		$sql = "IF  OBJECT_ID(N'tempdb..#temp_t1')  IS NOT NULL
			BEGIN
			DROP TABLE #temp_t1
			END

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
						and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'
						left JOIN [tblLSPhieu_HangBan] d
						on c.[MaLichSuPhieu] = d.[MaLichSuPhieu]
						
						where a.MaKhu = '04-NH'
						--where (b.MaBan='W.3' or b.MaBan='W.13')
						and ( c.MaLichSuPhieu IS  NULL 
							or ( c.MaLichSuPhieu IS  not NULL  and [ThoiGianDongPhieu] is not null )
						)
			) t1


				select MaBan, case when i.rnk=1 THEN i.MaLichSuPhieu  ELSE ' ' 	END as MaLichSuPhieu, 
				GioVao, TenHangBan, DonGia, SoLuong, ThanhTien, TongDoanhThu, MaNhanVien
				FROM (
					select *
					, row_number() over (partition by MaLichSuPhieu order by MaBan) as rnk
					from #temp_t1
				) i order by MaBan DESC

			drop table #temp_t1 
			 
			";

		$rs = $this->conn->query($sql)->fetchAll();

		return $rs;

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
				and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = convert(varchar, getdate(), 111)
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
				and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) =  convert(varchar, getdate(), 111)
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
	
	public function getSalesSpa_Advanced_Rec( $makhu,  $tungay, $denngay, $where, $paginating )
	{	//echo $tungay;
		$sql = "SET NOCOUNT ON;
		IF OBJECT_ID(N'tempdb..#temp_t1') IS NOT NULL BEGIN DROP TABLE #temp_t1 END 

			select * into #temp_t1 FROM ( SELECT distinct a.MaKhu, a.MaLichSuPhieu, 
			GioVao, ThoiGianDongPhieu, TenHangBan ,DonGia , SoLuong = sum( SoLuong ) 
			OVER(PARTITION BY a.MaLichSuPhieu, TenHangBan) , 
			ThanhTien = sum( SoLuong ) 	OVER(PARTITION BY a.MaLichSuPhieu, TenHangBan) * DonGia , 
			TongDoanhThu = sum( ThanhTien ) OVER(PARTITION BY a.MaKhu) ,MaNhanVien 
			FROM [tblLichSuPhieu] a 
			left JOIN [tblLSPhieu_HangBan] b 
			on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
			where substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
			between '$tungay' and '$denngay'  and  $makhu
			 AND a.MaLichSuPhieu IS NOT NULL
			)
			 t1 
 
			 ; WITH cte_1 AS ( SELECT MaKhu, case when i.rnk=1 then MaLichSuPhieu else MaLichSuPhieu END as 
			 MaLichSuPhieu, TenHangBan, GioVao, DonGia , SoLuong , ThanhTien , MaNhanVien 
			 ,TongDoanhThu, RowNum = row_number() over (order by MaLichSuPhieu) 
			 FROM ( SELECT *, row_number() 
			 over(partition by MaLichSuPhieu order by MaLichSuPhieu ) as rnk from #temp_t1 ) i )
			";

		if ( $where == "" )
		{
			$sql .= 'SELECT * FROM   cte_1';
	    	$sql .= " WHERE ". $paginating ;
		}
		else
		{
			$sql .= ' ,
				cte_2 as (
					SELECT  RowNum = row_number() over (order by MaKhu), MaKhu, MaLichSuPhieu, TenHangBan, GioVao, DonGia , SoLuong , ThanhTien , MaNhanVien ,  TotalWhere = sum(ThanhTien)OVER(PARTITION BY MaKhu ) , TongDoanhThu
					FROM cte_1 
				WHERE ' . $where . '	
				)

				SELECT * FROM   cte_2';

			 $sql .= " WHERE " .  $paginating ;

			//WHERE ' . $where . '
		}

		      $sql .= " drop table #temp_t1";

		try{
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}

	}


	public function getSalesSpa_Advanced_Tot( $makhu, $tungay, $denngay, $where)
	{
		 $sql = "SET NOCOUNT ON;
		 IF OBJECT_ID(N'tempdb..#temp_t1') IS NOT NULL BEGIN DROP TABLE #temp_t1 END 

			select * into #temp_t1 FROM ( SELECT distinct a.MaKhu, a.MaLichSuPhieu, 
			GioVao, ThoiGianDongPhieu, TenHangBan ,DonGia , SoLuong = sum( SoLuong ) 
			OVER(PARTITION BY a.MaLichSuPhieu, TenHangBan) , 
			ThanhTien = sum( SoLuong ) 	OVER(PARTITION BY a.MaLichSuPhieu, TenHangBan) * DonGia , 
			TongDoanhThu = sum( ThanhTien ) OVER(PARTITION BY a.MaKhu) ,MaNhanVien  
			FROM [tblLichSuPhieu] a 
			left JOIN [tblLSPhieu_HangBan] b 
			on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
			where substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
			between '$tungay' and '$denngay' and  $makhu
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
				$rs = $this->conn->query($sql)->fetchColumn();
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}

	}

	public function getSalesSpa_Advanced_TotalRev(  $ma_khu, $tungay, $denngay )
	{
		$sql ="SELECT  TongDoanhThu = sum( Thanhtien ) 
			FROM [tblLichSuPhieu] a 
			left JOIN [tblLSPhieu_HangBan] b 
			on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
			where substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
			between '$tungay' and '$denngay'  and $ma_khu
			AND a.MaLichSuPhieu IS NOT NULL group by a.MaKhu";
			
		try{
				$rs = $this->conn->query($sql)->fetchColumn();
		
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

			$rs = $this->conn->query($sql);
		  	$rowset =  array();

			do {

			    $rowset[] = $rs->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($rs->nextRowset());
			//pr($rowset);die;
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

			$rs = $this->conn->query($sql);
		  	$rowset =  array();

			do {

			    $rowset[] = $rs->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($rs->nextRowset());
			//pr($rowset);die;
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

			$rs = $this->conn->query($sql);
		  	$rowset =  array();

			do {

			    $rowset[] = $rs->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($rs->nextRowset());
			//pr($rowset);die;
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
  where d.TenQuay = 'RESTAURANT' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -1, GETDATE()),126),0,11 )

      SELECT  ISNULL( sum(a.TienThucTra), 0 ) as DoanhThu from tblLichSuPhieu a  JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
  JOIN tblDMHangBan c on b.MaHangBan = c.MaHangBan join [tblDMNhomHangBan] d on c.MaNhomHangBan = d.Ma
  where d.TenQuay = 'RESTAURANT' and substring( Convert(varchar,[ThoiGianTaoPhieu],126),0,11 ) = substring( Convert(varchar,DATEADD(day, -7, GETDATE()),126),0,11 )";
  		try{

			$rs = $this->conn->query($sql);
		  	$rowset =  array();

			do {

			    $rowset[] = $rs->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($rs->nextRowset());
			//pr($rowset);die;
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

			$rs = $this->conn->query($sql);
		  	$rowset =  array();

			do {

			    $rowset[] = $rs->fetchAll(PDO::FETCH_ASSOC);
			    
			} while ($rs->nextRowset());
			//pr($rowset);die;
			return $rowset;		
				
		}
		catch ( PDOException $error ){
			
			echo $error->getMessage();
	
		}
	}




}

/**Note**/
