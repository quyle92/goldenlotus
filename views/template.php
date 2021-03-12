<?php  
$page_name = "BaoCaoQuanTri";
require_once('../helper/security.php'); 
require('../lib/db.php');
require('../lib/goldenlotus.php');
require_once('../helper/custom-function.php'); 
@session_start();
$goldenlotus = new GoldenLotus($dbCon);

?>


<!DOCTYPE HTML>
<html>
<head>
<?php include ('../head/head-tag.php');?>
</head>
<body>
<div id="wrapper">
    <?php include '../menu.php'; ?>
  <div id="page-wrapper">
     <div class="container">  
     	
     </div>
   </div>            
</div>

<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});


</script>
</body>
</html>    

