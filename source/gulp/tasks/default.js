'use strict';

var conf = require('../config.js');
var gulp = require('gulp');
var runSequence = require('run-sequence');

gulp.task('default', ['clean', 'del'], function (cb) {
    return runSequence(['font', 'img', 'scss', 'js'], 'browserSync', 'watch', cb);
});
