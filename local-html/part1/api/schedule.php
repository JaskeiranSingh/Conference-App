<?php
//Includes setenv script for used db details
require_once("../../../config/setenv.php");

//Variables to be used for different api's
$subject = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : null;
$day = isset($_REQUEST['day']) ? $_REQUEST['day'] : null;
$slotID = isset($_REQUEST['slotID']) ? $_REQUEST['slotID'] : null;
$sessID = isset($_REQUEST['sessID']) ? $_REQUEST['sessID'] : null;
$actID = isset($_REQUEST['actID']) ? $_REQUEST['actID'] : null;
$sessTitle = isset($_REQUEST['sessTitle']) ? $_REQUEST['sessTitle'] : null;

//Concat action and subject with uppercase first letter of subject
$route = ucfirst($subject);
 
//Connects to db
$db = applicationRegistry::DB();
 
//Sets the header to json because everything is returned in that format
header("Content-Type: application/json");
 
//Take the appropriate action based on the subject
switch ($route) { 
        
    //Gets all timeslots for monday - schedule.php?subject=Monday    
    case 'Monday':
        $getMonSlots = "SELECT time, slots.id AS 'slotID'
        FROM slots
        INNER JOIN sessions
        ON sessions.slotsID = slots.id
        WHERE slots.day = 'Monday'
        GROUP BY time";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($getMonSlots, 'ResultSet');
        echo $retval;
        break;
        
        //Gets all timeslots for tuesday - schedule.php?subject=Tuesday    
    case 'Tuesday':
        $getTueSlots = "SELECT time, slots.id AS 'slotID'
        FROM slots
        INNER JOIN sessions
        ON sessions.slotsID = slots.id
        WHERE slots.day = 'Tuesday'
        GROUP BY time";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($getTueSlots, 'ResultSet');
        echo $retval;
        break;
        
    //Gets all timeslots for wednesday - schedule.php?subject=Wednesday
    case 'Wednesday':
        $getWedSlots = "SELECT time, slots.id AS 'slotID'
        FROM slots
        INNER JOIN sessions
        ON sessions.slotsID = slots.id
        WHERE slots.day = 'Wednesday'
        GROUP BY time";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($getWedSlots, 'ResultSet');
        echo $retval;
        break;
        
    //Gets all timeslots for thursday schedule.php?subject=Thursday  
    case 'Thursday':
        $getThurSlots = "SELECT time, slots.id AS 'slotID'
        FROM slots
        INNER JOIN sessions
        ON sessions.slotsID = slots.id
        WHERE slots.day = 'Thursday'
        GROUP BY time";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($getThurSlots, 'ResultSet');
        echo $retval;
        break;
        
    //Gets all Sessions for time slot ID - schedule.php?subject=sessions&slotID=   
    case 'Sessions':
        $id = $db->quote($slotID);
        $getSlots = "SELECT sessions.id AS 'sessID', sessions.description, sessions.title AS 'Session_Title', sessions.room, sessions.chair, activities.title, activities.keywords, activities.abstract, slots.id as 'slotID'
        FROM slots
        INNER JOIN sessions
        ON sessions.slotsID = slots.id
        LEFT JOIN activities
        ON activities.id = sessions.id
        WHERE slotID = '$slotID'";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($getSlots, 'ResultSet');
        echo $retval;
        break;
        
    //Gets all activities for session ID - schedule.php?subject=Activities&sessID=  
    case 'Activities':
        $id = $db->quote($sessID);
        $getActivities = "SELECT activities.id AS 'actID', activities.title AS 'Activity_Title', activities.keywords, activities.abstract, activities.sessionsID as 'sessID'
        FROM activities
        WHERE activities.sessionsID = '$sessID'";
                        
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($getActivities, 'ResultSet');
        echo $retval;
        break;
        
    //Gets all authors for activity - schedule.php?subject=Authors&actID=    
    case 'Authors':
        $id = $db->quote($actID);
        $sqlAllAuthors = "SELECT authors.author, authors.affiliation, activities.id as 'actID'
        FROM activities
        LEFT JOIN papers_authors
        ON papers_authors.activitiesID = activities.id
        LEFT JOIN authors
        ON authors.authorID = papers_authors.authorID
        WHERE authors.author IS NOT NULL
        AND activities.id = '$actID'";
                            
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($sqlAllAuthors, 'ResultSet');
        echo $retval;
        break;    
 
        
        //Searches session for given name - schedule.php?subject=search&sessTitle=    
    case 'Search':
        $id = $db->quote($sessTitle);
        $sqlSearchSess = "SELECT sessions.id AS 'sessID', sessions.description, sessions.title AS 'Session Title', sessions.room, sessions.chair, activities.title, activities.keywords, activities.abstract
        FROM slots
        INNER JOIN sessions
        ON sessions.slotsID = slots.id
        LEFT JOIN activities
        ON activities.id = sessions.id
        WHERE sessions.title LIKE '%$sessTitle%'";
                            
        $rs = new JSON_RecordSet();
        $retval = $rs->getRecordSet($sqlSearchSess, 'ResultSet');
        echo $retval;
        break;    

    default:
        echo '{"status":"error", "message":{"text": "No api has been specified"}}';
}

?>