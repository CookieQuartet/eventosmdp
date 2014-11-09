
//angular.module('app', ['users', 'view', 'events', 'ui.router', 'angular.filter'])
angular.module('app', ['users', 'view', 'events', 'ui.router'])
    .value('emdpActions', {
      list: [
        { id: 'events', name: 'Eventos', icon: "img/svg/map-marker.svg", action: 'state.go("events")', type: 3 },
        { id: 'new_event', name: 'Nuevo evento', icon: "img/svg/plus.svg", action: 'state.go("new_event")', type: 2 },
        { id: 'favorites', name: 'Favoritos', icon: "img/svg/heart.svg", action: 'state.go("favorites")', type: 3 },
        { id: 'profile', name: 'Mi perfil', icon: "img/svg/account.svg", action: 'state.go("profile")', type: 3 },
        { id: 'new_user', name: 'Nuevo usuario', icon: "img/svg/person-plus.svg", action: 'state.go("new_user")', type: 1 },
        { id: 'users', name: 'Usuarios', icon: "img/svg/people.svg", action: 'state.go("users")', type: 1 },
        { id: 'alerts', name: 'Mis Alertas', icon: "img/svg/bell.svg", action: 'state.go("alerts")', type: 3 },
        { id: 'logout', name: 'Cerrar sesión', icon: "img/svg/exit-to-app.svg", action: 'user.logout(); state.go("events")', type: 3 }
      ]
    })
    .config(['$stateProvider', '$urlRouterProvider', 'emdpActionsProvider', function($stateProvider, $urlRouterProvider, emdpActions) {
      var actions = emdpActions.$get().list;
      $urlRouterProvider.otherwise('/events');
      $stateProvider
        /*.state('login', {
          "url": "/login",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpLogin.html",
              "controller": 'emdpLoginController'
            }
          },
          "resolve" : {
          }
        })*/
        .state('events', {
          "url": "/events",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpEventList.html",
              "controller": 'emdpEventsController'
            }
          },
          "resolve" : {
            "action": function() {
              return _.find(actions, { id: 'events' });
            }
          }
        })
        .state('new_event', {
          "url": "/new_event",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpNewEvent.html",
              "controller": 'emdpNewEventController'
            }
          },
          "resolve" : {
            "action": function() {
              return _.find(actions, { id: 'new_event' });
            }
          }
        })
        .state('favorites', {
          "url": "/favorites",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpFavorites.html",
              "controller": 'emdpFavoritesController'
            }
          },
          "resolve" : {
            "action": function() {
              return _.find(actions, { id: 'favorites' });
            }
          }
        })
        .state('profile', {
          "url": "/profile",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpProfile.html",
              "controller": 'emdpProfileController'
            }
          },
          "resolve" : {
            "action": function() {
              return _.find(actions, { id: 'profile' });
            }
          }
        })
        .state('new_user', {
          "url": "/new_user",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpProfile.html",
              "controller": 'emdpNewUserController'
            }
          },
          "resolve" : {
            "action": function() {
              return _.find(actions, { id: 'new_user' });
            }
          }
        })
        .state('users', {
          "url": "/users",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpUsers.html",
              "controller": 'emdpUsersController'
            }
          },
          "resolve" : {
            "action": function() {
              return _.find(actions, { id: 'users' });
            }
          }
        })
        .state('alerts', {
          "url": "/alerts",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpAlerts.html",
              "controller": 'emdpAlertsController'
            }
          },
          "resolve" : {
            "action": function() {
              return _.find(actions, { id: 'alerts' });
            }
          }
        });
    }]);