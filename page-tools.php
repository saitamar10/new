<?php
/**
 * Template Name: AI Tools Page
 * Description: Displays AI tools with filtering and load more
 *
 * @package OneNav
 */

get_header();

$options = get_option('onenav_options', array());
$filter_titles = isset($options['ai_filter_titles']) ? $options['ai_filter_titles'] : 'Tümü,Metin,Görsel,Video,Kod,Müzik';
$max_columns = isset($options['ai_max_columns']) ? $options['ai_max_columns'] : 4;
$load_more_text = isset($options['ai_load_more_text']) ? $options['ai_load_more_text'] : 'Daha Fazla Yükle';

$filters = array_map('trim', explode(',', $filter_titles));
?>

<div class="ai-tools-page">
    <div class="container">
        <!-- Page Header -->
        <header class="ai-tools-page__header">
            <div class="ai-tools-page__header-content">
                <h1 class="ai-tools-page__title">
                    <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" class="ai-tools-page__icon">
                        <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                    </svg>
                    <?php the_title(); ?>
                </h1>
                <div class="ai-tools-page__description">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </header>

        <!-- Filter Tabs -->
        <div class="ai-tools-page__filters">
            <?php foreach ($filters as $index => $filter): ?>
                <button
                    class="ai-tools-filter-btn <?php echo $index === 0 ? 'active' : ''; ?>"
                    data-filter="<?php echo esc_attr(strtolower($filter)); ?>"
                >
                    <?php echo esc_html($filter); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Tools Grid -->
        <div class="ai-tools-grid" data-max-columns="<?php echo esc_attr($max_columns); ?>">
            <?php
            $ai_tools_query = new WP_Query(array(
                'post_type' => 'ai_tool',
                'posts_per_page' => 12,
                'orderby' => 'date',
                'order' => 'DESC',
            ));

            if ($ai_tools_query->have_posts()) {
                while ($ai_tools_query->have_posts()) {
                    $ai_tools_query->the_post();
                    $tool_url = get_post_meta(get_the_ID(), 'ai_tool_url', true);
                    $features = get_post_meta(get_the_ID(), 'ai_features', true);
                    $feature_array = $features ? array_map('trim', explode(',', $features)) : array();
                    ?>
                    <article class="ai-tool-card" data-post-id="<?php the_ID(); ?>">
                        <!-- Tool Logo -->
                        <div class="ai-tool-card__header">
                            <?php if (has_post_thumbnail()): ?>
                                <img
                                    src="<?php the_post_thumbnail_url('thumbnail'); ?>"
                                    alt="<?php the_title_attribute(); ?>"
                                    class="ai-tool-card__logo"
                                >
                            <?php else: ?>
                                <div class="ai-tool-card__logo ai-tool-card__logo--placeholder">
                                    <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Tool Content -->
                        <div class="ai-tool-card__content">
                            <h3 class="ai-tool-card__title">
                                <a href="<?php echo esc_url($tool_url ? $tool_url : get_permalink()); ?>" class="ai-tool-card__title-link" target="_blank" rel="noopener">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <p class="ai-tool-card__description">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </p>

                            <!-- Features Tags -->
                            <?php if (!empty($feature_array)): ?>
                                <div class="ai-tool-card__features">
                                    <?php foreach (array_slice($feature_array, 0, 3) as $feature): ?>
                                        <span class="ai-tool-card__feature-tag"><?php echo esc_html($feature); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Tool Footer -->
                        <div class="ai-tool-card__footer">
                            <?php if ($tool_url): ?>
                                <a
                                    href="<?php echo esc_url($tool_url); ?>"
                                    target="_blank"
                                    rel="noopener"
                                    class="ai-tool-card__btn"
                                >
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M10 2v2h3.59L7 10.59 8.41 12 15 5.41V9h2V2h-7z"/>
                                        <path d="M13 13H3V3h4V1H3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V9h-2v4z"/>
                                    </svg>
                                    <?php esc_html_e('Siteye Git', 'onenav'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>
                    <?php
                }
                wp_reset_postdata();
            } else {
                ?>
                <div class="ai-tools-empty">
                    <svg width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                    </svg>
                    <h3><?php esc_html_e('Henüz AI Aracı Eklenmemiş', 'onenav'); ?></h3>
                    <p><?php esc_html_e('Yakında birçok AI aracı eklenecek.', 'onenav'); ?></p>
                </div>
                <?php
            }
            ?>
        </div>

        <!-- Load More Button -->
        <?php if ($ai_tools_query->max_num_pages > 1): ?>
            <div class="ai-tools-page__load-more">
                <button class="ai-tools-load-more-btn" data-page="1" data-max-pages="<?php echo $ai_tools_query->max_num_pages; ?>">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6 0 1.01-.25 1.97-.7 2.8l1.46 1.46C19.54 15.03 20 13.57 20 12c0-4.42-3.58-8-8-8zm0 14c-3.31 0-6-2.69-6-6 0-1.01.25-1.97.7-2.8L5.24 7.74C4.46 8.97 4 10.43 4 12c0 4.42 3.58 8 8 8v3l4-4-4-4v3z"/>
                    </svg>
                    <?php echo esc_html($load_more_text); ?>
                </button>
                <div class="ai-tools-loading" style="display: none;">
                    <div class="spinner"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* AI Tools Page */
.ai-tools-page {
    padding: 40px 0;
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
    min-height: 100vh;
}

.ai-tools-page__header {
    margin-bottom: 40px;
    text-align: center;
}

.ai-tools-page__header-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
}

