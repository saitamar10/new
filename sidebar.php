<?php
/**
 * Sidebar Template
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="sidebar">
    <!-- Son Yazılar (Recent Posts) -->
    <div class="sidebar__widget widget--recent-posts">
        <h3 class="sidebar__widget-title">
            <svg width="16" height="16" fill="currentColor" class="sidebar__widget-icon">
                <path d="M14 2H6a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2zM6 20H3a1 1 0 01-1-1V5a1 1 0 011-1h3v16z"/>
            </svg>
            <?php esc_html_e('Son Yazılar', 'onenav'); ?>
        </h3>
        <div class="sidebar__widget-content">
            <?php
            $recent_posts = new WP_Query(array(
                'posts_per_page' => 5,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
            ));

            if ($recent_posts->have_posts()) {
                echo '<ul class="recent-posts-list">';
                while ($recent_posts->have_posts()) {
                    $recent_posts->the_post();
                    ?>
                    <li class="recent-posts-list__item">
                        <a href="<?php the_permalink(); ?>" class="recent-posts-list__link">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="recent-posts-list__thumbnail">
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'recent-posts-list__image')); ?>
                                </div>
                            <?php endif; ?>
                            <div class="recent-posts-list__content">
                                <h4 class="recent-posts-list__title"><?php the_title(); ?></h4>
                                <span class="recent-posts-list__date"><?php echo get_the_date('j M Y'); ?></span>
                            </div>
                        </a>
                    </li>
                    <?php
                }
                echo '</ul>';
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>

    <!-- Popüler Siteler (Popular Sites) -->
    <div class="sidebar__widget widget--popular-sites">
        <h3 class="sidebar__widget-title">
            <svg width="16" height="16" fill="currentColor" class="sidebar__widget-icon">
                <path d="M10 2L8.59 3.41 13.17 8l-4.58 4.59L10 14l6-6-6-6zM0 12V8h12v4H0z"/>
            </svg>
            <?php esc_html_e('Popüler Siteler', 'onenav'); ?>
        </h3>
        <div class="sidebar__widget-content">
            <?php
            $popular_sites = new WP_Query(array(
                'post_type' => 'site',
                'posts_per_page' => 8,
                'meta_key' => 'click_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            ));

            if ($popular_sites->have_posts()) {
                echo '<ul class="popular-sites-list">';
                while ($popular_sites->have_posts()) {
                    $popular_sites->the_post();
                    $site_url = get_post_meta(get_the_ID(), 'site_url', true);
                    $site_icon = get_post_meta(get_the_ID(), 'site_icon', true);
                    $clicks = (int) get_post_meta(get_the_ID(), 'click_count', true);
                    ?>
                    <li class="popular-sites-list__item">
                        <a href="<?php echo esc_url($site_url); ?>" target="_blank" rel="noopener" class="popular-sites-list__link">
                            <?php if ($site_icon): ?>
                                <img src="<?php echo esc_url($site_icon); ?>" alt="<?php the_title_attribute(); ?>" class="popular-sites-list__icon">
                            <?php endif; ?>
                            <div class="popular-sites-list__content">
                                <h4 class="popular-sites-list__title"><?php the_title(); ?></h4>
                                <span class="popular-sites-list__clicks"><?php echo $clicks; ?> görüntüleme</span>
                            </div>
                        </a>
                    </li>
                    <?php
                }
                echo '</ul>';
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>

    <!-- Etiket Bulutu (Tag Cloud) -->
    <div class="sidebar__widget widget--tag-cloud">
        <h3 class="sidebar__widget-title">
            <svg width="16" height="16" fill="currentColor" class="sidebar__widget-icon">
                <path d="M2 2h6l8 8-6 6-8-8V2zm3 3a1 1 0 100-2 1 1 0 000 2z"/>
            </svg>
            <?php esc_html_e('Etiket Bulutu', 'onenav'); ?>
        </h3>
        <div class="sidebar__widget-content">
            <div class="tag-cloud">
                <?php
                $tags = get_tags(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 20,
                ));

                if ($tags) {
                    foreach ($tags as $tag) {
                        $tag_link = get_tag_link($tag->term_id);
                        echo '<a href="' . esc_url($tag_link) . '" class="tag-cloud__item" title="' . $tag->count . ' yazı">';
                        echo esc_html($tag->name);
                        echo '</a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Kategoriler (Categories) -->
    <div class="sidebar__widget widget--categories">
        <h3 class="sidebar__widget-title">
            <svg width="16" height="16" fill="currentColor" class="sidebar__widget-icon">
                <path d="M2 2h5l2 2h7a2 2 0 012 2v8a2 2 0 01-2 2H2a2 2 0 01-2-2V4a2 2 0 012-2z"/>
            </svg>
            <?php esc_html_e('Kategoriler', 'onenav'); ?>
        </h3>
        <div class="sidebar__widget-content">
            <ul class="categories-list">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 10,
                    'hide_empty' => true,
                ));

                foreach ($categories as $category) {
                    ?>
                    <li class="categories-list__item">
                        <a href="<?php echo get_category_link($category->term_id); ?>" class="categories-list__link">
                            <span class="categories-list__name"><?php echo esc_html($category->name); ?></span>
                            <span class="categories-list__count"><?php echo $category->count; ?></span>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Ziyaret İstatistikleri (Visit Statistics) -->
    <div class="sidebar__widget widget--stats">
        <h3 class="sidebar__widget-title">
            <svg width="16" height="16" fill="currentColor" class="sidebar__widget-icon">
                <path d="M2 2h2v12H2V2zm5 0h2v12H7V2zm5 0h2v12h-2V2zm5 0h2v12h-2V2z"/>
            </svg>
            <?php esc_html_e('Ziyaret İstatistikleri', 'onenav'); ?>
        </h3>
        <div class="sidebar__widget-content">
            <div class="stats-list">
                <div class="stats-list__item">
                    <span class="stats-list__label"><?php esc_html_e('Toplam Siteler', 'onenav'); ?></span>
                    <span class="stats-list__value"><?php echo wp_count_posts('site')->publish; ?></span>
                </div>
                <div class="stats-list__item">
                    <span class="stats-list__label"><?php esc_html_e('Toplam Yazılar', 'onenav'); ?></span>
                    <span class="stats-list__value"><?php echo wp_count_posts('post')->publish; ?></span>
                </div>
                <div class="stats-list__item">
                    <span class="stats-list__label"><?php esc_html_e('AI Araçları', 'onenav'); ?></span>
                    <span class="stats-list__value"><?php echo wp_count_posts('ai_tool')->publish; ?></span>
                </div>
                <div class="stats-list__item">
                    <span class="stats-list__label"><?php esc_html_e('E-Kitaplar', 'onenav'); ?></span>
                    <span class="stats-list__value"><?php echo wp_count_posts('ebook')->publish; ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Ad Space (Optional) -->
    <div class="sidebar__widget widget--ad-space">
        <div class="ad-space">
            <p class="ad-space__label"><?php esc_html_e('Reklam Alanı', 'onenav'); ?></p>
            <div class="ad-space__content">
                <!-- Add banner or ad code here -->
                <div style="background: linear-gradient(135deg, #a855f7, #ec4899); height: 250px; display: flex; align-items: center; justify-content: center; color: white; border-radius: 8px;">
                    300x250
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Sidebar Styles */
.sidebar {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.sidebar__widget {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.sidebar__widget-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--primary-color);
}

