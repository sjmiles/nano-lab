var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyInline = require('gulp-minify-inline');

var minifyOptions = {
  //js: false
};
 
var criticalSegment = [
  // polymer nano
  '../../../nano/polymer-nano.html',
  // components
  '../../../components/nano-layout.html',
  '../../../components/nano-import.html',
  // assets
  '../assets/icons-simple.html',
  // main view
  '../main/translate.html',
  '../main/settings-view-styles.html',
  '../main/settings-view.html'
];

gulp.task('default', function() {
  return gulp.src(criticalSegment)
    .pipe(concat('critical.html'))
    .pipe(minifyInline(minifyOptions))
    .pipe(gulp.dest('../serve'))
  ;
});

var lazySegment = [
  '../../../../lib/nano-router.html',
  '../lazy/settings-content.html',
  '../lazy/settings-card.html',
  '../lazy/card-banner.html',
  '../lazy/ic-view.html',
  '../lazy/wifi-view.html',
  '../lazy/nav-bar.html',
  '../lazy/crumb-bar.html',
];

gulp.task('all', function() {
  return gulp.src(criticalSegment.concat(lazySegment))
    .pipe(concat('all.html'))
    .pipe(minifyInline(minifyOptions))
    .pipe(gulp.dest('../serve'))
  ;
});