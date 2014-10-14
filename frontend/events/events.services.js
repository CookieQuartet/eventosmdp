angular.module('events', [])
    .factory('eventsAPI', function($q, $http, $filter) {
      var toAPIDate = function(date) {
            return Date.parse(date).toString('yyyyMMddTHHmmss')
          },
          eventsAPI = {
            getEvents: function(from, to) {
              var defer = $q.defer();

              $http({
                method:'get',
                url: 'backend/apiConnect/testData.php',
                params: {
                  from: toAPIDate(from),
                  to: toAPIDate(to)
                }
              }).success(function(response) {
                var days = _.chain(response).map(function(event) {
                  event.fecha = Date.parse(event.FechaHoraInicio.split('T')[0]).toString('yyyy/MM/dd');
                  return event;
                }).groupBy('fecha').map(function(item, key) {
                  return {
                    fecha: key,
                    fecha_completa: $filter('date')(Date.parse(key), 'fullDate', 'es_AR'),
                    eventos: item
                  }
                }).value();
                defer.resolve(days);
              });
              return defer.promise;
            }
          };
      return eventsAPI;
    });
