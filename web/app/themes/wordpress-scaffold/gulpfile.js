/**
 * The amazing Grrr WordPress/Garp Gulpfile
 * Author: Koen Schaft / Mattijs Bliek
 */

const gulp         = require('gulp'),
  gulpLoadPlugins = require('gulp-load-plugins'),
  $               = gulpLoadPlugins(),
  pxtorem         = require('postcss-pxtorem'),
  autoprefixer    = require('autoprefixer'),
  browserSync     = require('browser-sync'),
  browserify      = require('browserify'),
  babelify        = require('babelify'),
  del             = require('del'),
  watchify        = require('watchify'),
  assign          = require('lodash.assign'),
  runSequence     = require('run-sequence'),
  source          = require('vinyl-source-stream'),
  buffer          = require('vinyl-buffer'),
  path            = require('path'),
  sassGlob        = require('gulp-sass-glob'),
  cleanCSS        = require('gulp-clean-css'),
  execSync        = require('child_process').execSync,
  argv            = require('yargs').argv,
  dotenv          = require('dotenv').config({ path: '../../../../.env' })
;

let paths = {};
let isWatching = false;

/**
 * Environment flags
 * Please note: the staging flag maps to the production one,
 * and both `--production` as well as `--e=production` are allowed
 */
const staging = argv.staging || argv.e === 'staging';
const production = staging || argv.production || argv.e === 'production';


/**
 * Handle errors
 */
const handleError = (error, emitEnd) => {
  if (typeof(emitEnd) === 'undefined') {
    emitEnd = true;
  }
  $.util.beep();
  $.util.log($.util.colors.white.bgRed('Error:'), $.util.colors.red(error.toString()));
  if (emitEnd) {
    this.emit('end');
  }
};

/**
 * Construct paths
 */
const constructPaths = () => {
  paths.src         = 'assets';
  paths.build       = `dist/${production ? 'prod' : 'dev'}`;

  paths.jsSrc       = paths.src + '/scripts';
  paths.jsBuild     = paths.build + '/scripts';

  paths.cssSrc      = paths.src + '/styles';
  paths.cssBuild    = paths.build + '/styles';

  paths.imgSrc      = paths.src + '/images';
  paths.imgBuild    = paths.build + '/images';

  return paths;
};

/**
 * Constructs paths and gets the domain for Browserify
 */
gulp.task('init', () => {
  paths = constructPaths();
  $.util.log($.util.colors.green('———————————————————————————————'));
  $.util.log($.util.colors.green(`Environment: ${production ? 'production' : 'development'}`));
  if (isWatching) {
    $.util.log($.util.colors.green('———————————————————————————————'));
    $.util.log($.util.colors.green(`Proxy Domain: ${process.env.WP_HOME}`));
    $.util.log($.util.colors.green(`Using Cache: ${process.env.WP_CACHE}`));
    $.util.log($.util.colors.green(`Using Cron: ${!!process.env.DISABLE_WP_CRON}`));
  }
  $.util.log($.util.colors.green('———————————————————————————————'));
});

/**
 * Deletes all previous build files
 */
gulp.task('clean', () => {
  return del([
    paths.build + '/**/*'
  ], { dot: true });
});

/**
 * Builds css files
 */
gulp.task('sass', () => {
  const processors = [
    autoprefixer({
      browsers: [
        '>5%',
        'last 3 versions',
        'ie 9',
        'ie 10',
        'ie 11'
      ]
    }),
    pxtorem({
      root_value: 10,
      unit_precision: 5,
      prop_white_list: [
        'font',
        'font-size',
      ],
      replace: false,
      media_query: false
    }),
  ];

  return gulp.src(paths.cssSrc + '/base.scss')
    .pipe(sassGlob())
    .pipe($.sass().on('error', $.sass.logError))
    .pipe($.postcss(processors))
    .pipe($.if(production, cleanCSS({
      aggressiveMerging: false,
      restructuring: false,
    })))
    .pipe(gulp.dest(paths.cssBuild))
    .pipe(browserSync.reload({stream:true}))
  ;
});

/**
 * Lints Sass
 */
gulp.task('sass:lint', () => {
  return gulp.src(paths.cssSrc + '/**/*.scss')
    .pipe($.sassLint({
      configFile: '.sass-lint.yml',
    }))
    .pipe($.sassLint.format())
    .on('error', handleError)
  ;
});

