<?php
/****************************
* Dashboard 1.1
* Created: 11/30/15
* Updated: 12/26/15
* By: Mike Rogers
* Notes
* Generic dashboard for displaying time and weather.
* 1.1 Implementing basic MVC style separation of business logic from view.
*****************************/



//include files
include_once "weather.php";
include_once "time.php";
include_once "getStocks.php";

//DEBUG MODE
// Report all PHP errors (see changelog)
error_reporting(E_ALL);


//pull in the weather class
$weather = new weather;
$weatherWidget = $weather->weatherWidgetHTML();

$currentWeather = $weather->todaysWeather();
$tomorrowsWeather = $weather->tomorrowsWeather();

//extract the stocks
$stocks = new stockPrices;
$currentPrices = $stocks->getStocksDiv();

//pull in the time object and provide weather info
$time = new Time;
$welcomeWidget = $time->welcomeWidget($currentWeather,$tomorrowsWeather);
$timeNatLangWidget = $time->timeNaturalLanguage(1);

?>
<html>
  
<head>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE"> 
  <meta http-equiv="refresh" content="60">
  <title>Welcome Screen! (Release 3)</title>
  <!-- Inserting web fonts -->
<link href='https://fonts.googleapis.com/css?family=Poiret+One|Fredericka+the+Great|Cabin+Sketch|Poller+One|Chelsea+Market|Londrina+Solid|Lilita+One|Codystar|Raleway+Dots' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="./css/main.css">  
<script type="text/javascript" src="./scripts/updateBg.js"></script>
</head>

<body>
<!-- Add a page refresh header every minute -->
  
  
  
<h1><?= $welcomeWidget; ?></h1>

  <div id='time'>
    <?= $timeNatLangWidget; ?>
  </div>
  
  <div id='weather'>
    <?= $weatherWidget ?>  
  </div>
  
  <div id='stocks'>
    <?= $currentPrices ?>
  </div>
  
</body>
</html>
