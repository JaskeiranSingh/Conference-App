<?php
//Includes setenv script for used db details
require_once("../../../config/setenv.php");
//Headers to get json data from app
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");

//Variable to store json data
$data = json_decode(file_get_contents("php://input"));

    
    $dbConn = pdoDB::getConnection();
    
    //If an account has been found with matching details
    if ($dbConn == true) {
            
            //Print success message and sets values for app
            http_response_code(201);
            echo json_encode(array("title" => "You are connected to the CHI2019 database", "body" => "This API provides information on the schedule and presentations within the CHI2019 conference", "Author of whole application" => "Jaskeiran Singh Deol - W16007099"));
    }
        
    //Otherwise password is wrong
    else {
            http_response_code(201);
            echo json_encode(array("Message" => "You're not connected to the API"));
    }
?>