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

    // Scripts - jQuery üzerine build
    wp_enqueue_script('onenav-theme', ONENAV_ASSETS . '/js/theme.js', array('jquery'), ONENAV_VERSION, true);

    // Localize script for AJAX
    wp_localize_script('onenav-theme', 'onenavData', array(
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

// ============================================
// THEME SETTINGS PANEL - WordPress Settings API
// ============================================

// Add Theme Settings Menu
function onenav_add_theme_settings_menu() {
    add_theme_page(
        'Tema Ayarları',
        'Tema Ayarları',
        'manage_options',
        'onenav-settings',
        'onenav_render_settings_page'
    );
}
add_action('admin_menu', 'onenav_add_theme_settings_menu');

// Register Settings
function onenav_register_settings() {
    register_setting('onenav_options_group', 'onenav_options', 'onenav_sanitize_settings');

    // Section 1: Genel Ayarlar
    add_settings_section(
        'onenav_general_section',
        'Genel Ayarlar',
        'onenav_general_section_callback',
        'onenav-settings'
    );

    add_settings_field('site_logo', 'Site Logosu', 'onenav_logo_field', 'onenav-settings', 'onenav_general_section');
    add_settings_field('favicon', 'Favicon', 'onenav_favicon_field', 'onenav-settings', 'onenav_general_section');
    add_settings_field('primary_color', 'Ana Renk', 'onenav_primary_color_field', 'onenav-settings', 'onenav_general_section');
    add_settings_field('footer_text', 'Altbilgi Metni', 'onenav_footer_text_field', 'onenav-settings', 'onenav_general_section');

    // Section 2: Anasayfa Ayarları
    add_settings_section(
        'onenav_homepage_section',
        'Anasayfa Ayarları',
        'onenav_homepage_section_callback',
        'onenav-settings'
    );

    add_settings_field('hero_bg', 'Hero Arka Plan Resmi', 'onenav_hero_bg_field', 'onenav-settings', 'onenav_homepage_section');
    add_settings_field('search_placeholder', 'Arama Çubuğu Placeholder', 'onenav_search_placeholder_field', 'onenav-settings', 'onenav_homepage_section');
    add_settings_field('popular_sites_title', 'Popüler Siteler Başlığı', 'onenav_popular_sites_title_field', 'onenav-settings', 'onenav_homepage_section');
    add_settings_field('ebook_section_title', 'E-Kitap Bölümü Başlığı', 'onenav_ebook_section_title_field', 'onenav-settings', 'onenav_homepage_section');

    // Section 3: Blog Ayarları
    add_settings_section(
        'onenav_blog_section',
        'Blog Ayarları',
        'onenav_blog_section_callback',
        'onenav-settings'
    );

    add_settings_field('blog_layout', 'Sayfa Düzeni', 'onenav_blog_layout_field', 'onenav-settings', 'onenav_blog_section');
    add_settings_field('show_author', 'Yazar Bilgisi Göster', 'onenav_show_author_field', 'onenav-settings', 'onenav_blog_section');
    add_settings_field('show_like_button', 'Beğeni Butonu Aktif', 'onenav_show_like_button_field', 'onenav-settings', 'onenav_blog_section');

    // Section 4: AI Araçları
    add_settings_section(
        'onenav_aitools_section',
        'AI Araçları Sayfası',
        'onenav_aitools_section_callback',
        'onenav-settings'
    );

    add_settings_field('ai_columns', 'Kart Başına Maksimum Sütun', 'onenav_ai_columns_field', 'onenav-settings', 'onenav_aitools_section');
    add_settings_field('ai_load_more_text', 'Daha Fazla Yükle Buton Metni', 'onenav_ai_load_more_text_field', 'onenav-settings', 'onenav_aitools_section');
    add_settings_field('ai_filter_titles', 'Filtre Başlıkları (virgülle ayrılmış)', 'onenav_ai_filter_titles_field', 'onenav-settings', 'onenav_aitools_section');

    // Section 5: E-Kitap Sayfası
    add_settings_section(
        'onenav_ebook_section',
        'E-Kitap Sayfası',
        'onenav_ebook_section_callback',
        'onenav-settings'
    );

    add_settings_field('ebook_buy_text', 'Basılı Kitabı Satın Al Buton Metni', 'onenav_ebook_buy_text_field', 'onenav-settings', 'onenav_ebook_section');
    add_settings_field('ebook_download_text', 'E-Kitabı İndir Buton Metni', 'onenav_ebook_download_text_field', 'onenav-settings', 'onenav_ebook_section');
    add_settings_field('ebook_related_title', 'İlgili Kitaplar Başlığı', 'onenav_ebook_related_title_field', 'onenav-settings', 'onenav_ebook_section');
    add_settings_field('ebook_excerpt_length', 'Kitap Açıklaması Maksimum Uzunluk', 'onenav_ebook_excerpt_length_field', 'onenav-settings', 'onenav_ebook_section');

    // Section 6: Dark Mode
    add_settings_section(
        'onenav_darkmode_section',
        'Dark Mode',
        'onenav_darkmode_section_callback',
        'onenav-settings'
    );

    add_settings_field('dark_mode_enabled', 'Dark Mode Aktif', 'onenav_dark_mode_enabled_field', 'onenav-settings', 'onenav_darkmode_section');
    add_settings_field('dark_mode_color', 'Gece Modu Rengi', 'onenav_dark_mode_color_field', 'onenav-settings', 'onenav_darkmode_section');
}
add_action('admin_init', 'onenav_register_settings');

// Section Callbacks
function onenav_general_section_callback() {
    echo '<p>Temanın genel görünüm ayarlarını buradan yapılandırın.</p>';
}

function onenav_homepage_section_callback() {
    echo '<p>Anasayfa özel ayarları</p>';
}

function onenav_blog_section_callback() {
    echo '<p>Blog yazılarının görünüm ayarları</p>';
}

function onenav_aitools_section_callback() {
    echo '<p>AI Araçları sayfası ayarları</p>';
}

function onenav_ebook_section_callback() {
    echo '<p>E-Kitap sayfası ayarları</p>';
}

function onenav_darkmode_section_callback() {
    echo '<p>Karanlık mod ayarları</p>';
}

// Field Callbacks
function onenav_logo_field() {
    $options = get_option('onenav_options');
    $logo = isset($options['site_logo']) ? $options['site_logo'] : '';
    ?>
    <input type="text" id="site_logo" name="onenav_options[site_logo]" value="<?php echo esc_attr($logo); ?>" style="width: 400px;" />
    <button type="button" class="button onenav-upload-button" data-target="site_logo">Resim Yükle</button>
    <?php if ($logo) : ?>
        <br><img src="<?php echo esc_url($logo); ?>" style="max-width: 200px; margin-top: 10px;" />
    <?php endif;
}

function onenav_favicon_field() {
    $options = get_option('onenav_options');
    $favicon = isset($options['favicon']) ? $options['favicon'] : '';
    ?>
    <input type="text" id="favicon" name="onenav_options[favicon]" value="<?php echo esc_attr($favicon); ?>" style="width: 400px;" />
    <button type="button" class="button onenav-upload-button" data-target="favicon">Resim Yükle</button>
    <?php if ($favicon) : ?>
        <br><img src="<?php echo esc_url($favicon); ?>" style="max-width: 50px; margin-top: 10px;" />
    <?php endif;
}

function onenav_primary_color_field() {
    $options = get_option('onenav_options');
    $color = isset($options['primary_color']) ? $options['primary_color'] : '#a855f7';
    ?>
    <input type="color" name="onenav_options[primary_color]" value="<?php echo esc_attr($color); ?>" />
    <?php
}

function onenav_footer_text_field() {
    $options = get_option('onenav_options');
    $footer_text = isset($options['footer_text']) ? $options['footer_text'] : '';
    ?>
    <textarea name="onenav_options[footer_text]" rows="3" style="width: 400px;"><?php echo esc_textarea($footer_text); ?></textarea>
    <?php
}

function onenav_hero_bg_field() {
    $options = get_option('onenav_options');
    $hero_bg = isset($options['hero_bg']) ? $options['hero_bg'] : '';
    ?>
    <input type="text" id="hero_bg" name="onenav_options[hero_bg]" value="<?php echo esc_attr($hero_bg); ?>" style="width: 400px;" />
    <button type="button" class="button onenav-upload-button" data-target="hero_bg">Resim Yükle</button>
    <?php if ($hero_bg) : ?>
        <br><img src="<?php echo esc_url($hero_bg); ?>" style="max-width: 300px; margin-top: 10px;" />
    <?php endif;
}

function onenav_search_placeholder_field() {
    $options = get_option('onenav_options');
    $placeholder = isset($options['search_placeholder']) ? $options['search_placeholder'] : 'Ara... (Site, Haber, Uygulama, E-Book, Galeri, AI)';
    ?>
    <input type="text" name="onenav_options[search_placeholder]" value="<?php echo esc_attr($placeholder); ?>" style="width: 400px;" />
    <?php
}

function onenav_popular_sites_title_field() {
    $options = get_option('onenav_options');
    $title = isset($options['popular_sites_title']) ? $options['popular_sites_title'] : 'Popüler Siteler';
    ?>
    <input type="text" name="onenav_options[popular_sites_title]" value="<?php echo esc_attr($title); ?>" style="width: 400px;" />
    <?php
}

function onenav_ebook_section_title_field() {
    $options = get_option('onenav_options');
    $title = isset($options['ebook_section_title']) ? $options['ebook_section_title'] : 'E-Kitaplar & Dergiler';
    ?>
    <input type="text" name="onenav_options[ebook_section_title]" value="<?php echo esc_attr($title); ?>" style="width: 400px;" />
    <?php
}

function onenav_blog_layout_field() {
    $options = get_option('onenav_options');
    $layout = isset($options['blog_layout']) ? $options['blog_layout'] : 'full_width';
    ?>
    <select name="onenav_options[blog_layout]">
        <option value="full_width" <?php selected($layout, 'full_width'); ?>>Full Width</option>
        <option value="with_sidebar" <?php selected($layout, 'with_sidebar'); ?>>With Sidebar</option>
    </select>
    <?php
}

function onenav_show_author_field() {
    $options = get_option('onenav_options');
    $show_author = isset($options['show_author']) ? $options['show_author'] : '1';
    ?>
    <input type="checkbox" name="onenav_options[show_author]" value="1" <?php checked($show_author, '1'); ?> />
    <label>Yazar bilgisini göster</label>
    <?php
}

function onenav_show_like_button_field() {
    $options = get_option('onenav_options');
    $show_like = isset($options['show_like_button']) ? $options['show_like_button'] : '1';
    ?>
    <input type="checkbox" name="onenav_options[show_like_button]" value="1" <?php checked($show_like, '1'); ?> />
    <label>Beğeni butonunu göster</label>
    <?php
}

function onenav_ai_columns_field() {
    $options = get_option('onenav_options');
    $columns = isset($options['ai_columns']) ? $options['ai_columns'] : '3';
    ?>
    <input type="number" name="onenav_options[ai_columns]" value="<?php echo esc_attr($columns); ?>" min="1" max="6" />
    <?php
}

function onenav_ai_load_more_text_field() {
    $options = get_option('onenav_options');
    $text = isset($options['ai_load_more_text']) ? $options['ai_load_more_text'] : 'Daha Fazla Yükle';
    ?>
    <input type="text" name="onenav_options[ai_load_more_text]" value="<?php echo esc_attr($text); ?>" style="width: 300px;" />
    <?php
}

function onenav_ai_filter_titles_field() {
    $options = get_option('onenav_options');
    $filters = isset($options['ai_filter_titles']) ? $options['ai_filter_titles'] : 'Tümü,Metin,Görsel,Video,Ses,Kod';
    ?>
    <input type="text" name="onenav_options[ai_filter_titles]" value="<?php echo esc_attr($filters); ?>" style="width: 400px;" />
    <p class="description">Virgülle ayırarak yazın. Örnek: Tümü,Metin,Görsel,Video</p>
    <?php
}

function onenav_ebook_buy_text_field() {
    $options = get_option('onenav_options');
    $text = isset($options['ebook_buy_text']) ? $options['ebook_buy_text'] : 'Basılı Kitabı Satın Al';
    ?>
    <input type="text" name="onenav_options[ebook_buy_text]" value="<?php echo esc_attr($text); ?>" style="width: 300px;" />
    <?php
}

function onenav_ebook_download_text_field() {
    $options = get_option('onenav_options');
    $text = isset($options['ebook_download_text']) ? $options['ebook_download_text'] : 'E-Kitabı İndir';
    ?>
    <input type="text" name="onenav_options[ebook_download_text]" value="<?php echo esc_attr($text); ?>" style="width: 300px;" />
    <?php
}

function onenav_ebook_related_title_field() {
    $options = get_option('onenav_options');
    $title = isset($options['ebook_related_title']) ? $options['ebook_related_title'] : 'İlgili Kitaplar';
    ?>
    <input type="text" name="onenav_options[ebook_related_title]" value="<?php echo esc_attr($title); ?>" style="width: 300px;" />
    <?php
}

function onenav_ebook_excerpt_length_field() {
    $options = get_option('onenav_options');
    $length = isset($options['ebook_excerpt_length']) ? $options['ebook_excerpt_length'] : '150';
    ?>
    <input type="number" name="onenav_options[ebook_excerpt_length]" value="<?php echo esc_attr($length); ?>" min="50" max="500" />
    <p class="description">Karakter sayısı</p>
    <?php
}

function onenav_dark_mode_enabled_field() {
    $options = get_option('onenav_options');
    $enabled = isset($options['dark_mode_enabled']) ? $options['dark_mode_enabled'] : '0';
    ?>
    <input type="checkbox" name="onenav_options[dark_mode_enabled]" value="1" <?php checked($enabled, '1'); ?> />
    <label>Dark mode'u varsayılan olarak aktif et</label>
    <?php
}

function onenav_dark_mode_color_field() {
    $options = get_option('onenav_options');
    $color = isset($options['dark_mode_color']) ? $options['dark_mode_color'] : '#0f172a';
    ?>
    <input type="color" name="onenav_options[dark_mode_color]" value="<?php echo esc_attr($color); ?>" />
    <?php
}

// Sanitize Settings
function onenav_sanitize_settings($input) {
    $sanitized = array();

    if (isset($input['site_logo'])) {
        $sanitized['site_logo'] = esc_url_raw($input['site_logo']);
    }
    if (isset($input['favicon'])) {
        $sanitized['favicon'] = esc_url_raw($input['favicon']);
    }
    if (isset($input['primary_color'])) {
        $sanitized['primary_color'] = sanitize_hex_color($input['primary_color']);
    }
    if (isset($input['footer_text'])) {
        $sanitized['footer_text'] = sanitize_textarea_field($input['footer_text']);
    }
    if (isset($input['hero_bg'])) {
        $sanitized['hero_bg'] = esc_url_raw($input['hero_bg']);
    }
    if (isset($input['search_placeholder'])) {
        $sanitized['search_placeholder'] = sanitize_text_field($input['search_placeholder']);
    }
    if (isset($input['popular_sites_title'])) {
        $sanitized['popular_sites_title'] = sanitize_text_field($input['popular_sites_title']);
    }
    if (isset($input['ebook_section_title'])) {
        $sanitized['ebook_section_title'] = sanitize_text_field($input['ebook_section_title']);
    }
    if (isset($input['blog_layout'])) {
        $sanitized['blog_layout'] = sanitize_text_field($input['blog_layout']);
    }
    if (isset($input['show_author'])) {
        $sanitized['show_author'] = '1';
    } else {
        $sanitized['show_author'] = '0';
    }
    if (isset($input['show_like_button'])) {
        $sanitized['show_like_button'] = '1';
    } else {
        $sanitized['show_like_button'] = '0';
    }
    if (isset($input['ai_columns'])) {
        $sanitized['ai_columns'] = absint($input['ai_columns']);
    }
    if (isset($input['ai_load_more_text'])) {
        $sanitized['ai_load_more_text'] = sanitize_text_field($input['ai_load_more_text']);
    }
    if (isset($input['ai_filter_titles'])) {
        $sanitized['ai_filter_titles'] = sanitize_text_field($input['ai_filter_titles']);
    }
    if (isset($input['ebook_buy_text'])) {
        $sanitized['ebook_buy_text'] = sanitize_text_field($input['ebook_buy_text']);
    }
    if (isset($input['ebook_download_text'])) {
        $sanitized['ebook_download_text'] = sanitize_text_field($input['ebook_download_text']);
    }
    if (isset($input['ebook_related_title'])) {
        $sanitized['ebook_related_title'] = sanitize_text_field($input['ebook_related_title']);
    }
    if (isset($input['ebook_excerpt_length'])) {
        $sanitized['ebook_excerpt_length'] = absint($input['ebook_excerpt_length']);
    }
    if (isset($input['dark_mode_enabled'])) {
        $sanitized['dark_mode_enabled'] = '1';
    } else {
        $sanitized['dark_mode_enabled'] = '0';
    }
    if (isset($input['dark_mode_color'])) {
        $sanitized['dark_mode_color'] = sanitize_hex_color($input['dark_mode_color']);
    }

    return $sanitized;
}

// Render Settings Page
function onenav_render_settings_page() {
    ?>
    <div class="wrap">
        <h1><i class="fa fa-cog"></i> <?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('onenav_options_group');
            do_settings_sections('onenav-settings');
            submit_button('Ayarları Kaydet');
            ?>
        </form>
    </div>
    <script>
    jQuery(document).ready(function($) {
        $('.onenav-upload-button').on('click', function(e) {
            e.preventDefault();
            var button = $(this);
            var targetId = button.data('target');
            var image = wp.media({
                title: 'Resim Seç',
                multiple: false
            }).open()
            .on('select', function() {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $('#' + targetId).val(image_url);
                button.after('<br><img src="' + image_url + '" style="max-width: 200px; margin-top: 10px;" />');
            });
        });
    });
    </script>
    <?php
}

// Enqueue media uploader in admin
function onenav_enqueue_admin_media() {
    if (isset($_GET['page']) && $_GET['page'] === 'onenav-settings') {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
    }
}
add_action('admin_enqueue_scripts', 'onenav_enqueue_admin_media');

// Helper function to get theme option
function onenav_get_option($key, $default = '') {
    $options = get_option('onenav_options');
    return isset($options[$key]) ? $options[$key] : $default;
}
