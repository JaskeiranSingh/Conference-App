(function () {
'use strict';
    
/** Service to return the data for the app */
angular.module('ConferenceApp').
    service('applicationData',
            
        //Gets general data for the app
        function ($rootScope){
            var sharedService = {};
            sharedService.info = {};

            sharedService.publishInfo = function (key,obj) {
                this.info[key] = obj;
                $rootScope.$broadcast('systemInfo_'+key,obj);
            };
            return sharedService;
        }

    ).
    //Services for all the controllers
    service('dataService',
        ['$q',
         '$http',
         function($q, $http, $scope) {
 
            //var to hold the data base url
            var urlBase = '/local-html/part1/api/';
             
             //Display Title for app
             this.getSysInfo = function () {
                let data = { 
                    title:"CHI2019 Conference",
                };

                return data;
            } 
            
            //Method that gets all presentations 
            this.getPresentations = function () {
                var defer = $q.defer(),
                  presentations = {
                        subject: 'Presentations',
                  };
                
                //Gets variables for api url
                $http.get(urlBase+'presentations.php', {params: presentations, cache: true}).
                
                        //Function that assigns json data to manageable variables 
                        then(function(response){
                            defer.resolve({
                                            data: response.data.ResultSet.Result,
                                            rowCount: response.data.ResultSet.RowCount
                                          });
                        },function(err){
                            defer.reject(err);
                        });
                return defer.promise;
            };
             //Method that gets all presentations based on particular category
             this.getPresentations2 = function (description) {
                var defer = $q.defer(),             // The promise
                  presentations2 = {
                        subject: 'Category',
                        description: description
                  };
                 
                //Gets variables for api url
                $http.get(urlBase+'presentations.php', {params: presentations2, cache: true}).
                
                        //Function that assigns json data to manageable variables
                        then(function(response){
                            defer.resolve({
                                            data: response.data.ResultSet.Result,
                                            rowCount: response.data.ResultSet.RowCount
                                          });
                        },function(err){
                            defer.reject(err);
                        });
                return defer.promise;
            };
             
             //Method that gets category list
             this.getCategories = function () {
                var defer = $q.defer(),             // The promise
                  categories = {
                        subject: 'CategoryList',
                  };
                 
                //Gets variables for api url
                $http.get(urlBase+'presentations.php', {params: categories, cache: true}).
                
                        //Function that assigns json data to manageable variables
                        then(function(response){
                            defer.resolve({
                                            data: response.data.ResultSet.Result,
                                            rowCount: response.data.ResultSet.RowCount
                                          });
                        },function(err){
                            defer.reject(err);
                        });
                return defer.promise;
            };
             
            //Method that gets monday slots 
            this.getMonSlots = function () {
                var defer = $q.defer(),
                  monSlots = {
                        subject: 'Monday',
                  };
                
                //Gets variables for api url
                $http.get(urlBase+'schedule.php', {params: monSlots, cache: true}).
                
                        //Function that assigns json data to manageable variables
                        then(function(response){
                            defer.resolve({
                                            data: response.data.ResultSet.Result,
                                            rowCount: response.data.ResultSet.RowCount
                                          });
                        },function(err){
                            defer.reject(err);
                        });
                return defer.promise;
            };
             
             //Method that gets tuesday slots
             this.getTueSlots = function () {
                var defer = $q.defer(),
                  tueSlots = {
                        subject: 'Tuesday',
                  };
                 
                //Gets variables for api url
                $http.get(urlBase+'schedule.php', {params: tueSlots, cache: true}).
                
                        //Function that assigns json data to manageable variables
                        then(function(response){
                            defer.resolve({
                                            data: response.data.ResultSet.Result,         // create data property with value from response
                                            rowCount: response.data.ResultSet.RowCount  // create rowCount property with value from response
                                          });
                        },function(err){
                            defer.reject(err);
                        });
                return defer.promise;
            };
             
             //Method that gets wednesday slots
             this.getWedSlots = function () {
                var defer = $q.defer(),             // The promise
                  wedSlots = {
                        subject: 'Wednesday',
                  };
                 
                //Gets variables for api url 
                $http.get(urlBase+'schedule.php', {params: wedSlots, cache: true}).
                
                        //Function that assigns json data to manageable variables
                        then(function(response){
                            defer.resolve({
                                            //Create data property with value from response
                                            data: response.data.ResultSet.Result,
                                
                                            //Create rowCount property with value from response
                                            rowCount: response.data.ResultSet.RowCount
                                          });
                        },function(err){
                            defer.reject(err);
                        });
                return defer.promise;
            };
             
             //Method that gets thursday slots
             this.getThurSlots = function () {
                var defer = $q.defer(),
                  thurSlots = {
                        subject: 'Thursday',
                  };
                //Gets variables for api url 
                $http.get(urlBase+'schedule.php', {params: thurSlots, cache: true}).
                
                        //Function that assigns json data to manageable variables
                        then(function(response){
                            defer.resolve({
                                            //Create data property with value from response
                                            data: response.data.ResultSet.Result,
                                            //Create rowCount property with value from response
                                            rowCount: response.data.ResultSet.RowCount
                                          });
                        },function(err){
                            defer.reject(err);
                        });
                return defer.promise;
            };

            //Method that gets sessions based on given slot id
            this.getSessions = function (slotID) {
                var defer = $q.defer(),
                    sessions = {
                        subject: 'Sessions',
                        slotID: slotID
                      };
                    
                //Gets variables for api url
                $http.get(urlBase+'schedule.php', {params: sessions, cache: false}).
                
                        //Function that assigns json data to manageable variables
                        then(function(response){
                            
                            defer.resolve({
                                            //Create data property with value from response
                                            data: response.data.ResultSet.Result,
                                            //Create rowCount property with value from response
                                            rowCount: response.data.ResultSet.RowCount
                                          });
                        }), function(err){
                            defer.reject(err);
                        };
                return defer.promise;
            };
             
            //Method that gets activities based on given session id 
            this.getActivities = function (sessID) {
                var defer = $q.defer(),
                    activities = {
                        subject: 'Activities',
                        sessID: sessID
                      };
                    
                //Gets variables for api url
                $http.get(urlBase+'schedule.php', {params: activities, cache: false}).
                
                        //Function that assigns json data to manageable variables
                        then(function(response){
                            
                            defer.resolve({
                                            //Create data property with value from response
                                            data: response.data.ResultSet.Result,
                                
                                            //Create rowCount property with value from response
                                            rowCount: response.data.ResultSet.RowCount
                                          });
                        }), function(err){
                            defer.reject(err);
                        };
                return defer.promise;
            };
             
            //Method that gets authors based on given activity id  
            this.getAuthors = function (actID) {
                var defer = $q.defer(),
                    authors = {
                        subject: 'Authors',
                        actID: actID
                      };
                
                //Gets variables for api url
                $http.get(urlBase+'schedule.php', {params: authors, cache: false}).
                
                        //Function that assigns json data to manageable variables
                        then(function(response){
                            
                            defer.resolve({
                                            //Create data property with value from response
                                            data: response.data.ResultSet.Result,
                                
                                            //Create rowCount property with value from response
                                            rowCount: response.data.ResultSet.RowCount
                                          });
                        }), function(err){
                            defer.reject(err);
                        };
                return defer.promise;
            };
 
         }
        ]
    );
}());