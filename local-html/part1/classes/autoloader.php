<?php

//Class that automatically loads all classes within classes folder

//Autoload classes where classes folder is in same directory
function autoloadClasses($className) {
	    $filename = "classes/" . $className . ".php";
	    if (is_readable($filename)) {
	        include $filename;
	    }
	}

//Autoload classes where classes folder is in previous directory
function autoloadClasses2($className) {
	    $filename = "../classes/" . $className . ".php";
	    if (is_readable($filename)) {
	        include $filename;
	    }
	}

	spl_autoload_register("autoloadClasses");
    spl_autoload_register("autoloadClasses2");
?>