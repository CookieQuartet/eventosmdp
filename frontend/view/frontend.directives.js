
  angular.module('view')
    .directive('ig', function() {
      return {
        restrict: 'E',
        replace: true,
        scope: {
          label: '@',
          fid: '@',
          type: '@'
        },
        template:
        '<material-input-group>' +
        '<label for="{{fid}}">{{ label }}</label>' +
        '<material-input id="{{fid}}" type="{{ type }}" ng-model="data.description">' +
        '</material-input-group>'
      };
    })
    .directive('emdpAction', function() {
        return {
          restrict: 'E',
          replace: false,
          controller: function($scope, user, fbUser) {
            $scope.fbUser = fbUser;
            $scope.call = function() {
              $scope.$eval($scope.action);
            }
          },
          scope: {
            action: '@',
            icon: '@',
            name: '@'
          },
          templateUrl: 'frontend/view/partials/emdpAction.html'
        };
    });
