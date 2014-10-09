angular.module('users', ['facebook'])
    .config([ 'FacebookProvider', function(FacebookProvider) {
        FacebookProvider.setLocale('es_AR');
        FacebookProvider.setSdkVersion('v2.1');
        FacebookProvider.setXfbml(true);
        FacebookProvider.init('680325438729479');
      }
    ])
    .value('emptyUser', {
      name: 'Usuario Anónimo',
      pic: 'img/svg/account-circle_wht.svg'
    })
    .factory('gUser', function($rootScope, $http) {
      var logged = false,
          _authResult = null;
      return {
        init: function() {
          $rootScope.$on('event:google-plus-signin-success', function (event, authResult) {
            if(authResult && authResult.status.signed_in) {
              console.log(event, authResult);
              logged = true;
              _authResult = authResult;
            }
          });
          $rootScope.$on('event:google-plus-signin-failure', function (event, authResult) {
            // Auth failure or signout detected
            console.log(event, authResult);
          });
        },
        login: function() {

        },
        logout: function() {

        },
        disconnect: function() {
          if(logged) {
            $timeout(function() {
              var revokeUrl = 'https://accounts.google.com/o/oauth2/revoke?token=' +
                  $scope.authResult.access_token,
                  call = $http({
                    method: 'jsonp',
                    url: revokeUrl
                  });
              call.success(function(response) {
                logged = false;
              }).error(function(error) {
                console.log(error);
              });
            });
          }
        },
        getProfileData: function() {

        },
        getProfilePicture: function() {

        },
        logged: function() {
          return logged;
        }
      };
    })
    .factory('fbUser', function($q, $rootScope, Facebook, $timeout, emptyUser) {
      var logged = false,
          fbData = null,
          fbPicture = null,
          _scope = null,
          loadFBData = function(iface) {
            $timeout(function() {
              logged = true;
              iface.getProfileData().then(function(data) {
                _scope.$emit('user:fbData', data);
              });
              iface.getProfilePicture().then(function(pic) {
                _scope.$emit('user:fbPic', pic);
              });
              _scope.$emit('user:fbLogged', true);
            });
          },
          f = {
            init: function(scope) {
              _scope = scope;
              $rootScope.$on('Facebook:statusChange', function(ev, data) {
                //console.log('Status: ', data);
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
              if(!logged) {
                Facebook.login(function(response) {
                  if (response.status == 'connected') {
                    logged = true;
                    loadFBData(f);
                  }
                });
              }
            },
            logout: function() {
              if(logged) {
                Facebook.logout(function() {
                  $timeout(function() {
                    logged = false;
                    _scope.$emit('user:fbLogout', {
                      fbData: null,
                      fbLogged: false,
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
            logged: function() {
              return logged;
            }
          };
      return f;
  })
  .factory('user', function(emptyUser, fbUser) {
      var logged = false,
          _user = angular.extend({}, emptyUser),
          _fbUser = fbUser;
      return {
        init: function(scope) {
          _fbUser.init(scope);
        },
        login: function(loginData) {
          _fbUser.login()
        },
        logout: function() {
          if(_fbUser.logged()) {
            _fbUser.logout();
          }
        },
        getProfileData: function() {
          return _fbUser.logged() ? _fbUser.getProfileData() : _user;
        },
        getProfilePicture: function() {
          return _fbUser.logged() ? _fbUser.getProfilePicture() : _user.pic;
        },
        logged: function() {
          return logged;
        }
      };
  });