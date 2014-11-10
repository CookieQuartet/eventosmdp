
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
        controller: function($scope, user, $state, $materialSidenav, emdpActions) {
          $scope.user = user;
          $scope.state = $state;
          $scope.call = function() {
            angular.forEach(emdpActions.list, function(action) {
              action.selected = false;
            });
            $scope.$parent.action.selected = true;
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
                      $rootScope.persona.password = '';
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
            $materialToast.show({
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
        templateUrl: 'frontend/view/partials/emdpLoginForm2.html'
      };
    })
    .directive('emdpEvent', function($rootScope, $q) {
      return {
        restrict: 'E',
        replace: true,
        link: function(scope, element) {
          scope.config = {
            showComments: false
          };
          scope.comment = {
            usuario: $rootScope.persona.name,
            pic: $rootScope.persona.pic,
            comentario: '',
            rating: 0,
            visible: true
          };
          scope.event.comments = [];

          var mockComments = function() {
            var defer = $q.defer();
            defer.resolve([
              {
                usuario: 'un usuario',
                pic: 'img/svg/account-circle.svg',
                comentario: 'esto es un comentario',
                rating: 4,
                visible: true
              },
              {
                usuario: 'un usuario',
                pic: 'img/svg/account-circle.svg',
                comentario: 'esto es un comentario',
                rating: 4,
                visible: true
              },
              {
                usuario: 'un usuario',
                pic: 'img/svg/account-circle.svg',
                comentario: 'esto es un comentario',
                rating: 4,
                visible: true
              }
            ]);
            return defer.promise;
          };
          scope.methods = {
            favorite: function(item) {
              item.favorite = !item.favorite || false;
            },
            report: function(item) {
              item.visible = false;
            },
            comment: function(data) {
              scope.event.comments.push({
                usuario: $rootScope.persona.name,
                pic: $rootScope.persona.pic,
                comentario: data.comentario,
                rating: scope.event.rating,
                visible: true
              });
              document.getElementById('emdp-comment-area-' + scope.event.IdEvento).remove();
            },
            comments: function() {
              mockComments().then(function(comments) {
                scope.event.comments = _.merge(scope.event.comments, comments);
              });
              scope.config.showComments = !scope.config.showComments;
              document.getElementById('emdp-textarea-comment-' + scope.event.IdEvento).focus();
            }
          }
        },
        templateUrl: 'frontend/view/partials/emdpEvent.html'
      };
    })
    .directive('emdpEventsDay', function() {
      return {
        restrict: 'E',
        replace: true,
        controller: function($scope) {

        },
        templateUrl: 'frontend/view/partials/emdpEventsInDay.html'
      };
    })
    .directive('emdpEvents', function() {
      return {
        restrict: 'E',
        replace: true,
        templateUrl: 'frontend/view/partials/emdpEvents.html'
      };
    })
    .directive('emdpRating', function() {
      return {
        restrict: 'E',
        replace: true,
        scope: {
          max: '@',
          value: '@',
          event: '=',
          editable: '@'
        },
        link: function(scope, element, attrs) {

          scope.config = {
            max: parseInt(attrs.max) || 5,
            editable: true
          };

          scope.data = {
              stars: []
          };

          for(var i = 0; i < scope.config.max; i++){
            scope.data.stars.push({ index: i, on: false });
          }

          scope.methods = {
            select: function(node) {
              if(scope.config.editable) {
                var i;

                angular.forEach(scope.data.stars, function(star) {
                  star.on = false;
                });

                if(node && node.index >= 0) {
                  for(i = 0; i < node.index; i++) {
                    scope.data.stars[i].on = true;
                  }
                  scope.data.stars[i].on = true;
                }
                scope.$parent.event.rating = node.index + 1;
              }
            }
          };

          attrs.$observe('value', function(value) {
            var _value = parseInt(value),
                node = {
                  index: _value - 1,
                  on: false
                };
            scope.methods.select(node);
          });

          attrs.$observe('editable', function(value) {
            var editable = value === 'true' ? true : false;
            scope.config.editable = editable;
          });
        },
        templateUrl: 'frontend/view/partials/emdpRating.html'
      };
    });