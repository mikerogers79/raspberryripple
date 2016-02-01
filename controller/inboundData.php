<?php
/****************************
* inbound Data
* Created: 01/11/16
* Updated: 
* By: Mike Rogers
* Notes
* Handle sending data to the model.
*****************************/

//pull in the DB library
include_once "dbCxn.php";
include_once "dataStructures.php";



//standard class for pulling in data from forms and making it manageable
class formHandler {
  
  public $formData = false;
  
  
  function __construct() {
    
    
      //check if the form is of get or post type
        if (sizeof($_GET) > 0) {
          
          //assign the get elements to a var for use
          $this->formData = $_GET;
          
        } 
        else if (sizeof($_POST) > 0) {
          //assign the get elements to a var for use
          $this->formData = $_POST;

        } 
            
  }
 
  
}



//class for pulling result sets from teh model

class DataInDataOut extends dbModel {
  
  public $dbCxn;
  
  public function __construct() {
    
    //instantiate the model
    parent::__construct();
    
  }
  
  
  //catch all method for returning all data in a query
  //can either format as a (table) or return an unordered list (text).
  public function returnAllData($whatData) {
      
    //try to find a match for the SQL we want to retrieve.
    $sql = parent::getSQL($whatData);
    $result = parent::execQuery($sql,true);
    
    if (!$result) {
      
      echo "There was an issue executing your query to return all metrics";
      exit;
      
    }
    else {
      
      $strBuffer = "<ul>";
      //let's package the data for consumption
      for ($i=0; $i<sizeof($result); $i++) {
        
        $strBuffer .= "<li>".$result[$i]['note']."</li>";
        
      }
      $strBuffer .= "</ul>";
      
    }
  return $strBuffer;
  }
  
  
}







//PROCESS THE DATA
$formHandler = new formHandler;
$formData = $formHandler->formData;

$strBuffer = '';


if($formData != false) {
  
  //let's instantiate a class to pull data from the db.
  $dbData = new DataInDataOut;
  
  //figure out what form has been submitted 
  switch ($formData['formName']) {
    
    case 'bp':
      $bloodPressureLog = new BloodPressure($formData['systolic'], $formData['diastolic'], $formData['hr'], 1);
      $bloodPressureLog->insertBPData();
    break;
      
  }
  
  
  //pull back the results from a simple query
  //echo $dbData->returnAllData('BodyMetricsAllRecords','text'); 
  
  
} else {
  
  $strBuffer = 'We have NO data';
  
}




echo $strBuffer;




?>