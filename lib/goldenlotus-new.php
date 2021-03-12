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
			echo $sql = "SELECT count(*) FROM 
			( SELECT  a.MaBan, sum(TienThucTra) as DoanhThu from  [HOANGSEN].[dbo].[tblDMBan]a left join [HOANGSEN].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan	and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
				= '$date' group by a.MaBan ) t1";
		}

		try{
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				 $itemcount =(int) $stmt->fetchColumn();var_dump($itemcount);
				
				$stmt->closeCursor();
				return $itemcount;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}
	
	public function getSalesByTableID_Paginate( $itemcount=30,  $date, $occupation ){

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
						 and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '2020/01/01'
						 group by a.MaBan  ) t1
						 where rn between  @offset and @end

						END

						
			";
		}
		
				
		elseif( $occupation == 1 )
		{
		$proc_sql = "CREATE PROCEDURE  t1  @offset int, @end Int
						AS
						BEGIN 
						SET NOCOUNT ON

					select * from ( SELECT ROW_NUMBER() OVER (ORDER BY a.MaBan DESC) AS rn, a.MaBan, sum(TienThucTra) as 							DoanhThu  from  [HOANGSEN].[dbo].[tblDMBan] a 
					left join [HOANGSEN].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan	
					and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
					= '$date' where [ThoiGianDongPhieu] is   null 
					group by a.MaBan  ) t1
						 where rn between  @offset and @end order by DoanhThu DESC 

						END

						
			";
		}
		
		elseif( $occupation == 0)
		{
		$proc_sql = "CREATE PROCEDURE  t1  @offset int, @end Int
						AS
						BEGIN 
						SET NOCOUNT ON

						select * from (  SELECT ROW_NUMBER() OVER (ORDER BY a.MaBan DESC) AS rn, a.MaBan, sum(TienThucTra) as DoanhThu  from  [HOANGSEN].[dbo].[tblDMBan] a left join [HOANGSEN].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date' where [ThoiGianDongPhieu] IS NOT NULL  group by a.MaBan order by DoanhThu DES  ) t1
						 where rn between  @offset and @end

						END

						
			";
		}

		
		$proc_query = $this->conn->query( $proc_sql );

		//$itemcount = 20;
		$runs = floor( $itemcount / 100 );
		
		//$i = 0;
		for ($i = 0; $i <=$runs; $i++) {
			$offset = ( isset($end) ) ? ( $end + 1 ) : 0 ;
			$end = ( $itemcount > 100 ) ? ($i + 1 ) *100 : $itemcount;

			if ( $occupation == null)
			{
				$sql = "EXEC t1  @offset = $offset, @end = $end";
			}
			
			if ( $occupation == 1)
			{
			$sql = "
			With t2 as ( SELECT ROW_NUMBER() OVER (ORDER BY a.MaBan DESC) AS rn, a.MaBan, sum(TienThucTra) as DoanhThu  from  [HOANGSEN].[dbo].[tblDMBan] a 
					left join [HOANGSEN].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan	
					and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) 
					= '$date' where [ThoiGianDongPhieu] is   null 
					group by a.MaBan order by DoanhThu DESC )
		
			SELECT  * from  t2 WHERE rn BETWEEN '$offset' AND '$end' 
";
			}
			
			if ( $occupation == '0' && $occupation != null )
			{
			$sql = "
			
			With t3 as ( SELECT ROW_NUMBER() OVER (ORDER BY a.MaBan DESC) AS rn, a.MaBan, sum(TienThucTra) as DoanhThu  from  [HOANGSEN].[dbo].[tblDMBan] a left join [HOANGSEN].[dbo].[tblLichSuPhieu] b on  a.MaBan = b.MaBan and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date' where [ThoiGianDongPhieu] IS NOT NULL  group by a.MaBan order by DoanhThu DES )
		
			SELECT  * from  t3 WHERE rn BETWEEN '$offset' AND '$end' 
			
";
				
			}
		
		try{
				$rs = $this->conn->query( $sql )->fetchAll(PDO::FETCH_ASSOC);

					foreach( $rs as $r  ){
					
			
						 $result[] = array(
						 	'rn' => $r['rn'],
							'MaBan' => $r['MaBan'],
							'DoanhThu' => $r['DoanhThu'],

						);
				
					}	
			
				if ( $i == $runs ) return $result;
			
				

			}

		catch ( PDOException $error ){
				echo $error->getMessage();
			}

		}

		
	}

	public function getSalesByFoodNames ( $date, $table_id, $occupation = null ){

		$drop_proc_sql = "IF EXISTS (SELECT type_desc, type FROM sys.procedures WITH(NOLOCK)  WHERE NAME = 't1a' AND type = 'P'  ) DROP PROCEDURE dbo.t1a";
    	$drop_proc_query = $this->conn->query( $drop_proc_sql );

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
			$proc_sql = "CREATE PROCEDURE  t1a  @table_id varchar(255)
						AS
						BEGIN 
						SET NOCOUNT ON

						select * from ( SELECT distinct TenHangBan, MaHangBan, MaDVT, sum (SoLuong)  OVER(PARTITION BY TenHangBan) AS SoLuong,
				sum (SoLuong*DonGia)  OVER(PARTITION BY TenHangBan) AS DoanhThu
			 from [HOANGSEN].[dbo].[tblDMBan] a
			 left join [HOANGSEN].[dbo].[tblLichSuPhieu] b
			 on a.[MaBan] = b.[MaBan]
			 join  [HOANGSEN].[dbo].[tblLSPhieu_HangBan] c
			 on b.[MaLichSuPhieu] = c.[MaLichSuPhieu]  
			 where substring( Convert(varchar,[ThoiGianBan],111),0,11 ) = '$date'

			 and a.MaBan = @table_id  ) t1a
						

						END

						
			";
		}

			$proc_query = $this->conn->query( $proc_sql );

		try{
				$sql = "EXEC t1a  @table_id = $table_id";
				$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
		
					return $rs;
			}
		catch ( PDOException $error ){
				echo $error->getMessage();
			}
	}
	
	
	public function getAllTables($date ){

		$sql = "SELECT distinct b.MaBan,
			MaHangBan,
			TenHangBan	
			, MaDVT
			, sum( SoLuong ) OVER(PARTITION BY TenHangBan) AS SoLuong
			, ThanhTien = sum( SoLuong ) OVER(PARTITION BY TenHangBan) * DonGia
			, TongDoanhThu =  sum( Thanhtien ) OVER(PARTITION BY b.MaBan) 
			FROM 
			[HOANGSEN].[dbo].[tblDMKhu] a
			join 	[HOANGSEN].[dbo].[tblDMBan] b 
			on a.[MaKhu] = b.[MaKhu]
			left join [HOANGSEN].[dbo].[tblLichSuPhieu] c
			on b.[MaBan] = c.[MaBan]
			and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'
			left JOIN [HOANGSEN].[dbo].[tblLSPhieu_HangBan] d
			on c.[MaLichSuPhieu] = d.[MaLichSuPhieu]
			where a.MaKhu = '04-NH'
			--where a.MaBan='M.53' or a.MaBan='M.11'
		";

		$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

		return $rs;

	}

	public function getAllTables_Occupied( $date ){

		$sql = "SELECT distinct b.MaBan,
			MaHangBan,
			TenHangBan	
			, MaDVT
			, sum( SoLuong ) OVER(PARTITION BY TenHangBan) AS SoLuong
			, ThanhTien = sum( SoLuong ) OVER(PARTITION BY TenHangBan) * DonGia
			, TongDoanhThu =  sum( Thanhtien ) OVER(PARTITION BY b.MaBan) 
			FROM 
			[HOANGSEN].[dbo].[tblDMKhu] a
			join 	[HOANGSEN].[dbo].[tblDMBan] b 
			on a.[MaKhu] = b.[MaKhu]
			left join [HOANGSEN].[dbo].[tblLichSuPhieu] c
			on b.[MaBan] = c.[MaBan]
			and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'
			left JOIN [HOANGSEN].[dbo].[tblLSPhieu_HangBan] d
			on c.[MaLichSuPhieu] = d.[MaLichSuPhieu]
			where a.MaKhu = '04-NH'
			and [ThoiGianDongPhieu] is   null 
			--where a.MaBan='M.53' or a.MaBan='M.11'
		";

		$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

		return $rs;

	}

	public function getAllTables_Empty( $date ){

		$sql = "SELECT distinct b.MaBan,
			MaHangBan,
			TenHangBan	
			, MaDVT
			, sum( SoLuong ) OVER(PARTITION BY TenHangBan) AS SoLuong
			, ThanhTien = sum( SoLuong ) OVER(PARTITION BY TenHangBan) * DonGia
			, TongDoanhThu =  sum( Thanhtien ) OVER(PARTITION BY b.MaBan) 
			FROM 
			[HOANGSEN].[dbo].[tblDMKhu] a
			join 	[HOANGSEN].[dbo].[tblDMBan] b 
			on a.[MaKhu] = b.[MaKhu]
			left join [HOANGSEN].[dbo].[tblLichSuPhieu] c
			on b.[MaBan] = c.[MaBan]
			and substring( Convert(varchar,[ThoiGianTaoPhieu],111),0,11 ) = '$date'
			left JOIN [HOANGSEN].[dbo].[tblLSPhieu_HangBan] d
			on c.[MaLichSuPhieu] = d.[MaLichSuPhieu]
			where a.MaKhu = '04-NH'
			and [ThoiGianDongPhieu] is not  null 
			--where a.MaBan='M.53' or a.MaBan='M.11'
		";

		$rs = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

		return $rs;

	}
	
}	
