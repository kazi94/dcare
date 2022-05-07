const mix = require("laravel-mix");

mix.disableNotifications();

mix.js('resources/js/app.js', 'public/js');


mix.js("resources/js/gallery.js", "public/js");
if (mix.inProduction()) {
    mix.version();
}

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            '@/Components': path.resolve('resources/js/Components'),
            '@/services': path.resolve('resources/js/services'),
            '@/utils': path.resolve('resources/js/utils'),
        },
        // extensions: [".ts", ".tsx", ".js"]

    }
});
mix.browserSync("localhost:8000");
