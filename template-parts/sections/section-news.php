<?php
/**
 * Section: News
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

if (!get_theme_mod('onenav_show_news', true)) return;

$items_count = get_theme_mod('onenav_news_count', 6);
$section_title = get_theme_mod('onenav_news_section_title', '📰 Güncel Haberler');

$news_query = new WP_Query(array(
    'post_type' => 'news',
    'posts_per_page' => $items_count,
    'orderby' => 'date',
    'order' => 'DESC',
));

if (!$news_query->have_posts()) return;
?>

<div class="section news-section" id="news-section">
    <div class="section-header">
        <h2 class="section-title">
            <span class="section-icon">📰</span>
            <?php echo esc_html($section_title); ?>
        </h2>
        <a href="<?php echo home_url('/news/'); ?>" class="view-all-btn">
            Tümünü Gör <span class="arrow">→</span>
        </a>
    </div>

    <div class="news-grid">
        <?php
        while ($news_query->have_posts()):
            $news_query->the_post();
            get_template_part('template-parts/components/card', 'news');
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>
