// webpack.config.js
module.exports = {
  vue: {
    postcss: [require('autoprefixer')()],
    autoprefixer: true
  }
}
