<?php
/**
 * Home Page Template - Modern OneNav Design
 *
 * @package OneNav
 */

get_header();
?>

<!-- Hero Search Section -->
<?php
if (get_theme_mod('onenav_show_hero', true)) {
    get_template_part('template-parts/components/hero', 'search');
}
?>

<div class="main-wrapper">
    <!-- Category Sidebar -->
    <?php
    if (get_theme_mod('onenav_show_category_sidebar', true)) {
        get_template_part('template-parts/components/category', 'sidebar');
    }
    ?>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container">

            <?php
            /**
             * Display sections based on customizer settings
             * Each section can be enabled/disabled from theme customizer
             */

            // Popular Sites Section
            if (get_theme_mod('onenav_show_popular', true)) {
                get_template_part('template-parts/sections/section', 'sites');
            }

            // News Section
            if (get_theme_mod('onenav_show_news', true)) {
                get_template_part('template-parts/sections/section', 'news');
            }

            // Mobile Apps Section
            if (get_theme_mod('onenav_show_apps', true)) {
                get_template_part('template-parts/sections/section', 'apps');
            }

            // AI Tools Section
            if (get_theme_mod('onenav_show_ai_tools', true)) {
                get_template_part('template-parts/sections/section', 'ai-tools');
            }

            // E-Books Section
            if (get_theme_mod('onenav_show_ebooks', true)) {
                get_template_part('template-parts/sections/section', 'ebooks');
            }

            // Gallery Section
            if (get_theme_mod('onenav_show_galleries', true)) {
                get_template_part('template-parts/sections/section', 'gallery');
            }
            ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>
