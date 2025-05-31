# Gutenberg Addons

**Contributors:** your-name  
**Tags:** gutenberg, blocks, editor, react, admin  
**Requires at least:** 6.0  
**Tested up to:** 6.5  
**Requires PHP:** 7.4  
**Stable tag:** 1.0.0  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

Gutenberg Addons is a modular WordPress plugin that provides custom Gutenberg blocks and an admin settings panel built with React and the REST API.

## Features

- Multiple custom Gutenberg blocks
- React-based admin settings page
- REST API integration for saving settings
- Clean PSR-4 OOP architecture
- Dynamic block loading via `block.json`

## Included Blocks

- **My Block 1** (`gutenberg-addons/my-block-1`)
- **My Block 2** (`gutenberg-addons/my-block-2`)

*Additional blocks can be added in the `/src/` directory easily*

## Plugin Structure

```
gutenberg-addons/
├── includes/
│   └── Gutenberg_Addons_Init.php
├── src/
│   ├── my-block-1/
│   ├── my-block-2/
│   └── admin/
├── build/
│   ├── admin.js
│   ├── my-block-1.js
│   └── my-block-2.js
├── gutenberg-addons.php
├── package.json
└── README.md
```

## Development

### Requirements

- Node.js ≥ 16.x
- NPM
- WordPress environment (local or remote)

### Install Dependencies

```bash
npm install
```

### Start Development

```bash
npm start
```

This compiles:
- Admin app → `build/admin.js`
- Blocks → `build/my-block-1.js`, `build/my-block-2.js`, etc.

### Build for Production

```bash
npm run build
```

## Registering Blocks

Each block lives in its own folder under `src/` with a `block.json` file.

The `Gutenberg_Addons_Init` class automatically registers blocks:

```php
$blocks = ['my-block-1', 'my-block-2'];
foreach ( $blocks as $block ) {
    register_block_type( plugin_dir_path( __DIR__ ) . "/src/{$block}/block.json" );
}
```

## Admin Settings Page

- Available under **Dashboard → Gutenberg Addons**
- React-powered interface
- Saves and loads settings via REST API at `/wp-json/gutenberg-addons/v1/settings`

## REST API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/wp-json/gutenberg-addons/v1/settings` | Get saved settings |
| POST | `/wp-json/gutenberg-addons/v1/settings` | Save new settings |

## PSR-4 Autoloading (Optional)

Configure Composer for PSR-4 autoloading:

```json
{
  "autoload": {
    "psr-4": {
      "GutenbergAddons\\": "includes/"
    }
  }
}
```

Then run:

```bash
composer dump-autoload
```

Include the autoloader in `gutenberg-addons.php`.

## License

This plugin is licensed under the GPLv2 or later. See the [LICENSE](LICENSE) file for more information.

## Credits

Built with ❤️ using the [@wordpress/scripts](https://www.npmjs.com/package/@wordpress/scripts) toolkit.

## Support

Have issues or feature requests? Please open an issue or contact the maintainer.