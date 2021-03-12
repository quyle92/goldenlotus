<?php 
 $last_month =date('yy/m', strtotime('-1 months'));
  //

  //---thang 
  //
  $sql = "";
  $sql .= "SELECT ";

  for ( $i = 1; $i <= 31; $i++ ){

    if($i <= 9){
     $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,11) like '" . $last_month . "/0" . $i ."' Then TienThucTra  Else 0 END) as DoanhThu_0" . $i . ", "; 
   }

    if($i > 9){
      $sql .= "SUM(CASE WHEN substring(Convert(varchar,GioVao,111),0,11) like '" . $last_month . "/" . $i ."' Then TienThucTra  Else 0 END) as DoanhThu_" . $i . ", "; 
    }
  }

 $sql = rtrim($sql, ", ");

  $sql .=" FROM [tblLichSuPhieu]  
    where DangNgoi = 0 and PhieuHuy = 0 and DaTinhTien = 1";
  try
  {
    $rs = $dbCon->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if($rs != false)
    {
      foreach ( $rs as $r1 ) 
      {
        $r1['DoanhThu_01'];
        $r1['DoanhThu_02'];
        $r1['DoanhThu_03'];
        $r1['DoanhThu_04'];
        $r1['DoanhThu_05'];
        $r1['DoanhThu_06'];
        $r1['DoanhThu_07'];
        $r1['DoanhThu_08'];
        $r1['DoanhThu_09'];
        $r1['DoanhThu_10'];
        $r1['DoanhThu_11'];
        $r1['DoanhThu_12'];
        $r1['DoanhThu_13'];
        $r1['DoanhThu_14'];
        $r1['DoanhThu_15'];
        $r1['DoanhThu_16'];
        $r1['DoanhThu_17'];
        $r1['DoanhThu_18'];
        $r1['DoanhThu_19'];
        $r1['DoanhThu_20'];
        $r1['DoanhThu_21'];
        $r1['DoanhThu_22'];
        $r1['DoanhThu_23'];
        $r1['DoanhThu_24'];
        $r1['DoanhThu_25'];
        $r1['DoanhThu_26'];
        $r1['DoanhThu_27'];
        $r1['DoanhThu_28'];
        $r1['DoanhThu_29'];
        $r1['DoanhThu_30'];
        $r1['DoanhThu_31'];
      }
      
      $DoanhThu_01 = $r1['DoanhThu_01'];settype($DoanhThu_01, "integer");
      $DoanhThu_02 = $r1['DoanhThu_02'];settype($DoanhThu_02, "integer");
      $DoanhThu_03 = $r1['DoanhThu_03'];settype($DoanhThu_03, "integer");
      $DoanhThu_04 = $r1['DoanhThu_04'];settype($DoanhThu_04, "integer");
      $DoanhThu_05 = $r1['DoanhThu_05'];settype($DoanhThu_05, "integer");
      $DoanhThu_06 = $r1['DoanhThu_06'];settype($DoanhThu_06, "integer");
      $DoanhThu_07 = $r1['DoanhThu_07'];settype($DoanhThu_07, "integer");
      $DoanhThu_08 = $r1['DoanhThu_08'];settype($DoanhThu_08, "integer");
      $DoanhThu_09 = $r1['DoanhThu_09'];settype($DoanhThu_09, "integer");
      $DoanhThu_10 = $r1['DoanhThu_10'];settype($DoanhThu_10, "integer");
      $DoanhThu_11 = $r1['DoanhThu_11'];settype($DoanhThu_11, "integer");
      $DoanhThu_12 = $r1['DoanhThu_12'];settype($DoanhThu_12, "integer");
      $DoanhThu_13 = $r1['DoanhThu_13'];settype($DoanhThu_13, "integer");
      $DoanhThu_14 = $r1['DoanhThu_14'];settype($DoanhThu_14, "integer");
      $DoanhThu_15 = $r1['DoanhThu_15'];settype($DoanhThu_15, "integer");
      $DoanhThu_16 = $r1['DoanhThu_16'];settype($DoanhThu_16, "integer");
      $DoanhThu_17 = $r1['DoanhThu_17'];settype($DoanhThu_17, "integer");
      $DoanhThu_18 = $r1['DoanhThu_18'];settype($DoanhThu_18, "integer");
      $DoanhThu_19 = $r1['DoanhThu_19'];settype($DoanhThu_19, "integer");
      $DoanhThu_20 = $r1['DoanhThu_20'];settype($DoanhThu_20, "integer");
      $DoanhThu_21 = $r1['DoanhThu_21'];settype($DoanhThu_21, "integer");
      $DoanhThu_22 = $r1['DoanhThu_22'];settype($DoanhThu_22, "integer");
      $DoanhThu_23 = $r1['DoanhThu_23'];settype($DoanhThu_23, "integer");
      $DoanhThu_24 = $r1['DoanhThu_24'];settype($DoanhThu_24, "integer");
      $DoanhThu_25 = $r1['DoanhThu_25'];settype($DoanhThu_25, "integer");
      $DoanhThu_26 = $r1['DoanhThu_26'];settype($DoanhThu_26, "integer");
      $DoanhThu_27 = $r1['DoanhThu_27'];settype($DoanhThu_27, "integer");
      $DoanhThu_28 = $r1['DoanhThu_28'];settype($DoanhThu_28, "integer");
      $DoanhThu_29 = $r1['DoanhThu_29'];settype($DoanhThu_29, "integer");
      $DoanhThu_30 = $r1['DoanhThu_30'];settype($DoanhThu_30, "integer");
      $DoanhThu_31 = $r1['DoanhThu_31'];settype($DoanhThu_31, "integer");
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
          <canvas id="lastmonth" ></canvas>
        </div>
      </div>

    </div>
      
  </div>
</div>             
         

<script>
//var salesLastMonth = document.getElementById('myChart').getContext('2d');
var salesLastMonth = document.getElementById('lastmonth');
var data = {
  labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11,", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25","26", "27", "28", "29", "30", "31"],
  datasets: [{
    label: "Revenue",
    data: [('<?php echo $DoanhThu_01; ?>'), ('<?php echo $DoanhThu_02; ?>'), ('<?php echo $DoanhThu_03; ?>'), ('<?php echo $DoanhThu_04; ?>'), ('<?php echo $DoanhThu_05; ?>'), ('<?php echo $DoanhThu_06; ?>'), ('<?php echo $DoanhThu_07; ?>'), ('<?php echo $DoanhThu_08; ?>'), ('<?php echo $DoanhThu_09; ?>'), ('<?php echo $DoanhThu_10; ?>'), ('<?php echo $DoanhThu_11; ?>'), ('<?php echo $DoanhThu_12; ?>'), ('<?php echo $DoanhThu_13; ?>'), ('<?php echo $DoanhThu_14; ?>'), ('<?php echo $DoanhThu_15; ?>'), ('<?php echo $DoanhThu_16?>'), ('<?php echo $DoanhThu_17?>'), ('<?php echo $DoanhThu_18?>'), ('<?php echo $DoanhThu_19?>'), ('<?php echo $DoanhThu_20?>'), ('<?php echo $DoanhThu_21?>'), ('<?php echo $DoanhThu_22?>'), ('<?php echo $DoanhThu_23?>'), ('<?php echo $DoanhThu_24?>'), ('<?php echo $DoanhThu_25?>'), ('<?php echo $DoanhThu_26?>'), ('<?php echo $DoanhThu_27?>'), ('<?php echo $DoanhThu_28?>'), ('<?php echo $DoanhThu_29?>'), ('<?php echo $DoanhThu_30?>'), ('<?php echo $DoanhThu_31?>')
    ], 
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
            callback: function(value, index, values) {
            // Convert the number to a string and splite the string every 3 charaters from the end
            value = value.toString();
            value = value.split(/(?=(?:...)*$)/);

            // Convert the array to a string and format the output
            value = value.join('.');
            return value;
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
    text:"Doanh Thu Tháng Này"
   },
   tooltips:{
                callbacks: {
                    label: function(tooltipItem, data) {
                        var formatNum = addCommas(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                        return "Day " + data.labels[tooltipItem.index] + ': ' + formatNum; 
                    }
                }
   } 
};

var lineChart = new Chart(salesLastMonth, {
    type: 'line',
    data: data,
    options: options,
    //make data figure above point
    // plugins: [{
    //       afterDatasetsDraw: function(chart) {
    //          var ctx = chart.ctx;
    //          chart.data.datasets.forEach(function(dataset, index) {
    //             var datasetMeta = chart.getDatasetMeta(index);
    //             if (datasetMeta.hidden) return;
    //             datasetMeta.data.forEach(function(point, index) {
    //                var value = dataset.data[index],
    //                    x = point.getCenterPoint().x,
    //                    y = point.getCenterPoint().y,
    //                    radius = point._model.radius,
    //                    fontSize = 10,
    //                    fontFamily = 'Verdana',
    //                    fontColor = 'black',
    //                    fontStyle = 'normal';
    //                ctx.save();
    //                ctx.textBaseline = 'middle';
    //                ctx.textAlign = 'center';
    //                ctx.font = fontStyle + ' ' + fontSize + 'px' + ' ' + fontFamily;
    //                ctx.fillStyle = fontColor;
    //                ctx.fillText( addCommas( value ), x, y - radius - fontSize);
    //                ctx.restore();
    //             });
    //          });
    //       }
    //    }]
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

console.log(options.plugins);console.log(lineChart. salesLastMonth)
salesLastMonth.onclick = function(e) {
  var point = lineChart.getElementAtEvent(e);
   var label = lineChart.data.labels[point[0]._index];//console.log(point[0]);
   var value = lineChart.data.datasets[0].data[point[0]._index];//console.log(label);
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

$(function(){ 
  function updateConfigByMutating(lineChart) {
      lineChart.options.title.text = 'Doanh Thu Tháng Trước';
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