var path = require('path');

var root = __dirname;
var gsapPath = "/node_modules/gsap/src/uncompressed/";
var scrollPath = "/node_modules/scrollmagic/scrollmagic/uncompressed/"
var webpack = require('webpack');
var optimize = webpack.optimize;
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    entry: {
        bundle: './src/js/index.js',
        //vendor: ['jquery']
    },

    output: {
        path: path.join(__dirname, 'dist'),
        filename: 'js/[name].[chunkhash].js',
    },

    module: {
        rules: [
            
            {
                test: /\.js$/,
                exclude: ['./node-modules', './src/js/donotcompile.js'],
                use: ['babel-loader']
            },
            
            {
                test: /\.scss$/, 
                    use: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: ['css-loader', 'sass-loader'],
                        publicPath: '/dist/css'    
                    })
            },

            {
                test: /\.(jpg|png|gif)/,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 35000,
                        }
                    },
                    'image-webpack-loader'
                ]
            }
            
        ]
    },

    plugins: [
        new ExtractTextPlugin({
            filename: 'app.css',
            //disabled: false,
            allChunks: true
        }),

        new optimize.UglifyJsPlugin(),
        /*new optimize.CommonsChunkPlugin({
            name: ['vendor', 'manifest']
        }),*/

        new HtmlWebpackPlugin({
            template: './src/index-boot.html'
        })

    ],

    externals: {
        'scrollmagic': 'ScrollMagic',
        'jquery' : 'jQuery',
    },

    devServer: {
        contentBase: path.join(__dirname, "/dist"),
        compress: true,
        port: 9000,
        stats: "errors-only",
        open: true,
        hotOnly: true
    },
}