/**
 * Lints JS
 */
const eslint = () => {
  return gulp.src([
    paths.jsSrc + '/**/*.js',
    '!**/vendor/**/*.js',
  ])
    .pipe($.eslint('.eslintrc').on('error', handleError))
    .pipe($.eslint.format());
};
gulp.task('eslint', eslint);

/**
 * Javascript bundle with Browserify
 */
let b;
function initBrowserify() {
  const customOpts = {
    entries: paths.jsSrc + '/main.js'
  };
  const opts = assign({}, watchify.args, customOpts);
  b = browserify(opts);

  // If this is a watch task, wrap browserify in watchify
  if (isWatching) {
    b = watchify(b);
  }
  b.transform(babelify, {
    'plugins': [
      'lodash',
    ],
    'presets': [
      ['env', {
        'targets': {
          'browsers': [
            '> 5%',
            'last 3 versions',
            'safari >= 7',
            'ie >= 9',
          ]
        }
      }]
    ]
  }).on('error', handleError);

  b.on('update', bundle);
  return bundle();
};
gulp.task('javascript', initBrowserify);

function bundle() {
  if (!isWatching) {
    eslint();
  }

  return b.bundle()
    .on('error', handleError)
    .pipe(source('main.js'))
    .pipe(buffer())
    .pipe($.sourcemaps.init({loadMaps: true}))
    .pipe($.if(production, $.uglify({
      compress: {
        drop_console: true,
        drop_debugger: true,
      },
      output: {
        comments: /^!/,
      }
    }))).on('error', handleError)
    .pipe($.sourcemaps.write('./'))
    .pipe(gulp.dest(paths.jsBuild))
};
gulp.task('bundle', bundle);


/**
 * Copy some JS vendor files (eg. polyfills)
 */
gulp.task('javascript:vendor', () => {
  return gulp.src([
    './node_modules/fg-loadjs/loadJS.js',
    './node_modules/svg4everybody/dist/svg4everybody.js',
    './node_modules/picturefill/dist/picturefill.js',
  ])
    .pipe($.uglify({
      compress: {
        drop_console: true,
        drop_debugger: true,
      },
      output: {
        comments: /^!/,
      }
    })).on('error', handleError)
    .pipe(gulp.dest(paths.jsBuild + '/vendor'));
});

/**
 * Compresses images
 */
gulp.task('images', () => {
  if (argv.skipImages) {
    return;
  }
  $.util.log($.util.colors.green('Building images to ' + paths.imgBuild));
  return gulp.src([
    paths.imgSrc + '/**/*.{png,gif,jpg,svg}',
    '!**/icons/*.svg',
  ])
    .pipe($.imagemin({
      progressive: true,
      svgoPlugins: [{removeViewBox: false}]
    }))
    .on('error', handleError)
    .pipe(gulp.dest(paths.imgBuild))
  ;
});

/**
 * Creates an svg sprite out of all files in the public/css/img/icons folder
 * This sprite is lazy loaded with JS, see load-icons.js for more info
 */
gulp.task('images:icons', () => {
  $.util.log($.util.colors.green('Spriting icons to ' + paths.imgBuild));
  return gulp.src(paths.imgSrc + '/icons/*.svg')
  .pipe($.svgmin(function (file) {
    const prefix = path.basename(file.relative, path.extname(file.relative));
    return {
      plugins: [{
        cleanupIDs: {
          prefix: prefix + '-',
          minify: true
        }
      }]
    }
  }).on('error', handleError))
  .pipe($.svgstore({ inlineSvg: true }).on('error', handleError))
  .pipe(gulp.dest(paths.imgBuild));
});

/**
 * Copy assets that don't need to be processed
 */
gulp.task('copy', () => {
	$.util.log($.util.colors.green('Copying unprocesed assets to ' + paths.build));
	return gulp.src([
		paths.src + '/fonts/**/*',
		paths.src + '/videos/**/*',
	], { base: paths.src })
		.pipe(gulp.dest(paths.build));
});

/**
 * Checks js and scss source files for Modernizr tests such as Modernizr.flexbox or .flexbox
 * and creates a custom modernizr build containing only the tests you use.
 *
 * Note: this task isn't run on watch, you can run it manually via `gulp modernizr`
 */
