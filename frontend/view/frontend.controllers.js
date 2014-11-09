angular.module('view', ['ngMaterial', 'users'])
  .controller('AppController', function($scope, $timeout, $materialSidenav, $materialToast, $rootScope) {
    $rootScope.lastState = '';
    $rootScope.eventList = [];

    $scope.data = {
      search: {
        text: '',
        visible: false
      }
    };

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
  .controller('emdpHomeController', function($rootScope, $scope, $state, user) {
    // este es el estado base

  })
  .controller('emdpEventsController', function($rootScope, $scope, $state, user, eventsAPI, action) {
    $rootScope.lastState = 'events';
    $scope.data.search.visible = true;
    eventsAPI.getEvents(Date.today(), Date.today().add(10).days()).then(function(response) {
      $rootScope.eventList = _.merge(response, $rootScope.eventList);
    });
    $scope.$on('$destroy', function() {
      $scope.data.search.visible = false;
    });
  })
  .controller('emdpNewEventController', function($rootScope, $scope, $state, user, eventsAPI, action) {
      $rootScope.lastState = 'new_event';

      $scope.data = {
        imageLink: ''
      };
      $scope.methods = {
        saveEvent: function(data) {
          console.log(data);
          $scope.$parent.methods.toastMessage('Se creó el usuario.');
        }
      };  })
  .controller('emdpFavoritesController', function($rootScope, $scope, $state, user, action) {
    $rootScope.lastState = 'favorites';
    $scope.data.search.visible = true;
    user.checkLogged(function() {

    });
    $scope.$on('$destroy', function() {
      $scope.data.search.visible = false;
    });
  })
  .controller('emdpProfileController', function($rootScope, $scope, $state, user, action) {
    $rootScope.lastState = 'profile';

    $scope.methods = {
      saveProfile: function(data) {
        // diferentes tipos de datos entre lo que se guarda y lo que se muestra
        angular.extend($rootScope.persona, data, { type: parseInt(data.type)});
        console.log(data);
        $scope.$parent.methods.toastMessage('Cambios guardados.');
      }
    };

    user.checkLogged(function() {
        $scope.data = {
          email: $rootScope.persona.email,
          name: $rootScope.persona.name,
          password: '',
          pic: $rootScope.persona.pic,
          type: $rootScope.persona.type.toString()
        };
    });
  })
  .controller('emdpNewUserController', function($rootScope, $scope, $state, user, action) {
      $rootScope.lastState = 'new_user';

      $scope.data = {
        email: '',
        name: '',
        password: '',
        pic: 'img/svg/account-circle_wht.svg',
        type: '3'
      };
      $scope.methods = {
        saveProfile: function(data) {
          // diferentes tipos de datos entre lo que se guarda y lo que se muestra
          angular.extend($rootScope.persona, data, { type: parseInt(data.type)});
          console.log(data);
          $scope.$parent.methods.toastMessage('Se creó el usuario.');
        }
      };
  })
  .controller('emdpUsersController', function($rootScope, $scope, $state, user, action) {

  })
  .controller('emdpAlertsController', function($rootScope, $scope, $state, user, action) {
    $rootScope.lastState = 'alerts';
    user.checkLogged(function() {

    });
  });

