angular.module('view', ['ngMaterial', 'users'])
  .service('checkLogin', function() {
      // TODO: cambiar a chequeo en el server / solucion hibrida
    return function(user, state, callback) {
      if(!user.logged()) {
        state.go('home');
      } else {
        if(angular.isFunction(callback)) {
          callback.call();
        }
      }
    };
  })
  .controller('AppController', function($scope, $timeout, $materialSidenav, $rootScope, user, fbUser, emdpActions, $state) {
    $rootScope.lastState = '';
    $scope.methods = {
      openLeftMenu: function() {
        $materialSidenav('left').toggle();
      }
    };
    $scope.persona = {
      user: user,
      fbUser: fbUser,
      fbData: null,
      fbLogged: false,
      email: '',
      password: '',
      pic: 'img/svg/account-circle_wht.svg',
      name: 'Usuario Anónimo',
      logged: false
    };
    $scope.actions = emdpActions;
    $scope.persona.user.init($scope);
    $scope.persona.fbUser.init($scope);

    $scope.$on('user:fbLogged', function(event, logged) {
      $scope.persona.fbLogged = logged;
      if(logged && $rootScope.lastState.length > 0 ) {
        $state.go($rootScope.lastState);
      }
    });
    $scope.$on('user:fbData', function(event, data) {
      $scope.persona.fbData = data;
      $scope.persona.name = data.name;
    });
    $scope.$on('user:fbPic', function(event, data) {
      $scope.persona.pic = data;
    });
    $scope.$on('user:fbLogout', function(event, data) {
      angular.extend($scope.persona, data);
    });

  })
  .controller('emdpLoginController', function($rootScope, $scope, $state, fbUser, checkLogin) {

  })
  .controller('emdpNewUserController', function($rootScope, $scope, $state, fbUser, checkLogin) {

  })
  .controller('emdpHomeController', function($rootScope, $scope, $state, fbUser, checkLogin) {
    // este es el estado base

  })
  .controller('emdpEventsController', function($rootScope, $scope, $state, fbUser, checkLogin) {
    $rootScope.lastState = 'events';
    checkLogin(fbUser, $state, function() {

    });
  })
  .controller('emdpFavoritesController', function($rootScope, $scope, $state, fbUser, checkLogin) {
    $rootScope.lastState = 'favorites';
    checkLogin(fbUser, $state, function() {

    });
  })
  .controller('emdpProfileController', function($rootScope, $scope, $state, fbUser, checkLogin) {
    $rootScope.lastState = 'profile';
    checkLogin(fbUser, $state, function() {

    });
  })
  .controller('emdpAlertsController', function($rootScope, $scope, $state, fbUser, checkLogin) {
    $rootScope.lastState = 'alerts';
    checkLogin(fbUser, $state, function() {

    });
  });

