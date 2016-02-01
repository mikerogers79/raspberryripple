<?
/****************************
* Stock Retrieval Library 0.1
* Created: 12/6/15
* Updated: 
* By: Mike Rogers
* Notes
* Extract stock data
*****************************/


include_once "getExternalData.php";




class stockPrices {
  
  public $stockPrices;
  public $hourlyStocksObj;
  
  private $stockFile = "http://mikesonsmack.asuscomm.com:8888/dashboard/model/hourlyStocks.json";
  
  
  //we don't need any special input, we'll just extract the data straight from the file
  function __construct() {
    
        //load the file to memory
        $hourlyStocks = file_get_contents($this->stockFile);  
    
        //parse the file as JSON
        $this->hourlyStocksObj = json_decode($hourlyStocks);
    
      
    
  return;  
  }
  
  //get the stocks formatted in a div
  function getStocksDiv() {
    
      $stockObj = $this->hourlyStocksObj;
      $buffer = "";

        $buffer .= "<span class='currentStockPrice'>STOCKS</span>";

              for ($i=0; $i < sizeof($stockObj->query->results->quote); $i++) {

                $buffer .= "<span class='currentStockPrice'>" . $stockObj->query->results->quote[$i]->symbol . " : $" . $stockObj->query->results->quote[$i]->Ask ."</span>";

              }

        $buffer .="";
    
    
  
  return $buffer;
  }
  
  
  
}




?>