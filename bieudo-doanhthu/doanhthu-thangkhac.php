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
      url:"bieudo-doanhthu/ajax-call/process-month.php",
      method:"POST",
      data:formValues,
      //dataType:"json",
      success:function(data)
      {
        var result = [];
        json_data=JSON.parse(data);  
        for(var i in json_data)
          result.push([i, json_data [i]]);
        console.log(json_data['doanhthu_t8']);
        var t1 = json_data['doanhthu_t8'];
        var  anotherMonthSales = document.getElementById('others');
        console.log(t1);

        var speedData = {
             labels :["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11,", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25","26", "27", "28", "29", "30", "31"],
              datasets: [{
                data:[
                json_data['doanhthu_01'],json_data['doanhthu_02'],json_data['doanhthu_03'],json_data['doanhthu_04'],json_data['doanhthu_05'],json_data['doanhthu_06'],json_data['doanhthu_07'],json_data['doanhthu_08'],json_data['doanhthu_09'],json_data['doanhthu_10'],json_data['doanhthu_11'],json_data['doanhthu_12'],
                json_data['doanhthu_13'],json_data['doanhthu_14'],json_data['doanhthu_15'],json_data['doanhthu_16'],json_data['doanhthu_17'],json_data['doanhthu_18'],json_data['doanhthu_19'],json_data['doanhthu_20'],json_data['doanhthu_21'],json_data['doanhthu_22'],json_data['doanhthu_23'],json_data['doanhthu_24'],
                json_data['doanhthu_25'],json_data['doanhthu_26'],json_data['doanhthu_27'],json_data['doanhthu_28'],json_data['doanhthu_29'],json_data['doanhthu_30'],json_data['doanhthu_31'] 
                ],
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

        var chartOptions = {
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

        var lineChart = new Chart(anotherMonthSales, {
            type: 'line',
            data:speedData,
            options: chartOptions
        });


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