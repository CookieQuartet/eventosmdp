angular.module('comments', [])
    .factory('commentsAPI', function($q, $http, $filter) {
      var toAPIDate = function(date) {
            return Date.parse(date).toString('yyyyMMddTHHmmss')
          };
      return {
        addComment: function(event, comment) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/comment/CommentAPI.php',
            params: {
              method: 'add_review'
            },
            data: {
              event: angular.copy(event),
              comment: comment
            }
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        getComments: function(event) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/comment/CommentAPI.php',
            params: {
              method: 'get_reviews'
            },
            data: angular.copy(event)
          }).success(function(comments) {
            var data = _.map(comments, function(comment) {
                  comment.visible = true;
                  comment.pic = 'img/svg/account-circle_wht.svg';
                  return comment;
                });
            defer.resolve(data);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        }
        /*,
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
              //event.stars = 0;
              //event.favorite = false; // eliminar cuando forme parte de los datos devueltos por la consulta
              event.favorite = event.favorite === '1'; // eliminar cuando forme parte de los datos devueltos por la consulta
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
            //defer.resolve(response);

            var events = _.map(response, function(event) {
                  event.fecha = Date.parse(event.FechaHoraInicio.split('T')[0]).toString('yyyy/MM/dd');
                  event.fecha_real = Date.parse(event.FechaHoraInicio.split('T')[0]);
                  return event;
                });
            defer.resolve(events);
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
        }*/
      };
    });
