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
<?php include ('head/head-revenue.month.php');?>
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
    <?php include 'menu.php'; ?>
      <div id="page-wrapper" >
        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Thực đơn</h3>
            <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Tất cả</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">PORK</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                      <div class="tab-pane fade in active" id="tab1primary">
                          <div class="panel panel-default" style="width: 33.33%;float: left">
                                <ul class="list-group danh-sach-ban">
                                    <li class="list-group-item">
                                        <div class="row toggle" id="dropdown-detail-1" data-toggle="detail-1">
                                            <div class="col-xs-10">
                                              <div style="display:flex">
                                                <div class="tbl-image">
                                                    <img src="https://i.pinimg.com/originals/3b/5f/3f/3b5f3fe6d684d7cb19baa41820a66981.jpg"  width="80" height="80">
                                                </div> 
                                                <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                  <strong>01. Pork Belly</strong>
                                                  <br>
                                                  <span>Giá:</span>
                                                  <br>
                                                  <span>Hoạt động: <img src="https://png.pngtree.com/element_our/sm/20180515/sm_5afb099d307d3.jpg" width="30" height="30"/></span>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                     </li>
                                </ul>
                          </div>
                      </div>
                      <div class="tab-pane fade" id="tab2primary">
                           <div class="panel panel-default" style="width: 33.33%;float: left">
                                <ul class="list-group danh-sach-ban">
                                    <li class="list-group-item">
                                        <div class="row toggle" id="dropdown-detail-1" data-toggle="detail-1">
                                            <div class="col-xs-10">
                                              <div style="display:flex">
                                                <div class="tbl-image">
                                                    <img src="https://i.pinimg.com/originals/3b/5f/3f/3b5f3fe6d684d7cb19baa41820a66981.jpg"  width="80" height="80">
                                                </div> 
                                                <div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                                                  <strong>01. Pork Belly</strong>
                                                  <br>
                                                  <span>Giá:</span>
                                                  <br>
                                                  <span>Hoạt động: <img src="https://png.pngtree.com/element_our/sm/20180515/sm_5afb099d307d3.jpg" width="30" height="30"/></span>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                     </li>
                                </ul>
                          </div>
                        </div>
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