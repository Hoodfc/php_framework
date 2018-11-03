var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    rucksack = require('gulp-rucksack'),
    cssnano = require('gulp-cssnano'),
    rename = require('gulp-rename'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    del = require('del');


var webDevPath = './www/web_dev/',
    stylesMainPath = webDevPath + 'styles/main.scss';



gulp.task('styles', function() {
    return sass(stylesMainPath, { style: 'expanded' })
        .pipe(rucksack())
        .pipe(gulp.dest('./dist/css'))
        .pipe(notify({ message: 'Dev task complete' }));
});

gulp.task('prod', function() {
    var plugins = [
        autoprefixer({ browsers: 'last 5 version' }),
    ];
    return sass(stylesMainPath, { style: 'expanded' })
        .pipe(rucksack())
        .pipe(gulp.dest('./dist/css'))
        .pipe(rename({ suffix: '.min' }))
        .pipe(postcss(plugins))
        .pipe(cssnano())
        .pipe(gulp.dest('./dist/css'))
        .pipe(notify({ message: 'Prod task complete' }));
});

gulp.task('clean', function() {
    return del(['./dist/css']);
});

gulp.task('default', ['clean'], function() {
    gulp.start('prod');
});

gulp.task('watch', function() {
    gulp.watch('./www/web_dev/styles/*', ['styles']);
    livereload.listen();
    gulp.watch(['www/public/css/**']).on('change', livereload.changed);
});