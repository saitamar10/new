<?php
/**
 * Section: Popular Sites
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

if (!get_theme_mod('onenav_show_popular', true)) return;

$items_per_section = get_theme_mod('onenav_items_per_section', 12);
$section_title = get_theme_mod('onenav_sites_section_title', '⭐ Popüler Siteler');

$args = array(
    'post_type' => 'site',
    'posts_per_page' => $items_per_section,
    'meta_key' => 'click_count',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
);

// Category filter
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'site_category',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['category']),
        ),
    );
}

$sites_query = new WP_Query($args);

if (!$sites_query->have_posts()) return;
?>

<div class="section sites-section" id="sites-section">
    <div class="section-header">
        <h2 class="section-title">
            <span class="section-icon">⭐</span>
            <?php echo esc_html($section_title); ?>
        </h2>
        <a href="<?php echo home_url('/site-category/'); ?>" class="view-all-btn">
            Tümünü Gör <span class="arrow">→</span>
        </a>
    </div>

    <div class="sites-grid">
        <?php
        while ($sites_query->have_posts()):
            $sites_query->the_post();
            get_template_part('template-parts/components/card', 'site');
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>
