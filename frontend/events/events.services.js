angular.module('events', [])
    .filter('onlyFavorites', function() {
      return function(items) {
        var _items = [];
        angular.forEach(items, function(item) {
          if(_.find(item.eventos, 'favorite')) {
            _items.push(item);
          }
        });
        return _items;
      }
    })
    .filter('onlySearch', function($rootScope, $filter) {
      return function(items, search) {
        var _items = [];
        if(search.length) {
          _items = $filter('filter')(items, { $: search });
        } else {
          _items = $rootScope.eventList;
        }
        return _items;
      }
    })
    .factory('eventHolder', function() {
      var holder = null;
      return {
        set: function(item) {
          holder = item;
        },
        get: function() {
          return holder;
        }
      }
    })
    .factory('eventsAPI', function($q, $http, $filter) {
      var toAPIDate = function(date) {
            return Date.parse(date).toString('yyyyMMddTHHmmss')
          };
      return {
        getEvent: function(event) {
          var defer = $q.defer();

          $http({
            method:'get',
            url: 'backend/event/EventAPI.php',
            params: {
              method: 'get_event',
              id: event
            }
          }).success(function(event) {
            event.FechaHoraInicio = Date.parse(event.FechaHoraInicio, 'yyyyMMddTHHmmss');
            defer.resolve(event);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        getEvents: function(from, to) {
          var defer = $q.defer();

          $http({
            method:'get',
            url: 'backend/event/EventAPI.php',
            params: {
              method: 'get_events',
              from: toAPIDate(from),
              to: toAPIDate(to)
            }
          }).success(function(response) {
            var days = _.chain(response).map(function(event) {
              event.fecha = Date.parse(event.FechaHoraInicio.split('T')[0]).toString('yyyy/MM/dd');
              event.fecha_real = Date.parse(event.FechaHoraInicio.split('T')[0]);
              event.favorite = event.favorite === '1';
              event.stars = parseInt(event.stars);
              return event;
            }).groupBy('fecha_real').map(function(item, key) {
              return {
                fecha: Date.parse(key),
                fecha_completa: $filter('date')(Date.parse(key), 'fullDate', 'es_AR'),
                eventos: item
              }
            }).value();
            defer.resolve(days);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        getMyEvents: function() {
          var defer = $q.defer();

          $http({
            method:'get',
            url: 'backend/event/EventAPI.php',
            params: {
              method: 'get_my_events'
            }
          }).success(function(response) {
            defer.resolve(_.map(response, function(event) {
              event.fecha = Date.parse(event.FechaHoraInicio.split('T')[0]).toString('yyyy/MM/dd');
              event.fecha_real = Date.parse(event.FechaHoraInicio.split('T')[0]);
              return event;
            }));
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        addEvent: function(event) {
          var defer = $q.defer(),
              fecha = toAPIDate(new Date(event.FechaHoraInicio)),
              _event = angular.copy(event);

          $http({
            method:'post',
            url: 'backend/event/EventAPI.php',
            params: {
              method: 'add_event'
            },
            data: angular.extend(_event, { FechaHoraInicio: fecha })
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        deleteEvent: function(event) {
          var defer = $q.defer(),
              fecha = toAPIDate(new Date(event.FechaHoraInicio)),
              _event = angular.copy(event);

          $http({
            method:'post',
            url: 'backend/event/EventAPI.php',
            params: {
              method: 'remove_event'
            },
            data: angular.extend(_event, { FechaHoraInicio: fecha })
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        updateEvent: function(event) {
          var defer = $q.defer(),
              fecha = toAPIDate(new Date(event.FechaHoraInicio)),
              _event = angular.copy(event);

          $http({
            method:'post',
            url: 'backend/event/EventAPI.php',
            params: {
              method: 'edit_event'
            },
            data: angular.extend(_event, { FechaHoraInicio: fecha })
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        addFavorite: function(event) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/event/EventAPI.php',
            params: {
              method: 'add_favorite'
            },
            data: {
              Id: event.Id,
              IdEvento: event.IdEvento,
              fromAPI: _.isNull(event.Id) ? 1 : 2
            }
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        removeFavorite: function(event) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/event/EventAPI.php',
            params: {
              method: 'remove_favorite'
            },
            data: {
              Id: event.Id,
              IdEvento: event.IdEvento
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
