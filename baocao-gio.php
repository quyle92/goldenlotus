<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;

$date = $_POST['tungay'];
$date = substr($date,6) . "/" . substr($date,3,2) . "/" . substr($date,0,2);
//$date = date('2020/08/26');
$qty_chart = $goldenlotus->getFoodSoldQtyByHour( $date, $nhom_hang_ban = null );

while($r = sqlsrv_fetch_array( $qty_chart))
{
  $qty_sum_arr = array();
  $hour_block = array();
  foreach ($r as $k=>$v)
  {
  	$hour_block[] = $k;
    $qty_sum_arr[] = $v;
  }
}

$qty_sum_arr_new = array();
for ( $i = 1; $i < count($qty_sum_arr); $i++)
{ if( $i % 2)
    array_push( $qty_sum_arr_new, number_format( $qty_sum_arr[$i],0,",","." ) );
}
$max_value_qty = max($qty_sum_arr_new);

$sales_chart = $goldenlotus->getSalesAmountByHour( $date, $nhom_hang_ban  );
$sales_sum_arr = array();
while($r1 = sqlsrv_fetch_array( $sales_chart))
{
  $sales_sum_arr = array();
  foreach ($r1 as $k=>$v)
  {
    $sales_sum_arr[] = $v;
  }
}

$sales_sum_arr_new = array();
for ( $i = 1; $i < count($sales_sum_arr); $i++)
{ if( $i % 2)
    array_push( $sales_sum_arr_new, $sales_sum_arr[$i] );
}
$max_value_money = max($sales_sum_arr_new);


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
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script> 
<script>


</script>  
</head>
<body>
<div id="wrapper">
    <?php include 'menu.php'; ?>
    <div id="page-wrapper">

    <div class="col-md-12 graphs">


 <h3 class="title">Báo cáo hóa đơn</h3>
 <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
	<div class="panel-body no-padding">
		<div class="container-fluid">
			<div class="row">
            
      </div>
			<div class="row">
				<div class="panel with-nav-tabs panel-primary ">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tatca" data-toggle="tab">Tất cả</a></li>
                        <?php 
                        $nhom_hang_ban = $goldenlotus->getNDMNhomHangBan();//var_dump(sqlsrv_fetch_array($nhom_hang_ban));
                        while( $r = sqlsrv_fetch_array($nhom_hang_ban) )
                        { ?>
                        <li><a href="#<?=$r['Ma']?>" data-toggle="tab"><?=$r['Ten']?></a></li>
                        <?php
                    	   }
                        ?>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                      <div class="tab-pane fade in active" id="tatca">
                          <form action="" method="post">
                            <div class="col-md-2" style="margin-bottom:5px">Ngày:</div>
                            <div class="col-md-3" style="margin-bottom:5px"><input name="tungay" type="text"  value="<?php echo @$tungay ?>" id="tungay" />
                            </div>
                            <div class="col-md-2" style="margin-bottom:5px"><input type="submit" value="Lọc"></div>
                          </form>
                          <div class="col-xs-12 col-sm-12 table-responsive">
                          	<div class="col-md-12" >
            									<canvas id="bieudo-soluong" ></canvas>
            								</div>
          						      <div class="col-md-12" >
          						          <canvas id="bieudo-sotien" ></canvas>
          						      </div>
                         </div>
                      </div>
                        
                        <?php 
                        $nhom_hang_ban = $goldenlotus->getNDMNhomHangBan();
                        while( $r = sqlsrv_fetch_array($nhom_hang_ban) )
                        {
                        $nhom_hang_ban_id = $r['Ma']; 
                        $nhom_hang_ban_ten = $r['Ten']; 
                        require_once ('baocao-gio/' . strtolower($r['Ma']) . '.php'); 
                    	 }
                        ?>
                     
                    </div>
                </div>
        </div>
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

<script>
var qty_sum_arr = new Array();
    qty_sum_arr = <?php echo json_encode( $qty_sum_arr_new );?>;
var maxValueQty = <?=$max_value_qty?>;

