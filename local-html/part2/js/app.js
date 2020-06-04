(function () {
    "use strict";
    
    //References app
    angular.module("ConferenceApp", 
      [
        'ngRoute'
      ]
    ).
    config(
        [
          '$routeProvider',
          function($routeProvider) { 
              $routeProvider.
                //Produce presentation-list.html when url = /presentations
                when('/presentations', {
                  templateUrl: 'js/partials/presentation-list.html',
                  controller: 'PresentationController'
                }).
                //Produce session-list.html when url = /slot/ selected slotID
                when('/slot/:slotID', {
                  templateUrl: 'js/partials/session-list.html',
                  controller: 'SessionController'
                }).
                //Produce activity-list.html when url = /session/ selected sessID
                when('/session/:sessID', {
                  templateUrl: 'js/partials/activity-list.html',
                  controller: 'ActivityController'
                }).
                //Produce authors-list.html when url = /activity/ selected actID
                when('/activity/:actID', {
                  templateUrl: 'js/partials/authors-list.html',
                  controller: 'AuthorController'
                }).
                //Otherwise just display index of app
                otherwise({
                  redirectTo: '/'
                });
          } 
        ]
    );
}());