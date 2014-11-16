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
  .controller('emdpEventsController', function($rootScope, $scope, $state, user, eventsAPI, action) {
    $rootScope.lastState = 'events';
    $scope.data.search.visible = true;
    eventsAPI.getEvents(Date.today(), Date.today().add(10).days()).then(function(response) {
      //$rootScope.eventList = _.merge(response, $rootScope.eventList);
      //$rootScope.eventList = _.chain(response).merge($rootScope.eventList).sortBy('fecha').value();
      $rootScope.eventList = response;
    });
    $scope.$on('$destroy', function() {
      $scope.data.search.visible = false;
    });
  })
  .controller('emdpNewEventController', function($rootScope, $scope, $state, user, eventsAPI, action, $filter) {
    $rootScope.lastState = 'new_event';
    $scope.data = {
      DescripcionEvento: null,
      DetalleTexto: null,
      DireccionEvento: null,
      FechaHoraFin: null,
      FechaHoraInicio: null,
      IdArea: 2,
      IdCalendario: 1,
      IdSubarea: 2,
      Lugar: null,
      NombreEvento: null,
      Precio: null,
      RutaImagen: null,
      ZonaHoraria: "America/Argentina/Buenos_Aires",
      fecha: null,
      fecha_real: null
    };
    $scope.methods = {
      saveEvent: function(data) {
        console.log(data);
        //var fecha = Date.parse(data.FechaHoraInicio.split(' ')[0]);
        var fecha = (new Date(data.FechaHoraInicio)).clearTime();
        var dia = _.find($rootScope.eventList, { fecha: fecha });
        if(typeof dia === 'undefined') {
          dia = {
            "fecha": fecha.toISOString(),
            "fecha_completa": $filter('date')(Date.parse(fecha), 'fullDate', 'es_AR'),
            "eventos":[]
          };
          $rootScope.eventList.push(dia);
        }
        dia.eventos.push(data);
        $scope.$parent.methods.toastMessage('Se creó el evento.');
      }
    };
    user.checkLogged();
  })
  .controller('emdpFavoritesController', function($rootScope, $scope, $state, user, action, $filter) {
    $rootScope.lastState = 'favorites';
    $scope.data.search.visible = true;
    $scope.eventList = $rootScope.eventList;
    $scope.checkFavorites = function() {
      $scope.onlyFavorites = $filter('onlyFavorites')($scope.eventList);
      $scope.favoriteWarning = $scope.onlyFavorites.length === 0;
    };
    $scope.$watch('eventList', function() {
      $scope.checkFavorites();
    }, true);
    user.checkLogged(function() {
      $scope.checkFavorites();
    });
    $scope.$on('$destroy', function() {
      $scope.data.search.visible = false;
      $scope.onlyFavorites.length = 0;
    });
  })
  .controller('emdpProfileController', function($rootScope, $scope, $state, user, action) {
    $rootScope.lastState = 'profile';

    $scope.methods = {
      saveProfile: function(data) {
        // diferentes tipos de datos entre lo que se guarda y lo que se muestra
        angular.extend($rootScope.persona, data, { type: parseInt(data.type)});
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
  .controller('emdpProfileUserController', function($rootScope, $scope, $state, user, userHolder, userAPI) {
    $rootScope.lastState = 'user';
    var data = userHolder.get();
    $scope.methods = {
      saveProfile: function(data) {
        userAPI.updateUser({
          email: data.email,
          id: data.id,
          name: data.name,
          password: data.password,
          active: data.active ? '1' : '0',
          type: data.type
        }).then(function(response) {
          //angular.extend({}, data, { type: parseInt(data.type)});
          $scope.$parent.methods.toastMessage('Se modificó el usuario.');
        }, function(message) {
          $scope.$parent.methods.toastMessage(message.error);
        });
        // diferentes tipos de datos entre lo que se guarda y lo que se muestra
      }
    };
    if(data) {
      user.checkLogged(function() {
        $scope.data = angular.extend({}, data, { type: data.id_user_type.toString() });
      });
    } else {
      user.checkLogged(function() {
        if($rootScope.persona.type === 1) {
          userAPI.getUser($state.params.id).then(function(data) {
            $scope.data = angular.extend({}, data, { type: data.id_user_type.toString() });
          }, function(error) {
            $state.go('events');
          });
        } else {
          $state.go('events');
        }
      });
    }
  })
  .controller('emdpNewUserController', function($rootScope, $scope, $state, user, userAPI, action) {
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
          userAPI.create({
            email: data.email,
            name: data.name,
            password: data.password,
            type: data.type
          }).then(function(response) {
            //angular.extend({}, data, { type: parseInt(data.type)});
            $scope.$parent.methods.toastMessage(response.message);
          }, function(message) {
            $scope.$parent.methods.toastMessage(message.error);
          });
          // diferentes tipos de datos entre lo que se guarda y lo que se muestra
          /*angular.extend($scope.data, data, { type: parseInt(data.type)});
          $scope.$parent.methods.toastMessage('Se creó el usuario.');*/
        }
      };
      user.checkLogged();
    })
  .controller('emdpUsersController', function($rootScope, $scope, $state, userAPI, user, action, userHolder) {
      $scope.data = {
        users: []
      };
      $scope.methods = {
        toggleActive: function(item) {
          item.active = !item.active;
          item.icon = item.active ? "img/svg/thump-up_wht.svg" : "img/svg/thumb-down_wht.svg";
          userAPI.toggleUser({
            id: item.id,
            active: item.active ? '1' : '0'
          }).then(function(response) {
            //angular.extend({}, item, { type: parseInt(item.type)});
            if(item.active) {
              $scope.$parent.methods.toastMessage('Se activó el usuario.');
            } else {
              $scope.$parent.methods.toastMessage('Se desactivó el usuario.');
            }

          }, function(message) {
            $scope.$parent.methods.toastMessage(message.error);
          });
        },
        getProfileData: function(user) {
          userHolder.set(user);
          $state.go('user', { id: user.id });
        }
      };
      user.checkLogged(function() {
        userAPI.getUsers().then(function(response) {
          $scope.data.users = _.merge(response, $scope.data.users);
        });
      });
      $scope.$on('$destroy', function() {
        $scope.data.users = [];
      });
  })
  .controller('emdpAlertsController', function($rootScope, $scope, $state, user, action) {
    $rootScope.lastState = 'alerts';
    user.checkLogged(function() {
      $scope.methods = {
        "delete": function(item) {
          _.remove($scope.data.alerts, { id: item.id });
        },
        "toggleActive": function(item) {
          item.active = !item.active;
        },
        "addAlert": function(text) {
          $scope.data.alerts.push({
            id: $scope.data.alerts.lenght +1,
            search: text,
            active: true
          });
        }
      };
      $scope.data = {
        text: '',
        alerts: [
          {
            id: 1,
            search: 'fileteado',
            active: true
          },
          {
            id: 2,
            search: 'soriano',
            active: true
          }
        ]
      }
    });
  });

