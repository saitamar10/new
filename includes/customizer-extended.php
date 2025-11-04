<?php
/**
 * OneNav - Extended Customizer Settings
 * Advanced theme customization options
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

function onenav_extended_customizer($wp_customize) {

    // ============================================
    // HERO SECTION SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_hero_section', array(
        'title' => esc_html__('OneNav - Hero Bölümü', 'onenav'),
        'priority' => 35,
    ));

    // Show Hero Section
    $wp_customize->add_setting('onenav_show_hero', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('onenav_show_hero', array(
        'label' => esc_html__('Hero Bölümünü Göster', 'onenav'),
        'section' => 'onenav_hero_section',
        'type' => 'checkbox',
    ));

    // Hero Title
    $wp_customize->add_setting('onenav_hero_title', array(
        'default' => 'Navigasyon Portalına Hoş Geldiniz',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_hero_title', array(
        'label' => esc_html__('Hero Başlık', 'onenav'),
        'section' => 'onenav_hero_section',
        'type' => 'text',
    ));

    // Show Hero Title
    $wp_customize->add_setting('onenav_show_hero_title', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('onenav_show_hero_title', array(
        'label' => esc_html__('Başlığı Göster', 'onenav'),
        'section' => 'onenav_hero_section',
        'type' => 'checkbox',
    ));

    // Hero Subtitle
    $wp_customize->add_setting('onenav_hero_subtitle', array(
        'default' => 'En popüler siteleri, uygulamaları ve içerikleri keşfedin',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('onenav_hero_subtitle', array(
        'label' => esc_html__('Hero Alt Başlık', 'onenav'),
        'section' => 'onenav_hero_section',
        'type' => 'textarea',
    ));

    // Show Hero Subtitle
    $wp_customize->add_setting('onenav_show_hero_subtitle', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('onenav_show_hero_subtitle', array(
        'label' => esc_html__('Alt Başlığı Göster', 'onenav'),
        'section' => 'onenav_hero_section',
        'type' => 'checkbox',
    ));

    // Show Hero Search
    $wp_customize->add_setting('onenav_show_hero_search', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('onenav_show_hero_search', array(
        'label' => esc_html__('Arama Kutusunu Göster', 'onenav'),
        'section' => 'onenav_hero_section',
        'type' => 'checkbox',
    ));

    // Show Hero Categories
    $wp_customize->add_setting('onenav_show_hero_categories', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('onenav_show_hero_categories', array(
        'label' => esc_html__('Hızlı Kategori Bağlantılarını Göster', 'onenav'),
        'section' => 'onenav_hero_section',
        'type' => 'checkbox',
    ));

    // ============================================
    // CATEGORY SIDEBAR SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_sidebar_section', array(
        'title' => esc_html__('OneNav - Kategori Sidebar', 'onenav'),
        'priority' => 36,
    ));

    // Show Category Sidebar
    $wp_customize->add_setting('onenav_show_category_sidebar', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('onenav_show_category_sidebar', array(
        'label' => esc_html__('Kategori Sidebar Göster', 'onenav'),
        'section' => 'onenav_sidebar_section',
        'type' => 'checkbox',
    ));

    // Sidebar Title
    $wp_customize->add_setting('onenav_sidebar_title', array(
        'default' => 'Kategoriler',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_sidebar_title', array(
        'label' => esc_html__('Sidebar Başlık', 'onenav'),
        'section' => 'onenav_sidebar_section',
        'type' => 'text',
    ));

    // Show Sidebar Stats
    $wp_customize->add_setting('onenav_show_sidebar_stats', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('onenav_show_sidebar_stats', array(
        'label' => esc_html__('İstatistikleri Göster', 'onenav'),
        'section' => 'onenav_sidebar_section',
        'type' => 'checkbox',
    ));

    // ============================================
    // SECTION TITLES & COUNTS
    // ============================================

    $wp_customize->add_section('onenav_section_settings', array(
        'title' => esc_html__('OneNav - Bölüm Ayarları', 'onenav'),
        'priority' => 51,
    ));

    // Sites Section
    $wp_customize->add_setting('onenav_sites_section_title', array(
        'default' => '⭐ Popüler Siteler',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_sites_section_title', array(
        'label' => esc_html__('Siteler Bölüm Başlığı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'text',
    ));

    // News Section
    $wp_customize->add_setting('onenav_news_section_title', array(
        'default' => '📰 Güncel Haberler',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_news_section_title', array(
        'label' => esc_html__('Haberler Bölüm Başlığı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('onenav_news_count', array(
        'default' => 6,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_news_count', array(
        'label' => esc_html__('Haberler Sayısı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50, 'step' => 1),
    ));

    // Apps Section
    $wp_customize->add_setting('onenav_apps_section_title', array(
        'default' => '📱 Mobil Uygulamalar',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_apps_section_title', array(
        'label' => esc_html__('Uygulamalar Bölüm Başlığı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('onenav_apps_count', array(
        'default' => 12,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_apps_count', array(
        'label' => esc_html__('Uygulamalar Sayısı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50, 'step' => 1),
    ));

    // AI Tools Section
    $wp_customize->add_setting('onenav_ai_tools_section_title', array(
        'default' => '🤖 Yapay Zeka Araçları',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_ai_tools_section_title', array(
        'label' => esc_html__('AI Araçları Bölüm Başlığı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('onenav_ai_tools_count', array(
        'default' => 12,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_ai_tools_count', array(
        'label' => esc_html__('AI Araçları Sayısı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50, 'step' => 1),
    ));

    // E-Books Section
    $wp_customize->add_setting('onenav_ebooks_section_title', array(
        'default' => '📚 E-Kitaplar & Rehberler',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_ebooks_section_title', array(
        'label' => esc_html__('E-Kitaplar Bölüm Başlığı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('onenav_ebooks_count', array(
        'default' => 12,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_ebooks_count', array(
        'label' => esc_html__('E-Kitaplar Sayısı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50, 'step' => 1),
    ));

    // Gallery Section
    $wp_customize->add_setting('onenav_galleries_section_title', array(
        'default' => '🖼️ Foto Galeriler',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_galleries_section_title', array(
        'label' => esc_html__('Galeriler Bölüm Başlığı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'text',
    ));

    $wp_customize->add_setting('onenav_galleries_count', array(
        'default' => 12,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_galleries_count', array(
        'label' => esc_html__('Galeriler Sayısı', 'onenav'),
        'section' => 'onenav_section_settings',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50, 'step' => 1),
    ));

    // ============================================
    // LAYOUT SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_layout', array(
        'title' => esc_html__('OneNav - Layout Ayarları', 'onenav'),
        'priority' => 52,
    ));

    // Grid Columns
    $wp_customize->add_setting('onenav_grid_columns', array(
        'default' => '4',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_grid_columns', array(
        'label' => esc_html__('Grid Sütun Sayısı (Desktop)', 'onenav'),
        'section' => 'onenav_layout',
        'type' => 'select',
        'choices' => array(
            '3' => '3 Sütun',
            '4' => '4 Sütun',
            '5' => '5 Sütun',
            '6' => '6 Sütun',
        ),
    ));

    // Card Border Radius
    $wp_customize->add_setting('onenav_card_radius', array(
        'default' => 12,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_card_radius', array(
        'label' => esc_html__('Kart Köşe Yuvarlama (px)', 'onenav'),
        'section' => 'onenav_layout',
        'type' => 'number',
        'input_attrs' => array('min' => 0, 'max' => 50, 'step' => 2),
    ));

    // Card Spacing
    $wp_customize->add_setting('onenav_card_spacing', array(
        'default' => 20,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_card_spacing', array(
        'label' => esc_html__('Kart Arası Boşluk (px)', 'onenav'),
        'section' => 'onenav_layout',
        'type' => 'number',
        'input_attrs' => array('min' => 5, 'max' => 50, 'step' => 5),
    ));

    // ============================================
    // DARK MODE SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_darkmode', array(
        'title' => esc_html__('OneNav - Dark Mode', 'onenav'),
        'priority' => 53,
    ));

    // Enable Dark Mode
    $wp_customize->add_setting('onenav_enable_darkmode', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('onenav_enable_darkmode', array(
        'label' => esc_html__('Dark Mode Aktif', 'onenav'),
        'section' => 'onenav_darkmode',
        'type' => 'checkbox',
    ));

    // Dark Mode Toggle Button
    $wp_customize->add_setting('onenav_show_darkmode_toggle', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('onenav_show_darkmode_toggle', array(
        'label' => esc_html__('Dark Mode Değiştirme Butonu Göster', 'onenav'),
        'section' => 'onenav_darkmode',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'onenav_extended_customizer');
