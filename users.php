<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];

$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];


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

         <div class="container" id="wrap"> <div class="row"> 
            <div class="btn-toolbar" style="margin-bottom:10px"> <button class="btn btn-primary"><a href="signup.php" style="text-decoration: none; color:#fff">Thêm User</a></button> 
            </div>

                <div class="well col-md-11" style="background:#fff; font-size: 1.2em;">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>ID</th>
                          <th>Tên</th>
                          <th>Báo cáo được xem</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                         <?php
                                $i = 1;
                                $users_list = $goldenlotus->layDanhSachUsers(); 
                                while( $r=sqlsrv_fetch_array($users_list) ){ ?>
                                                          
                        <tr>
                          <td><?=$i?></td>
                          <td><?=$r['TenSD']?></td>
                          <td><?=$r['TenNV']?></td>
                          <td><ul style="padding-left:0px">
                            <?php 
                                $bao_cao_duoc_xem_arr = ( !empty( $r['BaoCaoDuocXem'] )   ? unserialize($r['BaoCaoDuocXem']) :"" );
                                $ten_bao_cao = "";
                                 $report_name = "";
                                if ( !empty($bao_cao_duoc_xem_arr ) )
                                foreach ($bao_cao_duoc_xem_arr as $bao_cao_duoc_xem) {
                                        $ten_bao_cao = $goldenlotus->layBaoCao($bao_cao_duoc_xem);
                                        $report_name .=  '<li>' .
                                                    $ten_bao_cao . 
                                                 '</li>'
                                            ;
                                }
                                echo $report_name;
                            ?>
                          </ul></td>
                          <td>
                              <a href="signup.php?maNV=<?=$r['MaNV']?>"><i class="material-icons">&#xE8B8;</i></a>
                              <a href="user-delete.php?maNV=<?=$r['MaNV']?>" onclick="return confirm('Are you sure you want to delete?');" role="button" data-toggle="modal"><i class="material-icons" style="color:#F44336">&#xE5C9;</i></a>
                          </td>

                        </tr>

                         <?php $i++; } ?>
                      </tbody>
                    </table>
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
