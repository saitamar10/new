<?php
/**
 * Section: E-Books
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

if (!get_theme_mod('onenav_show_ebooks', true)) return;

$items_count = get_theme_mod('onenav_ebooks_count', 12);
$section_title = get_theme_mod('onenav_ebooks_section_title', '📚 E-Kitaplar & Rehberler');

$ebooks_query = new WP_Query(array(
    'post_type' => 'ebook',
    'posts_per_page' => $items_count,
));

if (!$ebooks_query->have_posts()) return;
?>

<div class="section ebooks-section" id="ebooks-section">
    <div class="section-header">
        <h2 class="section-title">
            <span class="section-icon">📚</span>
            <?php echo esc_html($section_title); ?>
        </h2>
        <a href="<?php echo home_url('/ebook/'); ?>" class="view-all-btn">
            Tümünü Gör <span class="arrow">→</span>
        </a>
    </div>

    <div class="ebooks-grid">
        <?php
        while ($ebooks_query->have_posts()):
            $ebooks_query->the_post();
            get_template_part('template-parts/components/card', 'ebook');
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>
