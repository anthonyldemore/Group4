// vue.config.js
module.exports = {
  // options...
  devServer: {
    proxy: {
      '/api': {
        target: 'http://corporatecontacts.club/LAMPAPI',
        pathRewrite: { '^/api': '' },
        changeOrigin: true,
        secure: false
      }
    }
  }
}