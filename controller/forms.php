<?php
/****************************
* Input Output Library 0.1
* Created: 1/3/16
* Updated: 
* By: Mike Rogers
* Notes
* Library for handling rendering 
* of forms.
*****************************/


//setup the base form which can be used for everything else.
class Form {
  
  public $formData, $formConfig, $formAction, $formMethod;
  
  
  function __construct() {
    
    
    
    
    
  }
  
  
  //load data from config files, eventually we'll use the formData to load a JSON file but for now it is all hardcoded.
  private function getFormData($formData) {
    
    $this->formMethod = "POST";
    $this->formAction = "controller/inboundData.php";
    //use default data for now.  This should be changed to read from config files in future.
    
    $formConfig[0] = array(
        
        "type" => 'text',
        "label" => 'Systolic',
        "name" => 'systolic',
        "value" => ''
    
    );
    
    $formConfig[1] = array(
        
        "type" => 'text',
        "label" => 'Diastolic',
        "name" => 'diastolic',
        "value" => ''
    
    );
    $formConfig[2] = array(
        
        "type" => 'text',
        "label" => 'Heart Rate',
        "name" => 'hr',
        "value" => ''
    
    );
    $formConfig[3] = array(
        
        "type" => 'hidden',
        "label" => '',
        "name" => 'formName',
        "value" => 'bp'
    
    );
  return $formConfig;
  }
  
  
  
  //this is the base form that everything will be based upon.
  public function generateFormHTML($formData) {
    $fields = $this->getFormData($formData);
    $method = $this->formMethod;
    $action = $this->formAction;  
    $formData = "<form method='".$method."' action='".$action."'>";
        
                
                //loop through the fields and populate the data
                for ($i=0; $i < sizeof($fields); $i++) {
                  
                    //only display a label if it is not a hidden field
                    if($fields[$i]['type'] != 'hidden') {
                      $formData .= "<p>";
                      $formData .= "<span class='formLabel'>".$fields[$i]['label']."</span>";
                    }

                    $formData .= "<input type='".$fields[$i]['type']."' name='".$fields[$i]['name']."' value='".$fields[$i]['value']."'>";

                    if($fields[$i]['type'] != 'hidden') {
                      $formData .= "</p>";
                    }
                }
      
    $formData .= "<input type='submit' name='submit'>".
                "</form>";
    
    
  return $formData;
  }
  
  
  
  
}










?>