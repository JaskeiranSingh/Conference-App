<?php
//Documentation of API for application

//Includes autoloader class that adds all classes when needed
include ('classes/autoloader.php');

//Sets variables for navbar within class
$navItems = Array("Home"=>"index","Documentation"=>"documentation","About"=>"about");
    
//Sets documentation list to main variable for webpage class 
$main = "
<div class 'main' style='margin:20px;'>
<h1 class= 'display-4'>List of API'S</h1>
<p class=lead><strong>localhost/local-html/part1/ - </strong>Index of part1</p>
<p class=lead><strong>localhost/local-html/part1/documentation - </strong>Documentation of API's within part1 of the application</p>
<p class=lead><strong>localhost/local-html/part1/about - </strong>Information about the whole application</p>
<p class=lead><strong>localhost/local-html/part1/api - </strong>General information about the API</p>
<br>
<p class=lead><strong>Please remove '/documentation' and add any of the following links to the url above</strong></p>
<p class=lead><strong>(Variable that you enter into the url)</strong></p>
<br>
<h2 class= 'display-5'>Schedule API's</h2>
    <ul class='list-group list-group-flush'>
    
        <li class='list-group-item'><strong>Returns all time slots for Monday</strong><br>/api/schedule.php?subject=monday</li>
        <li class='list-group-item'><strong>- Returns all time slots for Tuesday</strong><br>/api/schedule.php?subject=tuesday</li>

        <li class='list-group-item'><strong>- Returns all time slots for Wednesday</strong><br>/api/schedule.php?subject=wednesday</li>

        <li class='list-group-item'><strong>- Returns all time slots for Thursday</strong><br>/api/schedule.php?subject=thursday</li>

        <li class='list-group-item'><strong>- Returns all sessions for time slot</strong><br>/api/schedule.php?subject=sessions&slotID=(slotID)</li>

        <li class='list-group-item'><strong>- Returns all activities for session  slot</strong><br>/api/schedule.php?subject=activities&sessID=(sessID)</li>

        <li class='list-group-item'><strong>- Returns all authors for activity</strong><br>/api/schedule.php?subject=Authors&actID=(actID)</li>

        <li class='list-group-item'><strong>- Searches sessions for given session name</strong><br>/api/schedule.php?subject=search&sessTitle=(sessTitle)</li>
    </ul>
<br>
<h2 class= 'display-5'>Presentation API's</h2>
    <ul class='list-group list-group-flush'>
    
        <li class='list-group-item'><strong>- Returns all presentations</strong><br>/api/presentations.php?subject=presentations</li>
        
        <li class='list-group-item'><strong>- Returns presentations matching a search term</strong><br>/api/presentations.php?subject=search&searchTerm=(searchTerm)</li>

        <li class='list-group-item'><strong>- Returns all category types for presentations except for breaks and miscellaneous</strong><br>/api/presentations.php?subject=categoryList</li>

        <li class='list-group-item'><strong>- Returns all presentations based on given category</strong><br>/api/presentations.php?subject=category&description=(description)</li>
<br>
    </ul>
<h2 class= 'display-5'>User authenticated API's</h2>
    <ul class='list-group list-group-flush'>
    
        <li class='list-group-item'><strong>- API that deals with user login</strong><br>/api/login.php</li>
        
        <li class='list-group-item'><strong>- API that allows user to edit a session's chair</strong><br>/api/updateRecord.php</li>
    </ul>
    </div>";

//Set all required variables for webpage class
$webpage = new WebPageWithNav("Conference API", "Documentation", $navItems, $main);

//Print webpage
echo $webpage->getPage();
?>