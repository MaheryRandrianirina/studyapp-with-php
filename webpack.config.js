const path = require('path')
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const miniCssExtractPlugin = require('mini-css-extract-plugin')
const { WebpackManifestPlugin } = require('webpack-manifest-plugin')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')

const dev = process.env.NODE_ENV === "dev"

let cssLoaders = [
    dev ? "style-loader" : miniCssExtractPlugin.loader,
    { loader: "css-loader", options : { importLoaders: 1}}
]

if(!dev){
    cssLoaders.push(
        { 
            
            loader: "postcss-loader", 
            options : {
                postcssOptions: {
                    plugins: (loader) =>[
                        require('autoprefixer')({
                            browsers: ['last 2 versions', 'ie > 6']
                        })
                     ]
                }
                    
            }
        
        }
    )
}

let config = {
    entry: {
        home: "./src/home.js",
        login: "./src/login.js",
        register: "./src/register.js"
    },
    watch: dev,
    output: {
        path: path.resolve(__dirname, 'public/assets'),
        filename: dev ? '[name].js' : '[name].[chunkhash].js',
        clean: !dev ? true : false
    },
    devtool: dev ? "eval-cheap-module-source-map" : false,
    
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.css$/,
                use: cssLoaders
            },
            {
                test: /\.scss$/,
                use: [...cssLoaders, "sass-loader"]
            },
            {
                test: /\.(png|jpg|jpeg|gif|otf)$/,
                type: 'asset/resource'
            }
            
        ]
    },
    plugins: [
        new miniCssExtractPlugin({
            filename: dev ? '[name].css' : '[name].[contenthash:8].css',
            chunkFilename: dev ? '[id].css' : '[id].[contenthash:8].css'
        })
        
    ]
}

if(!dev){
    config.plugins.push(new UglifyJsPlugin({
        sourceMap: false
    }))

    config.plugins.push(new WebpackManifestPlugin())
    config.plugins.push(new CleanWebpackPlugin({
        root: path.resolve('./'),
        verbose: true,
        dry: false
    }))
}
module.exports = config