const gulp = require('gulp'),
      browserSync = require('browser-sync'),
      sass = require('gulp-sass'),
      rename = require("gulp-rename"),
      autoprefixer = require('gulp-autoprefixer'),
      cleanCSS = require('gulp-clean-css'),
      pug = require('gulp-pug'),
      concat = require('gulp-concat'),
      newer = require('gulp-newer'),
      image = require('gulp-image'),
      webp = require('gulp-webp'),
      uglify = require('gulp-uglify');


const src = 'src/',
      dist = 'dist/';

const config = {
    src : {
        html : src + 'pug/index.pug',
        style : src + 'scss/**/*.scss',
        js : src + 'js/**/*.*',
        fonts : src + 'fonts/**/*.*',
        img : src + 'img/**/*.*'
    },

    dist : {
        html : dist,
        style : dist + 'css/',
        js : dist + 'js/',
        fonts : dist + 'fonts/',
        img : dist + 'img/'
    },

    watch : {
        html : src + 'pug/**/*.pug',
        style : src + 'scss/**/*.scss',
        js : src + 'js/**/*.*',
        fonts : src + 'fonts/**/*.*',
        img : src + 'img/**/*.*'
    }
}

//Static server
gulp.task('server', function() {
    browserSync.init({
        server: {
            baseDir: dist
        }
    });
});

const pugTask = () => {
    return gulp.src(config.src.html)
        // .pipe(pug())
        .pipe(pug({
            pretty: true
        }))
        .pipe(gulp.dest(config.dist.html))
        .pipe(browserSync.stream());
}

const scssTask = () => {
    return gulp.src(config.src.style)
        .pipe(sass({outputStyle: 'expanded'}))
        .pipe(gulp.dest("./src/css"))
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(rename({
            prefix: "",
            suffix: ".min",
          }))
         .pipe(autoprefixer({
                overrideBrowserslist: ['> 1%'],
                grid: true,
                cascade: false
            }))
        .pipe(cleanCSS({
                level: { 2: { all: false, restructureRules: true, removeDuplicateRules: true }},
                compatibility: 'ie8'
            }
        ))
        .pipe(gulp.dest(config.dist.style))
        .pipe(browserSync.stream());
       
}

const jsTask = () => {
    return gulp.src(config.src.js)
        .pipe(concat('main.min.js'))
        .pipe(uglify(true))
        .pipe(gulp.dest(config.dist.js))
        .pipe(browserSync.stream());
}

const imgMin = () => {
    return gulp.src(config.src.img)
        .pipe(newer(config.dist.img))
        .pipe(image())
        .pipe(webp())
        .pipe(gulp.dest(config.dist.img))
        .pipe(browserSync.stream());
}

const watchFiles = () => {
    gulp.watch([config.watch.html], gulp.series(pugTask));
    gulp.watch([config.watch.style], gulp.series(scssTask));
    gulp.watch([config.watch.js], gulp.series(jsTask));
    // gulp.watch([config.watch.img], gulp.series(imgMin));g
}

const start = gulp.series(pugTask, scssTask, jsTask, imgMin);

exports.default = gulp.parallel(start, watchFiles, 'server');

