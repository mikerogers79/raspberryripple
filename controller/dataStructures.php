<?php
/****************************
* Standard classes for data objects
* Created: 01/30/16
* Updated: 
* By: Mike Rogers
* Notes
* 
* Allows us to create standard data structures
*
*****************************/

//requires dbCxn
include_once "dbCxn.php";


class BloodPressure extends dbModel {
  
  private $systolic, $diastolic, $datestamp, $user, $BPMetrics, $jsonData;
  public $validData;
  
  //in order to create a BP Object we require the following vars
  function __construct($systolic, $diastolic, $heartrate, $user) {
    
    //validate the data
    if($systolic == NULL || $diastolic == NULL || $user == NULL) {
      
      //use this to see if data has been validated correctly.
      $this->validData = false;
    }
    else {

        //write all of the properties to the object level.
        $this->BPMetrics = array (
          "Systolic"=>$systolic,
          "Diastolic"=>$diastolic,
          "Heartrate"=>$heartrate
        );
      
        $this->datestamp = $this->generateDatestamp();
        $this->user = $this->getUserId();
        $this->generateJSON($this->BPMetrics);
    }
  }
  
  //encode vars into JSON format
  private function generateJSON($arr) {
    
    $jsonData = json_encode($arr);
    $this->jsonData = $jsonData;
    
  return $jsonData;  
  }
  
  
  
  //insert BP data into the database
  public function insertBPData() {
    
    //create the sql query
    $sql = "INSERT INTO log_bodymetrics (created, user, metric_id, metric_value) values (CURRENT_TIMESTAMP, ".$this->user.",2,'".$this->jsonData."')";
    parent::__construct();
    parent::execQuery($sql, false);
  return true;  
  }
  
  
  
  //these standard funcs should be moved to a separate library.
  
  //generate a datestamp for use when inserting data to the db
  private function generateDatestamp() {
    
    $date = new DateTime();
    $dateStamp = $date->format('U = Y-m-d H:i:s');
    return $dateStamp;
  }
  
  //this is a placeholder for a later implementation
  private function getUserId() {
    
    return 1;
  }
  
}
  
  



?>