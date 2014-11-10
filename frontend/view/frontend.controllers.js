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
      $rootScope.eventList = _.merge(response, $rootScope.eventList);
      //$rootScope.eventList = _.merge($rootScope.eventList, response);
    });
    $scope.$on('$destroy', function() {
      $scope.data.search.visible = false;
    });
  })
  .controller('emdpNewEventController', function($rootScope, $scope, $state, user, eventsAPI, action, $filter) {
      $rootScope.lastState = 'new_event';
      $scope.data = {
        Altura: null,
        Calle: null,
        DescripcionCalendario: null,
        DescripcionEvento: null,
        Destacado: null,
        DetalleTexto: null,
        DireccionEvento: null,
        FechaHoraFin: null,
        FechaHoraInicio: '2013/12/14 13:00',
        Frecuencia: null,
        IdArea: 2,
        IdCalendario: 1,
        IdEvento: null,
        IdSubarea: 2,
        Latitud: null,
        Longitud: null,
        Lugar: null,
        NombreEvento: null,
        Precio: null,
        Repetir: null,
        RutaImagen: null,
        RutaImagenMiniatura: null,
        TodoDia: null,
        ZonaHoraria: null,
        favorite: false,
        fecha: null,
        fecha_real: null
      };
      $scope.methods = {
        saveEvent: function(data) {
          console.log(data);
          var fecha = Date.parse(data.FechaHoraInicio.split(' ')[0]);
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
  .controller('emdpUsersController', function($rootScope, $scope, $state, userAPI, user, action) {
      $scope.data = {
        users: []

      };
      $scope.methods = {
        toggleActive: function(item) {
          item.active = !item.active;
          item.icon = item.active ? "img/svg/thump-up_wht.svg" : "img/svg/thumb-down_wht.svg";
        }
      };
      userAPI.getUsers().then(function(response) {
        $scope.data.users = _.merge(response, $scope.data.users);
      });
      $scope.$on('$destroy', function() {
        $scope.data.users = [];
      });
  })
  .controller('emdpAlertsController', function($rootScope, $scope, $state, user, action) {
    $rootScope.lastState = 'alerts';
    user.checkLogged(function() {

    });
  });

