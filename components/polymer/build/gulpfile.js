var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyInline = require('gulp-minify-inline');

var minifyOptions = {
  //js: false
};
 
var criticalSegment = [
  '../annotator.html',
  '../dom-module.html',
  '../annotations.html',
  '../nano.html'
];

gulp.task('default', function() {
  return gulp.src(criticalSegment)
    .pipe(concat('polymer-nano.html'))
    .pipe(minifyInline(minifyOptions))
    .pipe(gulp.dest('../'))
  ;
});
