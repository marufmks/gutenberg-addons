import { render } from '@wordpress/element';
import App from './app';

window.addEventListener('DOMContentLoaded', () => {
	const root = document.getElementById('gutenberg-addons-settings');
	if (root) {
		render(<App />, root);
	}
});
