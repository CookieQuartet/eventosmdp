angular.module('comments', [])
    .factory('commentsAPI', function($q, $http, $filter) {
      var toAPIDate = function(date) {
            return Date.parse(date).toString('yyyyMMddTHHmmss')
          };
      return {
        addComment: function(event, comment) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/comment/CommentAPI.php',
            params: {
              method: 'add_review'
            },
            data: {
              event: angular.copy(event),
              comment: comment
            }
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        getComments: function(event) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/comment/CommentAPI.php',
            params: {
              method: 'get_reviews'
            },
            data: angular.copy(event)
          }).success(function(comments) {
            var data = _.map(comments, function(comment) {
                  comment.visible = true;
                  comment.pic = 'img/svg/account-circle_wht.svg';
                  comment.idCommentStatus = parseInt(comment.idCommentStatus);
                  comment.eventFromApi = parseInt(comment.eventFromApi);
                  comment.id = parseInt(comment.id);
                  comment.idEvent = parseInt(comment.idEvent);
                  comment.idUser = parseInt(comment.idUser);
                  comment.stars = parseInt(comment.stars);
                  return comment;
                });
            defer.resolve(data);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        reportComment: function(comment) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/comment/CommentAPI.php',
            params: {
              method: 'report'
            },
            data: {
              comment: comment
            }
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        },
        reactivateComment: function(comment) {
          var defer = $q.defer();

          $http({
            method:'post',
            url: 'backend/comment/CommentAPI.php',
            params: {
              method: 'reactivate'
            },
            data: {
              comment: comment
            }
          }).success(function(response) {
            defer.resolve(response);
          }).error(function(error) {
            defer.reject(error);
          });
          return defer.promise;
        }
      };
    });
