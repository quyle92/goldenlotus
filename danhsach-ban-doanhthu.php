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
.danh-sach-ban .soluong{
text-align: center;
border: 1px solid #333;
border-radius: 100%;
height: 45px;
width: 45px;
display: flex;
align-items: center;
justify-content: center;
}


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
			<div class="container">
	       <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Danh sách bàn + doanh thu</h3>
            </div>   
            <ul class="list-group danh-sach-ban">
                <li class="list-group-item">
                    <div class="row toggle" id="dropdown-detail-1" data-toggle="detail-1">
                        <div class="col-xs-10">
                        	<div style="display:flex">
                        		<div class="tbl-image">
                            		<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQAgbGp_MVun_RilsfDj3AAdrunFZXZAWkQPQ&usqp=CAU"  width="60" height="60">
                            	</div> 
                            	<div class="tlb-text" style="padding-left: 15px;padding-top: 5px;">
                            		<strong>TABLE</strong>
                            		<br>
                            		<span>Doanh thu:</span>
                            	</div>
                       		</div>
                        </div>
                        <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                    </div>
                    <div id="detail-1">
                        <hr></hr>
                        <div class="container">
                            <div class="fluid-row">
                                <div class="col-xs-1">
                                   <div class="soluong">
                                       1,0
                                   </div>
                                </div>
                                <div class="col-xs-5">
                                   <strong>120. Diet Coke (can)</strong>
                                   <br>
                                   <span>30.000<sup>đ</sup></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
	       </div>
      </div>
    </div>
   <!-- #end class col-md-12 -->
  </div>
      <!-- /#page-wrapper -->
</div>
    <!-- /#wrapper -->
</body>