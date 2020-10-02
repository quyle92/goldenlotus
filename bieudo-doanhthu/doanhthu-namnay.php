<?php 
if($tungay == "")
{
  $tungay = "01-01-".date('Y');
}

if($denngay == "")
{
  $denngay = date('d-m-Y');
}
  //
  //---------chuyển sang chuỗi tháng -> để query sql
  //
  $tuthang_converted = "";
  $denthang_converted = "";
  if($tungay != "")
  {
    $tuthang_converted = substr($tungay,6) . "/" . substr($tungay,3,2);
  }
  //
  //----loc doanh thu tung thang-----//
  //
  $doanhthu_t1 = 0; $doanhthu_t2 = 0; $doanhthu_t3 = 0; $doanhthu_t4 = 0; $doanhthu_t5 = 0; $doanhthu_t6 = 0;
  $doanhthu_t7 = 0; $doanhthu_t8 = 0; $doanhthu_t9 = 0; $doanhthu_t10 = 0; $doanhthu_t11 = 0; 
  $doanhthu_t12 = 0;
  //
  //---thang
  //
  $sql="SELECT SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) like '".substr($tungay,6)."/01' Then TongTien Else 0 END) as DoanhThuT1, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/02' Then TongTien Else 0 END) as DoanhThuT2, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/03' Then TongTien Else 0 END) as DoanhThuT3, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/04' Then TongTien Else 0 END) as DoanhThuT4, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".  substr($tungay,6)."/05' Then TongTien Else 0 END) as DoanhThuT5, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/06' Then TongTien Else 0 END) as DoanhThuT6, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/07' Then TongTien Else 0 END) as DoanhThuT7, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/08' Then TongTien Else 0 END) as DoanhThuT8, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/09' Then TongTien Else 0 END) as DoanhThuT9, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/10' Then TongTien Else 0 END) as DoanhThuT10, 
  SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/11' Then TongTien Else 0 END) as DoanhThuT11, 
SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,8) = '".substr($tungay,6)."/12' Then TongTien Else 0 END) as DoanhThuT12 
    FROM tblLichSuPhieu a 
    where a.DangNgoi = 0 and a.PhieuHuy = 0 and a.DaTinhTien = 1";
  try
  {
    $result_dt = sqlsrv_query( $conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET) );
    if($result_dt != false)
    {
      for ($i = 0; $i < sqlsrv_num_rows($result_dt); $i++)
      {
        $r1 = sqlsrv_fetch_array($result_dt, SQLSRV_FETCH_ASSOC , SQLSRV_SCROLL_ABSOLUTE, $i);
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
    }
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
          <canvas id="thisyear" ></canvas>
        </div>
      </div>

    </div>
      
  </div>
</div>             
         

<script>
//var ctx = document.getElementById('myChart').getContext('2d');
var salesThisYear = document.getElementById('thisyear');
var data = {
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
 
var options = {
  legend: {
    display: false,
    position: 'top',
    labels: {
      boxWidth: 80,
      fontColor: 'black'
    }
  },
  scales: {
    yAxes: [{
        ticks: {
            beginAtZero: true
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
   }
};

var lineChart = new Chart(salesThisYear, {
    type: 'line',
    data: data,
    options: options
});

salesThisYear.onclick = function(e) {
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