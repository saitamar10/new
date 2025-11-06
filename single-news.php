<?php
/**
 * Single News Template
 *
 * @package OneNav
 */

get_header();
?>

<main class="single-news-page">
    <?php while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('news-article'); ?>>

            <!-- News Header -->
            <header class="news-header">
                <div class="news-header-container">

                    <!-- Categories & Badges -->
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'news_category');
                    if ($categories && !is_wp_error($categories)) :
                    ?>
                        <div class="news-categories">
                            <?php foreach ($categories as $category) : ?>
                                <span class="news-badge news-badge-<?php echo esc_attr($category->slug); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Title -->
                    <h1 class="news-main-title"><?php the_title(); ?></h1>

                    <!-- Meta Information -->
                    <div class="news-meta-info">
                        <?php if (get_theme_mod('onenav_news_show_author', 1)) : ?>
                            <div class="news-author">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span><?php the_author(); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (get_theme_mod('onenav_news_show_date', 1)) : ?>
                            <div class="news-date">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                            </div>
                        <?php endif; ?>

                        <div class="news-reading-time">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span><?php echo onenav_reading_time(); ?></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="news-featured-image">
                    <?php the_post_thumbnail('large', array('class' => 'news-image-full')); ?>
                    <?php if ($caption = get_the_post_thumbnail_caption()) : ?>
                        <p class="news-image-caption"><?php echo esc_html($caption); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- News Content -->
            <div class="news-content-wrapper">
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <!-- News Tags -->
                <?php if (has_tag()) : ?>
                    <div class="news-tags">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                        <?php the_tags('', ' ', ''); ?>
                    </div>
                <?php endif; ?>

                <!-- Share Buttons -->
                <div class="news-share">
                    <h3>Haberi Paylaş</h3>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn share-facebook">
                            Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn share-twitter">
                            Twitter
                        </a>
                        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" class="share-btn share-whatsapp">
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related News -->
            <?php
            $related = new WP_Query(array(
                'post_type' => 'news',
                'posts_per_page' => 3,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand',
            ));

            if ($related->have_posts()) :
            ?>
                <div class="related-news">
                    <h3>İlgili Haberler</h3>
                    <div class="related-news-grid">
                        <?php while ($related->have_posts()) : $related->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="related-news-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'related-news-image')); ?>
                                <?php endif; ?>
                                <h4><?php the_title(); ?></h4>
                                <span class="related-news-date"><?php echo get_the_date(); ?></span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php
                wp_reset_postdata();
            endif;
            ?>

        </article>

    <?php endwhile; ?>
</main>

<style>
/* News Article Styles */
.single-news-page {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

.news-article {
    background: var(--content-bg, #ffffff);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.news-header {
    padding: 40px 40px 30px;
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.05) 0%, rgba(236, 72, 153, 0.05) 100%);
}

.news-categories {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.news-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: var(--primary-color, #a855f7);
    color: white;
}

.news-main-title {
    font-size: 2.5rem;
    line-height: 1.2;
    margin-bottom: 20px;
    color: var(--text-dark, #1e293b);
}

.news-meta-info {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
    color: var(--text-light, #64748b);
    font-size: 14px;
}

.news-meta-info > div {
    display: flex;
    align-items: center;
    gap: 6px;
}

.news-featured-image {
    position: relative;
}

.news-image-full {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: cover;
}

.news-image-caption {
    padding: 15px 40px;
    background: rgba(0, 0, 0, 0.05);
    font-size: 14px;
    font-style: italic;
    color: var(--text-light, #64748b);
    margin: 0;
}

.news-content-wrapper {
    padding: 40px;
}

.entry-content {
    font-size: var(--news-font-size, 16px);
    line-height: var(--line-height, 1.8);
    color: var(--text-dark, #1e293b);
}

.entry-content p {
    margin-bottom: 1.5em;
}

.entry-content h2,
.entry-content h3 {
    margin-top: 2em;
    margin-bottom: 1em;
}

.entry-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 2em 0;
}

.news-tags {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid var(--border-color, #e2e8f0);
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.news-tags a {
    display: inline-block;
    padding: 6px 14px;
    background: var(--light-bg, #f8fafc);
    border-radius: 16px;
    font-size: 13px;
    color: var(--text-dark, #1e293b);
    transition: all 0.3s ease;
}

.news-tags a:hover {
    background: var(--primary-color, #a855f7);
    color: white;
}

.news-share {
    margin-top: 40px;
    padding: 30px;
    background: var(--light-bg, #f8fafc);
    border-radius: 8px;
}

.news-share h3 {
    margin-bottom: 15px;
    font-size: 1.2rem;
}

.share-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.share-btn {
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
}

.share-facebook {
    background: #1877f2;
}

.share-twitter {
    background: #1da1f2;
}

.share-whatsapp {
    background: #25d366;
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.related-news {
    margin-top: 50px;
    padding: 30px 40px;
    background: var(--light-bg, #f8fafc);
}

.related-news h3 {
    margin-bottom: 20px;
    font-size: 1.5rem;
}

.related-news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.related-news-item {
    display: block;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.related-news-item:hover {
    transform: translateY(-5px);
}

.related-news-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.related-news-item h4 {
    padding: 15px;
    font-size: 14px;
    margin: 0;
    color: var(--text-dark, #1e293b);
}

.related-news-date {
    display: block;
    padding: 0 15px 15px;
    font-size: 12px;
    color: var(--text-light, #64748b);
}

@media (max-width: 768px) {
    .news-header,
    .news-content-wrapper,
    .related-news {
        padding: 20px;
    }

    .news-main-title {
        font-size: 1.8rem;
    }

    .news-meta-info {
        gap: 15px;
    }
}
</style>

<?php get_footer(); ?>
