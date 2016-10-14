'use strict';

var conf = require('../config.js');
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var browserSync = require('browser-sync').create();

gulp.task('browserSync', function () {
    browserSync.init({
        notify: false,
        open  : false,
        proxy : conf.wpURI,
        https : conf.wpSSL
    });
});

gulp.task('browserSync:reload', function () {
    browserSync.reload();
});

gulp.task('browserSync:stream', function () {
    browserSync.stream();
});
