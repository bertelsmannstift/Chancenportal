const path    = require('path');
const replace = require("replace");
const fs      = require('fs-extra');
const crypto = require('crypto');
const cssTargetPath = path.resolve(__dirname, '../packages/ui_sitepackage/Resources/Public/assets/css/');
const jsTargetPath = path.resolve(__dirname, '../packages/ui_sitepackage/Resources/Public/assets/js/');
const jsConfigPath = path.resolve(__dirname, '../packages/ui_sitepackage/Configuration/TypoScript/Page/');
const imgTargetPath = path.resolve(__dirname, '../packages/ui_sitepackage/Resources/Public/assets/images/');
const fontsTargetPath = path.resolve(__dirname, '../packages/ui_sitepackage/Resources/Public/assets/fonts/');
const distPath = path.resolve(__dirname, 'dist/js/');

/** Remove existing CSS files from target directory */
let cssTargetFiles = fs.readdirSync(cssTargetPath);
cssTargetFiles.forEach((file) => {
    fs.unlinkSync(cssTargetPath + '/' + file);
});

/** Remove existing JS files from target directory */
let jsTargetFiles = fs.readdirSync(jsTargetPath);
jsTargetFiles.forEach((file) => {
    fs.unlinkSync(jsTargetPath + '/' + file);
});

/** Copy Styles to target path */
fs.copy(path.resolve(__dirname, 'dist/css/style.css'), cssTargetPath + '/main.min.css', err => {
    replace({
        regex: 'url\\(\/',
        replacement: 'url(../',
        paths: [cssTargetPath + '/main.min.css'],
        recursive: true,
        silent: true
    });
    if (err) return console.error(err)
});

/** Copy JS files to target path */
fs.copy(path.resolve(__dirname, 'dist/js/'), jsTargetPath, err => {
    if (err) return console.error(err);

    replace({
        regex: '"js\/"',
        replacement: '"typo3conf/ext/ui_sitepackage/Resources/Public/assets/js/"',
        paths: [jsTargetPath],
        recursive: true,
        silent: true
    });
    replace({
        regex: '"fonts\/',
        replacement: '"typo3conf/ext/ui_sitepackage/Resources/Public/assets/fonts/',
        paths: [jsTargetPath],
        recursive: true,
        silent: true
    });

    /** Rename files in dist directory */
    let files = fs.readdirSync(distPath);
    files.forEach((file) => {
        let rxComponents = new RegExp('components\.', 'i');
        if(rxComponents.test(file)) {
            fs.renameSync(distPath + '/' + file, distPath + '/components.js');
        }

        let rxBuild = new RegExp('build\.', 'i');
        if(rxBuild.test(file)) {
            fs.renameSync(distPath + '/' + file, distPath + '/build.js');
        }
    });

    /** Update filenames in TYPO3 JS includes file */
    fs.readFile(jsConfigPath + '/includeJS.typoscript', 'utf8', function (err,data) {
        if (err) return console.error(err);

        let files = fs.readdirSync(jsTargetPath);
        files.forEach((file) => {
            let regexpComponents = new RegExp('components.*\.js', 'i');
            let regexpBuild = new RegExp('build\.(.*)\.js', 'i');

            if(regexpComponents.test(file)) {
                data = data.replace(/components.*\.js.*/g, file);
            }

            if(regexpBuild.test(file)) {
                data = data.replace(/build.*\.js.*/g, file);
            }
        });

        fs.writeFile(jsConfigPath + '/includeJS.typoscript', data, 'utf8', function (err) {
            if (err) return console.log(err);
        });
    });

    /** Update filenames in TYPO3 CSS includes file */
    fs.readFile(jsConfigPath + '/includeCSS.typoscript', 'utf8', function (err,data) {
        if (err) return console.error(err);

        fs.createReadStream(cssTargetPath + '/main.min.css').pipe(crypto.createHash('md5').setEncoding('hex')).on('finish', function () {
            let hash = this.read();

            fs.renameSync(cssTargetPath + '/main.min.css', cssTargetPath + '/main.min.'+hash+'.css');
            data = data.replace(/main\.min.*\.css.*/g, 'main.min.'+hash+'.css');

            fs.writeFile(jsConfigPath + '/includeCSS.typoscript', data, 'utf8', function (err) {
                if (err) return console.log(err);
            });
        });
    });
});

/** Copy assets to target paths */
fs.copy(path.resolve(__dirname, 'dist/img/'), imgTargetPath, err => {
    if (err) return console.error(err)
});

fs.copy(path.resolve(__dirname, 'dist/fonts/'), fontsTargetPath, err => {
    if (err) return console.error(err)
});
