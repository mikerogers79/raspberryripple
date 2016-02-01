<?
/****************************
* Stock Retrieval Library 0.2
* Created: 12/6/15
* Updated: 1/26/16
* By: Mike Rogers
* Notes
* Extract stock data
* 0.2 updated the class to point to LastTradePriceOnly 
* to get the latest stock price.
*****************************/


include_once "getExternalData.php";




class stockPrices {
  
  public $stockPrices;
  public $hourlyStocksObj;
  
  private $stockFile = "http://mikesonsmack.asuscomm.com:8888/dashboard/model/hourlyStocks.json";
  
  
  //we don't need any special input, we'll just extract the data straight from the file
  function __construct() {
    
        //load the file to memory
        
        $hourlyStocks = @file_get_contents($this->stockFile, true);  
        
        if($hourlyStocks === false || sizeof($hourlyStocks) < 1) {
            $this->hourlyStocksObj = false; //set the stock object to false.
        }
        else {
          
          //parse the file as JSON
            $this->hourlyStocksObj = json_decode($hourlyStocks);
        }
    
  return;  
  }
  
  //get the stocks formatted in a div
  function getStocksDiv() {
    
      $stockObj = $this->hourlyStocksObj;
      $buffer = "";  
    
      //check that the stock object is not false.
      if ($stockObj===false || sizeof($stockObj) < 1) {
        
        $buffer .= "<span class='currentStockPrice'>STOCKS</span>";

              $buffer .= "<span class='currentStockPrice'>No Stock Data</span>";

        $buffer .="";  
        
      }
      else {
        

        $buffer .= "<span class='currentStockPrice'>STOCKS</span>";

              for ($i=0; $i < sizeof($stockObj->query->results->quote); $i++) {

                $buffer .= "<span class='currentStockPrice'>" . $stockObj->query->results->quote[$i]->symbol . " : $" . $stockObj->query->results->quote[$i]->LastTradePriceOnly ."</span>";

              }

        $buffer .="";
      }
    
  
  return $buffer;
  }
  
  
  
}




?>