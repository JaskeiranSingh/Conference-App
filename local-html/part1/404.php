<?php
//More information about API for application

//Includes autoloader class that adds all classes when needed
include ('classes/autoloader.php');

//Sets documentation list to main variable for webpage class 
$main = "<br><br><h1 class='display-4' style='text-align: center;'>404: </h1><p class='lead' style='text-align: center;'>Sorry we couldn't find the page you were looking for try</p><p class='lead' style='text-align: center;'> <strong>http://localhost/local-html/part1/</strong></p>";

//Set all required variables for webpage class
$webpage = new WebPage("Conference API", "", $main);

//Print webpage
echo $webpage->getPage();
?>