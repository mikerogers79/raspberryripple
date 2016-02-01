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
       $weatherFile5 = @file_get_contents($this->fiveDayFile,true);  
       $weatherFileHourly = @file_get_contents($this->hourlyFile,true);  
    
        //check to see if the files have been loaded correctly otherwise set them to false.
        
        if($weatherFile5 ===false || sizeof($weatherFile5) < 1) {
          $this->weatherObj5 = false;  
        }
        else {
          $this->weatherObj5 = json_decode($weatherFile5);  
        }
    
    
        if ($weatherFileHourly === false || sizeof($weatherFileHourly) < 1) {
          $this->weatherObj = false;
        }
        else {
          $this->weatherObj = json_decode($weatherFileHourly);
        } 
        //parse the file as JSON
                
   
   return;
   }
  
  
 
  //private weather funcs
  private function getTemp($jsonObj,$offset,$unit) {
    
    //check that the json object is valid
        if ($jsonObj === false || sizeof($jsonObj) < 1) {
          $temperature = "Invalid Temperature Data";
        } 
        else {
    
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
        }
  return $temperature;
  }
  
  // returns pressure.  Currently only supports mb
  private function getPressure($jsonObj,$offset) {
    //check that the json object is valid
        if ($jsonObj === false || sizeof($jsonObj) < 1) {
          $pressure = "Invalid Pressure Data";
        } 
        else {
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
        }    
  return $pressure;  
  }
  
  private function getDate($jsonObj,$offset) {
    
    
    
    //if you want today's pressure
    if($offset == null || $offset == 0) {
        $date = "Invalid Date Offset";
    }
    //if you want details for a date in the future
    else {
        //check that the json object is valid
        if ($jsonObj === false || sizeof($jsonObj) < 1) {
          $date = false;
        } 
        else {
          $date = $jsonObj->list[$offset]->dt;
          $date = date("Y.m.d",$date);
        } 
   }
    
  return $date;  
  }
  
  //takes json obj and returns the description for a given offset
  private function getDesc($jsonObj,$offset) {
      //check that the json object is valid
        if ($jsonObj === false || sizeof($jsonObj) < 1) {
          $description = "Invalid Weather Data";
        } 
        else {
          //process the data
          if($offset == null || $offset == 0) {        
            $description = $jsonObj->weather[0]->description;
          }
          else {
            $description = $jsonObj->list[$offset]->weather[0]->description;
          }
        }

      
  return $description; 
  }
  
  private function getWeatherTip($desc) {
  
        //pull in weatherTips
        $extData = new getExternalData;

        //extract the weather data
        $weatherTips = $extData->csvToArray($this->weatherTips);
        
        if ($weatherTips === false) {
            //if the weather tip is not present then return a friendly error.
            $tip = "Invalid weather tip data"; 
          
        }
        else {

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
      "tempF" => $this->getTemp($this->weatherObj, 0, "F"),
      "tempC" => $this->getTemp($this->weatherObj, 0, "C"),
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
                "<span class='currentWeather'>". $currentWeather["tempF"] ." (".$currentWeather['tempC'].")</span>".
                "<span class='currentWeather'>-----------</span>";
    
    //future weather
    $buffer .= "<span class='currentWeather'>Tomorrow</span>".
               "<span class='currentWeather'>". $tomorrowsWeather["desc"] ."</span>".
               "<span class='currentWeather'>". $tomorrowsWeather["pressure"] ."</span>".
               "<span class='currentWeather'>". $tomorrowsWeather["tempF"] ." (".$tomorrowsWeather['tempC'].")</span>"; 
    
    
  return $buffer;
  }
  
  
  
  function tomorrowsWeather() {
    //pull in temp, pressure and desc into an array
    //feed in 5 day weather object and an offset of 1
    $tomorrowsWeather = array(
      "date" => $this->getDate($this->weatherObj5, 1),
      "desc" => $this->getDesc($this->weatherObj5, 1),
      "tempF" => $this->getTemp($this->weatherObj5, 1, "F"),
      "tempC" => $this->getTemp($this->weatherObj5, 1, "C"),
      "pressure" => $this->getPressure($this->weatherObj5, 1),
      "tip" => $this->getWeatherTip($this->getDesc($this->weatherObj5, 1))
    );
  return $tomorrowsWeather; 
  }
  

    
}


?>