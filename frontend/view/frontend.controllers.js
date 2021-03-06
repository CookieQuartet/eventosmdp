angular.module('view', ['ngMaterial', 'users'])
  .factory('insertEvents', function($rootScope, eventsAPI, $q, $interval) {
    var xhr;
    return function() {
      var defer = $q.defer();

      $rootScope.cacheEventList = [];
      $rootScope.showProgress = true;

      // este chequeo se hace porque en algunas situaciones la funcion se llama dos veces (login, events)
      if($rootScope.cacheEventList.length === 0) {
        xhr = eventsAPI.getEvents(Date.today(), Date.today().add(10).days());
        xhr.then(function(response) {
          $rootScope.eventList = [];
          $rootScope.cacheEventList = response;

          var count = $rootScope.cacheEventList.length;
          $interval(function() {
            var item = $rootScope.cacheEventList.shift();
            if(typeof item !== 'undefined') {
              $rootScope.eventList.push(item);
            }
          }, 1000, count);

          defer.resolve();
        }, function(error) {
          defer.reject(error);
        });
      } else {
        defer.resolve();
      }
      return defer.promise;
    }
  })
  .factory('addEventsToList', function($rootScope, $q, $timeout) {
    return function() {
      var defer = $q.defer();
      $timeout(function() {
        if($rootScope.cacheEventList.length > 0) {
          $rootScope.eventList.push($rootScope.cacheEventList.shift());
        }
        defer.resolve();
      }, 100);
      return defer.promise;
    }
  })
  .controller('AppController', function($scope, $timeout, $materialSidenav, $materialToast,
                                        $rootScope, eventsAPI, insertEvents, addEventsToList) {
    $rootScope.lastState = '';
    $rootScope.cacheEventList = [];
    $rootScope.eventList = [];

    $scope.data = {
      search: {
        text: '',
        visible: false
      },
      triggerSearch: false,
      swap: [],
      showProgress: true
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
      },
      addEventsToList: function() {
        $rootScope.showProgress = true;
        addEventsToList().then(function() {
          $rootScope.showProgress = false;
        });
      }
    };

    /*$scope.$watch('data.search.text', function(newValue, oldValue) {
      if(newValue.length == 1) {
        $scope.data.triggerSearch = true;
      }
      if(newValue.length && $scope.data.triggerSearch) {
        $scope.data.triggerSearch = false;
        $scope.data.swap = _.clone($rootScope.eventList);
        $rootScope.eventList = _.union($rootScope.cacheEventList, $rootScope.eventList);
      } else if(newValue.length == 0) {
        $rootScope.eventList = $scope.data.swap;
      }
    });*/

    $scope.$on('toastMessage', function(event, data) {
      $scope.methods.toastMessage(data);
    });

    $scope.$on('logout', function(event, data) {
      if($rootScope.eventList.length == 0) {
        insertEvents();
      }
    });

    $scope.$on('login', function(event, data) {
      if($rootScope.eventList.length == 0) {
        insertEvents();
      }
    });

    $scope.filterActions = function (action) {
      return action.type >= $rootScope.persona.type;
    };
  })
  .controller('emdpEventsController', function($rootScope, $scope, $state, user, eventsAPI, action, insertEvents) {
    $rootScope.lastState = 'events';
    $scope.data.search.visible = true;
    insertEvents();
    $scope.$on('$destroy', function() {
      $scope.data.search.visible = false;
    });
  })
  .controller('emdpMyEventsController', function($rootScope, $scope, $state, user, eventsAPI, eventHolder) {
    $rootScope.lastState = 'my_events';

    $scope.data = {
      myevents: []
    };
    $scope.methods = {
      "getEvent": function(event) {
        eventHolder.set(event);
        $state.go('event', { id: event.Id });
      },
      "delete": function(event) {
        eventsAPI.deleteEvent(event).then(function(response) {
          $scope.data.myevents = response;
        });
      }
    };
    user.checkLogged(function() {
      eventsAPI.getMyEvents().then(function(response) {
        $scope.data.myevents = response;
      });
    });
  })
  .controller('emdpNewEventController', function($rootScope, $scope, $state, user, eventsAPI) {
    $rootScope.lastState = 'new_event';

    var _data = {
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
          ZonaHoraria: "America/Argentina/Buenos_Aires"
        };
    $scope.methods = {
      checkData: function(data) {
        return data.DescripcionEvento &&
        data.DetalleTexto &&
        data.DireccionEvento &&
          //data.FechaHoraFin &&
        data.FechaHoraInicio &&
        data.Lugar &&
        data.NombreEvento &&
        data.Precio &&
        data.RutaImagen;
      },
      saveEvent: function(data) {
        if($scope.methods.checkData(data)) {
          eventsAPI.addEvent($scope.data).then(function(response) {
            $scope.$parent.methods.toastMessage('Se creó el evento.');
            $scope.data = angular.copy(_data);
            document.getElementById('emdp-newEvent-picture').src = "";
            $rootScope.$broadcast('toastMessage', 'Se creó el evento');
          });
        } else {
          $rootScope.$broadcast('toastMessage', 'Faltan datos!');
        }
      }
    };

    user.checkLogged(function () {
      $scope.data = angular.copy(_data);
    });
  })
  .controller('emdpMyEventController', function($rootScope, $scope, $state, user, eventsAPI, eventHolder) {
    $rootScope.lastState = 'event';

    var _id = $state.params.id,
        _data = {
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
          ZonaHoraria: "America/Argentina/Buenos_Aires"
        };
    $scope.methods = {
      checkData: function(data) {
        return data.DescripcionEvento &&
        data.DetalleTexto &&
        data.DireccionEvento &&
          //data.FechaHoraFin &&
        data.FechaHoraInicio &&
        data.Lugar &&
        data.NombreEvento &&
        data.Precio &&
        data.RutaImagen;
    },
      saveEvent: function(data) {
        if($scope.methods.checkData(data)) {
          eventsAPI.updateEvent($scope.data).then(function(response) {
            $scope.$parent.methods.toastMessage('Se modificó el evento.');
          });
        } else {
          $scope.$parent.methods.toastMessage('Faltan datos!.');
        }
      }
    };

    if(typeof $state.params.id !== 'undefined') {
      // viene por parametro desde afuera
      user.checkLogged(function() {
        eventsAPI.getEvent($state.params.id).then(function(response) {
          _data = response;
          $scope.methods.save = $scope.methods.saveEvent;
          $scope.data = angular.copy(_data);
        });
      });
    } else {
      // viene desde otra parte de la app
      user.checkLogged(function () {
        _data = eventHolder.get();
        $scope.data = angular.copy(_data);
      });
    }
  })
  .controller('emdpFavoritesController', function($rootScope, $scope, $state, user, eventsAPI, action, $filter, insertEvents) {
    $rootScope.lastState = 'favorites';
    $scope.data.search.visible = true;
    $scope.data.search.text = '';
    $scope.eventList = $rootScope.eventList;
    $scope.checkFavorites = function() {
      var eventos = _.union($rootScope.eventList, $rootScope.cacheEventList);
      $scope.onlyFavorites = $filter('onlyFavorites')(eventos);
      $scope.favoriteWarning = $scope.onlyFavorites.length === 0;
    };
    $scope.$watch('eventList', function() {
      $scope.checkFavorites();
    }, true);
    user.checkLogged(function() {
      insertEvents().then(function() {
        $scope.checkFavorites();
      })
    });
    $scope.$on('$destroy', function() {
      $scope.data.search.visible = false;
      $scope.onlyFavorites.length = 0;
    });
  })
  .controller('emdpProfileController', function($rootScope, $scope, $state, user, userAPI) {
    $rootScope.lastState = 'profile';

    $scope.methods = {
      saveProfile: function(data) {
        userAPI.updateUser({
          email: data.email,
          id: data.id,
          name: data.name,
          password: data.password,
          active: '1',
          type: data.type
        }).then(function(response) {
          $scope.$parent.methods.toastMessage('Se actualizaron los datos');
        }, function(error) {
          $scope.$parent.methods.toastMessage(error.message);
        });
        // diferentes tipos de datos entre lo que se guarda y lo que se muestra
      }
    };

    user.checkLogged(function() {
      $scope.data = {
        email: $rootScope.persona.email,
        name: $rootScope.persona.name,
        password: '',
        id: $rootScope.persona.id,
        pic: $rootScope.persona.pic,
        type: $rootScope.persona.type.toString()
      };
    });
  })
  .controller('emdpProfileUserController', function($rootScope, $scope, $state, user, userHolder, userAPI) {
    $rootScope.lastState = 'user';
    var data = userHolder.get();
    $scope.methods = {
      checkData: function(data) {
        return data.email &&
            data.id &&
            data.name &&
            data.password &&
            data.active &&
            data.type;
      },
      saveProfile: function(data) {
        if($scope.methods.checkData(data)) {
          userAPI.updateUser({
            email: data.email,
            id: data.id,
            name: data.name,
            password: data.password,
            active: data.active ? '1' : '0',
            type: data.type
          }).then(function(response) {
            $scope.$parent.methods.toastMessage('Se modificó el usuario.');
          }, function(message) {
            $scope.$parent.methods.toastMessage(message.error);
          });
        } else {
          $scope.$parent.methods.toastMessage('Faltan datos!');
        }
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
  .controller('emdpNewUserController', function($rootScope, $scope, $state, user, userAPI) {
      $rootScope.lastState = 'new_user';
      var _data = {
            email: '',
            name: '',
            password: '',
            pic: 'img/svg/account-circle_wht.svg',
            type: '3'
          };
      $scope.data = angular.copy(_data);
      $scope.methods = {
        saveProfile: function(data) {
          userAPI.create({
            email: data.email,
            name: data.name,
            password: data.password,
            type: data.type
          }).then(function(response) {
            $scope.$parent.methods.toastMessage(response.message);
            $scope.data = angular.copy(_data);
          }, function(message) {
            $scope.$parent.methods.toastMessage(message.error);
          });
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
  .controller('emdpAlertsController', function($rootScope, $scope, $state, user, alertsAPI) {
    $rootScope.lastState = 'alerts';
    user.checkLogged(function() {
      $scope.methods = {
        "getAlerts": function() {
          alertsAPI.getAlerts().then(function(response) {
            $scope.data.alerts = response;
          });
        },
        "delete": function(alert) {
          alertsAPI.deleteAlert(alert).then(function(response) {
            _.remove($scope.data.alerts, { id: alert.id });
          });
        },
        "toggleActive": function(alert) {
          // la logica esta invertida. duh.
          var active = alert.active ? 0 : 1;
          alertsAPI.updateAlert(_.extend({}, alert, { active: active })).then(function(response) {
            alert.active = !alert.active;
          });
        },
        "addAlert": function(text) {
          if(text.length > 0) {
            alertsAPI.addAlert({ keyword: text }).then(function(response) {
              $scope.data.alerts.push({
                id: parseInt(response),
                keyword: text,
                active: true
              });
            });
          } else {
            $scope.$parent.methods.toastMessage('Falta el criterio de búsqueda!');
          }
        }
      };
      $scope.data = {
        text: '',
        alerts: []
      };
      $scope.methods.getAlerts();
    });
  });

