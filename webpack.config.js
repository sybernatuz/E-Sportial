var Encore = require('@symfony/webpack-encore');
Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')
    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.scss) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('home', './assets/js/pages/front/home.js')

    .addEntry('user_list', './assets/js/pages/front/user/list.js')
    .addEntry('user_show', './assets/js/pages/front/user/show.js')
    .addEntry('user_edit', './assets/js/pages/front/user/edit.js')
    .addEntry('user_admin_list', './assets/js/pages/back/user/list.js')
    .addEntry('user_admin_edit', './assets/js/pages/back/user/edit.js')


    .addEntry('job_list', './assets/js/pages/front/job/list.js')
    .addEntry('job_manage', './assets/js/pages/front/job/manage.js')
    .addEntry('job_edit', './assets/js/pages/front/job/edit.js')
    .addEntry('job_show', './assets/js/pages/front/job/show.js')

    .addEntry('event_list', './assets/js/pages/front/event/list.js')
    .addEntry('event_show', './assets/js/pages/front/event/show.js')

    .addEntry('game_list', './assets/js/pages/front/game/list.js')
    .addEntry('game_show', './assets/js/pages/front/game/show.js')
    .addEntry('game_admin_list', './assets/js/pages/back/game/list.js')
    .addEntry('game_admin_edit', './assets/js/pages/back/game/edit.js')
    .addEntry('game_admin_new', './assets/js/pages/back/game/new.js')

    .addEntry('team_list', './assets/js/pages/front/team/list.js')

    .addEntry('register', './assets/js/pages/front/security/register.js')


    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()
    .enableSassLoader()
    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

// uncomment if you use API Platform Admin (composer req api-admin)
//.enableReactPreset()
//.addEntry('admin', './assets/js/admin.js')
;



module.exports = Encore.getWebpackConfig();
