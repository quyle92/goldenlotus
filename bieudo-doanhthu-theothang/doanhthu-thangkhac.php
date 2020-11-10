<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
<script type = "text/javascript">

</script>

  <div class="row">
      <form method="POST" action="">
        <div class="form-group">
          <label for="datepicker"><strong>Chọn tháng:</strong></label>
          <input type="text" value="" id="datepicker" name="month-selected">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-info">Submit</button>
        </div>

      </form>


 <div class="panel panel-warning" data-widget="{&quot;draggable&quot;: &quot;false&quot;}" data-widget-static="">
  <div class="panel-body no-padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" >
          <canvas id="others" ></canvas>
         
      </div>

    </div>
      
  </div>
</div>             
         

<script>
  $('form').on('submit', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    $.ajax({
      url:"../bieudo-doanhthu-theothang/ajax-call/process-month.php",
      method:"POST",
      data:formValues,
      //dataType:"json",
      success:function(data)
      {
        var result = [];
        json_data=JSON.parse(data);  
        for(var i in json_data)
          //result.push( [i, addCommas( json_data [i] ) ] );
          result.push(  parseInt( json_data [i] )   );
        console.log(  ( result ) ) ;
        var  anotherMonthSales = document.getElementById('others');
       
        var data = {
             labels :["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11,", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25","26", "27", "28", "29", "30", "31"],
              datasets: [{
                label: "Revenue",
                data:result,
                 fill: false,
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

              }],
             

        }

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
                    userCallback: function(value, index, values) {
                      // Convert the number to a string and split the string every 3 charaters from the end
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
            text:"Doanh Thu Khác"
           },
           tooltips:{
                callbacks: {
                    label: function(tooltipItem, data) {
                        var formatNum = addCommas(data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index]);
                        return "Day " +  data.labels[tooltipItem.index] + ': ' + formatNum; 
                    }
                }
            } 

        };

      var lineChart = new Chart(anotherMonthSales, {
            type: 'line',
            data:data,
            options: options,
            //make data figure above point
           //  plugins: [{
           //    afterDatasetsDraw: function(chart) {
           //       var ctx = chart.ctx;
           //       chart.data.datasets.forEach(function(dataset, index) {
           //          var datasetMeta = chart.getDatasetMeta(index);
           //          if (datasetMeta.hidden) return;
           //          datasetMeta.data.forEach(function(point, index) {
           //             var value = dataset.data[index],
           //                 x = point.getCenterPoint().x,
           //                 y = point.getCenterPoint().y,
           //                 radius = point._model.radius,
           //                 fontSize = 10,
           //                 fontFamily = 'Verdana',
           //                 fontColor = 'black',
           //                 fontStyle = 'normal';
           //             ctx.save();
           //             ctx.textBaseline = 'middle';
           //             ctx.textAlign = 'center';
           //             ctx.font = fontStyle + ' ' + fontSize + 'px' + ' ' + fontFamily;
           //             ctx.fillStyle = fontColor;
           //             ctx.fillText(addCommas( value ), x, y - radius - fontSize);
           //             ctx.restore();
           //          });
           //       });
           //    }
           // }]
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

        anotherMonthSales.onclick = function(e) {
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
              var activePoints = lineChart.getDatasetAtEvent(e);
          // }
         //    updateConfigByMutating(lineChart);
        }


      }
    });
  });




$('#tungay').datepicker({ uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 
$('#denngay').datepicker({  uiLibrary: 'bootstrap',format: "dd.mm.yyyy"}); 

$("#datepicker").datepicker({
    viewMode: 'years',
    format: 'mm-yyyy',
    autoclose: true
});

</script>