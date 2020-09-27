// vue.config.js
module.exports = {
  // options...
    devServer: {
      proxy: {
      'http://corporatecontacts.club/LAMPAPI/': {
        target: 'http://corporatecontacts.club/LAMPAPI/',
        changeOrigin: true,
        secure: false
      }
    }
  }
}