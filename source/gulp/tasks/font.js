'use strict';

var conf = require('../config.js');
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var browserSync = require('browser-sync');

gulp.task('font', function () {
    return gulp.src(conf.font.src)
        .pipe(gulp.dest(conf.font.dest))
        .pipe(browserSync.reload({
            stream: true,
            once: true
        }));
});
