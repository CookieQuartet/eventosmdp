module.exports = function(config) {
  config.set({
    basePath: '',
    frameworks: ['jasmine'],
    files: [
      'bower_components/angular/angular.view',
      'bower_components/angular-mocks/angular-mocks.view',
      'lib/angular-facebook.view',
      'lib/angular-facebook-phonegap.view',
      'test/unit/*.spec.view'
    ],
    exclude: [],
    port: 8080,
    logLevel: config.LOG_INFO,
    autoWatch: true,
    reporters: ['progress', 'dots'],
    browsers: ['Chrome'],
    singleRun: false
  });
};
