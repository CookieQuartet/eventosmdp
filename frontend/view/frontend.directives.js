
  angular.module('view')
    .directive('emdpMaterialInput', function() {
      return {
        restrict: 'E',
        replace: true,
        scope: {
          type: '@',
          fid : '@?',
          value : '='
        },
        compile : function() {
          return {
            pre : function(scope, element, attrs) {
              // transpose `disabled` flag
              if ( angular.isDefined(attrs.disabled) ) {
                element.attr('disabled', true);
                scope.isDisabled = true;
              }

              // transpose the `label` value
              scope.label = attrs.label || "";
              scope.fid = scope.fid || scope.label;

              // transpose optional `type` and `class` settings
              element.attr('type', attrs.type || "text");
              element.attr('class', attrs.class );
            }
          }
        },
        templateUrl: 'frontend/view/partials/emdpMaterialInput.html'
      };
    })
    .directive('emdpAction', function() {
      return {
        restrict: 'E',
        replace: false,
        controller: function($scope, user, $state, $materialSidenav) {
          $scope.user = user;
          $scope.state = $state;
          $scope.call = function() {
            $scope.$eval($scope.action);
            $materialSidenav('left').toggle();
          }
        },
        scope: {
          action: '@',
          icon: '@',
          name: '@'
        },
        templateUrl: 'frontend/view/partials/emdpAction.html'
      };
    })
    .directive('emdpLoginForm', function() {
      return {
        restrict: 'E',
        replace: true,
        controller: function($scope, $materialSidenav, $materialToast, $rootScope, user, $state,  emdpActions) {
          /* event handlers para eventos del login */
          var onLoggedHandler = function(event, logged) {
                $rootScope.persona.logged = logged;
                if(logged && $rootScope.lastState.length > 0 ) {
                  $state.go($rootScope.lastState);
                }
              },
              onLoginError = function(event, data) {
                $scope.toastMessage(data.error);
              },
              onLoginLogoutHandler = function(event, data) {
                switch(event.name) {
                  case 'user:login':
                    break;
                  case 'user:logout':
                  case 'user:fbLogout':
                    $scope.toastMessage("Hasta luego!");
                    break;
                  default:
                }
                angular.extend($rootScope.persona, data);
              },
              onWelcome = function(event, data) {
                $scope.toastMessage("Bienvenido, " + data.name);
              },
              onDataHandler = function(event, data) {
                $rootScope.persona.fbData = data;
                $rootScope.persona.name = data.name;
              },
              onPictureHandler = function(event, data) {
                $rootScope.persona.pic = data;
              };

          /* definicion básica de una persona en el sistema */
          $rootScope.persona = {
            user: user,
            fbData: null,
            email: '',
            password: '',
            pic: 'img/svg/account-circle_wht.svg',
            name: 'Usuario Anónimo',
            logged: false
          };
          $scope.persona = $rootScope.persona;
          $rootScope.persona.user.init($scope);

          /* lista de acciones disponibles */
          $scope.actions = emdpActions;


          $scope.toastMessage = function(message) {
            $materialToast({
              template: '<material-toast>' + message + '</material-toast>',
              duration: 1000,
              position: 'bottom top left right'
            });
          };

          $scope.$on('user:fbLogged', onLoggedHandler);
          $scope.$on('user:logged', onLoggedHandler);
          $scope.$on('user:fbData', onDataHandler);
          $scope.$on('user:fbPic', onPictureHandler);
          $scope.$on('user:login', onLoginLogoutHandler);
          $scope.$on('user:welcome', onWelcome);
          $scope.$on('user:loginError', onLoginError);
          $scope.$on('user:logout', onLoginLogoutHandler);
          $scope.$on('user:fbLogout', onLoginLogoutHandler);
        },
        templateUrl: 'frontend/view/partials/emdpLoginForm.html'
      };
    })

    .directive('emdpEvent', function() {
      return {
        restrict: 'E',
        replace: true,
        controller: function($scope) {

        },
        templateUrl: 'frontend/view/partials/emdpEvent.html'
      };
    });
