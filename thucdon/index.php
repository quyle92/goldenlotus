<?php require_once('../helper/security.php'); ?>
<?php
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];
$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];
$tungay=@$_POST['tungay'];
$denngay=@$_POST['denngay'];
if($tungay == "")
{
  $tungay = "01-01-".date('Y');
}
if($denngay == "")
{
  $denngay = date('d-m-Y');
}
?>
<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<style>
</style>
<script>
  $(document).ready(function() {
    $('[id^=detail-]').hide();
    $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
    });
});
</script>
</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >
        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <form action="" method="post">
              <div class="row">
                <div class="col-md-2" style="margin-bottom:5px">Chi nhánh:</div>
                <div class="col-md-3" style="margin-bottom:5px">
                  <select name="matrungtam" id="matrungtam" value="Tat ca">
                    <?php 
                    $chi_nhanh = $goldenlotus->getChiNhanh();
                    foreach ( $chi_nhanh as $r ) 
                    { if($matrungtam == $r['MaTrungTam']) ?>
                      <option value="<?php echo $r['MaTrungTam'];?>" selected="selected"><?php echo $r['TenTrungTam'];?></option>
                    <?php 
                      else ?>
                      <option value="<?php echo $r['MaTrungTam'];?>" ><?php echo $r['TenTrungTam'];?></option>
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-3" style="margin-bottom:5px"></div>
                <div class="col-md-2" style="margin-bottom:5px"></div>
              </div>
            </form>

            <h3 class="title">Thực đơn</h3>
            <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">TẤT CẢ</a></li>
                            <?php 
                            $all_food_items = $goldenlotus->getAllFoodGroups();
                            foreach ( $all_food_items as $r ) 
                            {  ?>
                            <li><a href="#<?=$r['Ma']?>" data-toggle="tab"><?=$r['Ten']?></a></li>
                            <?php }
                            ?>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                      <div class="tab-pane fade in active" id="tab1primary">
                      <?php 
                      $all_food_items = $goldenlotus->getAllFoodItems();
                      $i = 0;
                      foreach ( $all_food_items as $r ) 
                      { ?>
                          <div class="panel panel-default col-md-5" >
                            <div style="display:flex;white-space: nowrap;overflow: hidden;">
                                <div class="tbl-image">
                                    <!-- <img src="https://i.pinimg.com/originals/3b/5f/3f/3b5f3fe6d684d7cb19baa41820a66981.jpg"  width="80" height="80"> -->
                                </div> 
                                <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                  <div class="tenhangban" style="min-width: 50px"><strong><?=$r['MaHangBan']?>. <?=$r['TenHangBan']?> </strong></div>
                                
                                  <span>Giá: <?=( $r['Gia'] ) ? number_format($r['Gia'],0,",",".") : ""?> </span>
                                  <br>
                                  <span>Hoạt động: <img src="https://png.pngtree.com/element_our/sm/20180515/sm_5afb099d307d3.jpg" width="30" height="30"/></span>
                                </div>
                              </div>
                          </div>
                          <?php if( !($i % 2) ) echo '<div class="col-md-2" ></div>';  $i++;?>
                      <?php } ?>
                      </div>

                      <?php
                      $all_food_items = $goldenlotus->getAllFoodGroups();
                      foreach ( $all_food_items as $r ) 
                      { ?>
                      <div class="tab-pane fade" id="<?=$r['Ma']?>">
                        <?php 
                        $food_group = $r['Ma'];
                        $food_items_by_group = $goldenlotus->getFoodItemsByGroup( $food_group );
                        $i = 0;
                        foreach ( $food_items_by_group as $r1 )  
                        { ?>
                            <div class="panel panel-default col-md-5" >
                              <div style="display:flex;white-space: nowrap;overflow: hidden;">
                                  <div class="tbl-image">
                                    
                                  </div> 
                                  <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                    <div class="tenhangban" style="min-width: 50px"><strong><?=$r1['MaHangBan']?>. <?=$r1['TenHangBan']?> </strong></div>
                                  
                                    <span>Giá:   <?=( $r1['Gia'] ) ? number_format($r1['Gia'],0,",",".") : ""?></span>
                                    <br>
                                    <span>Hoạt động: <img src="https://png.pngtree.com/element_our/sm/20180515/sm_5afb099d307d3.jpg" width="30" height="30"/></span>
                                  </div>
                                </div>
                            </div>
                            <?php if( ($i % 2) == 0  ) echo '<div class="col-md-2" ></div>'; $i++;?>
                          <?php 
                        } ?>
                      </div>
                      <?php } ?> 

                    </div>
                </div>
            </div>
<!-- END BIEU DO DOANH THU-->
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
$('#tungay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
$('#denngay').datepicker({  uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
</script>
</body>
</html>
