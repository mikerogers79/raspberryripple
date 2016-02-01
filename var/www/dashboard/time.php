<?php
/****************************
* Created: 12/01/15
* Updated: 12/27/15
* By: Mike Rogers
* Time Library 1.1
* Notes
* Adding basic functionality for 
* formatting the time into natural language.
* 1.1: Converting to an OOP format for scalability.
*****************************/



class Time {
    //standard vars
    public $numbersAsWords = array(), $date, $currentDate, $currentTime, $currentHour, $welcomeMessage;  
  
      function __construct() {
          //array of values up to 60
          
          $this->numbersAsWords[0] = "ZERO";
          $this->numbersAsWords[1] = "ONE";
          $this->numbersAsWords[2] = "TWO";
          $this->numbersAsWords[3] = "THREE";
          $this->numbersAsWords[4] = "FOUR";
          $this->numbersAsWords[5] = "FIVE";
          $this->numbersAsWords[6] = "SIX";
          $this->numbersAsWords[7] = "SEVEN";
          $this->numbersAsWords[8] = "EIGHT";
          $this->numbersAsWords[9] = "NINE";

          $this->numbersAsWords[10] = "TEN";
          $this->numbersAsWords[11] = "ELEVEN";
          $this->numbersAsWords[12] = "TWELVE";
          $this->numbersAsWords[13] = "THIRTEEN";
          $this->numbersAsWords[14] = "FOURTEEN";
          $this->numbersAsWords[15] = "FIFTEEN";
          $this->numbersAsWords[16] = "SIXTEEN";
          $this->numbersAsWords[17] = "SEVENTEEN";
          $this->numbersAsWords[18] = "EIGHTEEN";
          $this->numbersAsWords[19] = "NINETEEN";

          $this->numbersAsWords[20] = "TWENTY";
          $this->numbersAsWords[21] = "TWENTY ONE";
          $this->numbersAsWords[22] = "TWENTY TWO";
          $this->numbersAsWords[23] = "TWENTY THREE";
          $this->numbersAsWords[24] = "TWENTY FOUR";
          $this->numbersAsWords[25] = "TWENTY FIVE";
          $this->numbersAsWords[26] = "TWENTY SIX";
          $this->numbersAsWords[27] = "TWENTY SEVEN";
          $this->numbersAsWords[28] = "TWENTY EIGHT";
          $this->numbersAsWords[29] = "TWENTY NINE";

          $this->numbersAsWords[30] = "THIRTY";
          $this->numbersAsWords[31] = "THIRTY ONE";
          $this->numbersAsWords[32] = "THIRTY TWO";
          $this->numbersAsWords[33] = "THIRTY THREE";
          $this->numbersAsWords[34] = "THIRTY FOUR";
          $this->numbersAsWords[35] = "THIRTY FIVE";
          $this->numbersAsWords[36] = "THIRTY SIX";
          $this->numbersAsWords[37] = "THIRTY SEVEN";
          $this->numbersAsWords[38] = "THIRTY EIGHT";
          $this->numbersAsWords[39] = "THIRTY NINE";

          $this->numbersAsWords[40] = "FOURTY";
          $this->numbersAsWords[41] = "FOURTY ONE";
          $this->numbersAsWords[42] = "FOURTY TWO";
          $this->numbersAsWords[43] = "FOURTY THREE";
          $this->numbersAsWords[44] = "FOURTY FOUR";
          $this->numbersAsWords[45] = "FOURTY FIVE";
          $this->numbersAsWords[46] = "FOURTY SIX";
          $this->numbersAsWords[47] = "FOURTY SEVEN";
          $this->numbersAsWords[48] = "FOURTY EIGHT";
          $this->numbersAsWords[49] = "FOURTY NINE";

          $this->numbersAsWords[50] = "FIFTY";
          $this->numbersAsWords[51] = "FIFTY ONE";
          $this->numbersAsWords[52] = "FIFTY TWO";
          $this->numbersAsWords[53] = "FIFTY THREE";
          $this->numbersAsWords[54] = "FIFTY FOUR";
          $this->numbersAsWords[55] = "FIFTY FIVE";
          $this->numbersAsWords[56] = "FIFTY SIX";
          $this->numbersAsWords[57] = "FIFTY SEVEN";
          $this->numbersAsWords[58] = "FIFTY EIGHT";
          $this->numbersAsWords[59] = "FIFTY NINE";
          $this->numbersAsWords[60] = "SIXTY";
        
        
          //retrieve the time
          $this->date = new DateTime();

          //set the format of the time
          $this->currentDate = $this->date->format('Y-m-d');
          $this->currentTime = $this->date->format('H:i');
          $this->currentHour = (int) $this->date->format('H');
          //$this->currentHour = (int) $this->currentHour;

          //fake the current hour for testing
          //$currentHour = 23;
        return;
      }
  
  



    /*****WELCOME MESSAGE*******/
    private function welcomeMessage($currentHour, $weatherTip, $weatherTipTomorrow) {

      //time cutoffs
      $afternoonCutoff = (int) 12;
      $eveningCutoff = (int) 17;
      $welcomeMessage = "";

      //switch statement to decide on welcome message
        if ($currentHour < $afternoonCutoff) {
          $welcomeMessage = "Good morning Mike" . (strlen($weatherTip) > 0 ? ", " . $weatherTip . " today!" : "!");

        }
        else if ($currentHour < $eveningCutoff) {
          $welcomeMessage = "Good afternoon Mike" . (strlen($weatherTip) > 0 ? ", " . $weatherTip . " this evening!" : "!");

        }
        else if ($currentHour >= $eveningCutoff) {

        }
        else {
          $welcomeMessage = "Hi Mike!";
          echo "No Match";
        }

      return $welcomeMessage;
    }


    //take the current time and return natural language version in either 12 or 24 hour format.
    public function timeNaturalLanguage($twentyFour) {
      
      //pull in global vars
      $numbersAsWords = $this->numbersAsWords;
      $theTime = $this->currentTime;
      
      //split the time by the colon
      $timeSplit = explode(":", $theTime);
      $currHour = (int) $timeSplit[0];
      $currMins = (int) $timeSplit[1];
      $amPmIndicator = "";

      //change format for twenty four hour flag
      if ($twentyFour == 1 && ($currHour > 12)) {
        $amPmIndicator = ($currHour > 12 ? "PM" : "AM");
        $currHour = $currHour - 12;
      }

      //correct hours for midnight
      if ($currHour == 0) {
        $currHour = 12;
      }

      //convert hours into words
      $hoursAsWords = $numbersAsWords[$currHour];

      if ((strlen($numbersAsWords[$currMins]) == 0)) {
        //display nothing
        $minutesAsWords = "";

      } 
      elseif ((round($currMins) > 0) && (round($currMins) < 10)) {
        // display the time with an O at the start  
        $minutesAsWords = "O'".$numbersAsWords[$currMins];

      } 
      else {
        //display as is
        $minutesAsWords = $numbersAsWords[$currMins];

      }

      //Now get the current time in natural language
      $currTimeNatural = "<span class='currentTimeNat'>" . $hoursAsWords . "</span><span class='currentTimeNat'>" . $minutesAsWords . "</span><span class='currentTimeNat'>" . $amPmIndicator . "</span>";
    return $currTimeNatural;  
    }
  
    //the time widget is dependent on weather widget info
    //**TODO need to add error handling for when the required arguments are not present.
    public function welcomeWidget($currentWeather, $tomorrowsWeather) {
      
      $buffer = $this->welcomeMessage($this->currentHour, $currentWeather["tip"], $tomorrowsWeather["tip"]);

      
      return $buffer;
    }
}


?>