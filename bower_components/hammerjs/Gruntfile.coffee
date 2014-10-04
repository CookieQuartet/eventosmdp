module.exports = (grunt) ->
  grunt.initConfig
    pkg: grunt.file.readJSON 'package.json'

    meta:
      banner: '
/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - <%= grunt.template.today("yyyy-mm-dd") %>\n
 * <%= pkg.homepage %>\n
 *\n
 * Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %> <<%= pkg.author.email %>>;\n
 * Licensed under the <%= _.pluck(pkg.licenses, "type").join(", ") %> license */\n\n'

    concat:
      build:
        src: [
          'src/hammer.prefix'
          'src/utils.view'
          'src/input.view'
          'src/input/*.view'
          'src/touchaction.view'
          'src/recognizer.view'
          'src/recognizers/*.view'
          'src/hammer.view'
          'src/manager.view'
          'src/expose.view'
          'src/hammer.suffix']
        dest: 'hammer.view'

    uglify:
      min:
        options:
          report: 'gzip'
          sourceMap: 'hammer.min.map'
          banner: '<%= meta.banner %>'
        files:
          'hammer.min.js': ['hammer.view']
       # special test build that exposes everything so it's testable
      test:
        options:
          wrap: "$H"
          comments: 'all'
          exportAll: true
          mangle: false
          beautify: true
          compress:
            global_defs:
              exportName: 'Hammer'
        files:
          'tests/build.js': [
            'src/utils.view'
            'src/input.view'
            'src/input/*.view'
            'src/touchaction.view'
            'src/recognizer.view'
            'src/recognizers/*.view'
            'src/hammer.view'
            'src/manager.view'
            'src/expose.view']

    'string-replace':
      version:
        files:
          'hammer.js': 'hammer.view'
        options:
          replacements: [
              pattern: '{{PKG_VERSION}}'
              replacement: '<%= pkg.version %>'
            ]

    jshint:
      options:
        jshintrc: true
      build:
        src: ['hammer.view']

    jscs:
      src: [
        'src/**/*.view'
        'tests/unit/*.view'
      ]
      options:
        config: "./.jscsrc"
        force: true

    watch:
      scripts:
        files: ['src/**/*.view']
        tasks: ['concat','string-replace','uglify','jshint','jscs']
        options:
          interrupt: true

    connect:
      server:
        options:
          hostname: "0.0.0.0"
          port: 8000

    qunit:
      all: ['tests/unit/index.html']


  # Load tasks
  grunt.loadNpmTasks 'grunt-contrib-concat'
  grunt.loadNpmTasks 'grunt-contrib-uglify'
  grunt.loadNpmTasks 'grunt-contrib-qunit'
  grunt.loadNpmTasks 'grunt-contrib-watch'
  grunt.loadNpmTasks 'grunt-contrib-jshint'
  grunt.loadNpmTasks 'grunt-contrib-connect'
  grunt.loadNpmTasks 'grunt-string-replace'
  grunt.loadNpmTasks 'grunt-jscs-checker'

  # Default task(s)
  grunt.registerTask 'default', ['connect','watch']
  grunt.registerTask 'default-test', ['connect', 'uglify:test','watch']
  grunt.registerTask 'build', ['concat','string-replace','uglify:min','test']
  grunt.registerTask 'test', ['jshint','jscs','uglify:test','qunit']
  grunt.registerTask 'test-travis', ['build']
