const path = require('path');
const fs = require('fs');
const serverBuild = require('./server-build.js');
const recursive = require("recursive-readdir-synchronous");
const webpackMerge = require('webpack-merge');
const mixinFiles = recursive(path.join(__dirname, 'src', 'backend/mixins'));
const backendFiles = recursive(path.join(__dirname, 'src', 'backend/components'));
const frontendFiles = recursive(path.join(__dirname, 'src', 'frontend/components'));
let tplPath = path.join(__dirname, 'src', 'backend/pages');
let serverFileChange = false;
let doRender = true;
let instance = null;
let currentWatchFile = null;

// load mixins
let mixins = [];
mixinFiles.forEach((file) => {
    mixins.push(require(file));
});

let options = {
    views: tplPath,
    cache: false,
    watch: true,
    watchCleanUp: process.env.NODE_ENV !== 'production',
    mixins: mixins,
    sassResources: '@import "' + path.join(__dirname, 'src', 'styles') + '/component-globals";',
    metaInfo: webpackMerge.smart({
        link: [
            {
                rel: 'stylesheet',
                href: '/css/components.css'
            }
        ],
        script: [
            {
                type: 'text/javascript',
                src: '/js/build.js',
                async: true,
                body: true
            },
        ],
    }, require('./head')),
    watchCallback: (stats) => {
        serverFileChange = !doRender;
    },
    beforeEndCallback: () => {
        doRender = false;
    },
    cssOutputPath: '/css/style.css',
    publicPath: path.join(__dirname, 'assets'),
    compilerConfig: {
        devtool: process.env.NODE_ENV === 'production' ? '' : 'source-map',
    },
    compilerConfigCallback: function (config) {
        config.resolve = {
            extensions: ['*', '.js', '.vue', '.json', '.scss', '.css'],
            alias: {
                assets: path.resolve(__dirname, 'src/assets'),
            }
        };
        config.module.rules.push({
            test: /\.(png|jpg|gif|svg)$/,
            loader: 'file-loader',
            options: {
                name: '[path][name].[ext]',
                outputPath: 'assets/',
                publicPath: '/',
                context: __dirname,
                emitFile: false
            }
        });
        return config;
    },
    onError: (err) => {
        console.log(err.errors);
        console.log('Please restarting the process!');
    }
};

function noCache(req, res, next) {
    res.header('Cache-Control', 'private, no-cache, no-store, must-revalidate');
    res.header('Expires', '-1');
    res.header('Pragma', 'no-cache');
    next();
}

function startServer() {
    let express = require('express');
    let vueRenderer = require('@doweb/vuexpress').vueRenderer;
    let renderer = new vueRenderer(options);
    let app = express();

    app.use(renderer);
    app.use(noCache);

    app.get('/index.html', function (req, res, next) {
        currentWatchFile = req.url;
        res.render('index', {}, {inlineCSS: true});
    });

    app.get('*.html', function (req, res) {
        currentWatchFile = req.url;
        doRender = true;
        let reqPath = req.path;
        reqPath = reqPath.substr(1).replace('.html', '');
        res.render(reqPath);
    });

    app.get('/backend/*.vue', function (req, res) {
        currentWatchFile = req.url;
        let vueFile = backendFiles.find(file => path.basename(file) === path.basename(req.path));
        res.render(vueFile.replace('.vue', ''));
    });

    app.get('/frontend/*.vue', function (req, res) {
        currentWatchFile = req.url;
        let vueFile = frontendFiles.find(file => path.basename(file) === path.basename(req.path));
        let component = path.basename(vueFile).replace('.vue', '');
        res.render('render', {component: component.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase()});
    });

    app.get('/', function (req, res, next) {
        res.redirect('/index.html');
    });

    app.get('/__server_hot.json', function (req, res, next) {
        res.json({reload: serverFileChange || currentWatchFile !== req.query.url});
        serverFileChange = false;
        currentWatchFile = req.query.url;
    });

    app.use(express.static(path.join(__dirname, 'assets')));

    instance = app.listen(3001, function () {
        if (process.argv.slice(2)[0] === '--build') {
            console.log('Starting server build...');
            setTimeout(serverBuild, 5000);
        } else {
            console.log('App listening on port 3000!');
        }
    });
}

startServer();
