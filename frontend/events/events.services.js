angular.module('events', [])
    .filter('onlyFavorites', function() {
      return function(items) {
        var _items = [];
        angular.forEach(items, function(item) {
          if(_.where(item.eventos, 'favorite').length > 0) {
            _items.push(item);
          }
        });
        return _items;
      }
    })
    .factory('eventsAPI', function($q, $http, $filter) {
      var toAPIDate = function(date) {
            return Date.parse(date).toString('yyyyMMddTHHmmss')
          };
      return {
        getEvents: function(from, to) {
          var defer = $q.defer();

          $http({
            method:'get',
            url: 'backend/event/EventAPI.php',
            params: {
              from: toAPIDate(from),
              to: toAPIDate(to)
            }
          }).success(function(response) {
            var days = _.chain(response).map(function(event) {
              event.fecha = Date.parse(event.FechaHoraInicio.split('T')[0]).toString('yyyy/MM/dd');
              event.fecha_real = Date.parse(event.FechaHoraInicio.split('T')[0]);
              event.rating = 0;
              event.favorite = false; // eliminar cuando forme parte de los datos devueltos por la consulta
              return event;
            }).groupBy('fecha_real').map(function(item, key) {
              return {
                fecha: Date.parse(key),
                fecha_completa: $filter('date')(Date.parse(key), 'fullDate', 'es_AR'),
                eventos: item
              }
            }).value();
            defer.resolve(days);
          });
          return defer.promise;
        }
      };
    });
