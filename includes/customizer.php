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

    // ============================================
    // TYPOGRAPHY SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_typography', array(
        'title' => esc_html__('OneNav - Tipografi Ayarları', 'onenav'),
        'priority' => 90,
        'description' => 'Yazı boyutlarını ve okunabilirlik ayarlarını yapılandırın',
    ));

    // Base Font Size
    $wp_customize->add_setting('onenav_base_font_size', array(
        'default' => 16,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_base_font_size', array(
        'label' => esc_html__('Temel Yazı Boyutu (px)', 'onenav'),
        'section' => 'onenav_typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 12,
            'max' => 24,
            'step' => 1,
        ),
    ));

    // News Post Font Size
    $wp_customize->add_setting('onenav_news_font_size', array(
        'default' => 16,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_news_font_size', array(
        'label' => esc_html__('Haber Yazı Boyutu (px)', 'onenav'),
        'section' => 'onenav_typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 12,
            'max' => 24,
            'step' => 1,
        ),
    ));

    // App Post Font Size
    $wp_customize->add_setting('onenav_app_font_size', array(
        'default' => 14,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_app_font_size', array(
        'label' => esc_html__('Uygulama Yazı Boyutu (px)', 'onenav'),
        'section' => 'onenav_typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 12,
            'max' => 24,
            'step' => 1,
        ),
    ));

    // Book Post Font Size
    $wp_customize->add_setting('onenav_book_font_size', array(
        'default' => 18,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_book_font_size', array(
        'label' => esc_html__('Kitap Okuma Yazı Boyutu (px)', 'onenav'),
        'section' => 'onenav_typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 14,
            'max' => 28,
            'step' => 1,
        ),
    ));

    // Line Height
    $wp_customize->add_setting('onenav_line_height', array(
        'default' => 1.6,
        'sanitize_callback' => 'onenav_sanitize_float',
    ));

    $wp_customize->add_control('onenav_line_height', array(
        'label' => esc_html__('Satır Yüksekliği', 'onenav'),
        'section' => 'onenav_typography',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1.2,
            'max' => 2.5,
            'step' => 0.1,
        ),
    ));

    // ============================================
    // TRANSPARENCY & COLOR COMFORT SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_appearance', array(
        'title' => esc_html__('OneNav - Görünüm & Şeffaflık', 'onenav'),
        'priority' => 95,
        'description' => 'Göz yorgunluğunu azaltmak için renk ve şeffaflık ayarları',
    ));

    // Card Transparency
    $wp_customize->add_setting('onenav_card_transparency', array(
        'default' => 100,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_card_transparency', array(
        'label' => esc_html__('Kart Şeffaflığı (%)', 'onenav'),
        'section' => 'onenav_appearance',
        'type' => 'range',
        'input_attrs' => array(
            'min' => 50,
            'max' => 100,
            'step' => 5,
        ),
        'description' => 'Kartların opaklık seviyesi (düşük değer = daha şeffaf)',
    ));

    // Background Overlay Color
    $wp_customize->add_setting('onenav_bg_overlay_color', array(
        'default' => '#f8fafc',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'onenav_bg_overlay_color', array(
        'label' => esc_html__('Arkaplan Rengi', 'onenav'),
        'section' => 'onenav_appearance',
    )));

    // Content Background Color
    $wp_customize->add_setting('onenav_content_bg_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'onenav_content_bg_color', array(
        'label' => esc_html__('İçerik Arkaplan Rengi', 'onenav'),
        'section' => 'onenav_appearance',
    )));

    // Reading Mode
    $wp_customize->add_setting('onenav_reading_mode', array(
        'default' => 'light',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_reading_mode', array(
        'label' => esc_html__('Okuma Modu', 'onenav'),
        'section' => 'onenav_appearance',
        'type' => 'select',
        'choices' => array(
            'light' => 'Açık Mod (Beyaz arka plan)',
            'sepia' => 'Sepia Mod (Göz dostu kahverengi)',
            'dark' => 'Karanlık Mod (Siyah arka plan)',
            'custom' => 'Özel Renkler',
        ),
    ));

    // Custom Reading Background
    $wp_customize->add_setting('onenav_reading_bg', array(
        'default' => '#fef3e0',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'onenav_reading_bg', array(
        'label' => esc_html__('Özel Okuma Arkaplanı', 'onenav'),
        'section' => 'onenav_appearance',
    )));

    // Custom Reading Text Color
    $wp_customize->add_setting('onenav_reading_text', array(
        'default' => '#3e2723',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'onenav_reading_text', array(
        'label' => esc_html__('Özel Okuma Metin Rengi', 'onenav'),
        'section' => 'onenav_appearance',
    )));

    // ============================================
    // POST TYPE DISPLAY SETTINGS
    // ============================================

    $wp_customize->add_section('onenav_post_types', array(
        'title' => esc_html__('OneNav - İçerik Türü Ayarları', 'onenav'),
        'priority' => 100,
        'description' => 'Farklı içerik türleri için görünüm ayarları',
    ));

    // News Display Style
    $wp_customize->add_setting('onenav_news_style', array(
        'default' => 'magazine',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_news_style', array(
        'label' => esc_html__('Haber Görünüm Stili', 'onenav'),
        'section' => 'onenav_post_types',
        'type' => 'select',
        'choices' => array(
            'magazine' => 'Dergi Stili',
            'newspaper' => 'Gazete Stili',
            'card' => 'Kart Stili',
            'list' => 'Liste Stili',
        ),
    ));

    // Show News Date
    $wp_customize->add_setting('onenav_news_show_date', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_news_show_date', array(
        'label' => esc_html__('Haber Tarihini Göster', 'onenav'),
        'section' => 'onenav_post_types',
        'type' => 'checkbox',
    ));

    // Show News Author
    $wp_customize->add_setting('onenav_news_show_author', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_news_show_author', array(
        'label' => esc_html__('Haber Yazarını Göster', 'onenav'),
        'section' => 'onenav_post_types',
        'type' => 'checkbox',
    ));

    // App Store Style
    $wp_customize->add_setting('onenav_app_store_style', array(
        'default' => 'playstore',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_app_store_style', array(
        'label' => esc_html__('Uygulama Mağaza Stili', 'onenav'),
        'section' => 'onenav_post_types',
        'type' => 'select',
        'choices' => array(
            'playstore' => 'Google Play Store Stili',
            'appstore' => 'Apple App Store Stili',
            'minimal' => 'Minimal Stil',
        ),
    ));

    // eBook Reader Style
    $wp_customize->add_setting('onenav_ebook_reader_style', array(
        'default' => 'inline',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('onenav_ebook_reader_style', array(
        'label' => esc_html__('E-Kitap Okuyucu Stili', 'onenav'),
        'section' => 'onenav_post_types',
        'type' => 'select',
        'choices' => array(
            'inline' => 'Sayfa içi okuma (PDF gömülü)',
            'download' => 'Sadece indirme butonu',
            'both' => 'Her ikisi de (Oku + İndir)',
        ),
    ));

    // Enable PDF.js
    $wp_customize->add_setting('onenav_enable_pdfjs', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('onenav_enable_pdfjs', array(
        'label' => esc_html__('PDF.js Okuyucu Etkinleştir', 'onenav'),
        'section' => 'onenav_post_types',
        'type' => 'checkbox',
        'description' => 'Tarayıcıda PDF okuma için PDF.js kullan',
    ));
}
add_action('customize_register', 'onenav_customize_register');

// ============================================
// SANITIZATION CALLBACKS
// ============================================

function onenav_sanitize_float($value) {
    return floatval($value);
}

// ============================================
// OUTPUT CUSTOMIZER CSS
// ============================================

function onenav_customizer_css() {
    // Colors
    $primary_color = get_theme_mod('onenav_primary_color', '#a855f7');
    $secondary_color = get_theme_mod('onenav_secondary_color', '#ec4899');
    $footer_bg = get_theme_mod('onenav_footer_bg_color', '#0f172a');
    $bg_overlay = get_theme_mod('onenav_bg_overlay_color', '#f8fafc');
    $content_bg = get_theme_mod('onenav_content_bg_color', '#ffffff');

    // Typography
    $base_font = get_theme_mod('onenav_base_font_size', 16);
    $news_font = get_theme_mod('onenav_news_font_size', 16);
    $app_font = get_theme_mod('onenav_app_font_size', 14);
    $book_font = get_theme_mod('onenav_book_font_size', 18);
    $line_height = get_theme_mod('onenav_line_height', 1.6);

    // Transparency
    $card_transparency = get_theme_mod('onenav_card_transparency', 100);
    $card_opacity = $card_transparency / 100;

    // Reading Mode
    $reading_mode = get_theme_mod('onenav_reading_mode', 'light');
    $reading_bg = get_theme_mod('onenav_reading_bg', '#fef3e0');
    $reading_text = get_theme_mod('onenav_reading_text', '#3e2723');

    // Generate reading mode colors
    $reading_bg_color = '#ffffff';
    $reading_text_color = '#1e293b';

    switch ($reading_mode) {
        case 'sepia':
            $reading_bg_color = '#fef3e0';
            $reading_text_color = '#3e2723';
            break;
        case 'dark':
            $reading_bg_color = '#1e293b';
            $reading_text_color = '#f1f5f9';
            break;
        case 'custom':
            $reading_bg_color = $reading_bg;
            $reading_text_color = $reading_text;
            break;
    }

    $css = "
    :root {
        --primary-color: {$primary_color};
        --secondary-color: {$secondary_color};
        --bg-overlay: {$bg_overlay};
        --content-bg: {$content_bg};
        --base-font-size: {$base_font}px;
        --news-font-size: {$news_font}px;
        --app-font-size: {$app_font}px;
        --book-font-size: {$book_font}px;
        --line-height: {$line_height};
        --card-opacity: {$card_opacity};
        --reading-bg: {$reading_bg_color};
        --reading-text: {$reading_text_color};
    }

    body {
        font-size: var(--base-font-size);
        line-height: var(--line-height);
        background-color: var(--bg-overlay);
    }

    footer {
        background-color: {$footer_bg};
    }

    /* Card transparency */
    .site-card,
    .news-card,
    .app-card,
    .ebook-card,
    .gallery-card,
    .ai-tool-card,
    .marketplace-card {
        background-color: var(--content-bg);
        opacity: var(--card-opacity);
    }

    .filter-tabs {
        background-color: var(--content-bg);
        opacity: var(--card-opacity);
    }

    /* News typography */
    .single-news .entry-content,
    .news-content {
        font-size: var(--news-font-size);
    }

    /* App typography */
    .single-app .entry-content,
    .app-description {
        font-size: var(--app-font-size);
    }

    /* Book typography - reading comfort */
    .single-ebook .entry-content,
    .ebook-reader-content {
        font-size: var(--book-font-size);
        background-color: var(--reading-bg);
        color: var(--reading-text);
        padding: 40px;
        max-width: 800px;
        margin: 0 auto;
        line-height: calc(var(--line-height) * 1.2);
    }

    /* Transparent overlay effect */
    main::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--bg-overlay);
        opacity: 0.95;
        pointer-events: none;
        z-index: -1;
    }
    ";

    wp_add_inline_style('onenav-style', $css);
}
add_action('wp_enqueue_scripts', 'onenav_customizer_css');
