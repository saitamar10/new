<?php
/**
 * OneNav - Custom Post Types & Taxonomies
 * 
 * @package OneNav
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// REGISTER CUSTOM POST TYPE: SITE
// ============================================

function onenav_register_site_post_type() {
    $labels = array(
        'name' => esc_html__('Sites', 'onenav'),
        'singular_name' => esc_html__('Site', 'onenav'),
        'add_new' => esc_html__('Add New', 'onenav'),
        'add_new_item' => esc_html__('Add New Site', 'onenav'),
        'edit_item' => esc_html__('Edit Site', 'onenav'),
        'view_item' => esc_html__('View Site', 'onenav'),
        'search_items' => esc_html__('Search Sites', 'onenav'),
    );

    $args = array(
        'label' => esc_html__('Sites', 'onenav'),
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'site'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-links',
    );

    register_post_type('site', $args);
}
add_action('init', 'onenav_register_site_post_type');

// Site Categories Taxonomy
function onenav_register_site_category_taxonomy() {
    $labels = array(
        'name' => esc_html__('Site Categories', 'onenav'),
        'singular_name' => esc_html__('Site Category', 'onenav'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'site-category'),
    );

    register_taxonomy('site_category', array('site'), $args);
}
add_action('init', 'onenav_register_site_category_taxonomy');

// ============================================
// REGISTER CUSTOM POST TYPE: NEWS
// ============================================

function onenav_register_news_post_type() {
    $labels = array(
        'name' => esc_html__('News', 'onenav'),
        'singular_name' => esc_html__('News Article', 'onenav'),
        'add_new_item' => esc_html__('Add New News', 'onenav'),
    );

    $args = array(
        'label' => esc_html__('News', 'onenav'),
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'news'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'author'),
        'menu_icon' => 'dashicons-megaphone',
    );

    register_post_type('news', $args);
}
add_action('init', 'onenav_register_news_post_type');

// News Categories
function onenav_register_news_category_taxonomy() {
    $args = array(
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'news-category'),
    );
    register_taxonomy('news_category', array('news'), $args);
}
add_action('init', 'onenav_register_news_category_taxonomy');

// ============================================
// REGISTER CUSTOM POST TYPE: APP
// ============================================

function onenav_register_app_post_type() {
    $args = array(
        'label' => esc_html__('Mobile Apps', 'onenav'),
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'app'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-smartphone',
    );
    register_post_type('app', $args);
}
add_action('init', 'onenav_register_app_post_type');

// ============================================
// REGISTER CUSTOM POST TYPE: E-BOOK
// ============================================

function onenav_register_ebook_post_type() {
    $args = array(
        'label' => esc_html__('E-Books', 'onenav'),
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'ebook'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-book',
    );
    register_post_type('ebook', $args);
}
add_action('init', 'onenav_register_ebook_post_type');

// ============================================
// REGISTER CUSTOM POST TYPE: GALLERY
// ============================================

function onenav_register_gallery_post_type() {
    $args = array(
        'label' => esc_html__('Galleries', 'onenav'),
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'gallery'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-format-image',
    );
    register_post_type('gallery', $args);
}
add_action('init', 'onenav_register_gallery_post_type');

// ============================================
// REGISTER CUSTOM POST TYPE: AI TOOL
// ============================================

function onenav_register_ai_tool_post_type() {
    $args = array(
        'label' => esc_html__('AI Tools', 'onenav'),
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'ai-tool'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-robotics',
    );
    register_post_type('ai_tool', $args);
}
add_action('init', 'onenav_register_ai_tool_post_type');

// ============================================
// REGISTER CUSTOM POST TYPE: MARKETPLACE
// ============================================

function onenav_register_marketplace_post_type() {
    $args = array(
        'label' => esc_html__('Marketplace', 'onenav'),
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'product'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-cart',
    );
    register_post_type('marketplace', $args);
}
add_action('init', 'onenav_register_marketplace_post_type');

// ============================================
// SITE META BOXES
// ============================================

function onenav_add_site_meta_boxes() {
    add_meta_box(
        'site_details',
        esc_html__('Site Details', 'onenav'),
        'onenav_render_site_details_meta_box',
        'site',
        'normal',
        'high'
    );

    add_meta_box(
        'site_stats',
        esc_html__('Statistics', 'onenav'),
        'onenav_render_site_stats_meta_box',
        'site',
        'side'
    );
}
add_action('add_meta_boxes', 'onenav_add_site_meta_boxes');

function onenav_render_site_details_meta_box($post) {
    wp_nonce_field('onenav_site_details_nonce', 'onenav_site_details_nonce');
    $site_url = get_post_meta($post->ID, 'site_url', true);
    $site_icon = get_post_meta($post->ID, 'site_icon', true);
    ?>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Site URL</label>
        <input type="url" name="site_url" value="<?php echo esc_url($site_url); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Icon URL</label>
        <input type="url" name="site_icon" value="<?php echo esc_url($site_icon); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <?php
}

function onenav_render_site_stats_meta_box($post) {
    $clicks = (int) get_post_meta($post->ID, 'click_count', true);
    ?>
    <p><strong>Clicks:</strong> <?php echo $clicks; ?></p>
    <p><strong>Added:</strong> <?php echo get_the_date('Y-m-d', $post->ID); ?></p>
    <?php
}

function onenav_save_site_meta_box($post_id) {
    if (!isset($_POST['onenav_site_details_nonce']) || !wp_verify_nonce($_POST['onenav_site_details_nonce'], 'onenav_site_details_nonce')) {
        return;
    }
    if (isset($_POST['site_url'])) {
        update_post_meta($post_id, 'site_url', esc_url_raw($_POST['site_url']));
    }
    if (isset($_POST['site_icon'])) {
        update_post_meta($post_id, 'site_icon', esc_url_raw($_POST['site_icon']));
    }
}
add_action('save_post_site', 'onenav_save_site_meta_box');

// ============================================
// APP META BOXES
// ============================================

function onenav_add_app_meta_boxes() {
    add_meta_box('app_details', esc_html__('App Links', 'onenav'), 'onenav_render_app_details_meta_box', 'app', 'normal', 'high');
}
add_action('add_meta_boxes', 'onenav_add_app_meta_boxes');

function onenav_render_app_details_meta_box($post) {
    wp_nonce_field('onenav_app_details_nonce', 'onenav_app_details_nonce');
    $ios_link = get_post_meta($post->ID, 'ios_link', true);
    $android_link = get_post_meta($post->ID, 'android_link', true);
    $price = get_post_meta($post->ID, 'app_price', true);
    ?>
    <div style="margin-bottom: 15px;">
        <label><strong>iOS Link:</strong></label>
        <input type="url" name="ios_link" value="<?php echo esc_url($ios_link); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label><strong>Android Link:</strong></label>
        <input type="url" name="android_link" value="<?php echo esc_url($android_link); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label><strong>Price:</strong></label>
        <input type="number" name="app_price" value="<?php echo esc_attr($price); ?>" step="0.01" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <?php
}

function onenav_save_app_meta_box($post_id) {
    if (!isset($_POST['onenav_app_details_nonce']) || !wp_verify_nonce($_POST['onenav_app_details_nonce'], 'onenav_app_details_nonce')) {
        return;
    }
    if (isset($_POST['ios_link'])) {
        update_post_meta($post_id, 'ios_link', esc_url_raw($_POST['ios_link']));
    }
    if (isset($_POST['android_link'])) {
        update_post_meta($post_id, 'android_link', esc_url_raw($_POST['android_link']));
    }
    if (isset($_POST['app_price'])) {
        update_post_meta($post_id, 'app_price', floatval($_POST['app_price']));
    }
}
add_action('save_post_app', 'onenav_save_app_meta_box');

// ============================================
// E-BOOK META BOXES
// ============================================

function onenav_add_ebook_meta_boxes() {
    add_meta_box('ebook_details', esc_html__('E-Book Details', 'onenav'), 'onenav_render_ebook_details_meta_box', 'ebook', 'normal', 'high');
}
add_action('add_meta_boxes', 'onenav_add_ebook_meta_boxes');

function onenav_render_ebook_details_meta_box($post) {
    wp_nonce_field('onenav_ebook_details_nonce', 'onenav_ebook_details_nonce');
    $file = get_post_meta($post->ID, 'ebook_file', true);
    $type = get_post_meta($post->ID, 'ebook_type', true);
    ?>
    <div style="margin-bottom: 15px;">
        <label><strong>File URL:</strong></label>
        <input type="url" name="ebook_file" value="<?php echo esc_url($file); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label><strong>Type:</strong></label>
        <select name="ebook_type" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="pdf" <?php selected($type, 'pdf'); ?>>PDF</option>
            <option value="epub" <?php selected($type, 'epub'); ?>>EPUB</option>
            <option value="mobi" <?php selected($type, 'mobi'); ?>>MOBI</option>
        </select>
    </div>
    <?php
}

function onenav_save_ebook_meta_box($post_id) {
    if (!isset($_POST['onenav_ebook_details_nonce']) || !wp_verify_nonce($_POST['onenav_ebook_details_nonce'], 'onenav_ebook_details_nonce')) {
        return;
    }
    if (isset($_POST['ebook_file'])) {
        update_post_meta($post_id, 'ebook_file', esc_url_raw($_POST['ebook_file']));
    }
    if (isset($_POST['ebook_type'])) {
        update_post_meta($post_id, 'ebook_type', sanitize_text_field($_POST['ebook_type']));
    }
}
add_action('save_post_ebook', 'onenav_save_ebook_meta_box');

// ============================================
// AI TOOL META BOXES
// ============================================

function onenav_add_ai_tool_meta_boxes() {
    add_meta_box('ai_details', esc_html__('AI Tool Info', 'onenav'), 'onenav_render_ai_tool_meta_box', 'ai_tool', 'normal', 'high');
}
add_action('add_meta_boxes', 'onenav_add_ai_tool_meta_boxes');

function onenav_render_ai_tool_meta_box($post) {
    wp_nonce_field('onenav_ai_details_nonce', 'onenav_ai_details_nonce');
    $url = get_post_meta($post->ID, 'ai_tool_url', true);
    $features = get_post_meta($post->ID, 'ai_features', true);
    ?>
    <div style="margin-bottom: 15px;">
        <label><strong>Tool URL:</strong></label>
        <input type="url" name="ai_tool_url" value="<?php echo esc_url($url); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label><strong>Features:</strong></label>
        <textarea name="ai_features" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; height: 80px;"><?php echo esc_textarea($features); ?></textarea>
    </div>
    <?php
}

function onenav_save_ai_tool_meta_box($post_id) {
    if (!isset($_POST['onenav_ai_details_nonce']) || !wp_verify_nonce($_POST['onenav_ai_details_nonce'], 'onenav_ai_details_nonce')) {
        return;
    }
    if (isset($_POST['ai_tool_url'])) {
        update_post_meta($post_id, 'ai_tool_url', esc_url_raw($_POST['ai_tool_url']));
    }
    if (isset($_POST['ai_features'])) {
        update_post_meta($post_id, 'ai_features', sanitize_textarea_field($_POST['ai_features']));
    }
}
add_action('save_post_ai_tool', 'onenav_save_ai_tool_meta_box');

// ============================================
// REGISTER CUSTOM POST TYPE: RESOURCE
// ============================================

function onenav_register_resource_post_type() {
    $labels = array(
        'name' => esc_html__('Resources', 'onenav-pro'),
        'singular_name' => esc_html__('Resource', 'onenav-pro'),
        'add_new' => esc_html__('Add New', 'onenav-pro'),
        'add_new_item' => esc_html__('Add New Resource', 'onenav-pro'),
        'edit_item' => esc_html__('Edit Resource', 'onenav-pro'),
        'view_item' => esc_html__('View Resource', 'onenav-pro'),
        'search_items' => esc_html__('Search Resources', 'onenav-pro'),
    );

    $args = array(
        'label' => esc_html__('Resources', 'onenav-pro'),
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'resource'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-download',
    );

    register_post_type('resource', $args);
}
add_action('init', 'onenav_register_resource_post_type');

// Resource Categories
function onenav_register_resource_category_taxonomy() {
    $labels = array(
        'name' => esc_html__('Resource Categories', 'onenav-pro'),
        'singular_name' => esc_html__('Resource Category', 'onenav-pro'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'resource-category'),
    );

    register_taxonomy('resource_category', array('resource'), $args);
}
add_action('init', 'onenav_register_resource_category_taxonomy');

// ============================================
// REGISTER CUSTOM POST TYPE: VIDEO
// ============================================

function onenav_register_video_post_type() {
    $labels = array(
        'name' => esc_html__('Videos', 'onenav-pro'),
        'singular_name' => esc_html__('Video', 'onenav-pro'),
        'add_new' => esc_html__('Add New', 'onenav-pro'),
        'add_new_item' => esc_html__('Add New Video', 'onenav-pro'),
        'edit_item' => esc_html__('Edit Video', 'onenav-pro'),
        'view_item' => esc_html__('View Video', 'onenav-pro'),
        'search_items' => esc_html__('Search Videos', 'onenav-pro'),
    );

    $args = array(
        'label' => esc_html__('Videos', 'onenav-pro'),
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'video'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-video-alt3',
    );

    register_post_type('video', $args);
}
add_action('init', 'onenav_register_video_post_type');

// Video Categories
function onenav_register_video_category_taxonomy() {
    $labels = array(
        'name' => esc_html__('Video Categories', 'onenav-pro'),
        'singular_name' => esc_html__('Video Category', 'onenav-pro'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'video-category'),
    );

    register_taxonomy('video_category', array('video'), $args);
}
add_action('init', 'onenav_register_video_category_taxonomy');

// ============================================
// TOOL CATEGORY TAXONOMY (for sites/tools)
// ============================================

function onenav_register_tool_cat_taxonomy() {
    $labels = array(
        'name' => esc_html__('Tool Categories', 'onenav-pro'),
        'singular_name' => esc_html__('Tool Category', 'onenav-pro'),
        'add_new_item' => esc_html__('Add New Category', 'onenav-pro'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'rewrite' => array('slug' => 'tool-cat'),
    );

    register_taxonomy('tool_cat', array('site', 'ai_tool'), $args);
}
add_action('init', 'onenav_register_tool_cat_taxonomy');

// ============================================
// RESOURCE META BOXES
// ============================================

function onenav_add_resource_meta_boxes() {
    add_meta_box(
        'resource_details',
        esc_html__('Resource Details', 'onenav-pro'),
        'onenav_render_resource_details_meta_box',
        'resource',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'onenav_add_resource_meta_boxes');

function onenav_render_resource_details_meta_box($post) {
    wp_nonce_field('onenav_resource_details_nonce', 'onenav_resource_details_nonce');
    $external_url = get_post_meta($post->ID, 'external_url', true);
    $pdf_url = get_post_meta($post->ID, 'pdf_url', true);
    $price = get_post_meta($post->ID, 'price', true);
    ?>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">External URL</label>
        <input type="url" name="external_url" value="<?php echo esc_url($external_url); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">PDF URL</label>
        <input type="url" name="pdf_url" value="<?php echo esc_url($pdf_url); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Price</label>
        <input type="text" name="price" value="<?php echo esc_attr($price); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <?php
}

function onenav_save_resource_meta_box($post_id) {
    if (!isset($_POST['onenav_resource_details_nonce']) || !wp_verify_nonce($_POST['onenav_resource_details_nonce'], 'onenav_resource_details_nonce')) {
        return;
    }
    if (isset($_POST['external_url'])) {
        update_post_meta($post_id, 'external_url', esc_url_raw($_POST['external_url']));
    }
    if (isset($_POST['pdf_url'])) {
        update_post_meta($post_id, 'pdf_url', esc_url_raw($_POST['pdf_url']));
    }
    if (isset($_POST['price'])) {
        update_post_meta($post_id, 'price', sanitize_text_field($_POST['price']));
    }
}
add_action('save_post_resource', 'onenav_save_resource_meta_box');

// ============================================
// VIDEO META BOXES
// ============================================

function onenav_add_video_meta_boxes() {
    add_meta_box(
        'video_details',
        esc_html__('Video Details', 'onenav-pro'),
        'onenav_render_video_details_meta_box',
        'video',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'onenav_add_video_meta_boxes');

function onenav_render_video_details_meta_box($post) {
    wp_nonce_field('onenav_video_details_nonce', 'onenav_video_details_nonce');
    $external_url = get_post_meta($post->ID, 'external_url', true);
    $video_url = get_post_meta($post->ID, 'video_url', true);
    $duration = get_post_meta($post->ID, 'duration', true);
    ?>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">External URL</label>
        <input type="url" name="external_url" value="<?php echo esc_url($external_url); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Video URL</label>
        <input type="url" name="video_url" value="<?php echo esc_url($video_url); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Duration (e.g., 12:34)</label>
        <input type="text" name="duration" value="<?php echo esc_attr($duration); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <?php
}

function onenav_save_video_meta_box($post_id) {
    if (!isset($_POST['onenav_video_details_nonce']) || !wp_verify_nonce($_POST['onenav_video_details_nonce'], 'onenav_video_details_nonce')) {
        return;
    }
    if (isset($_POST['external_url'])) {
        update_post_meta($post_id, 'external_url', esc_url_raw($_POST['external_url']));
    }
    if (isset($_POST['video_url'])) {
        update_post_meta($post_id, 'video_url', esc_url_raw($_POST['video_url']));
    }
    if (isset($_POST['duration'])) {
        update_post_meta($post_id, 'duration', sanitize_text_field($_POST['duration']));
    }
}
add_action('save_post_video', 'onenav_save_video_meta_box');

// ============================================
// EBOOK EXTENDED META (ISBN, Cover, etc.)
// ============================================

function onenav_add_ebook_extended_meta_boxes() {
    add_meta_box(
        'ebook_extended',
        esc_html__('Extended Book Info', 'onenav-pro'),
        'onenav_render_ebook_extended_meta_box',
        'ebook',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'onenav_add_ebook_extended_meta_boxes');

function onenav_render_ebook_extended_meta_box($post) {
    wp_nonce_field('onenav_ebook_extended_nonce', 'onenav_ebook_extended_nonce');
    $isbn = get_post_meta($post->ID, 'isbn', true);
    $cover = get_post_meta($post->ID, 'cover', true);
    $price = get_post_meta($post->ID, 'price', true);
    ?>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">ISBN</label>
        <input type="text" name="isbn" value="<?php echo esc_attr($isbn); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Cover Image URL</label>
        <input type="url" name="cover" value="<?php echo esc_url($cover); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px; font-weight: bold;">Price</label>
        <input type="text" name="price" value="<?php echo esc_attr($price); ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    <?php
}

function onenav_save_ebook_extended_meta_box($post_id) {
    if (!isset($_POST['onenav_ebook_extended_nonce']) || !wp_verify_nonce($_POST['onenav_ebook_extended_nonce'], 'onenav_ebook_extended_nonce')) {
        return;
    }
    if (isset($_POST['isbn'])) {
        update_post_meta($post_id, 'isbn', sanitize_text_field($_POST['isbn']));
    }
    if (isset($_POST['cover'])) {
        update_post_meta($post_id, 'cover', esc_url_raw($_POST['cover']));
    }
    if (isset($_POST['price'])) {
        update_post_meta($post_id, 'price', sanitize_text_field($_POST['price']));
    }
}
add_action('save_post_ebook', 'onenav_save_ebook_extended_meta_box');
