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
.bangke-chitiet-hoadon .table-responsive .table-striped{
  font-size: 13px!important;
}
.bangke-chitiet-hoadon .panel-body{
  padding: 0;
}
</style>

</head>
<body>
<div id="wrapper ">
    <?php include 'menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Bản kê chi tiết hóa đơn bán hàng</h3>

            <div class="panel with-nav-tabs panel-primary bangke-chitiet-hoadon">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Hôm nay</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Hôm qua</a></li>
                            <li><a href="#tab3primary" data-toggle="tab">Tháng này</a></li>
                            <li><a href="#tab4primary" data-toggle="tab">Tháng khác</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                        
                            <div class="col-xs-12 col-sm-12 table-responsive">
                             <table class="table table-striped table-bordered" id="sailorTable">
                                <thead>
                                  <tr>
                                    <th>Số HĐ</th>
                                    <th>Thu ngân</th>
                                    <th>Giờ vào</th>
                                    <th>Giờ ra</th>
                                    <th>Khách</th>
                                    <th>Khu vực</th>
                                    <th>Bàn</th>
                                    <th>Tổng tiền</th>
                                    <th>Giảm giá món</th>
                                    <th>% chiết khấu</th>
                                    <th>Tiền chiết khấu %</th>
                                    <th>Tiền phiếu giảm giá</th>
                                    <th>Phí dịch vụ</th>
                                    <th>Tiền phí dịch vụ</th>
                                    <th>Tiền thuế</th>
                                    <th>Thực thu</th>
                                    <th>Ghi chú</th>
                                    <th>Tạm tính</th>
                                    <th>Tên khách</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                              </tbody>
                             </table>
                           </div>
                        
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                                <thead>
                                  <tr>
                                    <th>Số HĐ</th>
                                    <th>Thu ngân</th>
                                    <th>Giờ vào</th>
                                    <th>Giờ ra</th>
                                    <th>Khách</th>
                                    <th>Khu vực</th>
                                    <th>Bàn</th>
                                    <th>Tổng tiền</th>
                                    <th>Giảm giá món</th>
                                    <th>% chiết khấu</th>
                                    <th>Tiền chiết khấu %</th>
                                    <th>Tiền phiếu giảm giá</th>
                                    <th>Phí dịch vụ</th>
                                    <th>Tiền phí dịch vụ</th>
                                    <th>Tiền thuế</th>
                                    <th>Thực thu</th>
                                    <th>Ghi chú</th>
                                    <th>Tạm tính</th>
                                    <th>Tên khách</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                                <thead>
                                  <tr>
                                    <th>Số HĐ</th>
                                    <th>Thu ngân</th>
                                    <th>Giờ vào</th>
                                    <th>Giờ ra</th>
                                    <th>Khách</th>
                                    <th>Khu vực</th>
                                    <th>Bàn</th>
                                    <th>Tổng tiền</th>
                                    <th>Giảm giá món</th>
                                    <th>% chiết khấu</th>
                                    <th>Tiền chiết khấu %</th>
                                    <th>Tiền phiếu giảm giá</th>
                                    <th>Phí dịch vụ</th>
                                    <th>Tiền phí dịch vụ</th>
                                    <th>Tiền thuế</th>
                                    <th>Thực thu</th>
                                    <th>Ghi chú</th>
                                    <th>Tạm tính</th>
                                    <th>Tên khách</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">
                            <div class="row">
                              <div class="col-xs-12 col-sm-12">
                                <div class="col-md-2" style="margin-bottom:5px">Từ ngày:</div>
                                <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?php echo @$tungay ?>" id="tungay" /></div>
                                <div class="col-md-2" style="margin-bottom:5px">Đến ngày: </div>
                                <div class="col-md-3" style="margin-bottom:5px"><input name="denngay" type="text"  value="<?php echo @$denngay ?>" id="denngay" /></div>
                                <div class="col-md-2" style="margin-bottom:5px"><input type="submit" value="Lọc"></div>
                            </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" width="100%" id="sailorTable">
                                <thead>
                                  <tr>
                                    <th>Số HĐ</th>
                                    <th>Thu ngân</th>
                                    <th>Giờ vào</th>
                                    <th>Giờ ra</th>
                                    <th>Khách</th>
                                    <th>Khu vực</th>
                                    <th>Bàn</th>
                                    <th>Tổng tiền</th>
                                    <th>Giảm giá món</th>
                                    <th>% chiết khấu</th>
                                    <th>Tiền chiết khấu %</th>
                                    <th>Tiền phiếu giảm giá</th>
                                    <th>Phí dịch vụ</th>
                                    <th>Tiền phí dịch vụ</th>
                                    <th>Tiền thuế</th>
                                    <th>Thực thu</th>
                                    <th>Ghi chú</th>
                                    <th>Tạm tính</th>
                                    <th>Tên khách</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </tbody>
                            </table>
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
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}

dropdown[0].click();

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