const QTY_CHART = document.getElementById('bieudo-soluong');
	
	var data = {
    labels: ["8h00",  "9h00", "10h00", "11h00", "12h00","13h00","14h00","15h00","16h00","17h00","18h00","19h00","20h00"],
    datasets: [
      {
        label: "Số Lượng",
        data: qty_sum_arr,
        fill: false,
	    // cubicInterpolationMode : 'monotone',
	    lineTension: 0,
	    borderColor: 'rgb(51, 153, 255)',
	    backgroundColor: 'rgb(51, 153, 255)',
	    pointBorderColor: 'rgb(255, 102, 0)',
	   // pointBackgroundColor: 'rgb(255, 102, 0)',
	    pointRadius: 5,
	    pointHoverRadius: 5,  
	    pointHitRadius: 30,
	    pointBorderWidth: 2,
	    pointStyle: 'rectRounded',
      }
    ]
  };

  var options = {
	  legend: {
	    display: true,
	    position: 'top',
	    labels: {
	      boxWidth: 80,
	      fontColor: 'black'
	    }
	  },
	  plugins: {
	        datalabels: false
	  },
	  scales: {
	    yAxes: [{
	        ticks: {
	            beginAtZero: true, 
	            max: Math.ceil( maxValueQty/0.7 ),
	            callback: function(value, index, values) {
	            // Convert the number to a string and splite the string every 3 charaters from the end
	            value = value.toString();
	            value = value.split(/(?=(?:...)*$)/);

	            // Convert the array to a string and format the output
	            value = value.join('.');
	            return  value;
	            }

	        }
	       
	    }]},
	  xAxes: [{

	        gridLines:{
	           
	            offsetGridLines: true
	        }
	      }]
	   ,
	   title: {
	    display:true,
	    text:"Tất cả"
	   }
	};

var mylineChart  = new Chart(QTY_CHART, {
    type: 'line',
    data: data,
    options: options,

});


</script>

<script>
var sales_sum_arr = []; 
sales_sum_arr =  <?php echo json_encode( $sales_sum_arr_new );?>;
var maxValueMoney = <?=$max_value_money?>;

const MONEY_CHART = document.getElementById('bieudo-sotien');
  
  var data2 = {
    labels: ["8h00",  "9h00", "10h00", "11h00", "12h00","13h00","14h00","15h00","16h00","17h00","18h00","19h00","20h00"],
    datasets: [
      {
        label: "Số Tiền",
        data:sales_sum_arr,
        fill: false,
      // cubicInterpolationMode : 'monotone',
      lineTension: 0,
      borderColor: 'rgb(51, 153, 255)',
      backgroundColor: 'rgb(51, 153, 255)',
      pointBorderColor: 'rgb(255, 102, 0)',
     // pointBackgroundColor: 'rgb(255, 102, 0)',
      pointRadius: 5,
      pointHoverRadius: 5,  
      pointHitRadius: 30,
      pointBorderWidth: 2,
      pointStyle: 'rectRounded',
      }
    ]
  };

  var options2 = {
    legend: {
      display: true,
      position: 'top',
      labels: {
        boxWidth: 80,
        fontColor: 'black'
      }
    },
    plugins: {
          datalabels: false
    },
    scales: {
      yAxes: [{
          ticks: {
              beginAtZero: true,
              max: Math.round( ( Math.ceil(maxValueMoney)/0.7 )/50000 ) * 50000,
              callback: function(value, index, values) {
              // Convert the number to a string and splite the string every 3 charaters from the end
              value = value.toString();
              value = value.split(/(?=(?:...)*$)/);

              // Convert the array to a string and format the output
              value = value.join('.');
              return  value;
              }

          }
         
      }]},
    xAxes: [{

          gridLines:{
             
              offsetGridLines: true
          }
        }]
     ,
     title: {
      display:true,
      text:"Tất cả"
     }
  };

var myMoneyChart  = new Chart(MONEY_CHART, {
    type: 'line',
    data: data2,
    options: options2
});


</script>


<script>

    $('#tungay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
    $('#denngay').datepicker({  uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 

    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap',
         format: "dd/mm/yyyy",
          todayBtn: true,
    });
</script>
</body>
</html>
