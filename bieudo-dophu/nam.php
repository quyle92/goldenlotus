<?php
require('../datetimepicker-year.php');
?>
<div class="container-fluid">
			<div class="row">
				<div class="col-md-12" >
					<canvas id="dophu_nam" ></canvas>
				</div>
			</div>

</div>

<script>
$(function () {  
  $('body').on('submit', 'form#customYear', function (event){
    event.preventDefault();
    var formValues= $(this).serialize();
    $.ajax({
    url: 'ajax/year.php',
    method:"POST",
    data:formValues,
    dataType:"json",
    success:function(response)
      { 
        const DOPHU_BAYGIO = document.getElementById('dophu_nam');
      
        var coNguoi = response.coNguoi;
        var banTrong = response.banTrong;
        var data = {
          labels: ["Bàn trống",  "Có người"],
          datasets: [
            {
              label: "Độ phủ theo năm",
              data: [banTrong, coNguoi],
              backgroundColor: [
                "#DC143C",
                "#2E8B57"
              ],
              borderColor: [
            "#CB252B",
                "#1D7A46"
              ],
              borderWidth: [1, 1]
            }
          ]
        };

        var options = {
          responsive: true,
          title: {
            display: false,
            position: "top",
            text: "Độ phủ theo năm",
            fontSize: 18,
            fontColor: "#111"
          },
          legend: {
            display: true,
            position: "bottom",
            labels: {
              fontColor: "#333",
              fontSize: 16
            }
          },
            plugins: {
              datalabels: {
                  formatter: (value, DOPHU_BAYGIO) => {
                      let sum = 0;
                      let dataArr = DOPHU_BAYGIO.chart.data.datasets[0].data;
                      dataArr.map(data => {
                          sum += data;
                      });
                      let percentage = (value*100 / sum).toFixed(2)+"%";
                      return percentage;
                  },
                  color: '#fff',
                  
              }
          }
        };

      var myPieChart  = new Chart(DOPHU_BAYGIO, {
          type: 'doughnut',
          data: data,
          options: options
      });

      }
    });
    
  });

});
</script>