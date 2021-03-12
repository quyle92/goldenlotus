
<?php
require('lib/db.php');
@session_start();
$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];
$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];

if($tungay == "")
{
	$tungay = date('d-m-Y');
}
if($denngay == "")
{
	$denngay = date('d-m-Y');
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý Spa, Clinic - ZinSpa</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa ZinSpa" />
<script type="application/x-javascript"> 
addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
function hideURLbar(){ window.scrollTo(0,1); } 
</script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />

<link href="css/font-awesome.css" rel="stylesheet"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<style>
/*--new menu 19042020 ---*/
.li-level1
{
  padding: 8px 8px 8px 5px;
}

.menu-level1 {
  font-size: 14px;
  color: #818181;
}

.menu-level1:hover {
  color: #f1f1f1;
}

.menu-level2 {
  padding: 8px 8px 8px 15px;
  font-size: 14px;
  color: #818181;
}

.menu-level2:hover {
  color: #f1f1f1;
}

.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 8px 8px 8px 5px; /*top right bottom left*/
  text-decoration: none;
  font-size: 14px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  background-color: green;
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 12px;
  line-height: 2em;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 12px;}
}

/*-----end style new menu 19042020*/
</style>
</head>
<body>
	<div id="wrapper">
    <?php include 'menu.php'; ?>
    <div id="page-wrapper">
    	<div class="col-md-12 graphs">
		<div class="xs">
	 		<h4>BẠN ĐANG ĐĂNG NHẬP VỚI QUYỀN - <?php echo $ten; ?> </h4>
     		<form action="" method="post">
	 			<div class="row">
				<div class="col-md-2" style="margin-bottom:5px">Chi nhánh:</div>
				<div class="col-md-3" style="margin-bottom:5px">
					<select name="matrungtam" id="matrungtam" value="Tat ca">
<?php 
	$sql="SELECT * FROM tblDMTrungTam Order by MaTrungTam";
	try
	{
		$result_tt = $dbCon->query($sql);
		if($result_tt != false)
		{
			foreach ($result_tt as $r)
			{
?>
			<?php if($matrungtam == $r['MaTrungTam'])
				{
			 ?>
		 			<option value="<?php echo $r['MaTrungTam'];?>" selected="selected"><?php echo $r['TenTrungTam'];?></option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $r['MaTrungTam'];?>"><?php echo $r['TenTrungTam'];?></option>
			<?php
				}
			?>
<?php
			}
		} 
	}
	catch (PDOException $e) {

		//loi ket noi db -> show exception
		echo $e->getMessage();
	}
?>
					</select>
				</div>
				<div class="col-md-3" style="margin-bottom:5px"></div>
				<div class="col-md-2" style="margin-bottom:5px"></div>
	 			</div>
     	<div class="row">
          	<div class="col-md-2" style="margin-bottom:5px">Từ ngày:</div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?php echo @$tungay ?>" id="tungay" /></div>
            <div class="col-md-2" style="margin-bottom:5px">Đến ngày: </div>
            <div class="col-md-3" style="margin-bottom:5px"><input name="denngay" type="text"  value="<?php echo @$denngay ?>" id="denngay" /></div>
            <div class="col-md-2" style="margin-bottom:5px"><input type="submit" value="Lọc"></div>
		</div>
     	</form>
<?php 

// convert to japan date format to filter data
	$tungay_converted = "";
	$denngay_converted = "";
	if($tungay != "")
	{
		$tungay_converted = substr($tungay,6) . "/" . substr($tungay,3,2) . "/" . substr($tungay,0,2);
	}
	
	if($denngay != "")
	{
		$denngay_converted = substr($denngay,6) . "/" . substr($denngay,3,2) . "/" . substr($denngay,0,2);
	}
?>
	<h3 class="title">CHI TIẾT HÓA ĐƠN</h3>
  	<div class="bs-example4" data-example-id="contextual-table">
    <table class="table">
      <thead>
        <tr>
          <th>Mã Bill</th>
		  <th>Thời gian</th>
          <th>Giường</th>
		  <th>Tổng tiền (VNĐ)</th>
          <th>Giảm giá</th>
          <th>Thực thu(VNĐ)</th>
          <th>Ghi chú</th>
        </tr>
      </thead>
      <tbody>
<?php 		
	$sql2="select MaLichSuPhieu, GioVao, isnull(GioTra,ThoiGianDongPhieu) as GioTra, MaBan, TongTien,TienGiamGia,TienThucTra,GhiChu from tblLichSuPhieu
		where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1";
	//----loc theo ngay ----//
	if($tungay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) >= '$tungay_converted'";
	}
	if($denngay_converted != "")
	{
		$sql2 = $sql2 . " and Convert(varchar,isnull(ThoiGianDongPhieu,getdate()),111) <= '$denngay_converted'";
	}
	try
	{
		//lay ket qua query chi tiet nap tien vao the
		$result_hd = $dbCon->query($sql2);
		if($result_hd != false)
		{
			//show the results
			foreach ($result_hd as $r2)
			{
	?>      
        <tr class="success">
			<td><?php echo $r2['MaLichSuPhieu'];?></td>
          <td><?php echo date_format($r2['GioVao'],'d-m-Y H:i:s');?></td>
          <td><?php echo $r2['MaBan'];?></td>
          <td><?php echo number_format($r2['TongTien'],0);?></td>
          <td><?php echo number_format($r2['TienGiamGia'],0);?></td>
          <td><?php echo number_format($r2['TienThucTra'],0);?></td>
          <td><?php echo $r2['GhiChu'];?></td>
        </tr>
<?php 		
			}
		}
	}
	catch (PDOException $e1) {

		//loi ket noi db -> show exception
		echo $e1->getMessage();
	} 
	?>
      </tbody>
    </table>
   </div>
   <p></p>
  </div>
   <!-- /XS -->
  </div>
  <!-- /col-md-12 -->
  </div>
  <!-- /#page-wrapper -->
  </div>
  <!-- /#wrapper -->
<!-- Nav CSS -->
<!-- Nav CSS -->
<link href="css/custom.css" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" />
<script>
	/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  	//this.classList.toggle("active");
  	var dropdownContent = this.nextElementSibling;
  	if (dropdownContent.style.display === "block") {
  		dropdownContent.style.display = "none";
  	} else {
  		dropdownContent.style.display = "block";
  	}
  });
}

//dropdown[0].click();
</script>
<script>
	$('#tungay').datepicker({
		dateFormat:'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		yearRange:'-99:+0',
	})
	 
	$('#denngay').datepicker({
		dateFormat:'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		yearRange:'-99:+0',
	})

</script>   
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
});
</script>
</body>
</html>
