angular.module('view', ['ngMaterial', 'users'])
  .controller('AppController', function($scope, $timeout, $materialSidenav, $materialToast, $rootScope) {
    $rootScope.lastState = '';
    $rootScope.eventList = [];
    $scope.methods = {
      toggleMenu: function() {
        $materialSidenav('left').toggle();
      },
      toastMessage: function(message) {
        $materialToast.show({
          template: '<material-toast>' + message + '</material-toast>',
          duration: 1000,
          position: 'bottom top left right'
        });
      }
    };

    $scope.filterActions = function (action) {
      return action.type >= $rootScope.persona.type;
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
    //user.checkLogged(function() {
      eventsAPI.getEvents(Date.today(), Date.today().add(10).days()).then(function(response) {
        $rootScope.eventList = _.merge(response, $rootScope.eventList);
      });
    //});
  })
  .controller('emdpFavoritesController', function($rootScope, $scope, $state, user) {
    $rootScope.lastState = 'favorites';
    user.checkLogged(function() {

    });
  })
  .controller('emdpProfileController', function($rootScope, $scope, $state, user) {
    $rootScope.lastState = 'profile';

    $scope.methods = {
      saveProfile: function(data) {
        console.log(data);
        angular.extend($rootScope.persona, data);
        $scope.$parent.methods.toastMessage('Cambios guardados.');
      }
    };

    user.checkLogged(function() {
        $scope.data = {
          email: $rootScope.persona.email,
          name: $rootScope.persona.name,
          password: '',
          pic: $rootScope.persona.pic,
          type: $rootScope.persona.type
        };
    });
  })
  .controller('emdpAlertsController', function($rootScope, $scope, $state, user) {
    $rootScope.lastState = 'alerts';
    user.checkLogged(function() {

    });
  });

