<title>Giải pháp quản lý Spa, Clinic - ZinSpa</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Spa ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
 
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/custom.css" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet"> 
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- Boostrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Boostrap Datetimepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" />

<!--  ChartJS   -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<!--  Datepicker -->   
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<!-- DataLabels plugin --> 
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.min.js"></script> 

<script>
// $('.navbar-toggle').on('click', function() {
//   $('.sidebar-nav').toggleClass('block');  
   
// });
</script>
<!---//webfonts---> 




<style>
/*--new menu 19042020 ---*/
.li-level1
{
  padding: 8px 8px 8px 5px;
}

.menu-level1 {
  font-size: 14px;
  color: #818181;
}

.menu-level1:hover {
  color: #f1f1f1;
}

.menu-level2 {
  padding: 8px 8px 8px 15px;
  font-size: 14px;
  color: #818181;
}

.menu-level2:hover {
  color: #f1f1f1;
}

.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 8px 8px 8px 5px; /*top right bottom left*/
  text-decoration: none;
  font-size: 14px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.dropdown-btn.active {
  background-color: green;
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 15px;
  line-height: 2em;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 12px;}
}

/*-----end style new menu 19042020*/


/********************************************************************/
/*** PANEL PRIMARY ***/
.with-nav-tabs.panel-primary .nav-tabs > li > a,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
    color: #fff;
}
.with-nav-tabs.panel-primary .nav-tabs > .open > a,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
  color: #fff;
  background-color: #3071a9;
  border-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
  color: #428bca;
  background-color: #fff!important;
  border-color: #428bca;
  border-bottom-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #428bca;
    border-color: #3071a9;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #fff;   
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #3071a9;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    background-color: #4a9fe9;
}
/********************************************************************/
@media only screen and (max-with:768px) {
#page-wrapper  .panel .panel-heading {
    height: initial!important;
  }
}

/*
*** Sign up page
 */
