//angular.module('users', ['facebook'])
angular.module('users', [])
    /*.config([ 'FacebookProvider', function(FacebookProvider) {
        FacebookProvider.setLocale('es_AR');
        FacebookProvider.setSdkVersion('v2.1');
        FacebookProvider.setXfbml(true);
        FacebookProvider.init('680325438729479');
      }
    ])*/
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
      /*
      return function(callback) {
        if(!$rootScope.persona.logged) {
          $state.go('home');
        } else {
          if(angular.isFunction(callback)) {
            callback.call();
          }
        }
      };
      */
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
    /*.factory('fbUser', function($q, $rootScope, Facebook, $timeout, emptyUser) {
      var logged = false,
          fbLoginResponse = null,
          fbData = null,
          fbPicture = null,
          fbPermissions = null,
          _scope = null,
          loadFBData = function(iface) {
            $timeout(function() {
              logged = true;
              iface.getProfileData().then(function(data) {
                _scope.$emit('user:fbData', data);
                _scope.$emit('user:welcome', data);
                _scope.$emit('user:login', {
                  type: 3
                });
              });
              iface.getProfilePicture().then(function(pic) {
                _scope.$emit('user:fbPic', pic);
              });
              iface.getProfilePermissions().then(function(permissions) {
                _scope.$emit('user:fbPermissions', permissions);
              });
              _scope.$emit('user:fbLogged', true);
            });
          },
          f = {
            init: function(scope) {
              _scope = scope;
              $rootScope.$on('Facebook:statusChange', function(ev, data) {
                if (data.status == 'connected') {
                  loadFBData(f);
                } else {
                  $timeout(function() {
                    logged = false;
                    _scope.$emit('user:fbData', emptyUser);
                  });
                }
              });
            },
            login: function() {
              var defer = $q.defer();
              if(!logged) {
                try {
                  Facebook.login(function(response) {
                    if (response.status == 'connected') {
                      logged = true;
                      loadFBData(f);
                      fbLoginResponse = response;
                      defer.resolve(fbLoginResponse);
                    }
                  });
                } catch(e) {
                  defer.reject(e);
                }
              } else {
                defer.resolve(fbLoginResponse);
              }
              return defer.promise;
            },
            logout: function() {
              if(logged) {
                Facebook.logout(function() {
                  $timeout(function() {
                    logged = false;
                    _scope.$emit('user:fbLogout', {
                      fbData: null,
                      pic: 'img/svg/account-circle_wht.svg',
                      name: 'Usuario Anónimo',
                      logged: false
                    });
                  });
                });
              }
            },
            getProfileData: function() {
              var defer = $q.defer();
              Facebook.api('/me', function(response) {
                fbData = response;
                defer.resolve(fbData);
              });
              return defer.promise;
            },
            getProfilePicture: function() {
              var defer = $q.defer();
              Facebook.api('/me/picture', function(response) {
                fbPicture = response.data.url;
                defer.resolve(fbPicture);
              });
              return defer.promise;
            },
            getProfilePermissions: function() {
              var defer = $q.defer();
              Facebook.api('/me/permissions', function(response) {
                fbPermissions = response;
                defer.resolve(fbPermissions);
              });
              return defer.promise;
            },
            logged: function() {
              return logged;
            }
          };
      return f;
    })*/
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
              item.active = item.active == '1' ? true : false;
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
    //.factory('user', function(emptyUser, fbUser, profiles, userAPI, checkLogged) {
    .factory('user', function(emptyUser, profiles, userAPI, checkLogged) {
      var _scope = null,
          _profile = {
            user: angular.extend({}, emptyUser),
            //fbUser: fbUser,
            email: "",
            password: "",
            type: profiles.general.id
          };

      return {
        init: function(scope) {
          _scope = scope;
          //_profile.fbUser.init(_scope);
          userAPI.checkServerLogged().then(function(user) {
            if(user) {
              _profile.user = angular.extend(_profile.user, user);
              _scope.$emit('user:login', {
                fbData: null,
                pic: 'img/svg/account-circle_wht.svg',
                name: _profile.user.name.length > 0 ? _profile.user.name : _profile.user.email,
                email: _profile.user.email,
                type: _profile.user.type,
                logged: true
              });
              _scope.$emit('user:logged', user.logged);
              _scope.$emit('user:welcome', user);
            }
          });
        },
        login: function(loginData) {
          if(loginData.withFacebook){
            /*_profile.fbUser.login().then(function(status) {

            });*/
          } else {
            userAPI.login(loginData).then(function(user) {
              if(typeof user.error !== 'undefined') {
                _scope.$emit('user:loginError', user);
              } else {
                _profile.user = angular.extend(_profile.user, user);
                _scope.$emit('user:login', {
                  fbData: null,
                  pic: 'img/svg/account-circle_wht.svg',
                  name: _profile.user.name,
                  email: _profile.user.email,
                  type: _profile.user.type,
                  logged: true
                });
                _scope.$emit('user:logged', user.logged);
                _scope.$emit('user:welcome', user);
              }
            }, function(error) {
              _scope.$emit('user:loginError', error);
            });
          }
        },
        logout: function() {
          /*if(_profile.fbUser.logged()) {
            _profile.fbUser.logout();
          } else {*/
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
          //}
        },
        register: function(registerData) {
          if(registerData.email.length > 0 && registerData.password.length > 0) {
            userAPI.register(registerData).then(function(user) {
              if(typeof user.error !== 'undefined') {
                _scope.$emit('user:loginError', user);
              } else {
                _profile.user = angular.extend(_profile.user, user);
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
        getUser: function(id) {

        },
        getProfileData: function() {
          //return _profile.fbUser.logged() ? _profile.fbUser.getProfileData() : _profile.user;
          return _profile.user;
        },
        getProfilePicture: function() {
          //return _profile.fbUser.logged() ? _profile.fbUser.getProfilePicture() : _profile.user.pic;
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