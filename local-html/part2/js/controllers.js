(function () {
    "use strict";
    
    //Controller for general functionality
    angular.module('ConferenceApp').
        controller('IndexController',
            [
                '$scope',         
                'dataService',
                'applicationData',
                function ($scope, dataService, applicationData) {
                    $scope.title = dataService.getSysInfo().title;

                }
            ]
        ).
    
    //Controller for login form
    controller('userAuthController',   
        [
            '$scope',
            function ($scope) {
            
                    //When form is submitted
                    $scope.login = function(user) {
                        
                    //Insert form input into object variable to send to login API    
                    var enteredDetails = {"username": user.name, "password": user.password};
                        //Connect to login API and send variables 
                        fetch('../part1/api/login.php', {
                                  method: 'POST',
                                  headers : new Headers(),
                                  body:JSON.stringify(enteredDetails)
                        })
                        
                        //Get back response from API
                        .then(function(response) {
                              return response.json();
                        })
                        
                        //Log returned data to console
                        .then(function(data) {
                              console.log(data);
                                
                              //If username and password are valid and the user is a not admin output suitable message and produce logout button
                              if (data.message === "User Logged in."){
                                  $scope.status = "You're logged in, but you need to login as an admin to edit a session's chair";
                                  $scope.loggedIn = true;
                              }
                              //If user type is admin output suitable message, produce session chair form, set user's tokens and show logout button
                              if (data.UserType === "admin"){
                                  $scope.status = "You can edit a session chair";
                                  $scope.sessionForm = true;
                                  $scope.usernameToken = data.usernameToken;
                                  $scope.ExpiryDate = data.ExpiryDate;
                              }
                              //If password is wrong output suitable message
                              if (data.message === "Invalid password."){ 
                                  $scope.status = "You have entered the wrong password!";
                                  $scope.loggedIn = false;
                              }
                              //If username is wrong output suitable message
                              if (data.message === "Account not found."){
                                  $scope.status = "Sorry, you dont have an account!";
                                  $scope.loggedIn = false;
                              }
                        })
                        //Else output try again message
                        .catch(function (err) {
                               console.log("Something went wrong!", err);
                                $scope.status = "Please try again";
                        });
                        
                        //Username variable needed for session Form 
                        $scope.username = user.name;
                    }
                    //When user presses logout button display login form, hide session chair form and empty status messages
                    $scope.logout = function() {
                        $scope.loggedIn = false;
                        $scope.sessionForm = false;
                        $scope.status = "";
                        $scope.Fstatus = "";
                    }
                
                    //When form is submitted
                    $scope.sessionEdit = function(session) {
                        
                        //Ready form input variables to send to login API
                        var enteredSessionDetails = {"title": session.title, "chair": session.chair, "usernameToken": $scope.usernameToken, "ExpiryDate": $scope.ExpiryDate, "username": $scope.username};
                            
                            //Connect to updateRecord API and send variables 
                            fetch('../part1/api/updateRecord.php', {
                                      method: 'POST',
                                      headers : new Headers(),
                                      body:JSON.stringify(enteredSessionDetails),
                            })
                            //Get back response from API
                            .then(function(response) {
                                  return response.json();
                            })
                            //Log returned data to console
                            .then(function(data) {
                                  console.log(data);
                                    
                                  //If session name is not valid output suitable message
                                  if (data.message === "Couldn't find that session"){
                                      $scope.Fstatus = "Session could not be found";
                                  }
                                  //If session name is valid output suitable message
                                  if (data.message === "Session has been updated"){
                                      $scope.Fstatus = "Session has been changed";
                                  }
                            })
                            //Else output try again message
                            .catch(function (err) {
                                   console.log("Something went wrong!", err);
                                    $scope.Fstatus = "Please try again";
                            });
                    }
            }
        ]
    ).
        //Controller for presentation-list.html
        controller('PresentationController',
            [
                '$scope',
                'dataService',
                function ($scope, dataService) {
                    
                    //Method that gets all presentations
                    var getPresentations = function () {
                            dataService.getPresentations().then(
                                function(response){
                                    $scope.presentationsCount = response.rowCount;
                                    $scope.presentations = response.data;

                                },
                                function(err){
                                    $scope.status = 'Unable to load data ' + err;
                                },
                                function(notify){
                                    console.log(notify);
                                }
                            )
                        }
                    
                    //Method that gets presentation category list 
                    var getCategories = function () {
                            dataService.getCategories().then( 
                                function(response){
                                    $scope.categories = response.data;
                                },
                                function(err){
                                    $scope.status = 'Unable to load data ' + err;
                                },
                                function(notify){
                                    console.log(notify);
                                }
                            )
                        }
                        //Method that gets presentations based on selected category
                        var getPresentations2 = function (description) {
                            
                            $scope.categorySelected = function() {
                                
                                var description = $scope.categorySelect.description;
                                dataService.getPresentations2(description).then(
                                function(response) {
                              $scope.presentations = response.data;
                            });
                        }
                    }
                        //Method that gets all presentations when button is clicked
                        $scope.allPresentations = function () {
                            dataService.getPresentations().then( 
                                
                                function(response){
                                    $scope.presentations = response.data;
                                }
                        )};
                        
                        //Calls all methods that should be run automatically
                        getPresentations();
                        getPresentations2();
                        getCategories();
                    }
        ]
    ).
        //Controller for slot-list.html
        controller('SlotController',
            [
                '$scope',
                'dataService',
                'applicationData',
                '$location',
                function ($scope, dataService, applicationData, $location) {
                    //Method that gets all Monday slots
                    var getMonSlots = function () {
                            dataService.getMonSlots().then(
                                function(response){
                                    $scope.monSlotsCount = response.rowCount;
                                    $scope.monSlots = response.data;

                                },
                                function(err){
                                    $scope.status = 'Unable to load data ' + err;
                                },
                                function(notify){
                                    console.log(notify);
                                }
                            );
                        };
                    //Method that gets all Tuesday slots
                    var getTueSlots = function () {
                            dataService.getTueSlots().then(
                                function(response){
                                    $scope.tueSlotsCount  = response.rowCount;
                                    $scope.tueSlots = response.data;

                                },
                                function(err){
                                    $scope.status = 'Unable to load data ' + err;
                                },
                                function(notify){
                                    console.log(notify);
                                }
                            );
                        };
                    
                    //Method that gets all Wednesday slots
                    var getWedSlots = function () {
                            dataService.getWedSlots().then(
                                function(response){
                                    $scope.wedSlotsCount  = response.rowCount;
                                    $scope.wedSlots = response.data;

                                },
                                function(err){
                                    $scope.status = 'Unable to load data ' + err;
                                },
                                function(notify){
                                    console.log(notify);
                                }
                            );
                        };
                    
                    //Method that gets all Thursday slots
                    var getThurSlots = function () {
                            dataService.getThurSlots().then(
                                function(response){
                                    $scope.thurSlotsCount  = response.rowCount;
                                    $scope.thurSlots = response.data;

                                },
                                function(err){
                                    $scope.status = 'Unable to load data ' + err;
                                },
                                function(notify){
                                    console.log(notify);
                                }
                            ); 
                        };
                    
                    //Puts selected monday slot id into url
                    applicationData.publishInfo('mon',{});
                    $scope.selectedMon= {};

                    $scope.selectMon = function ($event, slot) {
                        $scope.selectedMon = slot;
                        $location.path('/slot/' + slot.slotID);
                        applicationData.publishInfo('slot', slot);
                    }
                    
                    //Puts selected tuesday slot id into url
                    applicationData.publishInfo('tues',{});
                    $scope.selectedTues= {};

                    $scope.selectTues = function ($event, slot) {
                        $scope.selectedTues = slot;
                        $location.path('/slot/' + slot.slotID);
                        applicationData.publishInfo('slot', slot);
                    }
                    
                    //Puts selected wednesday slot id into url
                    applicationData.publishInfo('wed',{});
                    $scope.selectedWed= {};

                    $scope.selectWed = function ($event, slot) {
                        $scope.selectedWed = slot;
                        $location.path('/slot/' + slot.slotID);
                        applicationData.publishInfo('slot', slot);
                    }
                    
                    //Puts selected thursday slot id into url
                    applicationData.publishInfo('thurs',{});
                    $scope.selectedThurs= {};

                    $scope.selectThurs= function ($event, slot) {
                        $scope.selectedThurs = slot;
                        $location.path('/slot/' + slot.slotID);
                        applicationData.publishInfo('slot', slot);
                    }
                    
                    //Calls all methods that should be run automatically 
                    getMonSlots();  
                    getTueSlots();
                    getWedSlots();  
                    getThurSlots();

                }
            ]
        ).
    
        //Controller for session-list.html
        controller('SessionController', 
        [
            '$scope', 
            'dataService', 
            '$routeParams',
            'applicationData',
            '$location',
            function ($scope, dataService, $routeParams, applicationData, $location){
                $scope.sessions = [ ];
                $scope.sessionCount = 0;
                
                //Method that gets sessions based on selected slot id
                var getSessions = function (slotID) {
                    dataService.getSessions(slotID).then(
                        function (response) {
                            $scope.sessionCount = response.rowCount;
                            $scope.sessions = response.data;
                            
                            console.log(response);
                        },
                        function (err){
                            $scope.status = 'Unable to load data ' + err;
                        }
                    );
                };
                
                //Puts selected session id into url
                applicationData.publishInfo('session',{});
                $scope.selectedSession = {};

                $scope.selectSession = function ($event, session) {
                    $scope.selectedSession = session;
                    $location.path('/session/' + session.sessID);
                    applicationData.publishInfo('session', session);
                }
 
                //Only if there has been a slotID passed we try to get the sessions
                if ($routeParams && $routeParams.slotID) {
                    console.log($routeParams.slotID);
                    getSessions($routeParams.slotID);
                }
            }
        ]
    ).
    //Controller for activity-list.html
    controller('ActivityController', 
        [
            '$scope', 
            'dataService', 
            '$routeParams',
            'applicationData',
            '$location',

            function ($scope, dataService, $routeParams, applicationData, $location){
                $scope.activities = [ ];
                $scope.activityCount = 0;
                    
                //Method that gets activities based on selected session id
                var getActivities = function (sessID) {
                    dataService.getActivities(sessID).then(
                        function (response) {
                            $scope.activityCount = response.rowCount;
                            $scope.activities = response.data;
                            
                            console.log(response);
                        },
                        function (err){
                            $scope.status = 'Unable to load data ' + err;
                        }
                    );
                };
 
                //Only if there has been a sessID passed we try to get the activities
                if ($routeParams && $routeParams.sessID) {
                    console.log($routeParams.sessID);
                    getActivities($routeParams.sessID);
                }
                
                
                $scope.selectedactivity = {};
                
                //Puts selected activity id into url
                applicationData.publishInfo('activity',{});
                $scope.selectedActivity = {};
                
                $scope.selectActivity = function ($event, activity) {
                        $scope.selectedActivity = activity;
                        $location.path('/activity/' + activity.actID);
                        applicationData.publishInfo('activity', activity);
                }

            }
        ]
    ).
    //Controller for author-list.html
    controller('AuthorController', 
        [
            '$scope', 
            'dataService', 
            '$routeParams',
            '$location',

            function ($scope, dataService, $routeParams, $location){
                $scope.authors = [ ];
                $scope.authorsCount = 0;
                
                //Method that gets authors based on selected activity id
                var getAuthors = function (actID) {
                    dataService.getAuthors(actID).then(
                        function (response) {
                            $scope.authorsCount = response.rowCount;
                            $scope.authors = response.data;
                            
                            console.log(response);
                        },
                        function (err){
                            $scope.status = 'Unable to load data ' + err;
                        }
                    );
                };
 
                //Only if there has been a actID passed in do we try to get the authors
                if ($routeParams && $routeParams.actID) {
                    console.log($routeParams.actID);
                    getAuthors($routeParams.actID);
                }

            }
        ]
    );
}());