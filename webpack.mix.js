const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/assets/js')
    .react()
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.jsx?$/,
                    loader: 'esbuild-loader',
                    options: {
                        loader: 'jsx', // use the JSX loader
                        target: 'es2015' // specify compilation target
                    }
                }
            ]
        },
        resolve: {
            extensions: ['.js', '.jsx']
        }
    });

