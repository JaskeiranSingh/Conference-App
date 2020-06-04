<?php
//Includes setenv script for used db details
require_once("../../../config/setenv.php");
//Headers to get json data from app
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");

//Variable to store json data
$data = json_decode(file_get_contents("php://input"));

//Variables to get username and password
$username = isset($data->username) ? filter_var($data->username,FILTER_SANITIZE_STRING,FILTER_NULL_ON_FAILURE) : null;

$password = isset($data->password) ? filter_var($data->password,FILTER_SANITIZE_STRING,FILTER_NULL_ON_FAILURE) : null;

//If username is provided
if(!is_null($username)) {
    
    //Execute sql query to find account 
    $sqlQuery = "SELECT * FROM users WHERE username LIKE :username";
    $params = array("username" => $username); 
    $dbConn = pdoDB::getConnection();
    $queryResult = $dbConn->prepare($sqlQuery);
    $queryResult->execute($params);
    $rows = $queryResult->fetchAll(PDO::FETCH_ASSOC);
    
    $dbConn = null;
    
    //If an account has been found with matching details
    if (count($rows) > 0) {
        if (password_verify($password, $rows[0]['password']))
        {
            //Check to see if it's an admin user by running the query
            $sql = ("SELECT * FROM users WHERE username LIKE :username and admin = '1'");
            $params = array("username" => $username); 
            $dbConn = pdoDB::getConnection();
            $queryResult = $dbConn->prepare($sql);
            $queryResult->execute($params);
            $rows = $queryResult->fetchAll(PDO::FETCH_ASSOC);

                //If there is one row set user as admin
                if (count($rows) > 0) {
                    
                    $userType = 'admin';
                }
            
                //Else set user as non-admin
                else {
                    
                    $userType = 'non-admin';
                }
            
            //Encode tokens for username and todays date and get secret key from db details
            $key = applicationRegistry::getKey();
            $encodedUToken = JWT::encode($username, $key);
            $encodedDToken = JWT::encode(date("Y/m/d"), $key);
            
            //Print success message and sets values for app
            http_response_code(201);
            echo json_encode(array("message" => "User Logged in.", "usernameToken" => $encodedUToken, "ExpiryDate" => $encodedDToken, "UserType" => $userType));
        }
        
        //Otherwise password is wrong
        else {
            http_response_code(201);
            echo json_encode(array("message" => "Invalid password."));
        }
        
    }
    //Otherwise account is not in db
    else
    {
        http_response_code(201);
        echo json_encode(array("message" => "Account not found."));
    } 
} 
//Otherwise no details have been entered
else {
    http_response_code(403);
    echo json_encode(array("message" => "Error: Data is incomplete."));
}
?>