<?php
namespace Gutenberg_Addons\Rest;

class  Settings_Api{
    public static function register_routes() {
        register_rest_route('gutenberg-addons/v1', '/settings', [
            [
                'methods' => 'GET',
                'callback' => [self::class, 'get_settings'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ],
            [
                'methods' => 'POST',
                'callback' => [self::class, 'save_settings'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ],
        ]);
    }

    public static function get_settings() {
        return get_option('gutenberg_addons_settings', []);
    }

    public static function save_settings($request) {
        $params = $request->get_json_params();
        update_option('gutenberg_addons_settings', $params);
        return ['success' => true];
    }
}

add_action('rest_api_init', ['Gutenberg_Addons\Rest\Settings_API', 'register_routes']);