.ai-tools-page__title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    font-size: 3rem;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #a855f7, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.ai-tools-page__icon {
    width: 48px;
    height: 48px;
    fill: url(#gradient);
}

.ai-tools-page__description {
    font-size: 18px;
    color: #64748b;
    line-height: 1.6;
}

/* Filters */
.ai-tools-page__filters {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-bottom: 40px;
    padding: 25px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.ai-tools-filter-btn {
    padding: 12px 24px;
    border: 2px solid #e2e8f0;
    background: #fff;
    color: #475569;
    border-radius: 30px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.ai-tools-filter-btn:hover,
.ai-tools-filter-btn.active {
    border-color: var(--primary-color);
    background: var(--primary-color);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(168, 85, 247, 0.4);
}

/* Tools Grid */
.ai-tools-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 25px;
    margin-bottom: 40px;
}

.ai-tools-grid[data-max-columns="3"] {
    grid-template-columns: repeat(3, 1fr);
}

.ai-tools-grid[data-max-columns="5"] {
    grid-template-columns: repeat(5, 1fr);
}

/* Tool Card */
.ai-tool-card {
    background: #fff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    cursor: pointer;
}

.ai-tool-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.ai-tool-card__header {
    margin-bottom: 20px;
}

.ai-tool-card__logo {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.ai-tool-card__logo--placeholder {
    background: linear-gradient(135deg, #a855f7, #ec4899);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.ai-tool-card__content {
    flex: 1;
    margin-bottom: 20px;
}

.ai-tool-card__title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
    line-height: 1.3;
}

.ai-tool-card__title-link {
    color: #1e293b;
    text-decoration: none;
    transition: color 0.3s;
}

.ai-tool-card__title-link:hover {
    color: var(--primary-color);
}

.ai-tool-card__description {
    font-size: 14px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 15px;
}

.ai-tool-card__features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.ai-tool-card__feature-tag {
    display: inline-block;
    padding: 4px 10px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

.ai-tool-card__footer {
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
}

.ai-tool-card__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 20px;
    background: var(--primary-color);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s;
}

.ai-tool-card__btn:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(236, 72, 153, 0.4);
}

.ai-tool-card__btn svg {
    width: 16px;
    height: 16px;
}

/* Empty State */
.ai-tools-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
}

.ai-tools-empty svg {
    margin-bottom: 20px;
    color: #cbd5e1;
}

.ai-tools-empty h3 {
    font-size: 24px;
    margin-bottom: 12px;
    color: #1e293b;
}

.ai-tools-empty p {
    font-size: 16px;
    color: #64748b;
}

/* Load More */
.ai-tools-page__load-more {
    text-align: center;
}

.ai-tools-load-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 35px;
    background: #fff;
    border: 2px solid var(--primary-color);
    border-radius: 30px;
    color: var(--primary-color);
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.ai-tools-load-more-btn:hover {
    background: var(--primary-color);
    color: #fff;
}

.ai-tools-loading {
    margin-top: 20px;
}

.spinner {
    width: 40px;
    height: 40px;
    margin: 0 auto;
    border: 4px solid #f3f4f6;
    border-top-color: var(--primary-color);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 1200px) {
    .ai-tools-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .ai-tools-page__title {
        font-size: 2rem;
    }

    .ai-tools-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .ai-tools-filter-btn {
        padding: 10px 20px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .ai-tools-grid {
        grid-template-columns: 1fr;
    }

    .ai-tools-page__filters {
        gap: 8px;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Filter functionality
    $('.ai-tools-filter-btn').on('click', function() {
        $('.ai-tools-filter-btn').removeClass('active');
        $(this).addClass('active');

        const filter = $(this).data('filter');
        // Implement AJAX filter if needed
        console.log('Filter:', filter);
    });

    // Load more functionality
    $('.ai-tools-load-more-btn').on('click', function() {
        const button = $(this);
        const currentPage = parseInt(button.data('page'));
        const maxPages = parseInt(button.data('max-pages'));
        const nextPage = currentPage + 1;

        if (nextPage > maxPages) {
            button.text('<?php esc_html_e('Tüm Araçlar Yüklendi', 'onenav'); ?>').prop('disabled', true);
            return;
        }

        $('.ai-tools-loading').show();
        button.hide();

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'load_more_ai_tools',
                page: nextPage,
            },
            success: function(response) {
                if (response.success) {
                    $('.ai-tools-grid').append(response.data.html);
                    button.data('page', nextPage);

                    if (nextPage >= maxPages) {
                        button.text('<?php esc_html_e('Tüm Araçlar Yüklendi', 'onenav'); ?>').prop('disabled', true);
                    }
                }
                $('.ai-tools-loading').hide();
                button.show();
            },
            error: function() {
                $('.ai-tools-loading').hide();
                button.show();
            }
        });
    });
});
</script>

<?php get_footer(); ?>
