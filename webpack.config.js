const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = [
  {
    ...defaultConfig,
    entry: {
      admin: './src/admin/index.js',
    },
    output: {
      path: path.resolve(__dirname, 'build'),
      filename: '[name].js',
    },
  },
  {
    ...defaultConfig,
    entry: {
      'service-card/index': './src/blocks/service-card/index.js',
      'testimonial/index': './src/blocks/testimonial/index.js',
    },
    output: {
      path: path.resolve(__dirname, 'build/blocks'),
      filename: '[name].js',
    },
  },
];
