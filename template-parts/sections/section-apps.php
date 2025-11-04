<?php
/**
 * Section: Mobile Apps
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

if (!get_theme_mod('onenav_show_apps', true)) return;

$items_count = get_theme_mod('onenav_apps_count', 12);
$section_title = get_theme_mod('onenav_apps_section_title', '📱 Mobil Uygulamalar');

$apps_query = new WP_Query(array(
    'post_type' => 'app',
    'posts_per_page' => $items_count,
));

if (!$apps_query->have_posts()) return;
?>

<div class="section apps-section" id="apps-section">
    <div class="section-header">
        <h2 class="section-title">
            <span class="section-icon">📱</span>
            <?php echo esc_html($section_title); ?>
        </h2>
        <a href="<?php echo home_url('/app/'); ?>" class="view-all-btn">
            Tümünü Gör <span class="arrow">→</span>
        </a>
    </div>

    <div class="apps-grid">
        <?php
        while ($apps_query->have_posts()):
            $apps_query->the_post();
            get_template_part('template-parts/components/card', 'app');
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>
