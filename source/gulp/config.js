'use strict';

var path = require('path');
var root = __dirname;
var gulpTasks = root + '/tasks';
var theme = path.resolve(root + '/../../');
var themeName = theme.replace(/((.*?)\/)*/, '');
var wpPath = root.replace('/wp-content/themes/' + themeName + '/source/gulp', '');
var wpURI = 'http://127.0.0.1:8080';
var wpThemeUri = wpURI + '/wp-content/themes/' + themeName;
var wpSSL = false;
var src = theme + '/source';
var dest = theme + '/assets';
var bowerComponents = theme + '/bower_components';
var nodeModules = theme + '/node_modules';

module.exports = {
    root           : root,
    gulpTasks      : gulpTasks,
    wpPath         : wpPath,
    wpURI          : wpURI,
    wpThemeUri     : wpThemeUri,
    wpSSL          : wpSSL,
    theme          : theme,
    src            : src,
    dest           : dest,
    bowerComponents: bowerComponents,
    nodeModules    : nodeModules,
    html           : [
        theme + '/**/*.html',
        theme + '/**/*.php'
    ],
    font           : {
        src : [
            src + '/font/**/*'
        ],
        dest: dest + '/font'
    },
    img            : {
        src : src + '/img/**/*.+(jpg|jpeg|png|gif|svg)',
        dest: dest + '/img'
    },
    scss           : {
        src : [
            src + '/scss/**/*.scss'
        ],
        dest: dest + '/css'
    },
    js             : {
        map   : src + '/js/**/*.map',
        src   : [
            src + '/js/components/jquery.min.js',
            nodeModules + '/fastclick/lib/fastclick.js',
            nodeModules + '/what-input/what-input.js',
            nodeModules + '/foundation-sites/js/foundation.core.js',
            nodeModules + '/foundation-sites/js/foundation.util.mediaQuery.js',
            nodeModules + '/foundation-sites/js/foundation.util.keyboard.js',
            nodeModules + '/foundation-sites/js/foundation.util.box.js',
            nodeModules + '/foundation-sites/js/foundation.util.motion.js',
            nodeModules + '/foundation-sites/js/foundation.util.nest.js',
            nodeModules + '/foundation-sites/js/foundation.dropdownMenu.js',
            nodeModules + '/foundation-sites/js/foundation.accordionMenu.js',
            src + '/js/**/*.js'
        ],
        dest  : dest + '/js'
    },
    del            : [
        dest + '/font/**/*',
        dest + '/img/**/*',
        dest + '/css/**/*',
        dest + '/js/**/*'
    ]
};
