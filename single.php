<?php
/**
 * Single Post Template
 *
 * @package OneNav
 */

get_header();
?>

<div class="container" style="margin-top: 40px;">
    <?php
    $layout = onenav_get_option('blog_layout', 'full_width');
    $show_author = onenav_get_option('show_author', '1');
    $show_like = onenav_get_option('show_like_button', '1');
    ?>

    <div style="display: grid; grid-template-columns: <?php echo $layout === 'with_sidebar' ? '2fr 1fr' : '1fr'; ?>; gap: 40px; max-width: 1200px; margin: 0 auto;">
        <!-- Main Content -->
        <div class="single-post-content">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <!-- Post Header -->
                        <header class="entry-header" style="margin-bottom: 30px;">
                            <?php
                            $categories = get_the_category();
                            if ($categories) {
                                ?>
                                <div style="margin-bottom: 15px;">
                                    <?php foreach ($categories as $category) { ?>
                                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" style="display: inline-block; background: var(--primary-color); color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; margin-right: 8px; text-decoration: none;">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php } ?>
                                </div>
                                <?php
                            }
                            ?>

                            <h1 class="entry-title" style="font-size: 2.5rem; line-height: 1.2; margin-bottom: 20px;"><?php the_title(); ?></h1>

                            <div class="entry-meta" style="display: flex; flex-wrap: wrap; gap: 20px; color: #64748b; font-size: 14px; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px;">
                                <?php if ($show_author === '1') { ?>
                                    <span><i class="fas fa-user"></i> <?php the_author(); ?></span>
                                <?php } ?>
                                <span><i class="fas fa-calendar-alt"></i> <?php echo get_the_date('j F Y'); ?></span>
                                <span><i class="fas fa-clock"></i> <?php echo get_the_time('H:i'); ?></span>
                                <span><i class="fas fa-eye"></i> <?php echo get_post_meta(get_the_ID(), 'views', true) ?: '0'; ?> görüntüleme</span>
                                <?php if ($show_like === '1') { ?>
                                    <span><i class="fas fa-heart"></i> <span class="like-count"><?php echo get_post_meta(get_the_ID(), 'likes', true) ?: '0'; ?></span> beğeni</span>
                                <?php } ?>
                            </div>
                        </header>

                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) { ?>
                            <div class="entry-thumbnail" style="margin-bottom: 30px; border-radius: 12px; overflow: hidden;">
                                <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto;')); ?>
                            </div>
                        <?php } ?>

                        <!-- Post Content -->
                        <div class="entry-content" style="font-size: 18px; line-height: 1.8; color: #1e293b;">
                            <?php
                            the_content();

                            wp_link_pages(array(
                                'before' => '<div class="page-links" style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #e2e8f0;"><strong>Sayfalar:</strong>',
                                'after'  => '</div>',
                            ));
                            ?>
                        </div>

                        <!-- Post Tags -->
                        <?php
                        $tags = get_the_tags();
                        if ($tags) {
                            ?>
                            <div class="entry-tags" style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #e2e8f0;">
                                <strong style="margin-right: 10px;"><i class="fas fa-tags"></i> Etiketler:</strong>
                                <?php foreach ($tags as $tag) { ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" style="display: inline-block; background: #f8fafc; color: #64748b; padding: 6px 15px; border-radius: 20px; font-size: 13px; margin: 5px; text-decoration: none; border: 1px solid #e2e8f0;">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>

                        <!-- Social Share Buttons -->
                        <div class="social-share" style="margin-top: 40px; padding: 30px; background: #f8fafc; border-radius: 12px; text-align: center;">
                            <h3 style="margin-bottom: 20px;"><i class="fas fa-share-alt"></i> Bu yazıyı paylaş</h3>
                            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; padding: 12px 24px; background: #1877f2; color: white; border-radius: 8px; text-decoration: none;">
                                    <i class="fab fa-facebook-f"></i> <span style="margin-left: 8px;">Facebook</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; padding: 12px 24px; background: #1da1f2; color: white; border-radius: 8px; text-decoration: none;">
                                    <i class="fab fa-twitter"></i> <span style="margin-left: 8px;">Twitter</span>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; padding: 12px 24px; background: #0077b5; color: white; border-radius: 8px; text-decoration: none;">
                                    <i class="fab fa-linkedin-in"></i> <span style="margin-left: 8px;">LinkedIn</span>
                                </a>
                                <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; padding: 12px 24px; background: #25d366; color: white; border-radius: 8px; text-decoration: none;">
                                    <i class="fab fa-whatsapp"></i> <span style="margin-left: 8px;">WhatsApp</span>
                                </a>
                            </div>
                        </div>

                        <!-- Author Bio -->
                        <?php if ($show_author === '1') { ?>
                            <div class="author-bio" style="margin-top: 40px; padding: 30px; background: #f8fafc; border-radius: 12px; display: flex; gap: 20px;">
                                <div style="flex-shrink: 0;">
                                    <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', array('style' => 'border-radius: 50%;')); ?>
                                </div>
                                <div>
                                    <h3 style="margin-bottom: 10px;"><?php the_author(); ?></h3>
                                    <p style="color: #64748b; margin-bottom: 15px;"><?php echo get_the_author_meta('description'); ?></p>
                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">
                                        Tüm yazılarını gör <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </article>

                    <!-- Comments Section -->
                    <?php
                    if (comments_open() || get_comments_number()) {
                        echo '<div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 30px;">';
                        comments_template();
                        echo '</div>';
                    }
                    ?>
                    <?php
                }
            }
            ?>
        </div>

        <!-- Sidebar -->
        <?php if ($layout === 'with_sidebar') { ?>
            <aside class="sidebar">
                <!-- Recent Posts Widget -->
                <div class="widget" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--primary-color);"><i class="fas fa-clock"></i> Son Yazılar</h3>
                    <?php
                    $recent_posts = new WP_Query(array(
                        'posts_per_page' => 5,
                        'post__not_in' => array(get_the_ID()),
                    ));

                    if ($recent_posts->have_posts()) {
                        echo '<ul style="list-style: none;">';
                        while ($recent_posts->have_posts()) {
                            $recent_posts->the_post();
                            ?>
                            <li style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e2e8f0;">
                                <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: #1e293b; font-weight: 500; display: block;">
                                    <?php the_title(); ?>
                                </a>
                                <small style="color: #64748b; display: block; margin-top: 5px;">
                                    <i class="fas fa-calendar"></i> <?php echo get_the_date('j M Y'); ?>
                                </small>
                            </li>
                            <?php
                        }
                        echo '</ul>';
                        wp_reset_postdata();
                    }
                    ?>
                </div>

                <!-- Categories Widget -->
                <div class="widget" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--primary-color);"><i class="fas fa-folder"></i> Kategoriler</h3>
                    <?php
                    wp_list_categories(array(
                        'title_li' => '',
                        'style' => 'list',
                        'show_count' => true,
                    ));
                    ?>
                </div>

                <!-- Tags Cloud Widget -->
                <div class="widget" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <h3 style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--primary-color);"><i class="fas fa-tags"></i> Etiketler</h3>
                    <?php
                    $tags = get_tags();
                    if ($tags) {
                        foreach ($tags as $tag) {
                            ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" style="display: inline-block; background: #f8fafc; color: #64748b; padding: 6px 15px; border-radius: 20px; font-size: 13px; margin: 5px; text-decoration: none; border: 1px solid #e2e8f0;">
                                <?php echo esc_html($tag->name); ?> (<?php echo $tag->count; ?>)
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </aside>
        <?php } ?>
    </div>
</div>

<?php get_footer(); ?>
