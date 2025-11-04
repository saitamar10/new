<?php
/**
 * Index Template - Fallback
 * 
 * @package OneNav
 */

get_header();
?>

<div class="container">
    <div style="max-width: 800px; margin: 0 auto;">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            <span class="posted-on">📅 <?php echo get_the_date(); ?></span>
                            <span class="byline">👤 <?php the_author(); ?></span>
                        </div>
                    </header>

                    <?php if (has_post_thumbnail()) { ?>
                        <div class="entry-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php } ?>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <footer class="entry-footer">
                        <div class="entry-categories">
                            <strong>📁 <?php esc_html_e('Categories:', 'onenav'); ?></strong>
                            <?php the_category(', '); ?>
                        </div>
                        <?php
                        $tags = get_the_tags();
                        if ($tags) {
                            ?>
                            <div class="entry-tags">
                                <strong>🏷️ <?php esc_html_e('Tags:', 'onenav'); ?></strong>
                                <?php the_tags('', ', '); ?>
                            </div>
                            <?php
                        }
                        ?>
                    </footer>
                </article>
                <?php
            }

            // Pagination
            echo '<div class="pagination">';
            echo paginate_links(array(
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;',
            ));
            echo '</div>';
        } else {
            ?>
            <div class="no-posts">
                <p><?php esc_html_e('No posts found.', 'onenav'); ?></p>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>
