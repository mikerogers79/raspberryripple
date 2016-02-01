<?php
/****************************
* Data handling Library 0.1
* Created: 12/6/15
* Updated: 
* By: Mike Rogers
* Notes
* Adding basic func for reading from text files, API's etc
*****************************/


//retrieve data from text files and external sources
class getExternalData {
  
  //load csv data into an array
  public function csvToArray($dataURL) {
    
    $file_handle = fopen($dataURL, 'r');
    while (!feof($file_handle) ) {
      $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
  return $line_of_text;
  }
  
  
  
  
}



//read and write data from a local database
class getDBData {
  
  
  
  
  
}








?>