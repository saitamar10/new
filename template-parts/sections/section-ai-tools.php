<?php
/**
 * Section: AI Tools
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

if (!get_theme_mod('onenav_show_ai_tools', true)) return;

$items_count = get_theme_mod('onenav_ai_tools_count', 12);
$section_title = get_theme_mod('onenav_ai_tools_section_title', '🤖 Yapay Zeka Araçları');

$ai_query = new WP_Query(array(
    'post_type' => 'ai_tool',
    'posts_per_page' => $items_count,
));

if (!$ai_query->have_posts()) return;
?>

<div class="section ai-tools-section" id="ai-tools-section">
    <div class="section-header">
        <h2 class="section-title">
            <span class="section-icon">🤖</span>
            <?php echo esc_html($section_title); ?>
        </h2>
        <a href="<?php echo home_url('/ai-tool/'); ?>" class="view-all-btn">
            Tümünü Gör <span class="arrow">→</span>
        </a>
    </div>

    <div class="ai-tools-grid">
        <?php
        while ($ai_query->have_posts()):
            $ai_query->the_post();
            get_template_part('template-parts/components/card', 'ai-tool');
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
</div>
