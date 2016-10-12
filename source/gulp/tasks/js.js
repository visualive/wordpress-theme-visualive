'use strict';

var conf = require('../config.js');
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var browserSync = require('browser-sync');
var watching = false;

gulp.task('js', $.watchify(function () {

    return gulp.src(conf.js.src)
        .pipe($.ignore.exclude('components/**/*.js'))
        .pipe($.babel())
        .pipe($.if('!**/*customizer.js', $.concat('script.js')))
        .pipe($.crLfReplace({changeCode: 'LF'}))
        .pipe(gulp.dest(conf.js.dest))
        .pipe($.rename({suffix: '.min'}))
        .pipe($.uglify({preserveComments: 'some'}))
        .pipe(gulp.dest(conf.js.dest))
        .pipe($.if(watching, browserSync.reload({
            stream: true
        })));
}));

gulp.task('watchMode:js', function () {
    watching = true
});

gulp.task('watch:js', ['watchMode:js', 'js']);
