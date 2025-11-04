<?php
/**
 * Header Template
 * 
 * @package OneNav
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header>
        <!-- Trending Bar -->
        <div class="trending-bar">
            <span style="display: inline-block; margin-right: 15px; font-weight: bold;">📈 GÜNDEM:</span>
            <span class="trending-content">Yükleniyor...</span>
        </div>

        <!-- Header Main -->
        <div class="header-main">
            <!-- Logo -->
            <div class="logo">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                if ($custom_logo_id) {
                    echo wp_kses_post(wp_get_attachment_image($custom_logo_id, 'full'));
                }
                ?>
                <span><?php bloginfo('name'); ?></span>
            </div>

            <!-- Search Bar -->
            <div class="search-wrapper">
                <input 
                    type="text" 
                    id="site-search" 
                    class="search-input" 
                    placeholder="Ara... (Site, Haber, Uygulama, E-Book, Galeri, AI)"
                >
                <button class="search-button">🔍</button>
                <div class="search-results" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); margin-top: 5px; z-index: 100;"></div>
            </div>

            <!-- Header Actions -->
            <div class="header-actions">
                <button class="filter-btn" title="Filtreler">⚙️ Filtreler</button>
                <button class="settings-btn" title="Ayarlar">⚙️ Ayarlar</button>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav>
            <ul>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary-menu',
                    'fallback_cb' => 'onenav_default_menu',
                    'items_wrap' => '%3$s',
                    'depth' => 2,
                ));
                ?>
            </ul>
        </nav>
    </header>

    <!-- Filter Tabs -->
    <div class="container" style="margin-top: 20px;">
        <div class="filter-tabs"></div>
    </div>

    <main>
