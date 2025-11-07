<?php
/**
 * Template Name: E-Book Detail Page
 * Description: Displays e-book details with cover, purchase options, and related books
 *
 * @package OneNav
 */

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        $post_id = get_the_ID();

        // Get custom fields
        $ebook_file = get_post_meta($post_id, 'ebook_file', true);
        $ebook_type = get_post_meta($post_id, 'ebook_type', true);
        $ebook_price = get_post_meta($post_id, 'ebook_price', true);
        $ebook_isbn = get_post_meta($post_id, 'ebook_isbn', true);
        $ebook_pages = get_post_meta($post_id, 'ebook_pages', true);
        $ebook_language = get_post_meta($post_id, 'ebook_language', true);
        $ebook_publisher = get_post_meta($post_id, 'ebook_publisher', true);
        $ebook_publish_date = get_post_meta($post_id, 'ebook_publish_date', true);
        $buy_print_url = get_post_meta($post_id, 'buy_print_url', true);
        ?>

        <div class="ebook-detail-page">
            <div class="container">
                <!-- Main Content -->
                <div class="ebook-detail">
                    <!-- Left: Cover Image -->
                    <div class="ebook-detail__cover">
                        <?php if (has_post_thumbnail()): ?>
                            <img
                                src="<?php the_post_thumbnail_url('large'); ?>"
                                alt="<?php the_title_attribute(); ?>"
                                class="ebook-detail__cover-image"
                            >
                        <?php else: ?>
                            <div class="ebook-detail__cover-placeholder">
                                <svg width="120" height="120" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <!-- Quick Stats -->
                        <div class="ebook-detail__quick-stats">
                            <?php if ($ebook_type): ?>
                                <div class="ebook-detail__stat">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                    </svg>
                                    <span><?php echo strtoupper(esc_html($ebook_type)); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($ebook_pages): ?>
                                <div class="ebook-detail__stat">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                    </svg>
                                    <span><?php echo esc_html($ebook_pages); ?> <?php esc_html_e('Sayfa', 'onenav'); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($ebook_language): ?>
                                <div class="ebook-detail__stat">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95c-.32-1.25-.78-2.45-1.38-3.56 1.84.63 3.37 1.91 4.33 3.56zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2s.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56-1.84-.63-3.37-1.9-4.33-3.56zm2.95-8H5.08c.96-1.66 2.49-2.93 4.33-3.56C8.81 5.55 8.35 6.75 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2s.07-1.35.16-2h4.68c.09.65.16 1.32.16 2s-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95c-.96 1.65-2.49 2.93-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2s-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z"/>
                                    </svg>
                                    <span><?php echo esc_html($ebook_language); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Right: Details -->
                    <div class="ebook-detail__content">
                        <header class="ebook-detail__header">
                            <h1 class="ebook-detail__title"><?php the_title(); ?></h1>

                            <?php if ($ebook_publisher || $ebook_publish_date): ?>
                                <div class="ebook-detail__meta">
                                    <?php if ($ebook_publisher): ?>
                                        <span class="ebook-detail__publisher">
                                            <strong><?php esc_html_e('Yayınevi:', 'onenav'); ?></strong>
                                            <?php echo esc_html($ebook_publisher); ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($ebook_publish_date): ?>
                                        <span class="ebook-detail__publish-date">
                                            <strong><?php esc_html_e('Yayın Tarihi:', 'onenav'); ?></strong>
                                            <?php echo esc_html($ebook_publish_date); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Price -->
                        <?php if ($ebook_price): ?>
                            <div class="ebook-detail__price-section">
                                <div class="ebook-detail__price">
                                    <?php if (floatval($ebook_price) > 0): ?>
                                        <span class="ebook-detail__price-amount">₺<?php echo number_format(floatval($ebook_price), 2); ?></span>
                                        <span class="ebook-detail__price-label"><?php esc_html_e('E-Kitap', 'onenav'); ?></span>
                                    <?php else: ?>
                                        <span class="ebook-detail__price-free"><?php esc_html_e('ÜCRETSİZ', 'onenav'); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Description -->
                        <div class="ebook-detail__description">
                            <h3><?php esc_html_e('Açıklama', 'onenav'); ?></h3>
                            <?php the_content(); ?>
                        </div>

                        <!-- Additional Info -->
                        <?php if ($ebook_isbn): ?>
                            <div class="ebook-detail__info">
                                <div class="ebook-detail__info-item">
                                    <strong><?php esc_html_e('ISBN:', 'onenav'); ?></strong>
                                    <span><?php echo esc_html($ebook_isbn); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <div class="ebook-detail__actions">
                            <?php if ($buy_print_url): ?>
                                <a href="<?php echo esc_url($buy_print_url); ?>" target="_blank" rel="noopener" class="ebook-detail__btn ebook-detail__btn--primary">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2v9.67z"/>
                                    </svg>
                                    <?php esc_html_e('Basılı Kitabı Satın Al', 'onenav'); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($ebook_file): ?>
                                <a href="<?php echo esc_url($ebook_file); ?>" target="_blank" rel="noopener" class="ebook-detail__btn ebook-detail__btn--secondary">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2v9.67z"/>
                                    </svg>
                                    <?php esc_html_e('E-Kitabı İndir', 'onenav'); ?>
                                </a>

                                <a href="<?php echo esc_url($ebook_file); ?>" target="_blank" rel="noopener" class="ebook-detail__btn ebook-detail__btn--outline">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                    </svg>
                                    <?php esc_html_e('Önizleme / Oku', 'onenav'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Related/Similar Books -->
                <?php
                $categories = wp_get_post_categories($post_id);
                if ($categories) {
                    $related_args = array(
                        'post_type' => 'ebook',
                        'category__in' => $categories,
                        'post__not_in' => array($post_id),
                        'posts_per_page' => 4,
                        'orderby' => 'rand',
                    );
                    $related_query = new WP_Query($related_args);

                    if ($related_query->have_posts()):
                        ?>
                        <section class="related-ebooks">
                            <h2 class="related-ebooks__title">
                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/>
                                </svg>
                                <?php esc_html_e('Benzer Kitaplar', 'onenav'); ?>
                            </h2>

                            <div class="related-ebooks__carousel">
                                <?php
                                while ($related_query->have_posts()) {
                                    $related_query->the_post();
                                    ?>
                                    <article class="related-ebooks__item">
                                        <a href="<?php the_permalink(); ?>" class="related-ebooks__link">
                                            <?php if (has_post_thumbnail()): ?>
                                                <div class="related-ebooks__cover">
                                                    <?php the_post_thumbnail('medium', array('class' => 'related-ebooks__image')); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="related-ebooks__content">
                                                <h3 class="related-ebooks__item-title"><?php the_title(); ?></h3>
                                                <p class="related-ebooks__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                                            </div>
                                        </a>
                                    </article>
                                    <?php
                                }
                                ?>
                            </div>
                        </section>
                        <?php
                        wp_reset_postdata();
                    endif;
                }
                ?>
            </div>
        </div>

        <?php
    }
}
?>

