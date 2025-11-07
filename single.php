<?php
/**
 * Single Post Template
 *
 * @package OneNav
 */

get_header();
?>

<div class="container site-container">
    <div class="site-container__content">
        <div class="single-post-layout">
            <?php
            while (have_posts()) {
                the_post();
                $post_id = get_the_ID();
                $like_count = (int) get_post_meta($post_id, 'like_count', true);
                $author_id = get_the_author_meta('ID');
                $author_avatar = get_avatar($author_id, 80);
                $author_bio = get_the_author_meta('description');
                $options = get_option('onenav_options', array());
                $show_author_box = isset($options['show_author_box']) ? $options['show_author_box'] : 1;
                $enable_likes = isset($options['enable_likes']) ? $options['enable_likes'] : 1;
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                    <!-- Post Header -->
                    <header class="single-post__header">
                        <h1 class="single-post__title">
                            <a href="<?php the_permalink(); ?>" class="single-post__title-link">
                                <?php the_title(); ?>
                            </a>
                        </h1>

                        <div class="single-post__meta">
                            <span class="single-post__meta-item">
                                <svg width="16" height="16" fill="currentColor" class="single-post__meta-icon">
                                    <path d="M8 8a3 3 0 100-6 3 3 0 000 6zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                                <?php the_author_posts_link(); ?>
                            </span>
                            <span class="single-post__meta-item">
                                <svg width="16" height="16" fill="currentColor" class="single-post__meta-icon">
                                    <path d="M13 2H3a2 2 0 00-2 2v12l4-4h8a2 2 0 002-2V4a2 2 0 00-2-2z"/>
                                </svg>
                                <?php echo get_the_date('j F Y'); ?>
                            </span>
                            <span class="single-post__meta-item">
                                <svg width="16" height="16" fill="currentColor" class="single-post__meta-icon">
                                    <path d="M7 14l-5 3V3a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H7z"/>
                                </svg>
                                <?php comments_number('0 Yorum', '1 Yorum', '% Yorum'); ?>
                            </span>
                        </div>
                    </header>

                    <!-- Featured Image -->
                    <?php if (has_post_thumbnail()): ?>
                        <div class="single-post__thumbnail">
                            <?php the_post_thumbnail('large', array('class' => 'single-post__thumbnail-image')); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Post Content -->
                    <div class="single-post__content">
                        <?php the_content(); ?>
                    </div>

                    <!-- Post Footer -->
                    <footer class="single-post__footer">
                        <!-- Categories -->
                        <?php if (has_category()): ?>
                            <div class="single-post__categories">
                                <strong class="single-post__footer-label">
                                    <svg width="16" height="16" fill="currentColor" class="single-post__footer-icon">
                                        <path d="M2 2h5l2 2h7a2 2 0 012 2v8a2 2 0 01-2 2H2a2 2 0 01-2-2V4a2 2 0 012-2z"/>
                                    </svg>
                                    <?php esc_html_e('Kategoriler:', 'onenav'); ?>
                                </strong>
                                <div class="single-post__category-list">
                                    <?php the_category(', '); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Tags -->
                        <?php if (has_tag()): ?>
                            <div class="single-post__tags">
                                <strong class="single-post__footer-label">
                                    <svg width="16" height="16" fill="currentColor" class="single-post__footer-icon">
                                        <path d="M2 2h6l8 8-6 6-8-8V2zm3 3a1 1 0 100-2 1 1 0 000 2z"/>
                                    </svg>
                                    <?php esc_html_e('Etiketler:', 'onenav'); ?>
                                </strong>
                                <div class="single-post__tag-list">
                                    <?php
                                    $tags = get_the_tags();
                                    if ($tags) {
                                        foreach ($tags as $tag) {
                                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="single-post__tag">' . $tag->name . '</a>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Like Button -->
                        <?php if ($enable_likes): ?>
                            <div class="single-post__like-section">
                                <button class="single-post__like-btn" data-post-id="<?php echo esc_attr($post_id); ?>">
                                    <svg width="20" height="20" fill="currentColor" class="single-post__like-icon">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    <span class="single-post__like-count"><?php echo $like_count; ?></span>
                                    <span class="single-post__like-text"><?php esc_html_e('Beğen', 'onenav'); ?></span>
                                </button>
                            </div>
                        <?php endif; ?>
                    </footer>

                    <!-- Author Box -->
                    <?php if ($show_author_box && $author_bio): ?>
                        <div class="author-box">
                            <div class="author-box__avatar">
                                <?php echo $author_avatar; ?>
                            </div>
                            <div class="author-box__content">
                                <h3 class="author-box__name">
                                    <?php the_author_posts_link(); ?>
                                </h3>
                                <p class="author-box__bio"><?php echo esc_html($author_bio); ?></p>
                                <div class="author-box__stats">
                                    <span class="author-box__stat">
                                        <strong><?php echo count_user_posts($author_id); ?></strong> <?php esc_html_e('Yazı', 'onenav'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Related Posts -->
                    <?php
                    $categories = wp_get_post_categories($post_id);
                    if ($categories) {
                        $related_args = array(
                            'category__in' => $categories,
                            'post__not_in' => array($post_id),
                            'posts_per_page' => 3,
                            'orderby' => 'rand',
                        );
                        $related_query = new WP_Query($related_args);

                        if ($related_query->have_posts()):
                            ?>
                            <div class="related-posts">
                                <h3 class="related-posts__title">
                                    <?php esc_html_e('İlgili Yazılar', 'onenav'); ?>
                                </h3>
                                <div class="related-posts__grid">
                                    <?php
                                    while ($related_query->have_posts()) {
                                        $related_query->the_post();
                                        ?>
                                        <article class="related-posts__item">
                                            <a href="<?php the_permalink(); ?>" class="related-posts__link">
                                                <?php if (has_post_thumbnail()): ?>
                                                    <div class="related-posts__thumbnail">
                                                        <?php the_post_thumbnail('medium', array('class' => 'related-posts__image')); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="related-posts__content">
                                                    <h4 class="related-posts__item-title"><?php the_title(); ?></h4>
                                                    <p class="related-posts__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                                    <span class="related-posts__date"><?php echo get_the_date(); ?></span>
                                                </div>
                                            </a>
                                        </article>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            wp_reset_postdata();
                        endif;
                    }
                    ?>

                    <!-- Comments -->
                    <?php
                    if (comments_open() || get_comments_number()) {
                        comments_template();
                    }
                    ?>

                </article>

                <?php
            }
            ?>
        </div>

        <!-- Sidebar -->
        <aside class="site-container__sidebar">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</div>

<style>
/* Single Post Layout */
.single-post-layout {
    background: #fff;
    border-radius: 12px;
    padding: 40px;
    margin-bottom: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.site-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
}

.site-container__content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

/* Post Header */
.single-post__header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e2e8f0;
}

.single-post__title {
    font-size: 2.5rem;
    line-height: 1.2;
    margin-bottom: 15px;
}

.single-post__title-link {
    color: #1e293b;
    text-decoration: none;
    transition: color 0.3s;
}

.single-post__title-link:hover {
    color: var(--primary-color);
}

.single-post__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    font-size: 14px;
    color: #64748b;
}

.single-post__meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.single-post__meta-icon {
    width: 16px;
    height: 16px;
}

/* Thumbnail */
.single-post__thumbnail {
    margin-bottom: 30px;
    border-radius: 12px;
    overflow: hidden;
}

.single-post__thumbnail-image {
    width: 100%;
    height: auto;
    display: block;
}

/* Content */
.single-post__content {
    font-size: 18px;
    line-height: 1.8;
    color: #334155;
    margin-bottom: 30px;
}

.single-post__content p {
    margin-bottom: 1.5rem;
}

.single-post__content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

/* Footer */
.single-post__footer {
    padding-top: 30px;
    border-top: 2px solid #e2e8f0;
}

.single-post__categories,
.single-post__tags {
    margin-bottom: 20px;
}

.single-post__footer-label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    color: #64748b;
    margin-bottom: 10px;
}

.single-post__footer-icon {
    width: 16px;
    height: 16px;
}

.single-post__category-list a,
.single-post__tag {
    display: inline-block;
    padding: 6px 12px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 6px;
    font-size: 13px;
    margin-right: 8px;
    margin-bottom: 8px;
    text-decoration: none;
    transition: all 0.3s;
}

.single-post__category-list a:hover,
.single-post__tag:hover {
    background: var(--primary-color);
    color: #fff;
}

/* Like Button */
.single-post__like-section {
    margin-top: 30px;
}

.single-post__like-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    transition: all 0.3s;
}

