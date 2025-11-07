<?php
/**
 * OneNav Theme Functions
 * 
 * @package OneNav
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('ONENAV_VERSION', '1.0.0');
define('ONENAV_DIR', get_template_directory());
define('ONENAV_URI', get_template_directory_uri());
define('ONENAV_ASSETS', ONENAV_URI . '/assets');

// ============================================
// INCLUDE THEME FILES
// ============================================

require_once ONENAV_DIR . '/includes/post-types.php';
require_once ONENAV_DIR . '/includes/customizer.php';
require_once ONENAV_DIR . '/includes/api-endpoints.php';
require_once ONENAV_DIR . '/includes/trend-sync.php';
require_once ONENAV_DIR . '/includes/theme-options.php';

// ============================================
// THEME SETUP
// ============================================

function onenav_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo', array(
        'height' => 60,
        'width' => 200,
        'flex-width' => true,
        'flex-height' => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary-menu' => esc_html__('Primary Menu', 'onenav'),
        'footer-menu' => esc_html__('Footer Menu', 'onenav'),
    ));

    // Add custom image sizes
    add_image_size('onenav-site-icon', 60, 60, true);
    add_image_size('onenav-news-featured', 300, 200, true);
    add_image_size('onenav-app-icon', 80, 80, true);
    add_image_size('onenav-gallery', 200, 200, true);
    add_image_size('onenav-product', 300, 250, true);
}
add_action('after_setup_theme', 'onenav_theme_setup');

// ============================================
// ENQUEUE STYLES & SCRIPTS
// ============================================

function onenav_enqueue_assets() {
    // Style.css (theme stylesheet) otomatik yüklenir
    wp_enqueue_style('onenav-style', get_stylesheet_uri(), array(), ONENAV_VERSION);
    wp_enqueue_style('onenav-theme', ONENAV_ASSETS . '/css/theme.css', array('onenav-style'), ONENAV_VERSION);
    wp_enqueue_style('onenav-responsive', ONENAV_ASSETS . '/css/responsive.css', array('onenav-theme'), ONENAV_VERSION);
    wp_enqueue_style('onenav-admin', ONENAV_ASSETS . '/css/admin.css', array('onenav-theme'), ONENAV_VERSION);

    // Scripts - jQuery üzerine build
    wp_enqueue_script('onenav-main', ONENAV_ASSETS . '/js/main.js', array('jquery'), ONENAV_VERSION, true);
    wp_enqueue_script('onenav-theme', ONENAV_ASSETS . '/js/theme.js', array('jquery', 'onenav-main'), ONENAV_VERSION, true);

    // Localize script for AJAX
    wp_localize_script('onenav-main', 'onenavData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('onenav_nonce'),
        'siteUrl' => site_url(),
    ));
}
add_action('wp_enqueue_scripts', 'onenav_enqueue_assets');

// ============================================
// ADMIN ENQUEUE SCRIPTS
// ============================================

function onenav_admin_enqueue_assets() {
    wp_enqueue_style('onenav-admin', ONENAV_ASSETS . '/css/admin.css', array(), ONENAV_VERSION);
    wp_enqueue_script('onenav-admin', ONENAV_ASSETS . '/js/admin.js', array('jquery'), ONENAV_VERSION, true);
}
add_action('admin_enqueue_scripts', 'onenav_admin_enqueue_assets');

// ============================================
// REGISTER WIDGET AREAS
// ============================================

function onenav_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Primary Sidebar', 'onenav'),
        'id' => 'primary-sidebar',
        'description' => esc_html__('Main sidebar', 'onenav'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Column 1', 'onenav'),
        'id' => 'footer-col-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Column 2', 'onenav'),
        'id' => 'footer-col-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Footer Column 3', 'onenav'),
        'id' => 'footer-col-3',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'onenav_widgets_init');

// ============================================
// CUSTOM EXCERPT LENGTH
// ============================================

function onenav_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'onenav_excerpt_length');

function onenav_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'onenav_excerpt_more');

// ============================================
// CUSTOM LOGO SUPPORT
// ============================================

function onenav_get_custom_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    $html = wp_get_attachment_image($custom_logo_id, 'full');
    return $html;
}

// ============================================
// BODY CLASS FILTER
// ============================================

function onenav_body_classes($classes) {
    if (is_singular()) {
        $classes[] = 'is-singular';
    }
    if (is_home() || is_front_page()) {
        $classes[] = 'is-home';
    }
    return $classes;
}
add_filter('body_class', 'onenav_body_classes');

// ============================================
// AJAX SEARCH HANDLER
// ============================================

function onenav_ajax_search() {
    check_ajax_referer('onenav_nonce', 'nonce');

    $search_term = sanitize_text_field($_POST['search']);
    
    if (strlen($search_term) < 2) {
        wp_send_json_error('Search term too short');
    }

    $args = array(
        's' => $search_term,
        'posts_per_page' => 10,
        'post_type' => array('site', 'post', 'app', 'ebook', 'gallery', 'ai_tool'),
    );

    $query = new WP_Query($args);
    $results = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'type' => get_post_type(),
                'url' => get_permalink(),
                'excerpt' => wp_trim_words(get_the_excerpt(), 15),
            );
        }
    }

    wp_reset_postdata();
    wp_send_json_success($results);
}
add_action('wp_ajax_onenav_search', 'onenav_ajax_search');
add_action('wp_ajax_nopriv_onenav_search', 'onenav_ajax_search');

// ============================================
// CLICK TRACKING
// ============================================

function onenav_track_click() {
    check_ajax_referer('onenav_nonce', 'nonce');

    $site_id = intval($_POST['site_id']);
    
    if ($site_id) {
        $current_clicks = (int) get_post_meta($site_id, 'click_count', true);
        update_post_meta($site_id, 'click_count', $current_clicks + 1);
        wp_send_json_success('Click recorded');
    }

    wp_send_json_error('Invalid site ID');
}
add_action('wp_ajax_onenav_track_click', 'onenav_track_click');
add_action('wp_ajax_nopriv_onenav_track_click', 'onenav_track_click');

// ============================================
// LIKE TOGGLE
// ============================================

function onenav_toggle_like() {
    check_ajax_referer('onenav_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    $is_liked = isset($_POST['is_liked']) && $_POST['is_liked'] === 'true';

    if ($post_id) {
        $current_likes = (int) get_post_meta($post_id, 'like_count', true);

        if ($is_liked) {
            $new_count = $current_likes + 1;
        } else {
            $new_count = max(0, $current_likes - 1);
        }

        update_post_meta($post_id, 'like_count', $new_count);
        wp_send_json_success(array('count' => $new_count));
    }

    wp_send_json_error('Invalid post ID');
}
add_action('wp_ajax_onenav_toggle_like', 'onenav_toggle_like');
add_action('wp_ajax_nopriv_onenav_toggle_like', 'onenav_toggle_like');

// ============================================
// GET TRENDING KEYWORDS
// ============================================

function onenav_get_trending() {
    // Get cached trending data
    $trending = get_transient('onenav_trending_keywords');
    
    if (false === $trending) {
        // Fetch from trend-sync.php via onenav_sync_trends()
        // Bu fonksiyon trend-sync.php'de tanımlanmıştır
        do_action('onenav_update_trends');
        $trending = get_transient('onenav_trending_keywords');
    }

    return $trending;
}

// ============================================
// GET POSTS BY CATEGORY
// ============================================

function onenav_get_posts_by_category($category, $limit = 12) {
    $args = array(
        'posts_per_page' => $limit,
        'post_type' => 'site',
        'tax_query' => array(
            array(
                'taxonomy' => 'site_category',
                'field' => 'slug',
                'terms' => $category,
            ),
        ),
    );

    return new WP_Query($args);
}

// ============================================
// GET MOST VIEWED SITES
// ============================================

function onenav_get_popular_sites($limit = 12) {
    $args = array(
        'posts_per_page' => $limit,
        'post_type' => 'site',
        'meta_key' => 'click_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    );

    return new WP_Query($args);
}

// ============================================
// SANITIZE AND VALIDATE
// ============================================

function onenav_sanitize_text($text) {
    return sanitize_text_field($text);
}

function onenav_sanitize_url($url) {
    return esc_url_raw($url);
}

// ============================================
// SECURITY HEADERS
// ============================================

function onenav_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
}
add_action('wp_head', 'onenav_security_headers');

// ============================================
// PERFORMANCE OPTIMIZATION
// ============================================

// Disable emojis to reduce requests
function onenav_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('init', 'onenav_disable_emojis');

// Remove WordPress version
function onenav_remove_wp_version() {
    return '';
}
add_filter('the_generator', 'onenav_remove_wp_version');

// ============================================
// CUSTOM DASHBOARD WIDGET
// ============================================

function onenav_dashboard_widget() {
    wp_add_dashboard_widget('onenav_stats', 'OneNav Statistics', 'onenav_dashboard_widget_content');
}

function onenav_dashboard_widget_content() {
    $total_sites = wp_count_posts('site')->publish;
    $total_news = wp_count_posts('post')->publish;
    $total_apps = wp_count_posts('app')->publish;
    $total_ebooks = wp_count_posts('ebook')->publish;
    $total_categories = wp_count_terms('site_category');

    ?>
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
        <div style="background: #f3f4f6; padding: 15px; border-radius: 8px;">
            <p style="margin: 0; color: #6b7280; font-size: 12px;">Total Sites</p>
            <p style="margin: 0; font-size: 28px; font-weight: bold; color: #a855f7;"><?php echo $total_sites; ?></p>
        </div>
        <div style="background: #f3f4f6; padding: 15px; border-radius: 8px;">
            <p style="margin: 0; color: #6b7280; font-size: 12px;">Total News</p>
            <p style="margin: 0; font-size: 28px; font-weight: bold; color: #ec4899;"><?php echo $total_news; ?></p>
        </div>
        <div style="background: #f3f4f6; padding: 15px; border-radius: 8px;">
            <p style="margin: 0; color: #6b7280; font-size: 12px;">Total Apps</p>
            <p style="margin: 0; font-size: 28px; font-weight: bold; color: #10b981;"><?php echo $total_apps; ?></p>
        </div>
        <div style="background: #f3f4f6; padding: 15px; border-radius: 8px;">
            <p style="margin: 0; color: #6b7280; font-size: 12px;">Total E-Books</p>
            <p style="margin: 0; font-size: 28px; font-weight: bold; color: #f59e0b;"><?php echo $total_ebooks; ?></p>
        </div>
    </div>
    <p style="margin-top: 15px; color: #6b7280; font-size: 12px;">Categories: <?php echo $total_categories; ?></p>
    <?php
}
add_action('wp_dashboard_setup', 'onenav_dashboard_widget');

// ============================================
// ACF SUPPORT (Optional - for custom fields)
// ============================================

function onenav_register_acf_fields() {
    // This is optional - implement if you want to use ACF
    // Or use custom post meta instead
}

// ============================================
// IMPORT/EXPORT FUNCTIONALITY
// ============================================

function onenav_export_sites() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $args = array(
        'post_type' => 'site',
        'posts_per_page' => -1,
    );

    $sites = new WP_Query($args);
    $export_data = array();

    if ($sites->have_posts()) {
        while ($sites->have_posts()) {
            $sites->the_post();
            $export_data[] = array(
                'title' => get_the_title(),
                'url' => get_post_meta(get_the_ID(), 'site_url', true),
                'description' => get_the_content(),
                'category' => wp_get_post_terms(get_the_ID(), 'site_category', array('fields' => 'names')),
            );
        }
    }

    wp_reset_postdata();
    return $export_data;
}
