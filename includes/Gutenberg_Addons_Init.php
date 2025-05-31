<?php

namespace GutenbergAddons;

defined('ABSPATH') || exit;

class Gutenberg_Addons_Init {

    public function __construct() {
        add_action('init', [$this, 'register_blocks']);
        add_action('admin_menu', [$this, 'register_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('enqueue_block_editor_assets', [$this, 'enqueue_block_assets']);
        add_action('rest_api_init', [$this, 'register_rest_routes']);
    }

    /**
     * Register Gutenberg blocks from src directory.
     */
    public function register_blocks() {
        $blocks = ['my-block-1', 'my-block-2']; // Add more as needed

        foreach ($blocks as $block) {
            register_block_type(
                plugin_dir_path(__DIR__) . "../src/{$block}/block.json"
            );
        }
    }

    /**
     * Register the admin settings page.
     */
    public function register_admin_menu() {
        add_menu_page(
            __('Gutenberg Addons', 'gutenberg-addons'),
            __('Gutenberg Addons', 'gutenberg-addons'),
            'manage_options',
            'gutenberg-addons-settings',
            [$this, 'render_admin_page'],
            'dashicons-admin-generic'
        );
    }

    /**
     * Output container for React admin app.
     */
    public function render_admin_page() {
        echo '<div class="wrap"><div id="gutenberg-addons-settings"></div></div>';
    }

    /**
     * Enqueue admin settings page React app.
     */
    public function enqueue_admin_assets($hook) {
        if ($hook !== 'toplevel_page_gutenberg-addons-settings') {
            return;
        }

        wp_enqueue_script(
            'gutenberg-addons-admin',
            plugin_dir_url(__DIR__) . 'build/admin/index.js',
            ['wp-element', 'wp-api-fetch'],
            filemtime(plugin_dir_path(__DIR__) . 'build/admin/index.js'),
            true
        );

        wp_localize_script('gutenberg-addons-admin', 'GA_Settings', [
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
        ]);
    }

    /**
     * Enqueue block editor assets.
     */
    public function enqueue_block_assets() {
        // Optional: for custom shared styles or JS
        wp_enqueue_style(
            'gutenberg-addons-block-style',
            plugin_dir_url(__DIR__) . 'build/style-index.css',
            [],
            filemtime(plugin_dir_path(__DIR__) . 'build/style-index.css')
        );
    }

    /**
     * Register custom REST API routes.
     */
    public function register_rest_routes() {
        register_rest_route('gutenberg-addons/v1', '/settings', [
            [
                'methods' => \WP_REST_Server::READABLE,
                'callback' => [$this, 'get_settings'],
                'permission_callback' => [$this, 'can_manage_options'],
            ],
            [
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => [$this, 'save_settings'],
                'permission_callback' => [$this, 'can_manage_options'],
            ],
        ]);
    }

    public function get_settings() {
        return get_option('gutenberg_addons_settings', []);
    }

    public function save_settings($request) {
        $data = $request->get_json_params();
        update_option('gutenberg_addons_settings', $data);
        return rest_ensure_response(['success' => true, 'data' => $data]);
    }

    public function can_manage_options() {
        return current_user_can('manage_options');
    }
}
