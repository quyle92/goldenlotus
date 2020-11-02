<?php
require('lib/db.php');
require('lib/goldenlotus.php');
@session_start();
$goldenlotus = new GoldenLotus;

$today = date('Y-m-d');
$sales = $goldenlotus->getTotalSales($today);


$id=$_SESSION['MaNV'];
$ten=$_SESSION['TenNV'];

$matrungtam=$_SESSION['MaTrungTam'];
$trungtam=$_SESSION['TenTrungTam'];


if( $_SESSION['MaNV'] != 'HDQT' )
   die('<script> alert("Bạn ko được quyền truy cập vào đây!"); window.history.go(-1); </script>');
?>


<!DOCTYPE HTML>
<html>
<head>
<?php include ('head/head-revenue.month.php');?>
<style>
.graphs {
    padding: 2em 1em;
    background: transparent;
    font-family: 'Roboto', sans-serif;
}
table {
	    text-transform: capitalize;
	    font-size: 18px;
}
</style>
<!-- Bootstrap iOS toggle https://www.bootstraptoggle.com/ -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
<div id="wrapper">
    <?php include 'menu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
    <div class="xs">
   		<div class="container">
			<div class="row">
		        <div class="col-md-6">
		    		<table class="table table-striped table-hover">
		    			<thead>
		    				<tr>
		    					<th> Chi Nhánh</th>
		    					<th>doanh thu</th>
		    				

		    				</tr>
		    			</thead>
		    			<tbody>
		    				<tr>
		    					<td>tất cả chi nhánh</td>
		    					<td><?=number_format($sales[0],0,",",".")?><sup>đ</sup><d>
		    				

		    				</tr>
		    				<tr>
		    	
		    					<td>golden lotus spa q3</td>
		    					<td><?=number_format($sales[0],0,",",".")?><sup>đ</sup><d>

		    				</tr>


		    			</tbody>
		    		</table>
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


</body>
</html>
