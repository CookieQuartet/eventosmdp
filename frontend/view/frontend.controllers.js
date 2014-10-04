angular.module('view', ['ngMaterial', 'users'])
  .controller('AppController', function($scope, $timeout, $materialSidenav, $rootScope, user, fbUser, emdpActions) {
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
        pic: 'img/svg/account-circle_wht.svg',
        name: 'Usuario Anónimo',
        logged: false
      };
      $scope.actions = emdpActions;
      $scope.persona.user.init($scope);
      $scope.persona.fbUser.init($scope);
      $scope.$on('user:fbLogged', function(event, logged) {
        $scope.persona.fbLogged = logged;
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

  });