const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
	...defaultConfig,
	entry: {
		// Add the admin entry point manually
		'admin/index': path.resolve(__dirname, 'src/admin/index.js'),
		// Let wp-scripts auto-discover blocks
		...defaultConfig.entry,
	},
};
