module.exports = function (api){
    api.cache(true)
    
    const presets = [
        ['@babel/preset-env', {
            modules: false,
            targets: {
                browsers: ['last 2 versions', 'ie > 8']  
            }
            
        }]
    ]

    const plugins = ['syntax-dynamic-import']

    return {
        presets,
        plugins
    }
}