<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
<script type = "text/javascript">

</script>
<div class="container">
	  <div class="row">
		<form method="POST" action="">
		 <div class="col-md-4 form-group">
			<label for="tu-ngay">Từ:</label>
			<div class="input-group date" style="margin-bottom:5px">
			  <input name="year" type='text' class="form-control" id="tu-ngay" />
			  <span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			  </span>
			</div>
			<button type="submit" class="btn btn-info">Submit</button>
		  </div>

		</form>

	  </div>
</div>


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
         
<?php require_once('../ajax-loading.php'); ?>
<script>
//var ctx = document.getElementById('myChart').getContext('2d');


  $('form').on('submit', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    $.ajax({
      url:"../bieudo-doanhthu-theonam/ajax-call/process-year.php",
      method:"POST",
      data:formValues,
      beforeSend :function(){
          $("#loadingMask").css('visibility', 'visible');
      },
      success:function(data)
      {
        var result = [];
        json_data=JSON.parse(data);  
        for(var i in json_data)
          result.push([i, json_data [i]]);
        console.log(json_data['doanhthu_t8']);
        var t1 = json_data['doanhthu_t8'];
        var  anotherYearSales = document.getElementById('others');
        //console.log(t1);

        var speedData = {
             labels :["Jan", "Feb", "Mar", "Apr", "May", "June", "July","Aug","Sep","Oct","Nov","Dec"], 
              datasets: [{
                data:[json_data['doanhthu_t1'],json_data['doanhthu_t2'],json_data['doanhthu_t3'],json_data['doanhthu_t4'],json_data['doanhthu_t5'],json_data['doanhthu_t6'],json_data['doanhthu_t7'],json_data['doanhthu_t8'],json_data['doanhthu_t9'],json_data['doanhthu_t10'],json_data['doanhthu_t11'],json_data['doanhthu_t12'] ],
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
                      return  data.labels[tooltipItem.index] + ': ' + formatNum; 
                  }
              }
           } 
        };

        var lineChart = new Chart(anotherYearSales, {
            type: 'line',
            data:speedData,
            options: chartOptions
        });


        anotherYearSales.onclick = function(e) {
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


      },
		complete: function() { $("#loadingMask").css('visibility', 'hidden'); }
    });
	  
	  
  });

$(function () {
  //$('#tu-ngay').val('');console.log($('#tu-ngay').val());
  var dateNow = new Date();
   $('#tu-ngay').datetimepicker({
     // viewMode: 'years',
      //useCurrent: false,
      format: 'YYYY',
      //defaultDate:dateNow
   });
});



</script>