<?php
$baygio = date();

$sql = "SELECT DangNgoi, COUNT(*) as SoLuong
  FROM [NH_STEAK_PIZZA].[dbo].[tblLichSuPhieu]
   WHERE substring(Convert(varchar,GioVao,111),0,8) = '2020/09'
 GROUP BY DangNgoi ";

?>

<div class="container-fluid">
			<div class="row">
				<div class="col-md-12" >
					<canvas id="dophu-baygio" ></canvas>
				</div>
			</div>

</div>

<script>
//var ctx = document.getElementById('myChart').getContext('2d');
const DOPHU_BAYGIO = document.getElementById('dophu-baygio');
	
	var data = {
    labels: ["Bàn trống",  "Có người"],
    datasets: [
      {
        label: "Độ phủ theo thời gian thực",
        data: [10, 50],
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
      text: "Độ phủ theo thời gian thực",
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

</script>