angular.module('events', [])
    .factory('eventsAPI', function($q, $http) {
      var toAPIDate = function(date) {
            return Date.parse(date).toString('yyyyMMddTHHmmss')
          },
          eventsAPI = {
            getEvents: function(from, to) {
              return $http({
                method:'get',
                url: 'backend/apiConnect/testData.php',
                params: {
                  from: toAPIDate(from),
                  to: toAPIDate(to)
                }
              }).success(function(response) {
                return response;
              })
            }
          };
      return eventsAPI;
    });
