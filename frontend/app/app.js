
angular.module('app', ['users', 'view', 'ui.router'])
    .value('emdpActions', {
      list: [
        { name: 'Eventos', icon: "img/svg/map-marker.svg", action: 'state.go("events")' },
        { name: 'Favoritos', icon: "img/svg/heart.svg", action: 'state.go("favorites")' },
        { name: 'Mi perfil', icon: "img/svg/account.svg", action: 'state.go("profile")' },
        { name: 'Mis Alertas', icon: "img/svg/bell.svg", action: 'state.go("alerts")' },
        { name: 'Cerrar sesión', icon: "img/svg/exit-to-app.svg", action: 'fbUser.logout(); state.go("home")' }
      ]
    })
    .config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
      $urlRouterProvider.otherwise('/home');
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