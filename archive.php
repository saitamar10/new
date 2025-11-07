<?php
/**
 * Archive Template
 * For displaying categories, tags, date archives, etc.
 *
 * @package OneNav
 */

get_header();
?>

<div class="container archive-container">
    <div class="archive-container__content">
        <div class="archive-layout">
            <!-- Archive Header -->
            <header class="archive-header">
                <?php
                the_archive_title('<h1 class="archive-header__title">', '</h1>');
                the_archive_description('<div class="archive-header__description">', '</div>');
                ?>

                <div class="archive-header__meta">
                    <?php
                    $post_count = $wp_query->found_posts;
                    printf(
                        esc_html(_n('%s yazı bulundu', '%s yazı bulundu', $post_count, 'onenav')),
                        number_format_i18n($post_count)
                    );
                    ?>
                </div>
            </header>

            <!-- Archive Grid -->
            <div class="archive-grid">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('archive-card'); ?>>
                            <!-- Thumbnail -->
                            <?php if (has_post_thumbnail()): ?>
                                <a href="<?php the_permalink(); ?>" class="archive-card__thumbnail">
                                    <?php the_post_thumbnail('medium', array('class' => 'archive-card__image')); ?>
                                </a>
                            <?php else: ?>
                                <a href="<?php the_permalink(); ?>" class="archive-card__thumbnail archive-card__thumbnail--placeholder">
                                    <div class="archive-card__placeholder">
                                        <svg width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                        </svg>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <!-- Content -->
                            <div class="archive-card__content">
                                <!-- Categories -->
                                <?php if (has_category()): ?>
                                    <div class="archive-card__categories">
                                        <?php
                                        $categories = get_the_category();
                                        if ($categories) {
                                            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="archive-card__category">';
                                            echo esc_html($categories[0]->name);
                                            echo '</a>';
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Title -->
                                <h2 class="archive-card__title">
                                    <a href="<?php the_permalink(); ?>" class="archive-card__title-link">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <!-- Excerpt -->
                                <div class="archive-card__excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>

                                <!-- Meta -->
                                <div class="archive-card__meta">
                                    <span class="archive-card__meta-item">
                                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 100-6 3 3 0 000 6zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                        <?php the_author_posts_link(); ?>
                                    </span>
                                    <span class="archive-card__meta-item">
                                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M13 2H3a2 2 0 00-2 2v12l4-4h8a2 2 0 002-2V4a2 2 0 00-2-2z"/>
                                        </svg>
                                        <?php echo get_the_date('j M Y'); ?>
                                    </span>
                                    <?php if (get_comments_number()): ?>
                                        <span class="archive-card__meta-item">
                                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M7 14l-5 3V3a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H7z"/>
                                            </svg>
                                            <?php comments_number('0', '1', '%'); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Read More -->
                                <a href="<?php the_permalink(); ?>" class="archive-card__read-more">
                                    <?php esc_html_e('Devamını Oku', 'onenav'); ?>
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 0l6 8-6 8V0z"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                        <?php
                    }
                } else {
                    ?>
                    <div class="archive-no-posts">
                        <svg width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                        <h2><?php esc_html_e('İçerik Bulunamadı', 'onenav'); ?></h2>
                        <p><?php esc_html_e('Bu kategoride henüz içerik eklenmemiş.', 'onenav'); ?></p>
                        <a href="<?php echo home_url('/'); ?>" class="button">
                            <?php esc_html_e('Ana Sayfaya Dön', 'onenav'); ?>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Pagination -->
            <?php if (have_posts()): ?>
                <nav class="archive-pagination">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '<svg width="16" height="16" fill="currentColor"><path d="M15 8H1m7-7l-7 7 7 7"/></svg> ' . __('Önceki', 'onenav'),
                        'next_text' => __('Sonraki', 'onenav') . ' <svg width="16" height="16" fill="currentColor"><path d="M1 8h14M8 1l7 7-7 7"/></svg>',
                        'type' => 'list',
                        'end_size' => 2,
                        'mid_size' => 2,
                    ));
                    ?>
                </nav>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <aside class="archive-container__sidebar">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</div>

