var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyInline = require('gulp-minify-inline');
var size = require('gulp-size');

var minifyOptions = {
  //js: false
};

var modules = [
  'mdl-textfield.html'
];

var tasks = modules.forEach(function(m) {
  gulp.task(m, function() {
    gulp.src('../' + m)
    .pipe(minifyInline(minifyOptions))
    .pipe(size())
    .pipe(gulp.dest('../deploy'))
    ;
  });
});

gulp.task('default', modules);
