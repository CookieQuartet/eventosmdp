
angular.module('app', ['users', 'view', 'events', 'ui.router'])
    .value('emdpActions', {
      list: [

        { name: 'Eventos', icon: "img/svg/map-marker.svg", action: 'state.go("events")', type: 2 },
        { name: 'Favoritos', icon: "img/svg/heart.svg", action: 'state.go("favorites")', type: 2 },
        { name: 'Mi perfil', icon: "img/svg/account.svg", action: 'state.go("profile")', type: 2 },
        { name: 'Mis Alertas', icon: "img/svg/bell.svg", action: 'state.go("alerts")', type: 2 },
        { name: 'Cerrar sesión', icon: "img/svg/exit-to-app.svg", action: 'user.logout(); state.go("events")', type: 0 }

        /*{ name: 'Gestionar eventos', icon: "img/svg/account.svg", action: 'state.go("profile")', type: 3 },
        { name: 'Gestionar usuarios', icon: "img/svg/bell.svg", action: 'state.go("alerts")', type: 3 },
        { name: 'Cerrar sesión', icon: "img/svg/exit-to-app.svg", action: 'user.logout(); state.go("home")', type: 3 }*/

      ]
    })
    .config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
      $urlRouterProvider.otherwise('/events');
      $stateProvider
        .state('login', {
          "url": "/login",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpLogin.html",
              "controller": 'emdpLoginController'
            }
          },
          "resolve" : {

          }
        })
        .state('register', {
          "url": "/register",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpNewUser.html",
              "controller": 'emdpNewUserController'
            }
          },
          "resolve" : {

          }
        })
        .state('home', {
          "url": "/home",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpHome.html",
              "controller": 'emdpHomeController'
            }
          },
          "resolve" : {

          }
        })
        .state('events', {
          "url": "/events",
          "views": {
            "content": {
              "templateUrl": "frontend/view/partials/emdpEventList.html",
              "controller": 'emdpEventsController'
            }
          },
          "resolve" : {

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

          }
        });
    }]);