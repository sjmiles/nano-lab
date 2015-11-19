var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyInline = require('gulp-minify-inline');

var minifyOptions = {
  //js: false
};
  
var criticalSegment = [
  '../src/polymer-bootstrap.html',
  '../src/utils.html',
  '../src/BaseElement.html',
  '../src/sugar/accessors.html',
  '../src/sugar/annotator.html',
  '../src/sugar/annotations.html',
  '../src/nano.html'
];

gulp.task('default', function() {
  return gulp.src(criticalSegment)
    .pipe(concat('polymer-nano.html'))
    .pipe(minifyInline(minifyOptions))
    .pipe(gulp.dest('../'))
  ;
});
