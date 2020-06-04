<?php
//More information about API for application

//Includes autoloader class that adds all classes when needed
include ('classes/autoloader.php');

//Sets variables for navbar within class
$navItems = Array("Home"=>"index","Documentation"=>"documentation","About"=>"about");

//Sets documentation list to main variable for webpage class 
$main = "<br><p class='lead' style='margin:20px;'>This application was created by <br><strong>Jaskeiran Singh Deol - jaskeiran.deol@northumbria.ac.uk - W16007099</strong></p>";

//Set all required variables for webpage class
$webpage = new WebPageWithNav("Conference API", "About", $navItems, $main);

//Print webpage
echo $webpage->getPage();
?>