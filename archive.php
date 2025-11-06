<?php
/**
 * Archive Template
 *
 * @package OneNav
 */

get_header();
?>

<div class="container" style="margin-top: 40px;">
    <!-- Archive Header -->
    <div style="text-align: center; margin-bottom: 50px; padding: 40px; background: white; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h1 style="font-size: 3rem; margin-bottom: 15px;">
            <?php
            if (is_category()) {
                echo '<i class="fas fa-folder"></i> ';
                single_cat_title();
            } elseif (is_tag()) {
                echo '<i class="fas fa-tag"></i> ';
                single_tag_title();
            } elseif (is_author()) {
                echo '<i class="fas fa-user"></i> ';
                echo 'Yazar: ' . get_the_author();
            } elseif (is_date()) {
                echo '<i class="fas fa-calendar"></i> ';
                if (is_day()) {
                    echo get_the_date('j F Y');
                } elseif (is_month()) {
                    echo get_the_date('F Y');
                } elseif (is_year()) {
                    echo get_the_date('Y');
                }
            } else {
                echo '<i class="fas fa-archive"></i> Arşiv';
            }
            ?>
        </h1>

        <?php
        $description = '';
        if (is_category()) {
            $description = category_description();
        } elseif (is_tag()) {
            $description = tag_description();
        }

        if ($description) {
            echo '<div style="font-size: 1.1rem; color: #64748b; max-width: 800px; margin: 0 auto;">' . wp_kses_post($description) . '</div>';
        }
        ?>

        <!-- Post Count -->
        <div style="margin-top: 20px; font-size: 1rem; color: #64748b;">
            <i class="fas fa-file-alt"></i> <?php echo wp_count_posts()->publish; ?> yazı bulundu
        </div>
    </div>

    <?php
    $layout = onenav_get_option('blog_layout', 'full_width');
    ?>

    <div style="display: grid; grid-template-columns: <?php echo $layout === 'with_sidebar' ? '2fr 1fr' : '1fr'; ?>; gap: 40px;">
        <!-- Posts Grid -->
        <div>
            <div class="news-grid">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('news-card'); ?>>
                            <!-- Featured Image -->
                            <?php if (has_post_thumbnail()) { ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('onenav-news-featured', array('class' => 'news-image')); ?>
                                </a>
                            <?php } else { ?>
                                <a href="<?php the_permalink(); ?>">
                                    <div class="news-image" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                </a>
                            <?php } ?>

                            <!-- Post Content -->
                            <div class="news-content">
                                <!-- Category -->
                                <?php
                                $categories = get_the_category();
                                if ($categories) {
                                    ?>
                                    <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="news-category">
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </a>
                                    <?php
                                }
                                ?>

                                <!-- Title -->
                                <h3 class="news-title">
                                    <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <!-- Excerpt -->
                                <p class="news-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>

                                <!-- Meta -->
                                <div class="news-meta" style="display: flex; flex-wrap: wrap; gap: 15px; font-size: 13px;">
                                    <span><i class="fas fa-user"></i> <?php the_author(); ?></span>
                                    <span><i class="fas fa-calendar"></i> <?php echo get_the_date('j F Y'); ?></span>
                                    <span><i class="fas fa-comments"></i> <?php comments_number('0', '1', '%'); ?> yorum</span>
                                </div>

                                <!-- Read More Button -->
                                <a href="<?php the_permalink(); ?>" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: var(--primary-color); color: white; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600;">
                                    Devamını Oku <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                        <?php
                    }
                } else {
                    ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 12px;">
                        <i class="fas fa-inbox" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                        <h2 style="color: #64748b; margin-bottom: 10px;">Yazı Bulunamadı</h2>
                        <p style="color: #94a3b8;">Bu kategoride henüz yazı bulunmuyor.</p>
                        <a href="<?php echo home_url(); ?>" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: var(--primary-color); color: white; border-radius: 6px; text-decoration: none; font-weight: 600;">
                            <i class="fas fa-home"></i> Anasayfaya Dön
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Pagination -->
            <?php if (have_posts()) { ?>
                <div class="pagination" style="margin-top: 50px; text-align: center;">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '<i class="fas fa-arrow-left"></i> Önceki',
                        'next_text' => 'Sonraki <i class="fas fa-arrow-right"></i>',
                        'type' => 'plain',
                    ));
                    ?>
                </div>
            <?php } ?>
        </div>

        <!-- Sidebar -->
        <?php if ($layout === 'with_sidebar') { ?>
            <aside class="sidebar">
                <!-- Search Widget -->
                <div class="widget" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--primary-color);"><i class="fas fa-search"></i> Arama</h3>
                    <form method="get" action="<?php echo esc_url(home_url('/')); ?>" style="position: relative;">
                        <input type="text" name="s" placeholder="Yazı ara..." style="width: 100%; padding: 12px 45px 12px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;" value="<?php echo get_search_query(); ?>">
                        <button type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--primary-color); font-size: 18px; cursor: pointer;">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Recent Posts Widget -->
                <div class="widget" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--primary-color);"><i class="fas fa-clock"></i> Son Yazılar</h3>
                    <?php
                    $recent_posts = new WP_Query(array(
                        'posts_per_page' => 5,
                        'post__not_in' => get_option('sticky_posts'),
                    ));

                    if ($recent_posts->have_posts()) {
                        echo '<ul style="list-style: none;">';
                        while ($recent_posts->have_posts()) {
                            $recent_posts->the_post();
                            ?>
                            <li style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e2e8f0; display: flex; gap: 12px;">
                                <?php if (has_post_thumbnail()) { ?>
                                    <a href="<?php the_permalink(); ?>" style="flex-shrink: 0;">
                                        <?php the_post_thumbnail('thumbnail', array('style' => 'width: 60px; height: 60px; border-radius: 8px; object-fit: cover;')); ?>
                                    </a>
                                <?php } ?>
                                <div style="flex: 1; min-width: 0;">
                                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: #1e293b; font-weight: 500; display: block; font-size: 14px; line-height: 1.4; margin-bottom: 5px;">
                                        <?php the_title(); ?>
                                    </a>
                                    <small style="color: #64748b; display: block; font-size: 12px;">
                                        <i class="fas fa-calendar"></i> <?php echo get_the_date('j M Y'); ?>
                                    </small>
                                </div>
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
                    <ul style="list-style: none;">
                        <?php
                        wp_list_categories(array(
                            'title_li' => '',
                            'show_count' => true,
                            'style' => 'list',
                        ));
                        ?>
                    </ul>
                </div>

                <!-- Tags Widget -->
                <div class="widget" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <h3 style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid var(--primary-color);"><i class="fas fa-tags"></i> Popüler Etiketler</h3>
                    <?php
                    $tags = get_tags(array('number' => 20, 'orderby' => 'count', 'order' => 'DESC'));
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