<style>
/* Archive Container */
.archive-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
}

.archive-container__content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

.archive-layout {
    min-width: 0;
}

/* Archive Header */
.archive-header {
    background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
    color: #fff;
    padding: 40px;
    border-radius: 12px;
    margin-bottom: 40px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.archive-header__title {
    font-size: 2.5rem;
    margin-bottom: 15px;
    color: #fff;
}

.archive-header__description {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 15px;
    opacity: 0.95;
}

.archive-header__meta {
    font-size: 14px;
    opacity: 0.9;
    padding-top: 15px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

/* Archive Grid */
.archive-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

/* Archive Card */
.archive-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
}

.archive-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.archive-card__thumbnail {
    display: block;
    width: 100%;
    height: 220px;
    overflow: hidden;
    position: relative;
}

.archive-card__thumbnail--placeholder {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #cbd5e1;
}

.archive-card__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.archive-card:hover .archive-card__image {
    transform: scale(1.1);
}

.archive-card__content {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.archive-card__categories {
    margin-bottom: 12px;
}

.archive-card__category {
    display: inline-block;
    padding: 4px 12px;
    background: #a855f7;
    color: #fff;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.3s;
}

.archive-card__category:hover {
    background: #ec4899;
}

.archive-card__title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
    line-height: 1.3;
}

.archive-card__title-link {
    color: #1e293b;
    text-decoration: none;
    transition: color 0.3s;
}

.archive-card__title-link:hover {
    color: var(--primary-color);
}

.archive-card__excerpt {
    font-size: 15px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 15px;
    flex: 1;
}

.archive-card__meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    font-size: 13px;
    color: #94a3b8;
    margin-bottom: 15px;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
}

.archive-card__meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.archive-card__meta-item svg {
    width: 14px;
    height: 14px;
}

.archive-card__meta-item a {
    color: inherit;
    text-decoration: none;
}

.archive-card__meta-item a:hover {
    color: var(--primary-color);
}

.archive-card__read-more {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: var(--primary-color);
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: gap 0.3s;
}

.archive-card__read-more:hover {
    gap: 10px;
}

.archive-card__read-more svg {
    width: 16px;
    height: 16px;
}

/* No Posts */
.archive-no-posts {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
}

.archive-no-posts svg {
    margin-bottom: 20px;
    color: #cbd5e1;
}

.archive-no-posts h2 {
    font-size: 28px;
    margin-bottom: 15px;
    color: #1e293b;
}

.archive-no-posts p {
    font-size: 16px;
    color: #64748b;
    margin-bottom: 25px;
}

.archive-no-posts .button {
    display: inline-block;
    padding: 12px 30px;
    background: var(--primary-color);
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.3s;
}

.archive-no-posts .button:hover {
    background: var(--secondary-color);
}

/* Pagination */
.archive-pagination {
    margin-top: 40px;
}

.archive-pagination ul {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 0;
}

.archive-pagination li {
    margin: 0;
}

.archive-pagination a,
.archive-pagination span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 44px;
    height: 44px;
    padding: 0 15px;
    background: #fff;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    color: #475569;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.archive-pagination a:hover {
    border-color: var(--primary-color);
    background: var(--primary-color);
    color: #fff;
}

.archive-pagination .current {
    border-color: var(--primary-color);
    background: var(--primary-color);
    color: #fff;
}

.archive-pagination .dots {
    border: none;
    background: transparent;
}

/* Responsive */
@media (max-width: 1024px) {
    .archive-container__content {
        grid-template-columns: 1fr;
    }

    .archive-container__sidebar {
        order: 2;
    }
}

@media (max-width: 768px) {
    .archive-header {
        padding: 30px 20px;
    }

    .archive-header__title {
        font-size: 1.8rem;
    }

    .archive-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .archive-card__title {
        font-size: 18px;
    }
}

@media (max-width: 480px) {
    .archive-pagination a,
    .archive-pagination span {
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        font-size: 14px;
    }
}
</style>

<?php get_footer(); ?>
