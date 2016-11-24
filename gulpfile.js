const elixir = require('laravel-elixir'),
      glob = require('glob'),
      rename = require('gulp-rename');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss')
       .webpack('app.js');

    // Version the assets also
    mix.version([
       'css/app.css',
       'js/app.js'
    ]);

    // ! ==> Publish assets (images, fonts...)
    //mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/*.*', 'public/fonts');
    //mix.copy('node_modules/font-awesome/fonts/*.*',                    'public/fonts');
    mix.copy('resources/assets/sounds/*.*',                            'public/sounds');
    mix.copy('resources/assets/img/*.*',                               'public/img');
    //mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/*.*', 'public/build/fonts');
    //mix.copy('node_modules/font-awesome/fonts/*.*',                    'public/build/fonts');
    mix.copy('resources/assets/sounds/*.*',                            'public/build/sounds');
    mix.copy('resources/assets/img/*.*',                               'public/build/img');
    mix.copy('resources/update.txt',                                   'storage/app');

    gulp.src(glob.sync('resources/assets/js/widgets/**/*.{jpg,jpeg,JPG,JPEG}'))
        .pipe(rename(function(file) {
            file.basename = "widget-bg-" + file.basename.toLowerCase();
        }))
        .pipe(gulp.dest('public/img'));
});