.sidebar__widget-icon {
    width: 16px;
    height: 16px;
    color: var(--primary-color);
}

/* Recent Posts */
.recent-posts-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-posts-list__item {
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e2e8f0;
}

.recent-posts-list__item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.recent-posts-list__link {
    display: flex;
    gap: 12px;
    text-decoration: none;
    color: inherit;
    transition: color 0.3s;
}

.recent-posts-list__link:hover {
    color: var(--primary-color);
}

.recent-posts-list__thumbnail {
    flex-shrink: 0;
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
}

.recent-posts-list__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.recent-posts-list__content {
    flex: 1;
    min-width: 0;
}

.recent-posts-list__title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
    line-height: 1.4;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.recent-posts-list__date {
    font-size: 12px;
    color: #94a3b8;
}

/* Popular Sites */
.popular-sites-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.popular-sites-list__item {
    margin-bottom: 12px;
}

.popular-sites-list__link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px;
    background: #f8fafc;
    border-radius: 8px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s;
}

.popular-sites-list__link:hover {
    background: var(--primary-color);
    color: #fff;
    transform: translateX(5px);
}

.popular-sites-list__icon {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    object-fit: cover;
}

.popular-sites-list__content {
    flex: 1;
    min-width: 0;
}

.popular-sites-list__title {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.popular-sites-list__clicks {
    font-size: 11px;
    opacity: 0.7;
}

/* Tag Cloud */
.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-cloud__item {
    display: inline-block;
    padding: 6px 12px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 20px;
    font-size: 12px;
    text-decoration: none;
    transition: all 0.3s;
}

.tag-cloud__item:hover {
    background: var(--primary-color);
    color: #fff;
    transform: translateY(-2px);
}

/* Categories */
.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.categories-list__item {
    margin-bottom: 10px;
}

.categories-list__link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px;
    background: #f8fafc;
    border-radius: 8px;
    text-decoration: none;
    color: #475569;
    transition: all 0.3s;
}

.categories-list__link:hover {
    background: var(--primary-color);
    color: #fff;
}

.categories-list__name {
    font-size: 14px;
    font-weight: 500;
}

.categories-list__count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    padding: 0 8px;
    background: #fff;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.categories-list__link:hover .categories-list__count {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
}

/* Stats */
.stats-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.stats-list__item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
    border-radius: 8px;
}

.stats-list__label {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
}

.stats-list__value {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-color);
}

/* Ad Space */
.ad-space__label {
    text-align: center;
    font-size: 11px;
    color: #94a3b8;
    margin-bottom: 10px;
}

.ad-space__content {
    border-radius: 8px;
    overflow: hidden;
}

/* Responsive */
@media (max-width: 1024px) {
    .sidebar {
        margin-top: 30px;
    }
}
</style>
