<?php  
$page_name = "BaoCaoQuanTri";
require_once('../helper/security.php'); 
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

$today = date('yy/m/d');
$yesterday = date('yy/m/d',strtotime("-1 days"));
//$today = $yesterday = date('2020/12/01');
	

?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<script>
   $(document).ready(function() {
    $('#today').DataTable();
} );
  $(document).ready(function() {
    $('#yesterday').DataTable();
} );

  $(document).ready(function() {
    $('#this_month').DataTable();
} );
  
   $(document).ready(function() {
    $('#custom_month').DataTable( {
      //Disable filtering on the first column:
      "order": [],
      "columnDefs": [ {
      "targets"  : 0,
      "orderable": false,
      }]
    });
} );
  
//    $(document).ready(function() {
//     $('#custom_month').DataTable();
// } );



</script>

</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Bảng kê sửa hóa đơn</h3>

            <div class="panel with-nav-tabs panel-primary ">
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
                             <table class="table table-striped table-bordered" id="today">
                                <thead>
                                  <tr>
                                    <th>Ngày sửa</th>
                                    <th>NV sửa</th>
                                    <th>Giờ</th>
                                    
                                    <th>Nội dung sửa</th>
                                    <th>Ngày HĐ sửa</th>
                                    <th>Số HĐ sửa</th>
                                    <th>Giá trị trước khi sửa</th>
                                    <th>Giá trị sau  khi sửa</th>
                                    <th>Chênh lệch</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$today = date('2020/08/26');
                                $today = date('Y/m/d');
                                $bill_edit =$goldenlotus->getBillEditDetailsByDate( $today );
                                foreach ( $bill_edit as $r )
                                { ?>  
                                <tr>
                                  <td><?=( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 0, 10): ""?></td>
                                  <td><?=$r['TenNV']?></td>
                                  <td><?=( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 11, 5) : ""?></td>
                                  <td><?=$r['GhiChu']?></td>
                                  <td><?=substr($r['ThoiGianTaoPhieu'],0, 10)?></td>
                                  <td><?=$r['MaLichSuPhieu']?></td>
                                  
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <?php 
                                } ?>
                              </tbody>
                             </table>
                           </div>
                        
                        </div>
                        <div class="tab-pane fade" id="tab2primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="yesterday">
                                <thead>
                                  <tr>
                                    <th>Ngày sửa</th>
                                    <th>NV sửa</th>
                                    <th>Giờ</th>
                                    
                                    <th>Nội dung sửa</th>
                                    <th>Ngày HĐ sửa</th>
                                    <th>Số HĐ sửa</th>
                                    <th>Giá trị trước khi sửa</th>
                                    <th>Giá trị sau  khi sửa</th>
                                    <th>Chênh lệch</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$yesterday = date('2016/03/13');
                                $yesterday = date('Y/m/d',strtotime("-1 days"));
                                foreach ( $bill_edit as $r )
                                { ?>  
                                <tr>
                                  <td><?=( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 0, 10) : "" ?></td>
                                  <td><?=$r['TenNV']?></td>
                                  <td><?=( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 11, 5) : ""?></td>
                                  <td><?=$r['GhiChu']?></td>
                                  <td><?=substr($r['ThoiGianTaoPhieu'],0, 10)?></td>
                                  <td><?=$r['MaLichSuPhieu']?></td>
                                  
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <?php 
                                } ?>
                              </tbody>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab3primary">
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="this_month">
                                <thead>
                                  <tr>
                                    <th>Ngày sửa</th>
                                    <th>NV sửa</th>
                                    <th>Giờ</th>
                                    
                                    <th>Nội dung sửa</th>
                                    <th>Ngày HĐ sửa</th>
                                    <th>Số HĐ sửa</th>
                                    <th>Giá trị trước khi sửa</th>
                                    <th>Giá trị sau  khi sửa</th>
                                    <th>Chênh lệch</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php
                                //$this_month = date('2016/03');
                                $this_month = date('Y/m');
                                $bill_edit =$goldenlotus->getBillEditDetailsByMonth( $this_month );
                                foreach ( $bill_edit as $r )
                                { ?>  
                                <tr>
                                  <td><?=( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 0, 10) : "" ?></td>
                                  <td><?=$r['TenNV']?></td>
                                  <td><?=( $r['ThoiGianSuaPhieu'] ) ? substr($r['ThoiGianSuaPhieu'], 11, 5) : ""  ?></td>
                                  <td><?=$r['GhiChu']?></td>
                                  <td><?=substr($r['ThoiGianTaoPhieu'],0, 10)?></td>
                                  <td><?=$r['MaLichSuPhieu']?></td>
                                  
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                                <?php 
                                } ?>
                              </tbody>
                             </table>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="tab4primary">
                            <div class="row">
                              <form action="" method="post">
                                <div class="col-md-2" style="margin-bottom:5px">Từ:</div>
                                  <div class="col-md-3 input-group date" style="margin-bottom:5px">
                                    <input name="tu-ngay"type='text' class="form-control" id="tu-ngay" />
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>
                                <div class="col-md-2" style="margin-bottom:5px">Đến:</div>
                                   <div class="col-md-3 input-group date" style="margin-bottom:5px">
                                      <input name="den-ngay"type='text' class="form-control" id="den-ngay" />
                                      <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                                      </span>
                                    </div>
                                <div class="col-md-3" style="margin-bottom:5px">
                                  <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                              </form>
                          </div>
                          <div class="col-xs-12 col-sm-12 table-responsive">
                            <table class="table table-striped table-bordered" id="custom_month">
                                <thead>
                                  <tr>
                                    <th>Ngày sửa</th>
                                    <th>NV sửa</th>
                                    <th>Giờ</th>
                                    
                                    <th>Nội dung sửa</th>
                                    <th>Ngày HĐ sửa</th>
                                    <th>Số HĐ sửa</th>
                                    <th>Giá trị trước khi sửa</th>
                                    <th>Giá trị sau  khi sửa</th>
                                    <th>Chênh lệch</th>
                                  </tr>
                                </thead>
                                <tbody>
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
<?php require_once('../ajax-loading.php'); ?>
<script>

$('form').on('submit', function (event){
    event.preventDefault();
    var tuNgay = $('#tu-ngay').val();console.log(tuNgay);
    var denNgay = $('#den-ngay').val();console.log(denNgay);
    
    $.ajax({
      url: "khac.php",
      method:"POST",
      data:{'tu-ngay' : tuNgay, 'den-ngay' : denNgay},
      dataType:"json",
      beforeSend :function(){
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(output)
      { 

       if ($.fn.DataTable.isDataTable("#custom_month")) {
             $("#custom_month").dataTable().fnDestroy();
        } 
       //console.log(output);

        $('#tab4primary table tbody').html(output);
        $('#custom_month').DataTable({
            "order": [],
            "columnDefs": [ {
            "targets"  : 0,
            "orderable": false,
            }]
         });

      },
      complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
    });
  });

</script>
<script>
$(function () {
   $('#tu-ngay').datetimepicker({
     // viewMode: 'years',
      format: 'DD/MM/YYYY'
   });
});

$(function () {
   $('#den-ngay').datetimepicker({
     // viewMode: 'years',
      format: 'DD/MM/YYYY'
   });
});



</script>
</body>
</html>

