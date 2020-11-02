<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;
$maNV = isset($_GET['maNV']) ? $_GET['maNV'] : "";
if( !empty($maNV) ){
$user = $goldenlotus->layTenUser($maNV);
$user = sqlsrv_fetch_array($user);
}

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
                    <div class="col-md-6 col-md-offset-1">
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
                        <div class="" style="margin-bottom:5px">Chi nhánh:</div>
                        <div class="" style="margin-bottom:5px">
                            <select name="matrungtam" id="matrungtam" value="Tat ca">
                <?php 
                    $sql="SELECT * FROM tblDMTrungTam Order by MaTrungTam";
                    try
                    {
                        //lay ket qua query tong gia tri the
                        $result_tt = sqlsrv_query( $conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
                        if($result_tt != false)
                        {
                            //show the results
                        
                            while ($r=sqlsrv_fetch_array($result_tt))
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
                    </div>
                    <div class="col-md-3" style="margin-bottom:5px"></div>
                    <div class="col-md-2" style="margin-bottom:5px"></div>
                 </div>
            </div>
        </form>

         <div class="container" id="wrap">
            <div class="row">
                <div class="col-md-6 col-md-offset-1">
                    <form action="signup-process.php" method="post" accept-charset="utf-8" class="form" role="form">   
                            <legend>Sign Up</legend>
                            <input type="text" name="username" value="<?=isset($user['TenSD'])?:""?>" class="form-control input-lg" placeholder="ID"  />
                            <?php
                            if( empty($user) )
                            echo '<input type="password" name="password" value="" class="form-control input-lg" placeholder="Password"  /><input type="password" name="confirm_password" value="" class="form-control input-lg" placeholder="Confirm Password"  />';
                            ?>
                            <select name="maNV" id="maNV" class="form-control input-lg" required="required" >
                                <option value="" disabled selected> Tên NV</option>
                                <?php
                                $list_NV_arr = $goldenlotus->layMaNV(); 
                                while( $r=sqlsrv_fetch_array($list_NV_arr) ){
                                    if($r["MaNV"] == $user['MaNV']){
                                        echo '<option value="' . $r["MaNV"] . '" selected="selected">' . $r['TenNV'] . '</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="' . $r["MaNV"] . '">' . $r['TenNV'] . '</option>';
                                    }
                                }
                                ?>

                            </select>

                            <!-- <div class="container">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h5>Default</h5>
                                                <div class="checkbox checkbox-slider--b-flat checkbox-slider-md">
                                                    <label>
                                                        <input type="checkbox"><span>medium</span>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-slider--b-flat checkbox-slider-md">
                                                    <label>
                                                        <input type="checkbox" checked=""><span>checked</span>
                                                    </label>
                                                </div>
                                    </div>
                                </div>
                            </div> -->
                            <h4><strong>Lựa chọn menu:</strong></h4>
                            <?php
                            $danh_sach_bao_cao = $goldenlotus->layTatCaBaoCao();
                            $bao_cao_duoc_xem_arr = ( !empty( $user['BaoCaoDuocXem'] )   ? unserialize($user['BaoCaoDuocXem']) :array() );
                           
                            while ( $r = sqlsrv_fetch_array( $danh_sach_bao_cao ) ){
                                if(  in_array( $r['MaBaoCao'], $bao_cao_duoc_xem_arr ) ){
                                echo '<div class="">
                                  <label>
                                    <input type="checkbox" checked data-toggle="toggle" name="report_arr[]" value="' . $r['MaBaoCao'] . '">
                                     ' . $r['TenBaoCao']  . '
                                  </label>
                                </div>';
                                }
                                else{
                                    echo '<div class="">
                                  <label>
                                    <input type="checkbox" data-toggle="toggle" name="report_arr[]" value="' . $r['MaBaoCao'] . '">
                                     ' . $r['TenBaoCao']  . '
                                  </label>
                                </div>';
                                }

                            } ?>


                            <button class="btn btn-lg btn-primary btn-block signup-btn" type="submit">
                                Create account</button>
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
