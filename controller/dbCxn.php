<?php
/****************************
* Classes for handing data connections
* Created: 01/11/16
* Updated: 
* By: Mike Rogers
* Notes
* 
* php myadmin 
* root 
* B0bbydavr0
*
*****************************/

//standard db connection details
abstract class dbModel {
  
  public $dbcxn, $envDetails;
  private $servername = "localhost";
  private $username = "root";
  private $password = "B0bbydavr0";
  private $database = "dashboard";
  
  //standard SQL's
  public $sql = array (
    'BodyMetricsAllRecords' => "SELECT * FROM  `log_bodymetrics` LIMIT 0 , 30"
    );
  
  
  public function __construct() {
    
    //create the connection
    $this->createDbConnection();
    
  }
  
  //return the contents of a sql from the global array
  public function getSQL($queryName) {
    //return sql's from a centralized store
    if(!$this->sql[$queryName]) {
      return false;
    }
    else {
      
      return $this->sql[$queryName];
    }
  }
  
  
  private function createDbConnection() {
    
      // Create connection
      $conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

      // Check connection
      if ($conn->connect_errno) {
          die("Connection failed: " . $conn->connect_error);
      } else {
        
        //make this var available to the entire class.
        $this->dbcxn = $conn;
        $this->envDetails = $conn->host_info . "\n";
      }
  return true;
  }
  
  
  //provide a query to execute against the default connection
  public function execQuery($sql, $returnData) {
    
    //this is used to return the data, if required.
    $dataBuffer = '';
    
    
    //check that the sql is not null
    if (is_null($sql) || $sql == "") {
      return false;
    }
    
    if (!$result = $this->dbcxn->query($sql)) {
      // Oh no! The query failed. 

      // Again, do not do this on a public site, but we'll show you how
      // to get the error information
      echo "Error: Our query failed to execute and here is why: \n";
      echo "Query: " . $sql . "\n";
      echo "Errno: " . $this->dbcxn->errno . "\n";
      echo "Error: " . $this->dbcxn->error . "\n";
      exit;
    }
    
   
 
    
    if($returnData) {
        // Phew, we made it. We know our MySQL connection and query 
        // succeeded, but do we have a result?
        if ($result->num_rows === 0) {
            // Oh, no rows! Sometimes that's expected and okay, sometimes
            // it is not. You decide. In this case, maybe actor_id was too
            // large? 
          echo "SQL Query returned no data";
          exit;
          return false;
        }
        $i = 0;
        
        while ($row=mysqli_fetch_array($result)) {

            $dataBuffer[$i] = $row;
        $i++;
        }
      
    $result->free();
    }
    
    
  return $dataBuffer;
  }
  
  //delete a row, the safe way
  private function deleteRow($id) {
    
    
    
  }
  
  //add a row
  private function addRow() {
    
    
  }
  
  
  
  
  
  //public methods
  public function getDbInfo() {
    echo "ENVIRONMENT DETAILS: " . $this->envDetails . "\n";
    return;
  }
  
  public function closeCxn() {
    
    $this->dbcxn->close();
  }
  
  
}

?>