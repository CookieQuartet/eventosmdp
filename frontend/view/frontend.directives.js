
  angular.module('view')
    .factory('updateRating', function($timeout) {
      return function(scope) {
        // recalcular el rating
        var items = _.where(scope.event.comments, { 'idCommentStatus': 1 }),
            total = items.length,
            ratings = _.pluck(_.where(scope.event.comments, { 'idCommentStatus': 1 }), 'stars'),
            suma = _.reduce(ratings, function(stars, n) {
              return parseInt(stars) + n;
            }),
            avg = Math.floor(suma / total);
        $timeout(function() {
          scope.event.stars = avg;
        });
      }
    })
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
        controller: function($scope, $rootScope, user, $state, $materialSidenav, emdpActions) {
          $scope.user = user;
          $scope.state = $state;
          $scope.call = function() {
            angular.forEach(emdpActions.list, function(action) {
              action.selected = false;
            });
            $scope.$parent.action.selected = true;
            $scope.$eval($scope.action);
            if($scope.$parent.action.id === 'logout') {
              $rootScope.$broadcast('logout');
              angular.forEach(emdpActions.list, function(action) {
                action.selected = action.id === 'events';
              });
            }
            $materialSidenav('left').toggle();
          };
          $scope.$on('$destroy', function() {
            $scope.user = null;
            $scope.state = null;
            $scope.call = null;
          });
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
                      $rootScope.eventList = [];
                      $rootScope.$broadcast('login');
                    break;
                  case 'user:logout':
                      $scope.toastMessage("Hasta luego!");
                    break;
                  default:
                }
                angular.extend($rootScope.persona, data);
              },
              onWelcome = function(event, data) {
                $scope.toastMessage("Bienvenido, " + data.name);
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

          $scope.$on('user:logged', onLoggedHandler);
          $scope.$on('user:login', onLoginLogoutHandler);
          $scope.$on('user:welcome', onWelcome);
          $scope.$on('user:loginError', onLoginError);
          $scope.$on('user:logout', onLoginLogoutHandler);
        },
        templateUrl: 'frontend/view/partials/emdpLoginForm.html'
      };
    })
    .directive('emdpEvent', function($rootScope, $q, eventsAPI, commentsAPI, $timeout, updateRating) {
      return {
        restrict: 'E',
        replace: true,
        priority: 500,
        link: function(scope, element) {
          scope.config = {
            showComments: false
          };
          scope.comment = {
            name: $rootScope.persona.name,
            id: $rootScope.persona.id,
            pic: $rootScope.persona.pic,
            //idCommentStatus: 1,
            text: '',
            stars: 0,
            visible: true
          };
          scope.event.comments = [];

          scope.methods = {
            favorite: function(item) {
              if(item.favorite) {
                eventsAPI.removeFavorite(item).then(function(response) {
                  $rootScope.$broadcast('toastMessage', response.message);
                  item.favorite = !item.favorite;
                }, function(error) {
                  $rootScope.$broadcast('toastMessage', error.message);
                });
              } else {
                eventsAPI.addFavorite(item).then(function(response) {
                  $rootScope.$broadcast('toastMessage', response.message);
                  item.favorite = !item.favorite;
                }, function(error) {
                  $rootScope.$broadcast('toastMessage', error.message);
                });
              }
            },
            report: function(item) {
              commentsAPI.reportComment(item).then(function(response) {
                item.idCommentStatus = 3;
                updateRating(scope);
                $rootScope.$broadcast('toastMessage', 'Se reportó el comentario.');
              });
            },
            reactivate: function(item) {
              commentsAPI.reactivateComment(item).then(function(response) {
                item.idCommentStatus = 1;
                updateRating(scope);
                $rootScope.$broadcast('toastMessage', 'Se habilitó el comentario.');
              });
            },
            comment: function(event, comment) {
              if(comment.text.length > 0) {
                commentsAPI.addComment(event, comment).then(function(response) {
                  scope.event.comments.push({
                    name: $rootScope.persona.name,
                    id: $rootScope.persona.id,
                    idCommentStatus: 1,
                    pic: $rootScope.persona.pic,
                    text: comment.text,
                    stars: comment.stars,
                    visible: true
                  });
                  $rootScope.$broadcast('toastMessage', 'Gracias por tu comentario!');
                  var id = scope.event.IdEvento ? scope.event.IdEvento : scope.event.Id,
                      comment_area = document.getElementById('emdp-comment-area-' + id);
                  if(comment_area) {
                    comment_area.remove();
                  }
                  updateRating(scope);
                });
              } else {
                $rootScope.$broadcast('toastMessage', 'Falta el comentario!');
              }
            },
            comments: function(event) {
              if(!scope.config.showComments) {
                commentsAPI.getComments(event).then(function(comments) {
                  // busco si ya se comentó
                  var user = _.find(comments, { idUser: $rootScope.persona.id });
                  if(typeof user !== 'undefined') {
                    var id = scope.event.IdEvento ? scope.event.IdEvento : scope.event.Id,
                        comment_area = document.getElementById('emdp-comment-area-' + id);
                    if(comment_area) {
                      comment_area.remove();
                    }
                  }
                  scope.event.comments = comments;
                  updateRating(scope);
                });
              }
              scope.config.showComments = !scope.config.showComments;
            }
          }
        },
        templateUrl: 'frontend/view/partials/emdpEvent.html'
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
        //priority: 0,
        scope: {
          max: '@',
          value: '@',
          event: '=',
          changeable: '@',
          editable: '@'//,
          //rating: '=rating'
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
            select: function(node, override) {
              if(scope.config.editable || override) {
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
                if(typeof scope.$parent.comment !== 'undefined') {
                  scope.$parent.comment.stars = node.index + 1;
                }
              }
            }
          };
          attrs.$observe('value', function(value) {
            var _value = parseInt(value),
                node = {
                  index: _value - 1,
                  on: false
                };
            scope.methods.select(node, true);
          });

          attrs.$observe('editable', function(value) {
            scope.config.editable = value === 'true';
          });
        },
        templateUrl: 'frontend/view/partials/emdpRating.html'
      };
    });