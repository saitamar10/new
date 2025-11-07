<?php
/**
 * TGM Plugin Activation Configuration
 *
 * To use this feature, download the TGM Plugin Activation class from:
 * http://tgmpluginactivation.com/
 *
 * Place the class-tgm-plugin-activation.php file in the /inc/ directory
 *
 * @package OneNav Pro
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register required and recommended plugins
 */
function onenav_register_required_plugins() {
    /**
     * Array of plugin arrays. Required keys: name, slug
     * Optional keys: version, is_callable, required, recommended, force_activation, force_deactivation
     */
    $plugins = array(
        // Advanced Custom Fields (Recommended)
        array(
            'name' => 'Advanced Custom Fields',
            'slug' => 'advanced-custom-fields',
            'required' => false,
            'recommended' => true,
        ),

        // Kirki Customizer Framework (Recommended)
        array(
            'name' => 'Kirki Customizer Framework',
            'slug' => 'kirki',
            'required' => false,
            'recommended' => true,
        ),

        // WP-Optimize (Optional)
        array(
            'name' => 'WP-Optimize',
            'slug' => 'wp-optimize',
            'required' => false,
            'recommended' => false,
        ),

        // Regenerate Thumbnails (Optional)
        array(
            'name' => 'Regenerate Thumbnails',
            'slug' => 'regenerate-thumbnails',
            'required' => false,
            'recommended' => false,
        ),
    );

    /**
     * Array of configuration settings
     */
    $config = array(
        'id' => 'onenav-pro',
        'default_path' => '',
        'menu' => 'tgmpa-install-plugins',
        'parent_slug' => 'themes.php',
        'capability' => 'edit_theme_options',
        'has_notices' => true,
        'dismissable' => true,
        'dismiss_msg' => '',
        'is_automatic' => false,
        'message' => '',
        'strings' => array(
            'page_title' => esc_html__('Install Required Plugins', 'onenav-pro'),
            'menu_title' => esc_html__('Install Plugins', 'onenav-pro'),
            'installing' => esc_html__('Installing Plugin: %s', 'onenav-pro'),
            'updating' => esc_html__('Updating Plugin: %s', 'onenav-pro'),
            'oops' => esc_html__('Something went wrong with the plugin API.', 'onenav-pro'),
            'notice_can_install_required' => _n_noop(
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'onenav-pro'
            ),
            'notice_can_install_recommended' => _n_noop(
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'onenav-pro'
            ),
            'notice_ask_to_update' => _n_noop(
                'The following plugin needs to be updated to its latest version: %1$s.',
                'The following plugins need to be updated to their latest version: %1$s.',
                'onenav-pro'
            ),
            'notice_ask_to_update_maybe' => _n_noop(
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'onenav-pro'
            ),
            'notice_can_activate_required' => _n_noop(
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'onenav-pro'
            ),
            'notice_can_activate_recommended' => _n_noop(
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'onenav-pro'
            ),
            'install_link' => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'onenav-pro'
            ),
            'update_link' => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'onenav-pro'
            ),
            'activate_link' => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'onenav-pro'
            ),
            'return' => esc_html__('Return to Required Plugins Installer', 'onenav-pro'),
            'plugin_activated' => esc_html__('Plugin activated successfully.', 'onenav-pro'),
            'activated_successfully' => esc_html__('The following plugin was activated successfully:', 'onenav-pro'),
            'plugin_already_active' => esc_html__('No action taken. Plugin %1$s was already active.', 'onenav-pro'),
            'plugin_needs_higher_version' => esc_html__('Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'onenav-pro'),
            'complete' => esc_html__('All plugins installed and activated successfully. %1$s', 'onenav-pro'),
            'dismiss' => esc_html__('Dismiss this notice', 'onenav-pro'),
            'notice_cannot_install_activate' => esc_html__('There are one or more required or recommended plugins to install, update or activate.', 'onenav-pro'),
            'contact_admin' => esc_html__('Please contact the administrator of this site for help.', 'onenav-pro'),
            'nag_type' => 'updated',
        ),
    );

    // Only register if TGM Plugin Activation class exists
    if (class_exists('TGM_Plugin_Activation')) {
        tgmpa($plugins, $config);
    }
}
add_action('tgmpa_register', 'onenav_register_required_plugins');
