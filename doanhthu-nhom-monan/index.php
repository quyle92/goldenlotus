<?php
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;


$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];

$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];

$bao_cao_duoc_xem = ( isset( $_SESSION['BaoCaoDuocXem'] ) ? $_SESSION['BaoCaoDuocXem'] : array() );
$page_name = "BieuDoDoanhThu";
if( $_SESSION['MaNV'] != 'HDQT' && !in_array($page_name, $bao_cao_duoc_xem) )
    die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
 <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script> 
<style>
@media screen and (max-width:375px){
    .container-fluid .mychart{
        position: absolute;
        top: 60px;
        left: -21px;
        width: 430px;
        height: 400px;
    }
}
</style>
</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
  <div class="xs">
  <h4>BẠN ĐANG ĐĂNG NHẬP VỚI QUYỀN - <?php echo $ten; ?> </h4>
  <h2>Doanh thu nhóm món ăn </h2>
    <form action="" method="post">
  <div class="row">

    <div class="col-md-2" style="margin-bottom:5px">Chi nhánh:</div>
    <div class="col-md-3" style="margin-bottom:5px">
      <select name="matrungtam" id="matrungtam" value="Tat ca">
<?php 
  $sql="SELECT * FROM tblDMTrungTam Order by MaTrungTam";
  try
  {
    //lay ket qua query tong gia tri the
    $rs = $dbCon->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if($rs != false)
    {
      //show the results
    
      foreach ( $rs as $r ) 
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

     </form>
     <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Tháng này</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Tháng trước</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Khác</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <?php require('../doanhthu-nhom-monan/thangnay.php'); ?>
                           </div>
                      </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <?php require('../doanhthu-nhom-monan/thangtruoc.php'); ?>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                             <?php require('../doanhthu-nhom-monan/khac.php'); ?>
                          </div>
                        </div>
                                
                        
                    </div>
                </div>
            </div>
<!-- END BIEU DO DOANH THU-->

  </div>
  <!-- #end class xs-->
   </div>
   <!-- #end class col-md-12 -->
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
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
$('.navbar-toggle.pc-only').on('click', function() {
  $('.sidebar-nav.pc-only').toggleClass('new-menu');  
   
});

  $('#tu-ngay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
  $('#den-ngay').datepicker({  uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 

  $('#datepicker').datepicker({
      uiLibrary: 'bootstrap',
       format: "dd/mm/yyyy",
        todayBtn: true,
  });
</script>

</body>
</html>
