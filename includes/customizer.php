<?php
/**
 * OneNav - Customizer Settings
 * 
 * @package OneNav
 */

if (!defined('ABSPATH')) {
    exit;
}

function onenav_customize_register($wp_customize) {
    // ============================================
    // GENERAL SETTINGS
    // ============================================
    
    $wp_customize->add_section('onenav_general', array(
        'title' => esc_html__('OneNav - Genel Ayarlar', 'onenav'),
        'priority' => 30,
    ));

    // Primary Color
    $wp_customize->add_setting('onenav_primary_color', array(
        'default' => '#a855f7',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'onenav_primary_color', array(
        'label' => esc_html__('Ana Renk', 'onenav'),
        'section' => 'onenav_general',
        'settings' => 'onenav_primary_color',
    )));

    // Secondary Color
    $wp_customize->add_setting('onenav_secondary_color', array(
        'default' => '#ec4899',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'onenav_secondary_color', array(
        'label' => esc_html__('İkincil Renk', 'onenav'),
        'section' => 'onenav_general',
        'settings' => 'onenav_secondary_color',
    )));

    // ============================================
    // HEADER SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_header', array(
        'title' => esc_html__('OneNav - Header Ayarları', 'onenav'),
        'priority' => 40,
    ));

    // Show Trending Bar
    $wp_customize->add_setting('onenav_show_trending', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_show_trending', array(
        'label' => esc_html__('Trend Bar Göster', 'onenav'),
        'section' => 'onenav_header',
        'type' => 'checkbox',
    ));

    // Trending Source
    $wp_customize->add_setting('onenav_trending_source', array(
        'default' => 'google',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_trending_source', array(
        'label' => esc_html__('Trend Kaynağı', 'onenav'),
        'section' => 'onenav_header',
        'type' => 'select',
        'choices' => array(
            'google' => 'Google Trends',
            'yandex' => 'Yandex Trends',
            'custom' => 'Özel Girdi',
        ),
    ));

    // Custom Trends
    $wp_customize->add_setting('onenav_custom_trends', array(
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('onenav_custom_trends', array(
        'label' => esc_html__('Özel Trendler (Her satırda bir trend)', 'onenav'),
        'section' => 'onenav_header',
        'type' => 'textarea',
    ));

    // ============================================
    // HOME PAGE SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_homepage', array(
        'title' => esc_html__('OneNav - Ana Sayfa Ayarları', 'onenav'),
        'priority' => 50,
    ));

    // Show Popular Sites
    $wp_customize->add_setting('onenav_show_popular', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_show_popular', array(
        'label' => esc_html__('Popüler Siteler Göster', 'onenav'),
        'section' => 'onenav_homepage',
        'type' => 'checkbox',
    ));

    // Show News
    $wp_customize->add_setting('onenav_show_news', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_show_news', array(
        'label' => esc_html__('Haberler Göster', 'onenav'),
        'section' => 'onenav_homepage',
        'type' => 'checkbox',
    ));

    // Show Apps
    $wp_customize->add_setting('onenav_show_apps', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_show_apps', array(
        'label' => esc_html__('Uygulamalar Göster', 'onenav'),
        'section' => 'onenav_homepage',
        'type' => 'checkbox',
    ));

    // Show E-Books
    $wp_customize->add_setting('onenav_show_ebooks', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_show_ebooks', array(
        'label' => esc_html__('E-Kitaplar Göster', 'onenav'),
        'section' => 'onenav_homepage',
        'type' => 'checkbox',
    ));

    // Show AI Tools
    $wp_customize->add_setting('onenav_show_ai_tools', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_show_ai_tools', array(
        'label' => esc_html__('AI Araçları Göster', 'onenav'),
        'section' => 'onenav_homepage',
        'type' => 'checkbox',
    ));

    // Show Galleries
    $wp_customize->add_setting('onenav_show_galleries', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_show_galleries', array(
        'label' => esc_html__('Galeriler Göster', 'onenav'),
        'section' => 'onenav_homepage',
        'type' => 'checkbox',
    ));

    // Items Per Section
    $wp_customize->add_setting('onenav_items_per_section', array(
        'default' => 12,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_items_per_section', array(
        'label' => esc_html__('Her Bölümde Gösterilecek Öğe Sayısı', 'onenav'),
        'section' => 'onenav_homepage',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 50,
            'step' => 1,
        ),
    ));

    // ============================================
    // SEARCH SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_search', array(
        'title' => esc_html__('OneNav - Arama Ayarları', 'onenav'),
        'priority' => 60,
    ));

    // Search Placeholder
    $wp_customize->add_setting('onenav_search_placeholder', array(
        'default' => 'Ara...',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_search_placeholder', array(
        'label' => esc_html__('Arama Kutusu Placeholder', 'onenav'),
        'section' => 'onenav_search',
        'type' => 'text',
    ));

    // ============================================
    // FOOTER SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_footer', array(
        'title' => esc_html__('OneNav - Footer Ayarları', 'onenav'),
        'priority' => 70,
    ));

    // Footer Background Color
    $wp_customize->add_setting('onenav_footer_bg_color', array(
        'default' => '#0f172a',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'onenav_footer_bg_color', array(
        'label' => esc_html__('Footer Arka Plan Rengi', 'onenav'),
        'section' => 'onenav_footer',
        'settings' => 'onenav_footer_bg_color',
    )));

    // Footer Text
    $wp_customize->add_setting('onenav_footer_text', array(
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('onenav_footer_text', array(
        'label' => esc_html__('Footer Metni', 'onenav'),
        'section' => 'onenav_footer',
        'type' => 'textarea',
    ));

    // Show Social Icons
    $wp_customize->add_setting('onenav_show_social', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_show_social', array(
        'label' => esc_html__('Sosyal Medya İkonları Göster', 'onenav'),
        'section' => 'onenav_footer',
        'type' => 'checkbox',
    ));

    // ============================================
    // API SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_api', array(
        'title' => esc_html__('OneNav - API Ayarları', 'onenav'),
        'priority' => 80,
    ));

    // NewsAPI Key
    $wp_customize->add_setting('onenav_newsapi_key', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_newsapi_key', array(
        'label' => esc_html__('NewsAPI Anahtarı', 'onenav'),
        'section' => 'onenav_api',
        'type' => 'password',
        'description' => 'https://newsapi.org adresinden alınız',
    ));

    // QR Code Settings
    $wp_customize->add_setting('onenav_qr_size', array(
        'default' => 200,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_qr_size', array(
        'label' => esc_html__('QR Kod Boyutu (px)', 'onenav'),
        'section' => 'onenav_api',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 100,
            'max' => 500,
            'step' => 50,
        ),
    ));
}
add_action('customize_register', 'onenav_customize_register');

// ============================================
// OUTPUT CUSTOMIZER CSS
// ============================================

function onenav_customizer_css() {
    $primary_color = get_theme_mod('onenav_primary_color', '#a855f7');
    $secondary_color = get_theme_mod('onenav_secondary_color', '#ec4899');
    $footer_bg = get_theme_mod('onenav_footer_bg_color', '#0f172a');

    $css = ":root {
        --primary-color: {$primary_color};
        --secondary-color: {$secondary_color};
    }
    
    footer {
        background-color: {$footer_bg};
    }";

    wp_add_inline_style('onenav-main', $css);
}
add_action('wp_enqueue_scripts', 'onenav_customizer_css');
