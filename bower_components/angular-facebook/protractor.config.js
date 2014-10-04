exports.config = {
  multiCapabilities: [{
    'browserName': 'chrome'
  }],
  specs: ['./test/e2e/*.spec.view'],
  baseUrl: 'http://localhost:3333'
};