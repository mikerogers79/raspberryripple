<?php
/****************************
* Created: 12/31/15
* Updated: 
* By: Mike Rogers
* NavBar 0.1
* Notes
* Initial Navbar providing basic linking between screens.
*****************************/


class NavBar {
  
  public $nav; 
  private $navItems;
  
  
  function __construct() {
        
        //set the nav items
        $this->navItems = array();
        
        //Nav items have 3 values, label, URL and whether
        $this->navItems[] = array('Home', 'index.php', false);
        $this->navItems[] = array('Body', 'body.php', false);
       
  }  
  

      //generate the menu with an optional argument for setting the current page  
      public function generateMenu($currentPage) {

              //pull in the current nav items
              $navItems = $this->navItems;

              //iterate through the array and generate the menu
              $nav =  "<ul id='navigation'>";

              for ($i=0; $i < sizeof($navItems); $i++) {
                
                //confirm if the current page is the one selected
                if (strtolower($currentPage) == strtolower($navItems[$i][0])) {
                  $nav .= "<li><a href='".$navItems[$i][1]."' class='selected'>".$navItems[$i][0]."</a></li>";  
                }
                else {
                  $nav .= "<li><a href='".$navItems[$i][1]."'>".$navItems[$i][0]."</a></li>";
                }
                
              }

              $nav .=  "</ul>";


      return $nav; 
      }




}




?>
