<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];

$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];

if( $_SESSION['MaNV'] != 'HDQT' )
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');

?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>
<style>
.graphs {
    background-image: linear-gradient(to bottom, #FFFFFF 0%, #D3D8E8 100%);
    background-repeat: no-repeat;
    background-attachment: fixed;
   
}

.btn-primary:hover{
    background-color :rgb(13, 155, 109) !important;
    border-color: rgb(13, 155, 109) !important;
    color:#fff !important;
}

.table-striped > tbody > tr:nth-of-type(2n+1) {
    background-color: #f7efef;
}
</style>
<!-- Bootstrap iOS toggle https://www.bootstraptoggle.com/ -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
<div id="wrapper">
    <?php include 'menu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
    <div class="xs">
   
        <form action="" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="" style="margin-bottom:5px"> 
                            <?php 
                            if(  isset($_SESSION['signup_success']) && $_SESSION['signup_success'] == 1 )
                            {
                            echo "<div class='alert alert-success'>
                                  <strong>Success!</strong> Sign up successful...
                                </div>";unset($_SESSION['signup_success']); 
                            }

                            elseif ( isset($_SESSION['signup_success']) && $_SESSION['signup_success'] == 0  )
                            {
                            echo "<div class='alert alert-danger'>
                                  <strong>Alert!</strong> Sign up fail...
                            </div>";unset($_SESSION['signup_success']); 
                            }

                            elseif(  isset($_SESSION['password_mismatch']) && $_SESSION['password_mismatch'] == 1 ) 
                            {
                             echo "<div class='alert alert-warning'>
                                  <strong>Alert!</strong> Password mismatch...
                            </div>";unset($_SESSION['password_mismatch']); 
                            }

                            ?>
                            <h4>BẠN ĐANG ĐĂNG NHẬP VỚI QUYỀN - <?php echo $ten; ?> </h4>
                        </div>
                        
                    </div>
                    <div class="col-md-3" style="margin-bottom:5px"></div>
                    <div class="col-md-2" style="margin-bottom:5px"></div>
                 </div>
            </div>
        </form>
<?php
//var_dump ( $goldenlotus->layTatCaBaoCao() );
?>
         <div class="container" id="wrap"> <div class="row"> 
            <div class="btn-toolbar" style="margin-bottom:10px"> 
            </div>
            <?php
            if(isset($_POST['report_name']) || isset($_POST['report_name_eng']))
            {
              $report_name = $_POST['report_name'];
              $report_name_eng = $_POST['report_name_eng'];
            }
            if(isset($_POST['report_name'])) $goldenlotus->insertBaoCao($report_name, $report_name_eng);
            ?>
                <div class="col-md-11" style="background:#fff; font-size: 1.2em;">
                    <form action="" method="POST" class="form-horizontal" role="form">
                        <div class="form-group">
                          <legend>Tên Báo Cáo</legend>
                          <input type="text" name="report_name" id="inputReport_name" class="form-control" value="" required="required">
                        </div>
                        <div class="form-group">
                          <legend>Report name</legend>
                          <input type="text" name="report_name_eng" id="inputReport_name" class="form-control" value="" required="required" >
                        </div>                        
                    
                        <div class="form-group">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                    </form>
                    
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
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>


</body>
</html>
