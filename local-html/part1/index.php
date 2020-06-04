<?php
//Index of API for application

//Includes autoloader class that adds all classes when needed
include ('classes/autoloader.php');
    
    //Sets variables for navbar within class
	$navItems = Array("Home"=>"index","Documentation"=>"documentation","About"=>"about");

    //Sets main variable for webpage class
    $main = "<br><p class='lead' style='margin-left:20px;'>This is the API section of the application and produces schedule information for the CHI2019 Conference. Visit the documentation to view a list of all the API's used within part2 of the application.</p>";

    //Sets all required variables for webpage class
	$webpage = new WebPageWithNav("Conference API", "Home", $navItems, $main);

    //Print webpage
	echo $webpage->getPage();

?>
