<?php
//Script that is run when user visits part1/ directory of application

        //If URL is given
		if (isset($_GET['url'])) {           
            //Set URL as variable
            $requested_page = $_GET['url'];
        }
        else {
            //Otherwise set it as index
            $requested_page = 'index';
        }

    //Based on url given
    switch($requested_page) {
       //If url is about display about page        
       case "about":
          include("about.php");
          break;
       //If url is documentation display documentation page    
       case "documentation":
          include("documentation.php");
          break;
        //If url is index display home page      
        case "index":
          include("index.php");
          break; 
       //If none of those than display 404 page       
       default:
          include("404.php");
    }
?>