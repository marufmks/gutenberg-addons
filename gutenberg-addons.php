<?php
/**
 * Plugin Name: Gutenberg Addons
 * Description: A custom Gutenberg block and admin settings plugin.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;

use GutenbergAddons\Gutenberg_Addons_Init;

require_once __DIR__ . '/includes/Gutenberg_Addons_Init.php';

function gutenberg_addons_run() {
    new Gutenberg_Addons_Init();
}
add_action('plugins_loaded', 'gutenberg_addons_run');

