const mix = require("laravel-mix");

const userName = "omaririskic";
const siteName = "guhsaiyan-current";
const TLD = "test";
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .browserSync({
        proxy: "https://" + siteName + "." + TLD,
        host: siteName + "." + TLD,
        open: "external",
        port: 8000,
        notify: false,
        https: {
            key:
                "/Users/" +
                userName +
                "/.config/valet/Certificates/" +
                siteName +
                "." +
                TLD +
                ".key",
            cert:
                "/Users/" +
                userName +
                "/.config/valet/Certificates/" +
                siteName +
                "." +
                TLD +
                ".crt"
        }
    });
