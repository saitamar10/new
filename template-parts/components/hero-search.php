<?php
/**
 * Component: Hero Search Section
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

$hero_title = get_theme_mod('onenav_hero_title', 'Navigasyon Portalına Hoş Geldiniz');
$hero_subtitle = get_theme_mod('onenav_hero_subtitle', 'En popüler siteleri, uygulamaları ve içerikleri keşfedin');
$search_placeholder = get_theme_mod('onenav_search_placeholder', 'Ne aramak istiyorsunuz?');
?>

<div class="hero-section">
    <div class="hero-content">
        <?php if (get_theme_mod('onenav_show_hero_title', true)): ?>
        <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
        <?php endif; ?>

        <?php if (get_theme_mod('onenav_show_hero_subtitle', true)): ?>
        <p class="hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
        <?php endif; ?>

        <?php if (get_theme_mod('onenav_show_hero_search', true)): ?>
        <div class="hero-search-wrapper">
            <div class="hero-search-box">
                <span class="search-icon">🔍</span>
                <input
                    type="text"
                    id="hero-search"
                    class="hero-search-input"
                    placeholder="<?php echo esc_attr($search_placeholder); ?>"
                    autocomplete="off"
                >
                <button class="hero-search-btn">Ara</button>
            </div>
            <div class="hero-search-results" style="display: none;"></div>
        </div>
        <?php endif; ?>

        <?php if (get_theme_mod('onenav_show_hero_categories', true)): ?>
        <div class="hero-quick-links">
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'site_category',
                'hide_empty' => false,
                'number' => 8,
            ));

            if (!empty($categories) && !is_wp_error($categories)):
                foreach ($categories as $category):
                    $cat_link = get_term_link($category);
                    ?>
                    <a href="<?php echo esc_url($cat_link); ?>" class="hero-category-tag">
                        <?php echo esc_html($category->name); ?>
                    </a>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
        <?php endif; ?>
    </div>
</div>
