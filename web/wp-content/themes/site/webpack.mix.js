const {mix} = require('laravel-mix');
const fs = require('fs-extra');

// Clean up old build

fs.removeSync(__dirname + '/build/');

// public path behavior is messed up. DO NOT SET
// !!! @todo submit bug/patch for this

mix.options({
    //publicPath: 'docroot'
});

// Extra Webpack config

mix.webpackConfig({
    externals: {
        jquery: 'jQuery'
    }
});

// Javascript Bundles

mix.js('resources/js/site.js', 'build/js/site.js');

// SCSS Bundles

mix.sass('resources/scss/styles.scss', 'build/css/styles.css')
    .options({
        processCssUrls: false
    });

// Sourcemaps

mix.sourceMaps();

// BrowserSync

// mix.browserSync({
//     proxy: 'localhost',
//     files: [
//         'build/**/*',
//         'template/**/*',
//         '*.php'
//     ]
// });

// Version Files (For Prod)

if (mix.config.inProduction) {
    mix.version();
}
