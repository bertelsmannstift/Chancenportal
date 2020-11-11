const path = require('path');
const autoprefixer = require('autoprefixer');
const webpack = require('webpack');
const {VueLoaderPlugin} = require('vue-loader');
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const assets = path.join(__dirname, 'assets');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const WriteFilePlugin = require('write-file-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin')
const shell = require('shelljs');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const extractText = new MiniCssExtractPlugin({
    filename: 'css/[name].css',
});

// remove js files
shell.rm(path.join(assets, 'js') + '/*');

module.exports = {
    context: path.resolve(__dirname, 'src', 'frontend'),
    entry: {
        main: [
            './../styles/main.scss',
            './js/main.js',
            'jquery',
        ],
    },
    optimization: {
        splitChunks: {
            cacheGroups: {
                components: {
                    name: 'components',
                    test: m => {
                        return /\.vue\?vue&type=style/.test(m.identifier()) || m.constructor.name === "CssModule";
                    },
                    chunks: 'all',
                    enforce: true
                }
            }
        }
    },
    output: {
        path: path.resolve(__dirname, 'assets'),
        publicPath: '/',
        filename: process.env.NODE_ENV === 'production' ? 'js/build.[chunkhash].js' : 'js/build.js',
        chunkFilename: process.env.NODE_ENV === 'production' ? 'js/[name].[chunkhash].js' : 'js/[name].js',
    },
    mode: process.env.NODE_ENV === 'production' ? 'production' : 'development',
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    process.env.NODE_ENV !== 'production'
                        ? {
                            loader: 'vue-style-loader',
                            options: {
                                sourceMap: true,
                                minimize: false,
                            }
                        }
                        : MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {sourceMap: true, importLoaders: 1}
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            sourceMap: true,
                            ident: 'postcss',
                            plugins: (loader) => [
                                require('postcss-cssnext')()
                            ]
                        }
                    }
                ]
            },
            {
                test: /\.scss$/,
                use: [
                    process.env.NODE_ENV !== 'production'
                        ? {
                            loader: 'vue-style-loader',
                            options: {
                                sourceMap: true,
                                minimize: false,
                            }
                        }
                        : MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            importLoaders: 1,
                            sourceMap: process.env.NODE_ENV !== 'production',
                            minimize: process.env.NODE_ENV === 'production'
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            sourceMap: true,
                            ident: 'postcss',
                            plugins: (loader) => [
                                require('postcss-cssnext')()
                            ]
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            data: '@import "' + path.resolve(__dirname, 'src/styles/component-globals') + '";',
                            sourceMap: true
                        }
                    }
                ]
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: file => (
                    /node_modules/.test(file) &&
                    !/\.vue\.js/.test(file)
                )
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: 'img/[name].[ext]',
                }
            },
            {
                test: /\.(woff2?|woff|eot|ttf|otf)(\?.*)?$/,
                loader: 'file-loader',
                options: {
                    name: 'fonts/[name].[hash:7].[ext]',
                }
            }
        ]
    },
    devServer: {
        proxy: {
            '**': 'http://localhost:3001',
            logLevel: 'debug'
        },
        port: 3000,
        host: '0.0.0.0',
        hot: process.env.NODE_ENV !== 'production'
    },
    resolve: {
        extensions: ['*', '.js', '.vue', '.json', '.scss', '.css'],
        alias: {
            jquery: "jquery/src/jquery",
            assets: path.resolve(__dirname, 'src/assets'),
        }
    },
    performance: {
        hints: false
    },
    devtool: process.env.NODE_ENV === 'production' ? '' : 'source-map',
    plugins: [
        new VueLoaderPlugin(),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        }),
        extractText,
        new CleanWebpackPlugin(path.resolve(__dirname, 'assets'), {watch: true, exclude: 'css'}),
        new CopyWebpackPlugin([
            {from: '**/*', to: path.resolve(__dirname, 'assets'), context: path.resolve(__dirname, 'src', 'assets')}
        ], {copyUnmodified: true}),
        new WriteFilePlugin()
        // new BundleAnalyzerPlugin()
    ]
};

if (process.env.NODE_ENV === 'production') {
    // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([

        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: '"production"'
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true
        })
    ])
}
