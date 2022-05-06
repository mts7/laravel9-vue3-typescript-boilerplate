const path = require('path');

module.exports = {
	module: {
		rules: [
			{
				test: /\.pug$/,
				loader: 'pug-plain-loader',
			},
		],
	},
	resolve: {
		alias: {
			'@': path.resolve('resources/ts/'),
		},
		extensions: ['.vue', '.ts', '.js', '.json'],
	},
};
