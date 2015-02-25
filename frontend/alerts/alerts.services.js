angular.module('alerts', [])
    .factory('alertsAPI', function($q, $http) {
      return {
        addAlert: function(alert) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/alerts/AlertAPI.php',
            params: {
              method: 'add_alert'
            },
            data: {
              alert: alert
            }
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        getAlerts: function() {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/alerts/AlertAPI.php',
            params: {
              method: 'get_alerts'
            }
          }).success(function(alerts) {
            var data = _.map(alerts, function(alert) {
              alert.active = parseInt(alert.active) == 1;
              alert.id = parseInt(alert.id);
              alert.id_user = parseInt(alert.id_user);
              return alert;
            });
            defer.resolve(data);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        deleteAlert: function(alert) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/alerts/AlertAPI.php',
            params: {
              method: 'delete_alert'
            },
            data: {
              alert: alert
            }
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        updateAlert: function(alert) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/alerts/AlertAPI.php',
            params: {
              method: 'update_alert'
            },
            data: {
              alert: alert
            }
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        }
      };
    });
