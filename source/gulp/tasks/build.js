'use strict';

var gulp = require('gulp');
var runSequence = require('run-sequence');

gulp.task('build', ['clean', 'del'], function (cb) {
    return runSequence(['font', 'img', 'scss', 'js'], 'clean', cb);
});
