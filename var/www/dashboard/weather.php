<?php
/****************************
* Weather Library 1.1
* Created: 11/30/15
* Updated: 12/6/15
* By: Mike Rogers
* Notes
* Converting weather to object 
* oriented layout for easier maintenance.
* Updating weathertip to look at config file
*****************************/

include_once "getExternalData.php";


//This class controls all the weather details
class weather {

  //declare the global vars  
  private $fiveDayFile = "http://mikesonsmack.asuscomm.com:8888/dashboard/model/fiveDayWeather.json"; //5 day weather file  
  private $hourlyFile = "http://mikesonsmack.asuscomm.com:8888/dashboard/model/hourlyWeather.json"; //hourly weather
  private $weatherTips = "http://mikesonsmack.asuscomm.com:8888/dashboard_dev/model/weatherTips.csv";
  
  //make the weather objects available globally
  public $weatherObj5, $weatherObj;
  
  function __construct() {
       //add the file load details here
       $weatherFile5 = file_get_contents($this->fiveDayFile);  
       $weatherFileHourly = file_get_contents($this->hourlyFile);  
    
        //parse the file as JSON
        $this->weatherObj5 = json_decode($weatherFile5);
        $this->weatherObj = json_decode($weatherFileHourly);
   
   return;
   }
  
  
 
  //private weather funcs
  private function getTemp($jsonObj,$offset,$unit) {
    if($offset == null || $offset == 0) {
        $temperature = $jsonObj->main->temp;
      }
    else {
      $temperature = $jsonObj->list[$offset]->temp->day;
      
    }
    
    //convert from kelvin to the appropriate unit
    if ($unit == "F" || $unit == "f") {
      $temperature = round($this->k2f($temperature)) . "&deg;F";
    }
    else {
      $temperature = round($this->k2c($temperature)) . "&deg;C";
    }
    
  return $temperature;
  }
  
  // returns pressure.  Currently only supports mb
  private function getPressure($jsonObj,$offset) {
    
    //if you want today's pressure
    if($offset == null || $offset == 0) {
        $pressure = $jsonObj->main->pressure;
    }
    //if you want details for a date in the future
    else {
        $pressure = $jsonObj->list[$offset]->pressure;
    }
    
    //format the pressure
    $pressure = round($pressure) . "mb";
    
  return $pressure;  
  }
  
  private function getDate($jsonObj,$offset) {
    
    //if you want today's pressure
    if($offset == null || $offset == 0) {
        $date = "Invalid Date Offset";
    }
    //if you want details for a date in the future
    else {
        $date = $jsonObj->list[$offset]->dt;
        $date = date("Y.m.d",$date);
    }
    
  return $date;  
  }
  
  //takes json obj and returns the description for a given offset
  private function getDesc($jsonObj,$offset) {
      if($offset == null || $offset == 0) {        
        $description = $jsonObj->weather[0]->description;
      }
      else {
        $description = $jsonObj->list[$offset]->weather[0]->description;
      }

      
  return $description; 
  }
  
  private function getWeatherTip($desc) {
  
        //pull in weatherTips
        $extData = new getExternalData;

        //extract the weather data
        $weatherTips = $extData->csvToArray($this->weatherTips);
        

        $tip = '';
        //look for a match in the array
        for ($i=0; $i<sizeof($weatherTips); $i++) {

          //the string we're looking for is the first element on every line
          $targetString = $weatherTips[$i][0];

          //if there's a match with one of the target terms in the weather tip file then retrieve the tip (second element)
          if (substr_count($desc,$targetString) > 0) {
              $tip = $weatherTips[$i][1];
              return $tip; //break on the first match
          }

        }
    
  return $tip;
  }
  
  
  //convert kelvin to F
  private function k2f($t) {
    $f = ($t*9/5.0)-459.67;
    return $f;
  }
  
  //convert kelvin to C
  private function k2c($t) {
    $f = $t - 273.15;
    return $f;
  } 
  
  
  //pull the weather for a specific day in the future
  function getWeatherOffset($offset) {
    
    
  }
  
  //pull the weather for today
  function todaysWeather() {
    
    //pull in temp, pressure and desc into an array
    //feed in today's weather object and an offset of 0
    $todaysWeather = array(
      "desc" => $this->getDesc($this->weatherObj, 0),
      "temp" => $this->getTemp($this->weatherObj, 0, "F"),
      "pressure" => $this->getPressure($this->weatherObj, 0),
      "tip" => $this->getWeatherTip($this->getDesc($this->weatherObj, 0))
    );
    
  return $todaysWeather;
  }
  
  //format the weather widget
  function weatherWidgetHTML() {
    
    //pull in the weather as JSON Objects
     $currentWeather = $this->todaysWeather();
     $tomorrowsWeather = $this->tomorrowsWeather();
    
     $buffer = "";
     $buffer .= "<span class='currentWeather'>Today</span>".
                "<span class='currentWeather'>". $currentWeather["desc"] ."</span>".
                "<span class='currentWeather'>". $currentWeather["pressure"] ."</span>".
                "<span class='currentWeather'>". $currentWeather["temp"] ."</span>".
                "<span class='currentWeather'>-----------</span>";
    
    //future weather
    $buffer .= "<span class='currentWeather'>Tomorrow</span>".
               "<span class='currentWeather'>". $tomorrowsWeather["desc"] ."</span>".
               "<span class='currentWeather'>". $tomorrowsWeather["pressure"] ."</span>".
               "<span class='currentWeather'>". $tomorrowsWeather["temp"] ."</span>"; 
    
    
  return $buffer;
  }
  
  
  
  function tomorrowsWeather() {
    //pull in temp, pressure and desc into an array
    //feed in 5 day weather object and an offset of 1
    $tomorrowsWeather = array(
      "date" => $this->getDate($this->weatherObj5, 1),
      "desc" => $this->getDesc($this->weatherObj5, 1),
      "temp" => $this->getTemp($this->weatherObj5, 1, "F"),
      "pressure" => $this->getPressure($this->weatherObj5, 1),
      "tip" => $this->getWeatherTip($this->getDesc($this->weatherObj5, 1))
    );
  return $tomorrowsWeather; 
  }
  

    
}


?>