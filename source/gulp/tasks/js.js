'use strict';

var conf = require('../config.js');
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

gulp.task('js', $.watchify(function () {
    return gulp.src(conf.js.src)
        .pipe($.ignore.exclude('components/**/*.js'))
        .pipe($.babel())
        .pipe($.if('!**/*customizer.js', $.concat('script.js')))
        .pipe($.crLfReplace({changeCode: 'LF'}))
        .pipe(gulp.dest(conf.js.dest))
        .pipe($.rename({suffix: '.min'}))
        .pipe($.uglify({preserveComments: 'some'}))
        .pipe(gulp.dest(conf.js.dest));
}));

gulp.task('watch:js', ['js'], function() {
    return gulp.start(['browserSync:reload']);
});
