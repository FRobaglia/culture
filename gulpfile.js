const root = "./";
const proxy = "culturekuggfr/";

// Include gulp
const gulp = require("gulp");

// Include Our Plugins
const fs = require("fs");
const sass = require("gulp-sass");
const rollup = require("rollup-stream");
const source = require("vinyl-source-stream");
const buffer = require("vinyl-buffer");
const buble = require("rollup-plugin-buble");
const uglify = require("gulp-uglify");
const rename = require("gulp-rename");
const plumber = require("gulp-plumber");
const pxtorem = require("gulp-pxtorem");
const autoprefixer = require("gulp-autoprefixer");
const minifyCss = require("gulp-clean-css");
const sourcemaps = require("gulp-sourcemaps");
const browserSync = require("browser-sync").create();

// Compile Our sass
gulp.task("scss", function () {
  return gulp
    .src(root + "styles/*.scss")
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass().on("error", sass.logError))
    .pipe(pxtorem())
    .pipe(autoprefixer())
    .pipe(minifyCss({ compatibility: "ie9" }))
    .pipe(sourcemaps.write("./"))
    .pipe(gulp.dest(root + "styles"))
    .pipe(browserSync.stream({ match: "**/*.css" }));
});

// Concatenate & Minify JS
gulp.task("scripts", function () {
  return (
    rollup({
      input: root + "scripts/main.js",
      format: "es",
      plugins: [buble()],
      sourcemap: true,
    })
      // point to the entry file.
      .pipe(source("main.js", root + "scripts/"))

      // buffer the output. most gulp plugins, including gulp-sourcemaps, don't support streams.
      .pipe(buffer())

      // tell gulp-sourcemaps to load the inline sourcemap produced by rollup-stream.
      .pipe(sourcemaps.init({ loadMaps: true }))

      // output files
      .pipe(rename("bundle.js"))
      .pipe(gulp.dest(root + "scripts"))
      .pipe(rename("bundle.min.js"))
      .pipe(uglify())
      .pipe(sourcemaps.write("."))
      .pipe(gulp.dest(root + "scripts"))
  );
});

gulp.task("build", gulp.parallel("scss", "scripts"));

// Watch Files For Changes
gulp.task(
  "watch",
  gulp.series("build", function () {
    if (proxy) {
      browserSync.init({
        proxy: "localhost/" + proxy,
      });
    } else {
      browserSync.init({
        server: {
          baseDir: root,
        },
      });
    }

    gulp.watch([root + "styles/**/*.scss"], gulp.series("scss"));
    gulp.watch([root + "scripts/**/*.js"], gulp.series("scripts"));
    gulp
      .watch([root + "scripts/bundle.js", root + "scripts/bundle.min.js"])
      .on("change", browserSync.reload);
    gulp.watch([root + "*.php"]).on("change", browserSync.reload);
  })
);
