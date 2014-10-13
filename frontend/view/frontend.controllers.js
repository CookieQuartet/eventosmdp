angular.module('view', ['ngMaterial', 'users'])
  .controller('AppController', function($scope, $timeout, $materialSidenav, $rootScope) {
    $rootScope.lastState = '';
    $scope.methods = {
      toggleMenu: function() {
        $materialSidenav('left').toggle();
      }
    };
  })
  .controller('emdpLoginController', function($rootScope, $scope, $state, user) {

  })
  .controller('emdpNewUserController', function($rootScope, $scope, $state, user) {

  })
  .controller('emdpHomeController', function($rootScope, $scope, $state, user) {
    // este es el estado base

  })
  .controller('emdpEventsController', function($rootScope, $scope, $state, user, eventsAPI) {
    $rootScope.lastState = 'events';
    user.checkLogged(function() {
      $scope.events = [];
      eventsAPI.getEvents(Date.today(), Date.today().add(10).days()).then(function(response) {
        //$scope.events = response.data;
        $scope.days = response;
      });
    });
  })
  .controller('emdpFavoritesController', function($rootScope, $scope, $state, user) {
    $rootScope.lastState = 'favorites';
    user.checkLogged(function() {

    });
  })
  .controller('emdpProfileController', function($rootScope, $scope, $state, user) {
    $rootScope.lastState = 'profile';
    user.checkLogged(function() {

    });
  })
  .controller('emdpAlertsController', function($rootScope, $scope, $state, user) {
    $rootScope.lastState = 'alerts';
    user.checkLogged(function() {

    });
  });

