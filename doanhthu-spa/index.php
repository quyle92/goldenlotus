<?php  
$page_name = "TongHopSoLuongBan";
require_once('../helper/security.php'); 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

$id=isset($_SESSION['MaNV'])? $_SESSION['MaNV']:"";
$ten=isset($_SESSION['TenNV'])? $_SESSION['TenNV']:"";

$matrungtam=isset($_SESSION['MaTrungTam'])? $_SESSION['MaTrungTam']:"";
$trungtam=isset($_SESSION['TenTrungTam'])? $_SESSION['TenTrungTam']:"";

?>

<!DOCTYPE HTML>
<html>
<head>

<?php include ('../head/head-tag.php');?>


<style>
/*table#custom_month_men tbody tr:nth-child(11), table#custom_month_women tbody tr:nth-child(11){
  display: none;
}*/
.redText {
  color: red !important;
  font-weight: 500;
}

.borderLess{
  border-left: none!important;
  border-right: none!important
}

.borderLessLeft{
  border-left: none!important;
 
}

.borderLessRight{
  border-right: none!important;
 
}

.h2-bg{
    margin: 30px 0;
    background: repeating-linear-gradient(
        -45deg,
        #e6f4ff,
        #e6f4ff 2px,
        #fff 3px,
        #fff 8px
);
}

.bill_table td, .bill_table th{
   border: 1px solid black!important;
}

/**
 * "Full Clickable Panel Heading"
 */
.clickable
{
    cursor: pointer;
}

.clickable .glyphicon
{
    background: rgba(0, 0, 0, 0.15);
    display: inline-block;
    padding: 10px 12px;
    border-radius: 4px
}

.panel-heading-child
{
    padding-bottom: 10px;
}

.panel-heading-child h3
{
   	font-size: 22px!important;
}

.panel-heading-child span
{
    margin-top: -24px;
    font-size: 15px;
    margin-right: -9px;
}

a.clickable { color: inherit; }
a.clickable:hover { text-decoration:none; }

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

  $(document).ready(function() {
    $('#all').DataTable();
} );
  $(document).ready(function() {
    $('#occupied').DataTable();
} );
  $(document).ready(function() {
    $('#empty').DataTable();
} );

  $(function () {

  /**
   * css for first bill_ID
   * 
   */
  var tr = $('table tbody tr[data-bill]');
  var style = {
      'color':'#43C1FD',
      'font-weight': 'bold'
  };
  tr.each(function() {
    if($(this).data('bill') != " "){//console.log($(this).data('bill'));
      $(this).find('td').css(style);
    }
  });


  /**
   * css for subtotal
   * 
   */
  var tr = $('table tbody tr[data-total]');
  var style = {
      'color':'red',
      'font-weight': 'bold'
  };
  tr.each(function() {
    if($(this).data('bill') != " "){//console.log($(this).data('bill'));
      $(this).find('td').css(style);
    }
  });

});

  /**
   * "Full Clickable Panel Heading"
   */
  
var first = true;
$(document).on('click', '.panel div.clickable', function (e) {
    var $this = $(this);

     if ( !$this.hasClass('whatever')) {console.log($this.hasClass('whatever'));
    // if( $(this) && first ){console.log(first);
        $this.parent('.panel').find('.panel-body').slideUp();
        $this.addClass('whatever');
        $this.find('i').removeClass('glyphicon-minus').addClass('glyphicon-plus');
        
    } else  {console.log($this.hasClass('whatever'));
        $this.parent('.panel').find('.panel-body').slideDown();
        $this.removeClass('whatever');
        $this.find('i').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }

    first = !first;
});

$(document).ready(function () {

   // $('.panel div.clickable').click();
});

</script>
</head>
<body>
<div id="wrapper ">
    <?php include '../menu.php'; ?>
      <div id="page-wrapper" >

        <div class="col-xs-12 col-sm-12 col-md-12 graphs">
            <h3 class="title">Doanh thu Spa: <strong id="grandTotal" class="text-danger"></strong></h3>

            <div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1primary" data-toggle="tab">Khu nam</a></li>
                            <li><a href="#tab2primary" data-toggle="tab">Khu nữ</a></li>
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">

                      <div class="tab-pane fade active in" id="tab1primary">
                        <div class="col-xs-12 col-sm-12 ">

                            <div class="panel">
                            	<?php
                            	$goldenlotus = new GoldenLotus($dbCon);

              								$spa_sales = $goldenlotus->getSalesSpa_KhuNam();//pr($spa_sales[1]);die;

                              $total_bills_man_1 = $spa_sales[0][0]['TotalQty'];
                              $total_bills_man_2 = $spa_sales[0][1]['TotalQty'];
                              $total_bills_man_3 = $spa_sales[0][2]['TotalQty'];

              								$spa_sales = customizeArray_SpaZone($spa_sales[1]);
              								$ma_khu_arr = array();

              								foreach( $spa_sales as $k => $v )
              								{
              									$ma_khu_arr[] = $k;
              								}
              								
              								$man_1 = $spa_sales[$ma_khu_arr[0]];
              								$man_2 = $spa_sales[$ma_khu_arr[1]];
              								$man_3 = $spa_sales[$ma_khu_arr[2]];
              								//var_dump($man_2);die;
                            	?>

                           <?php require_once('khu_nam_total.php'); ?>
				            	
                            </div>
                        </div>
                      </div>
                      
                      <div class="tab-pane fade " id="tab2primary">
                          <div class="col-xs-12 col-sm-12">
                            <div class="panel">
                            	<?php
                            	$goldenlotus = new GoldenLotus($dbCon);

              								$spa_sales = $goldenlotus->getSalesSpa_KhuNu();

                              $total_bills_woman_1 = $spa_sales[0][0]['TotalQty'];
                              $total_bills_woman_2 = $spa_sales[0][1]['TotalQty'];
                              $total_bills_woman_3 = $spa_sales[0][2]['TotalQty'];

              								$spa_sales = customizeArray_SpaZone($spa_sales[1]);
              								$ma_khu_arr = array();

              								foreach( $spa_sales as $k => $v )
              								{
              									$ma_khu_arr[] = $k;
              								}
              								
              								$woman_1 = $spa_sales[$ma_khu_arr[0]];
              								$woman_2 = $spa_sales[$ma_khu_arr[1]];
              								$woman_3 = $spa_sales[$ma_khu_arr[2]];
              								//var_dump($woman_2);die;
                            	?>
                             <?php require_once('khu_nu_total.php'); ?>
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
<?php require_once('../ajax-loading.php'); ?>
</body>

<script>



$(function () {
   $('form#khu_nam .row input[name="tuNgay"]').datetimepicker({
     // viewMode: 'years',
      format: 'DD-MM-YYYY'
   });
});

$(function () {
   $('form#khu_nam .row input[name="denNgay"]').datetimepicker({
     // viewMode: 'years',
      format: 'DD-MM-YYYY'
   });
});

$(function () {
   $('form#khu_nu .row input[name="tuNgay"]').datetimepicker({
     // viewMode: 'years',
      format: 'DD-MM-YYYY'
   });
});

$(function () {
   $('form#khu_nu .row input[name="denNgay"]').datetimepicker({
     // viewMode: 'years',
      format: 'DD-MM-YYYY'
   });
});

</script>

