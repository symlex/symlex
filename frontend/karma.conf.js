const path = require('path');

// See https://github.com/webpack/loader-utils/issues/56
process.noDeprecation = true;

const puppeteer = require('puppeteer');
process.env.CHROME_BIN = puppeteer.executablePath();

module.exports = (config) => {
    const tests = 'tests/*/*.test.js';

    config.set({
        frameworks: ['mocha'],

        phantomjsLauncher: {
            // Have phantomjs exit if a ResourceError is encountered (useful if karma exits without killing phantom)
            exitOnResourceError: false
        },

        browsers: ['ChromeHeadlessDocker'],
        customLaunchers: {
            'ChromeHeadlessDocker': {
                base: 'ChromeHeadless',
                flags: [
                    // We must disable the Chrome sandbox when running Chrome inside Docker (Chrome's sandbox needs
                    // more permissions than Docker allows by default)
                    // Also: https://github.com/GoogleChrome/puppeteer/issues/560
                    '--no-sandbox',
                    '--disable-setuid-sandbox',
                    '--disable-web-security'
                ],
            },
        },
        files: [
            {pattern: 'tests/**/*_test.js', watched: false}
        ],

        // Preprocess through webpack
        preprocessors: {
            'tests/**/*_test.js': ['webpack']
        },

        reporters: ['progress', 'html'],

        htmlReporter: {
            outputFile: 'tests/result.html'
        },

        webpack: {
            resolve: {
                modules: [
                    path.join(__dirname, 'src'),
                    path.join(__dirname, 'node_modules'),
                    path.join(__dirname, 'tests'),
                ],
                alias: {
                    vue: 'vue/dist/vue.js'
                }
            },
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        loader: 'babel-loader',
                        query: {
                            presets: ['es2015']
                        },
                    },
                ]
            }
        },

        singleRun: true,
    });
};