#wrap{
background-image: -ms-linear-gradient(top, #FFFFFF 0%, #D3D8E8 100%);
/* Mozilla Firefox */ 
background-image: -moz-linear-gradient(top, #FFFFFF 0%, #D3D8E8 100%);
/* Opera */ 
background-image: -o-linear-gradient(top, #FFFFFF 0%, #D3D8E8 100%);
/* Webkit (Safari/Chrome 10) */ 
background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #FFFFFF), color-stop(1, #D3D8E8));
/* Webkit (Chrome 11+) */ 
background-image: -webkit-linear-gradient(top, #FFFFFF 0%, #D3D8E8 100%);
/* W3C Markup, IE10 Release Preview */ 
background-image: linear-gradient(to bottom, #FFFFFF 0%, #D3D8E8 100%);
background-repeat: no-repeat;
background-attachment: fixed;
}
legend{
  color:#141823;
  font-size:25px;
  font-weight:bold;
}
.signup-btn {
  background: #79bc64;
  background-image: -webkit-linear-gradient(top, #79bc64, #578843);
  background-image: -moz-linear-gradient(top, #79bc64, #578843);
  background-image: -ms-linear-gradient(top, #79bc64, #578843);
  background-image: -o-linear-gradient(top, #79bc64, #578843);
  background-image: linear-gradient(to bottom, #79bc64, #578843);
  -webkit-border-radius: 4;
  -moz-border-radius: 4;
  border-radius: 4px;
  text-shadow: 0px 1px 0px #898a88;
  -webkit-box-shadow: 0px 0px 0px #a4e388;
  -moz-box-shadow: 0px 0px 0px #a4e388;
  box-shadow: 0px 0px 0px #a4e388;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  padding: 10px 20px 10px 20px;
  border: solid #3b6e22  1px;
  text-decoration: none;
}

.signup-btn:hover {
  background: #79bc64;
  background-image: -webkit-linear-gradient(top, #79bc64, #5e7056);
  background-image: -moz-linear-gradient(top, #79bc64, #5e7056);
  background-image: -ms-linear-gradient(top, #79bc64, #5e7056);
  background-image: -o-linear-gradient(top, #79bc64, #5e7056);
  background-image: linear-gradient(to bottom, #79bc64, #5e7056);
  text-decoration: none;
}
.navbar-default .navbar-brand{
    color:#fff;
    font-size:30px;
    font-weight:bold;
  }
.form .form-control { margin-bottom: 10px; }
@media (min-width:768px) {
  #home{
    margin-top:50px;
  }
  #home .slogan{
    color: #0e385f;
    line-height: 29px;
    font-weight:bold;
  }
}

/*
****iOS toggle checkbox
 *

.checkbox-slider--b-flat {
  position: relative;
}
.checkbox-slider--b-flat input {
  display: block;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 0%;
  height: 0%;
  margin: 0 0;
  cursor: pointer;
  opacity: 0;
  filter: alpha(opacity=0);
}
.checkbox-slider--b-flat input + span {
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}
.checkbox-slider--b-flat input + span:before {
  position: absolute;
  left: 0px;
  display: inline-block;
}
.checkbox-slider--b-flat input + span > h4 {
  display: inline;
}
.checkbox-slider--b-flat input + span {
  padding-left: 40px;
}
.checkbox-slider--b-flat input + span:before {
  content: "";
  height: 20px;
  width: 40px;
  background: rgba(100, 100, 100, 0.2);
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.8);
  transition: background 0.2s ease-out;
}
.checkbox-slider--b-flat input + span:after {
  width: 20px;
  height: 20px;
  position: absolute;
  left: 0px;
  top: 0;
  display: block;
  background: #ffffff;
  transition: margin-left 0.1s ease-in-out;
  text-align: center;
  font-weight: bold;
  content: "";
}
.checkbox-slider--b-flat input:checked + span:after {
  margin-left: 20px;
  content: "";
}
.checkbox-slider--b-flat input:checked + span:before {
  transition: background 0.2s ease-in;
}
.checkbox-slider--b-flat input + span {
  padding-left: 40px;
}
.checkbox-slider--b-flat input + span:before {
  border-radius: 20px;
  width: 40px;
}
.checkbox-slider--b-flat input + span:after {
  background: #ffffff;
  content: "";
  width: 20px;
  border: solid transparent 2px;
  background-clip: padding-box;
  border-radius: 20px;
}
.checkbox-slider--b-flat input:not(:checked) + span:after {
  -webkit-animation: popOut ease-in 0.3s normal;
          animation: popOut ease-in 0.3s normal;
}
.checkbox-slider--b-flat input:checked + span:after {
  content: "";
  margin-left: 20px;
  border: solid transparent 2px;
  background-clip: padding-box;
  -webkit-animation: popIn ease-in 0.3s normal;
          animation: popIn ease-in 0.3s normal;
}
.checkbox-slider--b-flat input:checked + span:before {
  background: #5cb85c;
}
.checkbox-slider--b-flat.checkbox-slider-md input + span:before {
  border-radius: 30px;
}
.checkbox-slider--b-flat.checkbox-slider-md input + span:after {
  border-radius: 30px;
}
.checkbox-slider--b-flat.checkbox-slider-lg input + span:before {
  border-radius: 40px;
}
.checkbox-slider--b-flat.checkbox-slider-lg input + span:after {
  border-radius: 40px;
}
.checkbox-slider--b-flat input + span:before {
  box-shadow: none;
}

/*#####*/
.checkbox-slider-info.checkbox-slider--b input:checked + span:before,
.checkbox-slider-info.checkbox-slider--b-flat input:checked + span:before,
.checkbox-slider-info.checkbox-slider--c input:checked + span:before,
.checkbox-slider-info.checkbox-slider--c-weight input:checked + span:before {
  background: #5bc0de;
}

.checkbox-slider-warning.checkbox-slider--b input:checked + span:before,
.checkbox-slider-warning.checkbox-slider--b-flat input:checked + span:before,
.checkbox-slider-warning.checkbox-slider--c input:checked + span:before,
.checkbox-slider-warning.checkbox-slider--c-weight input:checked + span:before {
  background: #f0ad4e;
}

.checkbox-slider-danger.checkbox-slider--b input:checked + span:before,
.checkbox-slider-danger.checkbox-slider--b-flat input:checked + span:before,
.checkbox-slider-danger.checkbox-slider--c input:checked + span:before,
.checkbox-slider-danger.checkbox-slider--c-weight input:checked + span:before {
  background: #d9534f;
}

/*******************************************************
Sizes
*******************************************************/
.checkbox-slider-sm {
  line-height: 10px;
}
.checkbox-slider-sm input + span {
  padding-left: 20px;
}
.checkbox-slider-sm input + span:before {
  width: 20px;
}
.checkbox-slider-sm input + span:after,
.checkbox-slider-sm input + span:before {
  height: 10px;
  line-height: 10px;
}
.checkbox-slider-sm input + span:after {
  width: 10px;
  vertical-align: middle;
}
.checkbox-slider-sm input:checked + span:after {
  margin-left: 10px;
}
.checkbox-slider-md {
  line-height: 30px;
}
.checkbox-slider-md input + span {
  padding-left: 60px;
}
.checkbox-slider-md input + span:before {
  width: 60px;
}
.checkbox-slider-md input + span:after,
.checkbox-slider-md input + span:before {
  height: 30px;
  line-height: 30px;
}
.checkbox-slider-md input + span:after {
  width: 30px;
  vertical-align: middle;
}
.checkbox-slider-md input:checked + span:after {
  margin-left: 30px;
}
.checkbox-slider-lg {
  line-height: 40px;
}
.checkbox-slider-lg input + span {
  padding-left: 80px;
}
.checkbox-slider-lg input + span:before {
  width: 80px;
}
.checkbox-slider-lg input + span:after,
.checkbox-slider-lg input + span:before {
  height: 40px;
  line-height: 40px;
}
.checkbox-slider-lg input + span:after {
  width: 40px;
  vertical-align: middle;
}
.checkbox-slider-lg input:checked + span:after {
  margin-left: 40px;
}
</style>

