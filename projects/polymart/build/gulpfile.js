var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyInline = require('gulp-minify-inline');

var minifyOptions = {
  //js: false
};
   
var criticalSegment = [
  '../../../components/polymer/polymer-nano.html',
  '../../../components/nano-elements/nano-import.html',
  '../../../components/nano-elements/nano-layout.html',
  '../../../components/nano-elements/nano-ripple.html',
  '../../../components/nano-elements/nano-anchor.html',
  '../../../components/icons-simple.html',
  '../src/polymart-view.html',
  '../src/home-view.html'
];

gulp.task('default', function() {
  return gulp.src(criticalSegment)
    .pipe(concat('critical.build.html'))
    .pipe(minifyInline(minifyOptions))
    .pipe(gulp.dest('../'))
  ;
});
