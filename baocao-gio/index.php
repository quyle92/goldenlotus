<?php 
$page_name = "BieuDoDoanhThu";
require_once('../helper/security.php');
require('../lib/db.php');
require('../lib/goldenlotus.php');
require('../helper/custom-function.php');
@session_start();
$goldenlotus = new GoldenLotus($dbCon);


$tuNgay = isset($_POST['tuNgay']) ? $_POST['tuNgay'] : "";
$tuNgay = substr($tuNgay,6) . "/" . substr($tuNgay,3,2) . "/" . substr($tuNgay,0,2);
//$date = date('2020/08/26');
$qty_chart = $goldenlotus->getFoodSoldQtyByHour( $tuNgay, $nhom_hang_ban = null );

foreach ( $qty_chart as $r )
{
  $qty_sum_arr = array();
  $hour_block = array();
  foreach ($r as $k=>$v)
  {
  	$hour_block[] = $k;
	 if ($v < 0){
		$sales_sum_arr[] = 0;
	 }
    $qty_sum_arr[] = $v;
  }
}
//var_dump($qty_sum_arr);

$max_value_qty = max($qty_sum_arr);

$sales_chart = $goldenlotus->getSalesAmountByHour( $tuNgay, $nhom_hang_ban  );
$sales_sum_arr = array();
foreach ( $sales_chart as $r1 )
{
  $sales_sum_arr = array();
  foreach ($r1 as $k=>$v)
  {
	
    $sales_sum_arr[] = $v;
  }
}


$max_value_money = max($sales_sum_arr);


$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];



?>

<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script> 
<script>


</script>  
</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
    <div id="page-wrapper">

    <div class="col-md-12 graphs">


 <h3 class="title">Báo cáo giờ</h3>
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
                        foreach ( $nhom_hang_ban as $r )
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

						  <?php require_once('../datetimepicker-onetime.php'); ?>
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
                        foreach ( $nhom_hang_ban as $r )
                        {
                          $nhom_hang_ban_id = $r['Ma']; 
                          $nhom_hang_ban_ten = stripSpecial(stripUnicode(($r['Ten'])));

                          $file_name = '../baocao-gio/' . $nhom_hang_ban_ten . '.php';
                          $file_name_ajax = '../baocao-gio/ajax-call/process-' . $nhom_hang_ban_ten . '.php';
                          if( !( file_exists($file_name) ) ){
                            $file_contents = file_get_contents("../baocao-gio/template.php");
                            file_put_contents( $file_name , $file_contents );
                          }
                          if( !( file_exists($file_name_ajax) ) ){
                            $file_contents = file_get_contents("../baocao-gio/ajax-call/ajax-template.php");
                            file_put_contents( $file_name_ajax , $file_contents );
                          }
                                                  
                          require_once ( $file_name ); 
                          //require_once ('baocao-gio/' . $nhom_hang_ban_ten . '.php'); 
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
    qty_sum_arr = <?php echo json_encode( $qty_sum_arr );?>;
var maxValueQty = <?=$max_value_qty?>;

const QTY_CHART = document.getElementById('bieudo-soluong');
	
	var data = {
    labels: ["8h-9h",  "9h-10h", "10h-11h", "11h-12h", "12h-13h","13h-14h","14h-15h","15h-16h","16h-17h","17h-18h","18h-19h","19h-20h","20h-21h","21h-22h","22h-23h","23h-24h"],
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
	   },
	  tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';

                    if (label) {
                        label += ': ';
                    }
                    label += addCommas(tooltipItem.yLabel) ;
                    return label;
                }
              }
          }
	};

var mylineChart  = new Chart(QTY_CHART, {
    type: 'line',
    data: data,
    options: options,

});

    function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

</script>

<script>
var sales_sum_arr = []; 
sales_sum_arr =  <?php echo json_encode( $sales_sum_arr );?>;
var maxValueMoney = <?=$max_value_money?>;
console.log("sales_sum_arr");
const MONEY_CHART = document.getElementById('bieudo-sotien');
  
  var data2 = {
    labels: ["8h-9h",  "9h-10h", "10h-11h", "11h-12h", "12h-13h","13h-14h","14h-15h","15h-16h","16h-17h","17h-18h","18h-19h","19h-20h","20h-21h","21h-22h","22h-23h","23h-24h"],
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
     },
	   tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';

                    if (label) {
                        label += ': ';
                    }
                    label += addCommas(tooltipItem.yLabel) ;
                    return label;
                }
              }
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
		"setDate": new Date(),
    });
</script>
</body>
</html>

