const elixir = require('laravel-elixir'),
      path   = require('path'),
      fs     = require('fs');

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
    // ! ==> Webpack
    mix.sass('app.scss')
        .webpack('app.js')
        .version([
            elixir.config.css.outputFolder + '/app.css',
            elixir.config.js.outputFolder + '/app.js'
        ]);

    // ! ==> Publish assets
    //mix.copy('resources/assets/js/**/*.*',      'public/js');
    //mix.copy('resources/assets/css/**/*.*',     'public/css');
    mix.copy('resources/assets/img/**/*.*',     'public/img');
    mix.copy('resources/assets/fonts/**/*.*',   'public/fonts');
    mix.copy('resources/assets/favicon/**/*.*', 'public/favicon');
    mix.copy('resources/assets/sounds/**/*.*',  'public/sounds');

    // ! ==> Copy favicon config files
    mix.copy('resources/assets/favicon/favicon.ico',       'public');
    mix.copy('resources/assets/favicon/browserconfig.xml', 'public');
    mix.copy('resources/assets/favicon/manifest.json',     'public');

    // ! ==> Components assets
    getFolders('resources/assets/js/components/').forEach(function(component) {
        getFolders('resources/assets/js/components/' + component).forEach(function(asset) {
            gulp.src(['resources/assets/js/components/' + component + '/' + asset + '/**/*']).pipe(gulp.dest('public/components/' + component + '/' + asset));
        });
    });

    // ! ==> Widget assets
    getFolders('resources/assets/js/widgets/').forEach(function(component) {
        getFolders('resources/assets/js/widgets/' + component).forEach(function(asset) {
            gulp.src(['resources/assets/js/widgets/' + component + '/' + asset + '/**/*']).pipe(gulp.dest('public/widgets/' + component + '/' + asset));
        });
    });
});

function getFolders(dir) {
    return fs.readdirSync(dir)
        .filter(function(file) {
            return fs.statSync(path.join(dir, file)).isDirectory();
        });
}