gulp.task('modernizr:build', () => {
  return gulp.src([
    paths.cssSrc + '/**/*.scss',
    paths.jsSrc + '/modules/*.js',
    paths.jsSrc + '/main.js'
  ])
  .pipe($.modernizr({
    'enableJSClass': false,
    'options': [
      'setClasses',
    ],
    'tests': [
      'picture',
    ]
  }))
  .pipe($.uglify())
  .pipe(gulp.dest(paths.jsBuild))
});

/**
 * Used for running modernizr as an individual Gulp task
 */
gulp.task('modernizr', ['init', 'modernizr:build']);

/**
 * Watch wrapper for JavaScript bundle, since we want to reload
 * the browser only once, and only after finishing the bundling.
 */
gulp.task('js-watch', ['bundle'], (done) => {
    browserSync.reload();
    done();
});

/**
 * Watches for file changes and runs Gulp tasks accordingly
 */
gulp.task('watch-tasks', () => {
  gulp.watch(paths.cssSrc + '/**/*.scss', ['sass', 'sass:lint']);
  gulp.watch(paths.imgSrc + '/icons/*.svg', ['images:icons']);
  gulp.watch([
    paths.imgSrc + '/**/*.{gif,jpg,svg,png}',
    '!**/icons/**/*.svg',
  ], ['images']);
  gulp.watch(paths.fontSrc + '/**/*.{ttf,eot,woff,woff2}', ['copy']);
  gulp.watch(paths.videoSrc + '/**/*', ['copy']);
  gulp.watch(paths.jsSrc + '/**/*.js', ['js-watch']);

  browserSync.init({
    files: ['{lib,templates,woocommerce}/**/*.php', '*.php'],
    proxy: process.env.WP_HOME,
    open: false,
    debugInfo: false,
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    }
  });
});

/**
 * Watch
 * In sequence, since we need to set `isWatching`
 */
gulp.task('watch', (cb) => {
  isWatching = true;
  runSequence(
    'default',
    'watch-tasks',
    cb
  );
});

/**
 * Add revision hash behind filename so we can cache assets forever
 */
gulp.task('revision:hash', () => {
  const cssFilter = $.filter('**/*.css', {restore: true});
  const jsFilter = $.filter('**/*.js', {restore: true});
  const imgFilter = $.filter('**/*.{png,gif,jpg,svg}', {restore: true});

  return gulp.src([
    paths.cssBuild + '/*.css',
    paths.imgBuild + '/*.{png,gif,jpg,svg}',
    paths.jsBuild + '/*.js',
  ])
    .pipe($.rev())
    .pipe($.revDeleteOriginal())
    .pipe(cssFilter)
    .pipe(gulp.dest(paths.cssBuild))
    .pipe(cssFilter.restore)
    .pipe(jsFilter)
    .pipe(gulp.dest(paths.jsBuild))
    .pipe(jsFilter.restore)
    .pipe(imgFilter)
    .pipe(gulp.dest(paths.imgBuild))
    .pipe(imgFilter.restore)
    .pipe($.rev.manifest(paths.build + '/assets.json'))
    .pipe(gulp.dest('./'));
});

/*
 * Replace image and font urls in css files
 */
gulp.task('revision:replace:css', () => {
  const manifestFile = paths.build + '/assets.json';
  const manifest = gulp.src(manifestFile);

  return gulp.src(paths.cssBuild + '/*.css')
    .pipe($.revReplace({ manifest: manifest }))
    .pipe(gulp.dest(paths.cssBuild));
});

/**
 * Replace image and font urls in js files
 */
gulp.task('revision:replace:js', () => {
  const manifestFile = paths.build + '/assets.json';
  const manifest = gulp.src(manifestFile);

  return gulp.src(paths.jsBuild + '/*.js')
    .pipe($.revReplace({ manifest: manifest }))
    .pipe(gulp.dest(paths.jsBuild));
});

/**
 * Revision tasks wrapper
 */
gulp.task('revision', (cb) => {
  if (!production) {
    $.util.log('Skipping revisioning for development');
    return cb();
  }
  runSequence(
    'revision:hash',
    'revision:replace:css',
    'revision:replace:js',
    cb
  );
});

gulp.task('default', (cb) => {
  runSequence(
    'init',
    'clean',
    [
      'sass',
      'javascript',
      'javascript:vendor',
      'images',
      'images:icons',
      'copy',
      'modernizr:build'
  ],
  'sass:lint',
  'revision',
  cb
  );
});