.single-post__like-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.single-post__like-btn.liked {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: #fff;
}

.single-post__like-icon {
    width: 20px;
    height: 20px;
}

/* Author Box */
.author-box {
    display: flex;
    gap: 20px;
    padding: 30px;
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
    border-radius: 12px;
    margin: 40px 0;
}

.author-box__avatar img {
    border-radius: 50%;
    width: 80px;
    height: 80px;
}

.author-box__content {
    flex: 1;
}

.author-box__name {
    font-size: 20px;
    margin-bottom: 10px;
}

.author-box__name a {
    color: #1e293b;
    text-decoration: none;
}

.author-box__bio {
    color: #64748b;
    margin-bottom: 15px;
    line-height: 1.6;
}

.author-box__stats {
    display: flex;
    gap: 20px;
    font-size: 14px;
}

.author-box__stat strong {
    color: var(--primary-color);
}

/* Related Posts */
.related-posts {
    margin-top: 50px;
    padding-top: 40px;
    border-top: 2px solid #e2e8f0;
}

.related-posts__title {
    font-size: 24px;
    margin-bottom: 25px;
}

.related-posts__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.related-posts__item {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s;
}

.related-posts__item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.related-posts__link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.related-posts__thumbnail {
    width: 100%;
    height: 180px;
    overflow: hidden;
}

.related-posts__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.related-posts__item:hover .related-posts__image {
    transform: scale(1.1);
}

.related-posts__content {
    padding: 20px;
}

.related-posts__item-title {
    font-size: 16px;
    margin-bottom: 10px;
    color: #1e293b;
}

.related-posts__excerpt {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 10px;
}

.related-posts__date {
    font-size: 12px;
    color: #94a3b8;
}

/* Responsive */
@media (max-width: 1024px) {
    .site-container__content {
        grid-template-columns: 1fr;
    }

    .site-container__sidebar {
        order: 2;
    }
}

@media (max-width: 768px) {
    .single-post-layout {
        padding: 20px;
    }

    .single-post__title {
        font-size: 1.8rem;
    }

    .related-posts__grid {
        grid-template-columns: 1fr;
    }

    .author-box {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<?php get_footer(); ?>
