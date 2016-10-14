'use strict';

var conf = require('../config.js');
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

gulp.task('img', function () {
    return gulp.src(conf.img.src)
        .pipe($.cache($.imagemin({
            progressive: true,
            interlaced: true
        })))
        .pipe(gulp.dest(conf.img.dest))
});

gulp.task('watch:img', ['img'], function() {
    return gulp.start(['browserSync:reload']);
});

