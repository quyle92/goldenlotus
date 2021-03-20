<?php 

  //
  //----loc doanh thu tung thang-----//
  //
  $doanhthu_t1 = 0; $doanhthu_t2 = 0; $doanhthu_t3 = 0; $doanhthu_t4 = 0; $doanhthu_t5 = 0; $doanhthu_t6 = 0;
  $doanhthu_t7 = 0; $doanhthu_t8 = 0; $doanhthu_t9 = 0; $doanhthu_t10 = 0; $doanhthu_t11 = 0; 
  $doanhthu_t12 = 0;
  //
  //---thang
  //
  $last_year = date("Y",strtotime("-1 year"));
 $sql = "";

  $sql .= "SELECT ";

for ( $i = 1; $i <= 12; $i++ ){

    if($i <= 9){
     $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $last_year . "/0" . $i ."' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
   }

    if($i > 9){
      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '" . $last_year . "/" . $i ."' Then TienThucTra  Else 0 END) as DoanhThuT" . $i . ", "; 
    }
}
  
  $sql = rtrim($sql, ", ");

  $sql .=" FROM [tblLichSuPhieu] a LEFT JOIN [tblLSPhieu_HangBan] b on a.[MaLichSuPhieu] = b.[MaLichSuPhieu] 
    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1 ";
    
  if( ! empty($tenQuay) )
  {
      $sql .=" AND b.TenHangBan IN ( SELECT * FROM [{$tenQuay}View] )";
  }

  try
  {
    $rs = $dbCon->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if($rs != false)
    {
      foreach ( $rs as $r1 ) 
      {
        $r1['DoanhThuT1'];
        $r1['DoanhThuT2'];
        $r1['DoanhThuT3'];
        $r1['DoanhThuT4'];
        $r1['DoanhThuT5'];
        $r1['DoanhThuT6'];
        $r1['DoanhThuT7'];
        $r1['DoanhThuT8'];
        $r1['DoanhThuT9'];
        $r1['DoanhThuT10'];
        $r1['DoanhThuT11'];
        $r1['DoanhThuT12'];
      }
      
      $doanhthu_t1 = $r1['DoanhThuT1'];settype($doanhthu_t1, "integer");
      $doanhthu_t2 = $r1['DoanhThuT2'];settype($doanhthu_t2, "integer");
      $doanhthu_t3 = $r1['DoanhThuT3'];settype($doanhthu_t3, "integer");
      $doanhthu_t4 = $r1['DoanhThuT4'];settype($doanhthu_t4, "integer");
      $doanhthu_t5 = $r1['DoanhThuT5'];settype($doanhthu_t5, "integer");
      $doanhthu_t6 = $r1['DoanhThuT6'];settype($doanhthu_t6, "integer");
      $doanhthu_t7 = $r1['DoanhThuT7'];settype($doanhthu_t7, "integer");
      $doanhthu_t8 = $r1['DoanhThuT8'];settype($doanhthu_t8, "integer");
      $doanhthu_t9 = $r1['DoanhThuT9'];settype($doanhthu_t9, "integer");
      $doanhthu_t10 = $r1['DoanhThuT10'];settype($doanhthu_t10, "integer");
      $doanhthu_t11 = $r1['DoanhThuT11'];settype($doanhthu_t11, "integer");
      $doanhthu_t12 = $r1['DoanhThuT12'];settype($doanhthu_t12, "integer");
    } else echo "ERROR"; 
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
?>

 <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
  <div class="panel-body no-padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" >
          <canvas id="lastyear" ></canvas>
        </div>
      </div>

    </div>
      
  </div>
</div>             
         

<script>
//var ctx = document.getElementById('myChart').getContext('2d');
var salesLastYear = document.getElementById('lastyear');
var speedData = {
  labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July","Aug","Sep","Oct","Nov","Dec"],
  datasets: [{
    label: "Revenue",
    data: [('<?php echo $doanhthu_t1; ?>'), ('<?php echo $doanhthu_t2; ?>'), ('<?php echo $doanhthu_t3; ?>'), ('<?php echo $doanhthu_t4; ?>'), ('<?php echo $doanhthu_t5; ?>'), ('<?php echo $doanhthu_t6; ?>'), ('<?php echo $doanhthu_t7; ?>'), ('<?php echo $doanhthu_t8; ?>'), ('<?php echo $doanhthu_t9; ?>'), ('<?php echo $doanhthu_t10; ?>'), ('<?php echo $doanhthu_t11; ?>'), ('<?php echo $doanhthu_t12; ?>')],
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
    pointBackgroundColor: function(context) {
    var index = context.dataIndex; //console.log(index);
    var value = context.dataset.data[index];
    return value < 50 ? 'red' :  // draw negative values in red
       // index % 2 ? 'blue' :    // else, alternate values in blue and green
        'green';
    } 
  }]
};
 
var chartOptions = {
  legend: {
    display: false,
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
    display:false,
    text:"TEXT"
   },
   tooltips:{
      callbacks: {
          label: function(tooltipItem, data) {
              var formatNum = addCommas(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
              return data.labels[tooltipItem.index] + ': ' + formatNum; 
          }
      }
   } 
};

var lineChart = new Chart(salesLastYear, {
    type: 'line',
    data: speedData,
    options: chartOptions
});

salesLastYear.onclick = function(e) {
  var point = lineChart.getElementAtEvent(e);
   var label = lineChart.data.labels[point[0]._index];//console.log(point[0]);
   var value = lineChart.data.datasets[0].data[point[0]._index];console.log(label);
   switch (label) {
      // add case for each label/slice
      case 'Dec':
         //alert('clicked on slice 5');
        // window.open('http://localhost/goldenlotus/doanhthu-theongay?month=' + label +'.php');
         break;
      case 'July':
         //alert('clicked on slice 6');
         //window.open('http://localhost/goldenlotus/doanhthu-theongay.php');
         break;
      // add rests ...
   }
   //function updateConfigByMutating(lineChart) {
     
      lineChart.data.datasets[0].pointBackgroundColor[point[0]._index];
      lineChart.data.datasets[0].data[2] = 50; //console.log(lineChart.data.datasets[0].pointBackgroundColor[point[0]._index]);
      lineChart.update();
      var activePoints = lineChart.getDatasetAtEvent(e);console.log(activePoints);
  // }
 //    updateConfigByMutating(lineChart);
}
console.log(lineChart);
$(function(){ 
  function updateConfigByMutating(lineChart) {
      lineChart.options.title.text = 'new title';
      lineChart.update();
  }
  updateConfigByMutating(lineChart);

  $('.btn.btn-danger').click(function(){
    lineChart.clear();
    var label =  ["Jan", "Feb"]; var data = [10,20];
    function addData(lineChart, label, data) {
        lineChart.data.labels = label;
        lineChart.data.datasets.forEach((dataset) => {
            dataset.data = data;
        });
        lineChart.update();
    }
    addData(lineChart, label, data);

  });
});

$('#tungay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
$('#denngay').datepicker({  uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 

</script>