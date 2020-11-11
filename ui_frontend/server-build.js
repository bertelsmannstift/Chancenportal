const path = require('path');
const fs = require('fs');
const shell = require('shelljs');
const recursive = require("recursive-readdir-synchronous");
const pretty = require('pretty');
const files = recursive(path.join(__dirname, 'src', 'backend/pages'));
const request = require('request');
const backendPages = path.join(__dirname, 'src', 'backend/pages');
const assets = path.join(__dirname, 'assets');
const output = path.join(__dirname, 'dist');
const rmunusedcss = require('rm-unused-css');
const purify = require("purify-css");
const cssPurge = require('css-purge');
const clean = [
    new RegExp('\\s+data-vuexpress-meta="lang"', "ig"),
    new RegExp('\\s+data-vuexpress-meta="true"', "ig"),
    new RegExp('\\s+data-server-rendered="true"', "ig"),
    new RegExp('\\s+data-body="true"', "ig"),
    new RegExp('\\s+data-vuexpress-meta=""', "ig"),
    new RegExp('<link rel="stylesheet" href="/css/components.css" />', "ig"),
];

async function makeReq(uri) {
    return new Promise((resolve, reject)=>{
        request(uri, function (error, response, body) {
            resolve(body);
        });
    })
}

module.exports = async function () {

// delete old dist
    shell.rm('-R', output);

// Copy all files
    shell.cp('-R', assets, output);
    shell.rm('-R', path.join(output, 'css') + '/*.*');

    let doneCount = 0;
    let mergedPageStyles = '';

    for (let j in files) {
        let file = files[j];
        let sPath = file.replace(backendPages, '').replace('.vue', '.html');

        if (sPath.indexOf('.html') > -1) {
            let body = await makeReq('http://localhost:3001' + sPath);
            let styleCss = await makeReq('http://localhost:3001/css/style.css');

            // Prettify HTML output
            body = pretty(body, {ocd: true});

            // Clean vue server renderer tags
            let filePath = path.join(output, sPath);
            shell.mkdir('-p', path.dirname(filePath));
            for (let i in clean) {
                body = body.replace(clean[i], '');
            }

            if (sPath.indexOf('index') < 0) {
                // merge page css with all styles
                let styles = styleCss;
                // only add new styles
                if (mergedPageStyles.indexOf(styles) < 0) {
                    mergedPageStyles += styles;
                }
            }

            fs.writeFileSync(filePath, body);
            doneCount++;

            // check if we are done
            if (doneCount === files.length) {
                // Copy only compressed css
                let styleFile = path.join(output, 'css', 'style.css');
                let componentsCss = fs.readFileSync(path.join(assets, 'css', 'components.css')).toString();

                /*
                  fs.writeFileSync(styleFile, componentsCss + mergedPageStyles);
                  process.exit();
                  */
                cssPurge.purgeCSS(mergedPageStyles, {
                    "trim": false,
                    "shorten": false,
                    "bypass_media_rules": true,
                    "bypass_document_rules": true,
                    "bypass_supports_rules": true,
                    "bypass_page_rules": true,
                    "bypass_charset": true,
                    "trim_keep_non_standard_inline_comments": false,
                    "trim_removed_rules_previous_comment": false,
                    "trim_comments": false,
                    "trim_whitespace": false,
                    "trim_breaklines": false,
                    "trim_last_semicolon": false,
                    "shorten_zero": false,
                    "shorten_hexcolor": false,
                    "shorten_hexcolor_extended_names": false,
                    "shorten_hexcolor_UPPERCASE": false,
                    "shorten_font": false,
                    "shorten_background": false,
                    "shorten_margin": false,
                    "shorten_padding": false,
                    "shorten_list_style": false,
                    "shorten_outline": false,
                    "shorten_border": false,
                    "shorten_border_top": false,
                    "shorten_border_right": false,
                    "shorten_border_bottom": false,
                    "shorten_border_left": false,
                    "shorten_border_radius": false,
                    "format": false,
                    "format_4095_rules_legacy_limit": false,
                    "format_font_family": false,
                    "special_convert_rem": false,
                    "special_convert_rem_font_size": false
                }, function (error, result) {

                    purify(['./dist/**/*.html', './dist/**/*.js'], componentsCss + result, {minify: true}, function (purifiedResult) {
                        fs.writeFileSync(styleFile, purifiedResult);
                        process.exit();
                    });
                });
            }
        } else {
            doneCount++;
        }
    }
};
