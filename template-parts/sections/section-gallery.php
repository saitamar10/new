<?php
/**
 * Section: Gallery
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

if (!get_theme_mod('onenav_show_galleries', true)) return;

$items_count = get_theme_mod('onenav_galleries_count', 12);
$section_title = get_theme_mod('onenav_galleries_section_title', '🖼️ Foto Galeriler');

$gallery_query = new WP_Query(array(
    'post_type' => 'gallery',
    'posts_per_page' => $items_count,
));

if (!$gallery_query->have_posts()) return;
?>

<div class="section gallery-section" id="gallery-section">
    <div class="section-header">
        <h2 class="section-title">
            <span class="section-icon">🖼️</span>
            <?php echo esc_html($section_title); ?>
        </h2>
        <a href="<?php echo home_url('/gallery/'); ?>" class="view-all-btn">
            Tümünü Gör <span class="arrow">→</span>
        </a>
    </div>

    <div class="gallery-grid">
        <?php
        while ($gallery_query->have_posts()):
            $gallery_query->the_post();
            get_template_part('template-parts/components/card', 'gallery');
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>
