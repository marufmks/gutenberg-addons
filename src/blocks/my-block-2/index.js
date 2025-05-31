import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import Save from './save';

registerBlockType('gutenberg-addons/my-block-2', {
  edit: Edit,
  save: Save,
});
