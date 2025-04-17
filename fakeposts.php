<?php

/*
 * Plugin Name: FakePosts
 * Plugin URI: https://wordpress.org/plugins/superbot/
 * Description: Test wordpress plugin , built on the use cases to fultil the dummy content generatino for the cms & ecommerce projects.
 * Version: 1.0.0
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Shimanta Das
 * Author URI: https://microcodes.in/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * Text Domain: fke_post
 */

 if (!defined('ABSPATH')) {
    exit("You are restricted from accessing this page!");
}

require_once 'functions.php';

/**
 * Enqueue plugin assets (CSS & JS)
 */
function fke_post_enqueue_assets()
{
    // Enqueue Styles
    wp_enqueue_style('fke_post-material-icons-outlined', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0', [], null);
    wp_enqueue_style('fke_post-material-icons-rounded', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0', [], null);
    wp_enqueue_style('fke_post-bootstrap-icons-css', "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css", [], '1.0.0');
    wp_enqueue_style('fke_post-bootstrap-css', plugins_url('assets/css/bootstrap.min.css', __FILE__), [], '1.0.0');
    wp_enqueue_style('fke_post-custom-css', plugins_url('assets/css/custom.css', __FILE__), [], '1.0.0');
    wp_enqueue_style('fke_post-style-css', plugins_url('assets/css/style.css', __FILE__), [], '1.0.0');

    // Enqueue Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('fke_post-bootstrap-bundle-js', plugins_url('assets/js/bootstrap.bundle.min.js', __FILE__), ['jquery'], '1.0.0', true);
    wp_enqueue_script('fke_post-script-js', plugins_url('assets/js/script.js', __FILE__), ['jquery'], '1.0.0', true);

    // Pass AJAX URL to scripts
    wp_localize_script('fke_post-script-js', 'fke_post_ajax', [ 'ajax_url' => admin_url('admin-ajax.php') ]);
}
add_action('wp_enqueue_scripts', 'fke_post_enqueue_assets');


/**
 * Plugin Activation Hook - Creates necessary tables
 */
function fke_post_activate()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $tables = [
        'fke_post_chats' => "(
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            question VARCHAR(250) NOT NULL,
            answer LONGTEXT NOT NULL,
            PRIMARY KEY (id)
        )",

        'fke_post_chat_terms' => "(
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            chatid INT NOT NULL,
            tag VARCHAR(50) NOT NULL,
            PRIMARY KEY (id)
        )",

        'fke_post_chat_history' => "(
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            query VARCHAR(200) NOT NULL,
            gemini_reply LONGTEXT NOT NULL,
            ip_address VARCHAR(50) NULL,
            location VARCHAR(200) NULL,
            date VARCHAR(50) NOT NULL,
            PRIMARY KEY (id)
        )",

        'fke_post_chat_global_settings' => "(
            id BIGINT(20) NOT NULL AUTO_INCREMENT,
            gemini_key VARCHAR(200) NULL,
            contact_us_link VARCHAR(200) NULL,
            business_name VARCHAR(200) NULL,
            business_description VARCHAR(250) NULL,
            restriction VARCHAR(200) NULL,
            PRIMARY KEY (id)
        )"
    ];

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    foreach ($tables as $table => $schema) {
        $table_name = $wpdb->prefix . $table;
        if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) != $table_name) {
            $sql = "CREATE TABLE $table_name $schema $charset_collate;";
            dbDelta($sql);
        }
    }
}
register_activation_hook(__FILE__, 'fke_post_activate');

/**
 * Add plugin menu to admin panel
 */
function fke_post_activate_pages_register()
{
    $plugin_slug = "fke_post_admin";
    add_menu_page('Fake Posts', 'Fake Posts', 'edit', $plugin_slug, null, plugins_url('icon.png', __FILE__), 58);
    add_submenu_page($plugin_slug, 'Dashboard', 'Dashboard', 'manage_options', 'fke_posts_dashboard', 'fke_posts_dashboard_function');
    add_submenu_page($plugin_slug, 'Generate Posts', 'Generate Posts', 'manage_options', 'fke_posts_generate_post', 'fke_posts_generate_post_function');
    add_submenu_page($plugin_slug, 'Remove Posts', 'Remove Posts', 'manage_options', 'fke_posts_remove_post', 'fke_posts_remove_post_function');
}
add_action('admin_menu', 'fke_post_activate_pages_register');

/**
 * Include Admin Pages
 */
function fke_posts_dashboard_function() { require plugin_dir_path(__FILE__) . 'admin/dashboard.php'; }
function fke_posts_generate_post_function() { require plugin_dir_path(__FILE__) . 'admin/generate.php'; }
function fke_posts_remove_post_function() { require plugin_dir_path(__FILE__) . 'admin/removal.php'; }

?>