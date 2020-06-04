<?php
//Includes setenv script for used db details
require_once("../../../config/setenv.php");
//Headers to get json data from app
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");

//Variable to store json data
$data = json_decode(file_get_contents("php://input"));

//Variables to get inputted title, chair, username and tokens
$title = isset($data->title) ? filter_var($data->title,FILTER_SANITIZE_STRING,FILTER_NULL_ON_FAILURE) : null;

$chair = isset($data->chair) ? filter_var($data->chair,FILTER_SANITIZE_STRING,FILTER_NULL_ON_FAILURE) : null;

$usernameToken = isset($data->usernameToken) ? filter_var($data->usernameToken,FILTER_SANITIZE_STRING,FILTER_NULL_ON_FAILURE) : null;

$ExpiryDate = isset($data->ExpiryDate) ? filter_var($data->ExpiryDate,FILTER_SANITIZE_STRING,FILTER_NULL_ON_FAILURE) : null;

$username = isset($data->username) ? filter_var($data->username,FILTER_SANITIZE_STRING,FILTER_NULL_ON_FAILURE) : null;

//If data has been recieved
if (!is_null($data)) {
    
    //Get secret key from applicationRegistry
    $key = applicationRegistry::getKey();

    //Decode user's tokens
    $usernameDecoded = JWT::decode($usernameToken, $key , false);
    $ExpiryDateDecoded = JWT::decode($ExpiryDate, $key , false);
    
    //If the username token matches username and date token matches todays date
    if  (($username == $usernameDecoded) && (date("Y/m/d") == $ExpiryDateDecoded)) {
        
            //Try to add session details into db
            $sqlQuery = "UPDATE sessions SET chair = :chair WHERE title = :title";
            $params = array("chair" => $chair, "title" => $title); 
            $dbConn = pdoDB::getConnection();
            $queryResult = $dbConn->prepare($sqlQuery);

            // $success will just tell us if the query was executred
            $success = $queryResult->execute($params);

            // $wasupdated will tell us if anything was updated
            $wasupdated = ($queryResult->rowCount() > 0 ? true : false);
            $dbConn = null;
            
            //Session title entered is not in db
            http_response_code(201);
            echo json_encode(array("message" => "Couldn't find that session", "success"=>$success, "updated"=>$wasupdated, "user authenticated"=> "Yes"));

            //If query is executed, output success message
            if ($wasupdated == true) {

                    http_response_code(201);
                    echo json_encode(array("message" => "Session has been updated", "success"=>$success, "updated"=>$wasupdated, "user authenticated"=> "Yes"));
            } 
    }
    //Otherwise user has not been authenticated
    else {
                http_response_code(201);
                echo json_encode(array("message" => "Authentication required", "success"=>false, "user authenticated"=> "No"));
    }
}
//Otherwise no data has been recieved
else {
    http_response_code(403);
    echo json_encode(array("message" => "Data incomplete", "success"=>false, "user authenticated"=> "No"));
}
?>