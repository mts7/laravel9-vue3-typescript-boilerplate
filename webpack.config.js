const path = require('path');

module.exports = {
	resolve: {
		alias: {
			'@': path.resolve('resources/ts/'),
		},
		extensions: ['.vue', '.ts', '.js', '.json'],
	},
};
