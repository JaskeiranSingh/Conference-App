<?php
//Includes setenv script for used db details
require_once("../../../config/setenv.php");

//Variables to be used for different api's
$action  = isset($_REQUEST['action'])  ? $_REQUEST['action']  : null;
$subject = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : null;
$searchTerm = isset($_REQUEST['searchTerm']) ? $_REQUEST['searchTerm'] : null;
$description = isset($_REQUEST['description']) ? $_REQUEST['description'] : null;
 
//Concat action and subject with uppercase first letter of subject
$route = ucfirst($subject); 
 
$db = applicationRegistry::DB(); // connect to db
 
//Sets the header to json because everything is returned in that format
header("Content-Type: application/json");
 
//Take the appropriate action based on the subject
switch ($route) {  
        
    //Gets 50 presentations
    // presentations.php?action=list&subject=presentations    
    case 'Presentations':
        $sqlPresentations = "SELECT activities.title, activities.abstract, authors.author, authors.affiliation, keywords
        FROM activities 
        INNER JOIN sessions 
        ON activities.sessionsID = sessions.id
        LEFT JOIN papers_authors
        ON papers_authors.activitiesID = activities.id
        JOIN authors
        ON authors.authorID = papers_authors.authorID
        WHERE description NOT IN ('Miscellaneous','Break')";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($sqlPresentations, 'ResultSet');
        echo $retval;
        break;
        
    //Gets presentations for given search term  
    case 'Search':
        $id = $db->quote($searchTerm);
        $sqlSearchPresTerm = "SELECT activities.id AS 'actID', activities.title, slots.day, slots.time, activities.abstract, activities.keywords, sessions.title AS ‘session_title’, activities.sessionsID AS 'sessID', sessions.description
        FROM activities 
        INNER JOIN sessions 
        ON activities.sessionsID = sessions.id
        INNER JOIN slots 
        ON sessions.slotsID = slots.id
        WHERE activities.title LIKE '%$searchTerm%'
        OR activities.abstract LIKE '%$searchTerm%'";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($sqlSearchPresTerm, 'ResultSet');
        echo $retval;
        break;
        
        //Gets list of categories 
    case 'CategoryList':
        $sqlSearchPresTerm = "SELECT DISTINCT sessions.description 
        FROM sessions
        WHERE description NOT IN ('Miscellaneous','Break')";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($sqlSearchPresTerm, 'ResultSet');
        echo $retval;
        break;
        
    //Gets presentations for given search term category      
    case 'Category':
        $id = $db->quote($description);
        $sqlSearchPresCat = "SELECT activities.title, activities.abstract, authors.author, authors.affiliation, sessions.description
        FROM activities 
        INNER JOIN sessions 
        ON activities.sessionsID = sessions.id
        LEFT JOIN papers_authors
        ON papers_authors.activitiesID = activities.id
        LEFT JOIN authors
        ON authors.authorID = papers_authors.authorID
        WHERE sessions.description = '$description'";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($sqlSearchPresCat, 'ResultSet');
        echo $retval;
        break;  
        
    default:
        echo '{"status":"error", "message":{"text": "No api has been specified"}}';
        break;
}

?>