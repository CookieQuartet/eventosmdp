angular.module('users', [])
    .value('emptyUser', {
      id: 0,
      name: 'Usuario Anónimo',
      type: 2,
      email: 'user@mail.com',
      pic: 'img/svg/account-circle.svg',
      logged: false
    })
    .value('profiles', {
      "admin": {
        id: 1,
        name: "admin"
      },
      "general": {
        id: 2,
        name: "general"
      },
      "publisher": {
        id: 3,
        name: "publisher"
      }
    })
    .filter('lessEqualThan', function() {
      return function(val1, val2){
        return val1 <= val2;
      }
    })
    .service('checkLogged', function($rootScope, $state, userAPI) {
      return function(callback) {
        userAPI.checkServerLogged().then(function(response) {
          if(!(response.logged || $rootScope.persona.logged)) {
            $state.go('events');
          } else {
            if(angular.isFunction(callback)) {
              callback.call();
            }
          }
        });
      };
    })
    .factory('userAPI', function($q, $http) {
      var encryptPassword = function(password) {
            // codificacion previa del lado del cliente
            return password;
          };
      return {
        register: function(registerData) {
          var defer = $q.defer();
          $http({
            url: 'backend/user/UserAPI.php',
            method: 'get',
            params: {
              method: 'register',
              email: registerData.email,
              password: encryptPassword(registerData.password)
            }
          })
          .success(function(response) {
            defer.resolve(response);
          })
          .error(function(error) {
            defer.resolve(error);
          });
          return defer.promise;
        },
        create: function(user) {
          var defer = $q.defer();
          $http({
            url: 'backend/user/UserAPI.php',
            method: 'get',
            params: angular.extend({}, user, { method: 'create'})
          })
          .success(function(response) {
            if(!response.error) {
              defer.resolve(response);
            } else {
              defer.reject(response);
            }
          })
          .error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        login: function(loginData) {
          var defer = $q.defer();
          $http({
            url: 'backend/user/UserAPI.php',
            method: 'get',
            params: {
              method: 'login',
              email: loginData.email,
              password: encryptPassword(loginData.password)
            }
          })
          .success(function(response) {
            defer.resolve(response);
          })
          .error(function(error) {
            defer.resolve(error);
          });
          return defer.promise;
        },
        getUsers: function() {
          var defer = $q.defer();
          $http({
            url: 'backend/user/UserAPI.php',
            method: 'get',
            params: {
              method: 'users'
            }
          })
          .success(function(response) {
            var data = _.map(response, function(item) {
              item.pic = 'img/svg/account-circle_wht.svg';
              item.active = item.active == '1';
              return item;
            });
            defer.resolve(data);
          })
          .error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        getUser: function(id) {
          var defer = $q.defer();
          $http({
            url: 'backend/user/UserAPI.php',
            method: 'get',
            params: {
              method: 'user',
              id: id
            }
          })
          .success(function(response) {
            if(!response.error) {
              var data = response[0];
              data.pic = 'img/svg/account-circle_wht.svg';
              defer.resolve(data);
            } else {
              defer.reject(response);
            }
          })
          .error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        updateUser: function(user) {
          var defer = $q.defer();
          $http({
            url: 'backend/user/UserAPI.php',
            method: 'get',
            params: angular.extend({}, user, { method: 'update'})
          })
          .success(function(response) {
            if(!response.error) {
              var data = response[0];
              defer.resolve(data);
            } else {
              defer.reject(response);
            }
          })
          .error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        toggleUser: function(params) {
          var defer = $q.defer();
          $http({
            url: 'backend/user/UserAPI.php',
            method: 'get',
            params: angular.extend({}, params, { method: 'toggle'})
          })
          .success(function(response) {
            if(!response.error) {
              var data = response[0];
              defer.resolve(data);
            } else {
              defer.reject(response);
            }
          })
          .error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        logout: function(loginData) {
          var defer = $q.defer();
          $http({
            url: 'backend/user/UserAPI.php',
            method: 'get',
            params: {
              method: 'logout'
            }
          })
          .success(function(response) {
            if(response.status === 'logout') {
              defer.resolve(response);
            } else {
              defer.resolve(false);
            }
          })
          .error(function(error) {
            defer.resolve(false);
          });
          return defer.promise;
        },
        checkServerLogged: function() {
          var defer = $q.defer();
          $http({
            url: 'backend/user/UserAPI.php',
            method: 'get',
            params: {
              method: 'check'
            }
          })
          .success(function(response) {
            if(response.logged) {
              defer.resolve(response);
            } else {
              defer.resolve(false);
            }
          })
          .error(function(error) {
            defer.resolve(false);
          });
          return defer.promise;
        }
      }
    })
    .factory('user', function(emptyUser, profiles, userAPI, checkLogged) {
      var _scope = null,
          _profile = {
            user: angular.extend({}, emptyUser),
            email: "",
            password: "",
            type: profiles.general.id
          };

      return {
        init: function(scope) {
          _scope = scope;
          userAPI.checkServerLogged().then(function(user) {
            if(user) {
              _profile.user = angular.extend(_profile.user, user);
              _scope.$emit('user:login', {
                fbData: null,
                pic: 'img/svg/account-circle_wht.svg',
                name: _profile.user.name.length > 0 ? _profile.user.name : _profile.user.email,
                email: _profile.user.email,
                id: parseInt(_profile.user.id),
                type: _profile.user.type,
                logged: true
              });
              _scope.$emit('user:logged', user.logged);
              _scope.$emit('user:welcome', user);
            }
          });
        },
        login: function(loginData) {
          userAPI.login(loginData).then(function(user) {
            if(typeof user.error !== 'undefined') {
              _scope.$emit('user:loginError', user);
            } else {
              _profile.user = angular.extend(_profile.user, user, { id: parseInt(user.id) });
              _scope.$emit('user:login', {
                fbData: null,
                pic: 'img/svg/account-circle_wht.svg',
                name: _profile.user.name,
                email: _profile.user.email,
                type: _profile.user.type,
                id: _profile.user.id,
                logged: true
              });
              _scope.$emit('user:logged', user.logged);
              _scope.$emit('user:welcome', user);
            }
          }, function(error) {
            _scope.$emit('user:loginError', error);
          });
        },
        logout: function() {
          userAPI.logout().then(function(status) {
            if(!status.logged) {
              _logged = false;
              _profile.user = angular.extend({}, emptyUser);
              _scope.$emit('user:logout', {
                fbData: null,
                pic: 'img/svg/account-circle_wht.svg',
                name: 'Usuario Anónimo',
                email: '',
                password: '',
                logged: false
              });
            }
          });
        },
        register: function(registerData) {
          if(registerData.email.length > 0 && registerData.password.length > 0) {
            userAPI.register(registerData).then(function(user) {
              if(typeof user.error !== 'undefined') {
                _scope.$emit('user:loginError', user);
              } else {
                _profile.user = angular.extend(_profile.user, user, { id: parseInt(user.id) });
                _scope.$emit('user:login', {
                  fbData: null,
                  pic: 'img/svg/account-circle_wht.svg',
                  name: _profile.user.name,
                  email: _profile.user.email,
                  type: _profile.user.type,
                  logged: true
                });
                _scope.$emit('user:logged', user.logged);
              }
            }, function(error) {
              _scope.$emit('user:loginError', error);
            });
          } else {
            _scope.$emit('user:loginError', { error: "Ingresá un email y password!" });
          }
        },
        getProfileData: function() {
          return _profile.user;
        },
        getProfilePicture: function() {
          return _profile.user.pic;
        },
        checkLogged: checkLogged
      };
    })
    .factory('userHolder', function() {
      var holder = null;
      return {
        set: function(item) {
          holder = item;
        },
        get: function() {
          return holder;
        }
      }
    });