<?php  
$page_name = "BaoCaoQuanTri";
require_once('../helper/security.php'); 
require('../lib/db.php');
require('../lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

//$today = date('Y-m-d');
//$yesterday =   date('Y-m-d',strtotime("-1 day"));
//$last_week =   date('Y-m-d',strtotime("-7 days"));
$today = date('2021-01-20');
$yesterday =  date('2021-01-19');
$last_week = date('2021-01-13');

$up = '<i class="fa fa-arrow-up" aria-hidden="true"></i>';
$down = '<i class="fa fa-arrow-down" aria-hidden="true"></i>';

$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];


?>


<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<style>
.graphs {
    padding: 2em 1em;
    background: transparent;
    font-family: 'Roboto', sans-serif;
}
table {
	    text-transform: capitalize;
	    font-size: 18px;
}
/**
 * Striped table for popup
 */
.custab{
  border: 1px solid #ccc;
  padding: 5px;
  margin: 5% 0;
  box-shadow: 3px 3px 2px #ccc;
  transition: 0.5s;
  }
.custab:hover{
  box-shadow: 3px 3px 0px transparent;
  transition: 0.5s;
  }

.borderless td, .borderless th {
    border: none;
    color: #fff!important;
}

.well {
  background: #43C1FD !important;

}
</style>
<!-- Bootstrap iOS toggle https://www.bootstraptoggle.com/ -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
    <div class="xs">
   		<div class="container">
         <!--  TAble 1 -->
          <div class="row">
            <div class="col-md-6 well">

              <table class="table borderless">
                <thead>
                  <tr>
                    <th>Điểm tổng</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $sales_today = $goldenlotus->getTotalSales($today);//$today
                $sales_yesterday = $goldenlotus->getTotalSales($yesterday); 
                $sales_last_week = $goldenlotus->getTotalSales($last_week);

                if ( $sales_today !== NULL && $sales_yesterday !== NULL )
                {
                  $today_vs_yesterday_diff =  round( abs( ($sales_today - $sales_yesterday) * 100 / $sales_yesterday ) );
                }

                if ( $sales_today !== NULL && $sales_last_week !== NULL )
                {
                   $today_vs_lastWeek_diff =  round( abs( ($sales_today - $sales_last_week) * 100 / $sales_last_week ) );
                }

                $bill_amount_today = $goldenlotus->getBillAmount( $today);

                ?>
                  <tr>
                    <td><?=number_format($sales_today,0,",",".");?><sup>đ</sup></td>
                    <td>
                      <small class="pull-left">
                    <?php
                        if( $sales_today !== NULL && $sales_yesterday !== NULL )
                        {
                          echo ( $sales_today > $sales_yesterday ? $up : $down ) . ' ' . $today_vs_yesterday_diff . '% vs hôm qua';
                        }
                        elseif ( $sales_today == NULL && $sales_yesterday == NULL )
                        {
                          echo "";
                        }
                        elseif ( $sales_today == NULL || $sales_yesterday == NULL )
                        {
                          echo ( $sales_today == NULL ? $down : $up ) . ' ' . '100% vs hôm qua';
                        }
                    ?>
                      </small>
                    </td>
                  </tr>
                  <tr>
                    <td><?php echo $bill_amount_today; ?> hóa đơn</td>
                    <td>
                      <small class="pull-left">
                        <?php 
                        if( $sales_today !== NULL && $sales_last_week !== NULL )
                        {
                          echo ( $sales_today > $sales_last_week ? $up : $down ) . ' ' . $today_vs_lastWeek_diff . '% vs cùng ngày tuần trước';
                        }
                        elseif (  $sales_today == NULL && $sales_last_week == NULL )
                        {
                          echo "";
                        }
                        elseif ( $sales_today == NULL || $sales_last_week == NULL )
                        {
                          echo ( $sales_today == NULL ? $down : $up ) . ' ' . '100% vs  cùng ngày tuần trước';
                        }
                     ?>
                      </small>
                    </td>
                  </tr>
                  <tr>
                    <td><?=$bill_amount_today != 0  ? ( number_format( round($sales_today/$bill_amount_today),0,",",".") ) : 0?><sup>đ</sup>/hóa đơn</td>
                    <td></td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div>
          <!-- End TAble 1 -->
			    <div class="row">
		        <div class="col-md-6">
		    		<table class="table table-striped table-hover custab">
		    			<thead>
		    				<tr>
		    					<th> Chi Nhánh</th>
		    					<th>Doanh thu</th>
		    				</tr>
		    			</thead>
		    			<tbody>
              <?php
              $danh_sach_quay = $goldenlotus->layDSQuay();
              foreach( $danh_sach_quay as $quay )
              { ?> 
		    				<tr>
		    					<td><?=$quay['GhiChu']?></td>
		    					<td><?php
                    $ma_quay = $quay['MaQuay'];

                    $sales_today = $goldenlotus->getTotalSales($today, $ma_quay);
                    $sales_yesterday = $goldenlotus->getTotalSales($yesterday, $ma_quay); 
                    $sales_last_week = $goldenlotus->getTotalSales($last_week, $ma_quay);

                    if ( $sales_today !== NULL && $sales_yesterday !== NULL )
                    {
                      $today_vs_yesterday_diff =  round( abs( ($sales_today - $sales_yesterday) * 100 / $sales_yesterday ) );
                    }

                    if ( $sales_today !== NULL && $sales_last_week !== NULL )
                    {
                       $today_vs_lastWeek_diff =  round( abs( ($sales_today - $sales_last_week) * 100 / $sales_last_week ) );
                    }

                    //$bill_amount_today = $goldenlotus->getbBillAmount( $today , $ma_quay);
                    // $bill_amount_yesterday = $goldenlotus->getbBillAmount( $yesterday , $ma_quay);
                    // $percentage_amt =  round( abs( ($bill_amount_today - $bill_amount_yesterday) * 100 / $bill_amount_yesterday ) );
                  ?>
                  <div class="row">
                    <div class="col-md-4">
                      <?=number_format($sales_today,0,",",".");?><sup>đ</sup>
                    </div>
                    <div class="col-md-8">
                      <small class="pull-right">
                     <?php 
                        if( $sales_today !== NULL && $sales_yesterday !== NULL )
                        {
                          echo ( $sales_today > $sales_yesterday ? $up : $down ) . ' ' . $today_vs_yesterday_diff . '% vs hôm qua';
                        }
                        elseif ( $sales_today == NULL && $sales_yesterday == NULL )
                        {
                          echo "";
                        }
                        elseif ( $sales_today == NULL || $sales_yesterday == NULL )
                        {
                          echo ( $sales_today == NULL ? $down : $up ) . ' ' . '100% vs hôm qua';
                        }
                     ?>
                      </small>
                    </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                      <?php //echo number_format($bill_amount_today,0,",",".");?><!--  Hóa đơn -->
                    </div>
                    <div class="col-md-8">
                      <small class="pull-right">
                     <?php 
                        if( $sales_today !== NULL && $sales_last_week !== NULL )
                        {
                          echo ( $sales_today > $sales_last_week ? $up : $down ) . $today_vs_lastWeek_diff . ' ' . '% vs cùng ngày tuần trước';
                        }
                        elseif (  $sales_today == NULL && $sales_last_week == NULL )
                        {
                          echo "";
                        }
                        elseif ( $sales_today == NULL || $sales_last_week == NULL )
                        {
                          echo ( $sales_today == NULL ? $down : $up ) . ' ' . '100% vs  cùng ngày tuần trước';
                        }
                     ?>
                      </small>
                    </div>
                  </div>
                  <!-- <div class="row">
                    <div class="col-md-6">
                      <?php //echo number_format($sales_today / $bill_amount_today,0,",",".");?><sup>đ</sup>/Hóa đơn
                    </div>
         
                  </div> -->
                    
                  </td>
		    				</tr>
              <?php } ?>
		    				<!-- <tr>
		    					<td>Quầy 2</td>
		    					<td>
                  <?php
                    $ma_quay = 'Quay2';
                    $sales_today = $goldenlotus->getTotalSales($today, $ma_quay);
                    echo number_format($sales_today,0,",",".");
                  ?><sup>đ</sup><d>
                </tr> -->
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

