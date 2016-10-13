'use strict';

var conf = require('../config.js');
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var browserSync = require('browser-sync');
var watching = false;

gulp.task('html', $.watchify(function () {
    return gulp.src(conf.html.src)
        .pipe($.if(watching, browserSync.reload({
            stream: true
        })));
}));

gulp.task('watchMode:html', function () {
    watching = true
});

gulp.task('watch:html', ['watchMode:html', 'html']);
