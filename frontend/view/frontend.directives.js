
  angular.module('view')
    .directive('emdpMaterialInput', function() {
      return {
        restrict: 'E',
        replace: true,
        scope: {
          label: '@',
          fid: '@',
          type: '@'
        },
        templateUrl: 'frontend/view/partials/emdpMaterialInput.html'
      };
    })
    .directive('emdpAction', function() {
        return {
          restrict: 'E',
          replace: false,
          controller: function($scope, user, fbUser, $state) {
            $scope.fbUser = fbUser;
            $scope.state = $state;
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
    })
    .directive('emdpLoginForm', function() {
      return {
        restrict: 'E',
        replace: true,
        templateUrl: 'frontend/view/partials/emdpLoginForm.html'
      };
    });
