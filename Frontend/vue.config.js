//vue.config.js
module.exports = {
    //pages will correspond to the Views in our MVC controller
    pages: {
      //Main/Index
      index: {
        // entry for the page
        entry: 'src/pages/Main/main.js',
        // the source template
        template: 'public/index.html',
        // output as dist/index.html
        //filename: 'index.html',
        // when using title option,
        // template title tag needs to be <title><%= htmlWebpackPlugin.options.title %></title>
        title: 'TwitchCord',
        // chunks to include on this page, by default includes
        // extracted common chunks and vendor chunks.
        chunks: ['chunk-vendors', 'chunk-common', 'index']
      },
      //User/Signin
      signin: {
        entry: 'src/pages/SignIn/main.js',
        template: 'public/index.html',
        title: 'Sign Up',
        chunks: ['chunk-vendors', 'chunk-common', 'signin']
      }
    },
    filenameHashing: false,
    publicPath: './Vue/',
    outputDir: '../Public/Vue',
    configureWebpack: {
        output: {
          filename: '[name].js',
          chunkFilename: '[name].js'
        }
    },
  }