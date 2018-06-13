/* Load all plugin define in package.json */
var gulp = require('gulp')
var plugins = require('gulp-load-plugins')()

function getTask (task) {
  return require('./assets/tasks/' + task)(gulp, plugins)
}

// Scripts
gulp.task('js', ['js-lint'], getTask('js-dist'))
gulp.task('js-dist', getTask('js-dist'))
gulp.task('js-lint', getTask('js-lint'))

// Styles
gulp.task('sass', getTask('sass'))

// Favicon
gulp.task('favicon', getTask('favicon'))

// Image Minification
gulp.task('imagemin', getTask('imagemin'))

// Gulp build
gulp.task('build', ['imagemin', 'favicon', 'js', 'sass'])

// On default task, just compile on demand
gulp.task('default', ['js', 'sass'], function () {
  gulp.watch('assets/js/src/*.js', [ 'js' ])
  gulp.watch('assets/js/vendor/*.js', [ 'js' ])
  gulp.watch(['assets/css/*.scss', 'assets/css/**/*.scss'], ['sass'])
})