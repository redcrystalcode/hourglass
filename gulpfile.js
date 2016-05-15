var gulp = require('gulp');
var $ = require('gulp-load-plugins')();
var browserify = require('browserify');
// var del = require('del');
var watchify = require('watchify');
var source = require('vinyl-source-stream');
// var stylish = require('jshint-stylish');
var buffer = require('vinyl-buffer');
var now = require('performance-now');
var _ = require('lodash');
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;

var paths = {
    sass: {
        main: './resources/assets/sass/main.scss',
        watch: 'resources/assets/sass/**/*.scss',
        dest: './public/css'
    },
    js: {
        main: './resources/assets/javascript/main.js',
        watch: './resources/assets/javascript/**/*.js',
        dest: {
            dir: './public/js/',
            file: 'main.js'
        }
    }
};

function error() {
    var args = Array.prototype.slice.call(arguments);
    delete args[0].stream;
    $.util.log.apply(null, args);
    this.emit('end');
}
function bundler(watch) {
    var options = {
        debug: true,
        paths: [
            "./resources/assets/javascript",
            "./node_modules"
        ]
    };
    if (watch) {
        _.extend(options, watchify.args);
    }
    var b = browserify(paths.js.main, options);
    if (watch) {
        b = watchify(b);
    }
    return b;
}

function bundle(b, cb) {
    var stream = b.bundle()
        .on('error', error)
        .pipe(source(paths.js.dest.file))
        .pipe(buffer())
        .pipe($.sourcemaps.init({loadMaps: true}))
        .pipe($.sourcemaps.write('./'))
        .pipe(gulp.dest(paths.js.dest.dir));

    if (cb) {
        stream.on('end', cb);
    }

    stream.pipe(reload({stream: true}));

    return stream;
}

// Prepare SASS task.
gulp.task('sass:prepare', function() {
    // Copy necessary *.css files from node modules to a sass-compilable file.
    var files = [
        './node_modules/nprogress/nprogress.css'
    ];
    return gulp.src(files)
        .pipe($.rename(function(path) {
            path.basename = '_' + path.basename;
            path.extname = '.scss';
        }))
        .pipe(gulp.dest('./resources/assets/vendor-sass/'));
});

// Compile Sass
gulp.task('sass', ['sass:prepare'], function() {
    return gulp.src(paths.sass.main)
        .pipe($.sass({
            includePaths: ['./bower_components', './resources/assets/vendor-sass']
        }).on('error', $.sass.logError))
        .pipe($.autoprefixer())
        .pipe(gulp.dest(paths.sass.dest))
        .pipe(reload({stream: true}));
});
gulp.task('sass:watch', ['sass'], function() {
    $.watch(paths.sass.watch, function() {
        gulp.start('sass');
    });
});

// Compile JS
gulp.task('js', function(cb) {
    bundle(bundler(), cb);
});

gulp.task('js:watch', function() {
    var b = bundler(true);
    var time = null;

    b.on('update', function() {
        time = now();
        $.util.log(
            $.util.colors.cyan('\'js:watch\''),
            '=>',
            $.util.colors.green('Updating scripts...')
        );
        bundle(b, function() {
            var took = now() - time;
            $.util.log(
                $.util.colors.cyan('\'js:watch\''),
                '=> Updated after',
                $.util.colors.magenta(took.toFixed(0) + ' ms')
            );
        });
    });

    bundle(b);
});

// Watch assets.
gulp.task('watch', function() {
    browserSync.init({
        proxy: 'https://hourglass.app'
    });
    gulp.start(['js:watch', 'sass:watch']);
});

// Build command to build dependencies for production
gulp.task('build', ['sass', 'js']);

// Default to watching assets
gulp.task('default', ['watch']);
