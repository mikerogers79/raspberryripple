<?php
/****************************
* Body Dashboard 0.1
* Created: 01/01/16
* Updated: 
* By: Mike Rogers
* Notes
* Basic page for displaying body info.
*****************************/



//include files
include_once "getStocks.php";
include_once "navbar.php";
include_once "controller/forms.php";
include_once "time.php";


//DEBUG MODE
// Report all PHP errors (see changelog)
error_reporting(E_ALL);

//import the navbar
$navObj = new NavBar;
$navBar = $navObj->generateMenu('body');

//get the wallpaper synced up
$time = new Time;
$wallpaperOverride = $time->wallpaperCss();

////create the form
$form = new Form;
$BPForm = $form->generateFormHTML("BloodPressure.json"); //generate the form HTML

?>
<html>
  
<head>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE"> 
  <meta http-equiv="refresh" content="60">
  <title>Body Stats (Release 6)</title>
  <!-- Inserting web fonts -->
<link href='https://fonts.googleapis.com/css?family=Poiret+One|Fredericka+the+Great|Cabin+Sketch|Poller+One|Chelsea+Market|Londrina+Solid|Lilita+One|Codystar|Raleway+Dots' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="./css/main.css">  
<?= $wallpaperOverride ?>
</head>

<body>
<!-- Add a page refresh header every minute -->
  <div id='navContainer'>
  <span>Body Stats</span>
  <?= $navBar; ?>
  
  </div> 
 

<div id='pageContent'>
  
  <?= $BPForm; ?>
  
</div>  
</body>
</html>
