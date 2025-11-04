<?php
/**
 * Component: Category Sidebar Navigation
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

if (!get_theme_mod('onenav_show_category_sidebar', true)) return;
?>

<aside class="category-sidebar">
    <div class="sidebar-sticky">
        <div class="sidebar-header">
            <h3><?php echo esc_html(get_theme_mod('onenav_sidebar_title', 'Kategoriler')); ?></h3>
        </div>

        <nav class="category-nav">
            <?php
            $show_all_active = !isset($_GET['category']) ? 'active' : '';
            ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="category-nav-item <?php echo $show_all_active; ?>">
                <span class="category-icon">🏠</span>
                <span class="category-name">Tümü</span>
            </a>

            <?php
            $categories = get_terms(array(
                'taxonomy' => 'site_category',
                'hide_empty' => false,
                'orderby' => 'count',
                'order' => 'DESC',
            ));

            if (!empty($categories) && !is_wp_error($categories)):
                foreach ($categories as $category):
                    $active = (isset($_GET['category']) && $_GET['category'] == $category->slug) ? 'active' : '';
                    $cat_link = add_query_arg('category', $category->slug, home_url('/'));
                    ?>
                    <a href="<?php echo esc_url($cat_link); ?>" class="category-nav-item <?php echo $active; ?>" data-category="<?php echo esc_attr($category->slug); ?>">
                        <span class="category-icon">📁</span>
                        <span class="category-name"><?php echo esc_html($category->name); ?></span>
                        <span class="category-count"><?php echo $category->count; ?></span>
                    </a>
                    <?php
                endforeach;
            endif;
            ?>
        </nav>

        <?php if (get_theme_mod('onenav_show_sidebar_stats', true)): ?>
        <div class="sidebar-stats">
            <div class="stat-item">
                <span class="stat-value"><?php echo wp_count_posts('site')->publish; ?></span>
                <span class="stat-label">Siteler</span>
            </div>
            <div class="stat-item">
                <span class="stat-value"><?php echo wp_count_posts('app')->publish; ?></span>
                <span class="stat-label">Uygulamalar</span>
            </div>
            <div class="stat-item">
                <span class="stat-value"><?php echo wp_count_posts('ai_tool')->publish; ?></span>
                <span class="stat-label">AI Araçları</span>
            </div>
        </div>
        <?php endif; ?>
    </div>
</aside>