<style>
/* E-Book Detail Page */
.ebook-detail-page {
    padding: 40px 0;
    background: linear-gradient(135deg, #f8fafc 0%, #fce7f3 100%);
    min-height: 100vh;
}

.ebook-detail {
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 50px;
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    margin-bottom: 50px;
}

/* Cover Section */
.ebook-detail__cover {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.ebook-detail__cover-image {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    margin-bottom: 25px;
}

.ebook-detail__cover-placeholder {
    width: 100%;
    aspect-ratio: 3/4;
    background: linear-gradient(135deg, #a855f7, #ec4899);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    margin-bottom: 25px;
}

.ebook-detail__quick-stats {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.ebook-detail__stat {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: #f8fafc;
    border-radius: 8px;
    font-size: 14px;
    color: #475569;
}

.ebook-detail__stat svg {
    width: 18px;
    height: 18px;
    color: var(--primary-color);
}

/* Content Section */
.ebook-detail__header {
    margin-bottom: 30px;
}

.ebook-detail__title {
    font-size: 2.5rem;
    line-height: 1.2;
    margin-bottom: 15px;
    color: #1e293b;
}

.ebook-detail__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    font-size: 14px;
    color: #64748b;
}

.ebook-detail__publisher,
.ebook-detail__publish-date {
    display: flex;
    align-items: center;
    gap: 8px;
}

.ebook-detail__price-section {
    margin-bottom: 30px;
    padding: 25px;
    background: linear-gradient(135deg, #ede9fe 0%, #fce7f3 100%);
    border-radius: 12px;
}

.ebook-detail__price {
    display: flex;
    align-items: baseline;
    gap: 12px;
}

.ebook-detail__price-amount {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary-color);
}

.ebook-detail__price-label {
    font-size: 16px;
    color: #64748b;
}

.ebook-detail__price-free {
    font-size: 2rem;
    font-weight: 700;
    color: #10b981;
}

.ebook-detail__description {
    margin-bottom: 30px;
    line-height: 1.8;
    color: #475569;
}

.ebook-detail__description h3 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #1e293b;
}

.ebook-detail__info {
    margin-bottom: 30px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 12px;
}

.ebook-detail__info-item {
    display: flex;
    gap: 10px;
    font-size: 14px;
    color: #64748b;
}

.ebook-detail__info-item strong {
    color: #1e293b;
}

/* Action Buttons */
.ebook-detail__actions {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.ebook-detail__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 30px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    cursor: pointer;
}

.ebook-detail__btn--primary {
    background: var(--primary-color);
    color: #fff;
    border: 2px solid var(--primary-color);
}

.ebook-detail__btn--primary:hover {
    background: var(--secondary-color);
    border-color: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(168, 85, 247, 0.4);
}

.ebook-detail__btn--secondary {
    background: #10b981;
    color: #fff;
    border: 2px solid #10b981;
}

.ebook-detail__btn--secondary:hover {
    background: #059669;
    border-color: #059669;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

.ebook-detail__btn--outline {
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.ebook-detail__btn--outline:hover {
    background: var(--primary-color);
    color: #fff;
}

/* Related Books */
.related-ebooks {
    margin-top: 50px;
}

.related-ebooks__title {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 28px;
    margin-bottom: 30px;
    color: #1e293b;
}

.related-ebooks__title svg {
    color: var(--primary-color);
}

.related-ebooks__carousel {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
}

.related-ebooks__item {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.related-ebooks__item:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.related-ebooks__link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.related-ebooks__cover {
    width: 100%;
    height: 280px;
    overflow: hidden;
}

.related-ebooks__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.related-ebooks__item:hover .related-ebooks__image {
    transform: scale(1.1);
}

.related-ebooks__content {
    padding: 20px;
}

.related-ebooks__item-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #1e293b;
}

.related-ebooks__excerpt {
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
}

/* Responsive */
@media (max-width: 1024px) {
    .ebook-detail {
        grid-template-columns: 1fr;
    }

    .ebook-detail__cover {
        position: relative;
        top: 0;
        max-width: 400px;
        margin: 0 auto;
    }

    .related-ebooks__carousel {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .ebook-detail {
        padding: 25px;
    }

    .ebook-detail__title {
        font-size: 2rem;
    }

    .ebook-detail__price-amount {
        font-size: 2rem;
    }

    .ebook-detail__actions {
        flex-direction: column;
    }

    .ebook-detail__btn {
        width: 100%;
    }

    .related-ebooks__carousel {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
