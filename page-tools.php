<?php
/**
 * Template Name: AI Araçları
 * Template for displaying AI tools
 *
 * @package OneNav
 */

get_header();

$ai_columns = onenav_get_option('ai_columns', '3');
$load_more_text = onenav_get_option('ai_load_more_text', 'Daha Fazla Yükle');
$filter_titles = onenav_get_option('ai_filter_titles', 'Tümü,Metin,Görsel,Video,Ses,Kod');
$filters = explode(',', $filter_titles);
?>

<div class="container" style="margin-top: 40px;">
    <!-- Page Header -->
    <div style="text-align: center; margin-bottom: 50px;">
        <h1 style="font-size: 3rem; margin-bottom: 15px;"><i class="fas fa-robot"></i> <?php the_title(); ?></h1>
        <p style="font-size: 1.2rem; color: #64748b; max-width: 800px; margin: 0 auto;">
            <?php echo get_the_content() ? get_the_content() : 'En iyi yapay zeka araçlarını keşfedin ve projelerinizde kullanın.'; ?>
        </p>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs" style="margin-bottom: 40px;">
        <?php
        $first = true;
        foreach ($filters as $filter) {
            $filter = trim($filter);
            $filter_slug = sanitize_title($filter);
            ?>
            <button class="filter-tab <?php echo $first ? 'active' : ''; ?>" data-filter="<?php echo $first ? 'all' : esc_attr($filter_slug); ?>">
                <?php echo esc_html($filter); ?>
            </button>
            <?php
            $first = false;
        }
        ?>
    </div>

    <!-- AI Tools Grid -->
    <div class="ai-tools-container">
        <div class="sites-grid" id="ai-tools-grid" style="grid-template-columns: repeat(<?php echo esc_attr($ai_columns); ?>, 1fr);">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $ai_query = new WP_Query(array(
                'post_type' => 'ai_tool',
                'posts_per_page' => 24,
                'paged' => $paged,
            ));

            if ($ai_query->have_posts()) {
                while ($ai_query->have_posts()) {
                    $ai_query->the_post();
                    $tool_url = get_post_meta(get_the_ID(), 'ai_tool_url', true);
                    $features = get_post_meta(get_the_ID(), 'ai_features', true);
                    $pricing = get_post_meta(get_the_ID(), 'ai_pricing', true);
                    $category = get_post_meta(get_the_ID(), 'ai_category', true);
                    $rating = get_post_meta(get_the_ID(), 'ai_rating', true);
                    ?>
                    <div class="ai-tool-card" data-category="<?php echo esc_attr(sanitize_title($category)); ?>" data-post-id="<?php the_ID(); ?>" style="display: flex; flex-direction: column;">
                        <!-- Tool Logo -->
                        <div style="margin-bottom: 15px;">
                            <?php if (has_post_thumbnail()) { ?>
                                <?php the_post_thumbnail('onenav-site-icon', array('class' => 'ai-logo', 'style' => 'width: 60px; height: 60px; border-radius: 12px; object-fit: cover;')); ?>
                            <?php } else { ?>
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                                    <i class="fas fa-robot"></i>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Tool Header -->
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                                <h3 class="ai-tool-name" style="font-size: 18px; font-weight: 600; margin: 0; flex: 1;">
                                    <?php the_title(); ?>
                                </h3>
                                <?php if ($pricing === 'free') { ?>
                                    <span style="background: var(--success); color: white; padding: 4px 10px; border-radius: 5px; font-size: 11px; font-weight: bold; margin-left: 10px;">
                                        ÜCRETSİZ
                                    </span>
                                <?php } elseif ($pricing === 'freemium') { ?>
                                    <span style="background: var(--warning); color: white; padding: 4px 10px; border-radius: 5px; font-size: 11px; font-weight: bold; margin-left: 10px;">
                                        FREEMIUM
                                    </span>
                                <?php } elseif ($pricing === 'paid') { ?>
                                    <span style="background: var(--danger); color: white; padding: 4px 10px; border-radius: 5px; font-size: 11px; font-weight: bold; margin-left: 10px;">
                                        ÜCRETLI
                                    </span>
                                <?php } ?>
                            </div>

                            <!-- Category -->
                            <?php if ($category) { ?>
                                <p style="font-size: 13px; color: #64748b; margin-bottom: 12px;">
                                    <i class="fas fa-tag"></i> <?php echo esc_html($category); ?>
                                </p>
                            <?php } ?>

                            <!-- Rating -->
                            <?php if ($rating) { ?>
                                <div style="margin-bottom: 12px; color: #fbbf24; font-size: 14px;">
                                    <?php
                                    $rating_num = floatval($rating);
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating_num) {
                                            echo '<i class="fas fa-star"></i>';
                                        } elseif ($i - 0.5 <= $rating_num) {
                                            echo '<i class="fas fa-star-half-alt"></i>';
                                        } else {
                                            echo '<i class="far fa-star"></i>';
                                        }
                                    }
                                    ?>
                                    <span style="color: #64748b; margin-left: 5px;">(<?php echo esc_html($rating); ?>)</span>
                                </div>
                            <?php } ?>

                            <!-- Description -->
                            <p class="ai-tool-description" style="font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 15px;">
                                <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                            </p>

                            <!-- Features Tags -->
                            <?php if ($features) { ?>
                                <div class="ai-features" style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 15px;">
                                    <?php
                                    $feature_array = explode(',', $features);
                                    foreach (array_slice($feature_array, 0, 4) as $feature) {
                                        ?>
                                        <span class="feature-tag" style="background: #f8fafc; color: #64748b; padding: 5px 12px; border-radius: 12px; font-size: 12px; border: 1px solid #e2e8f0;">
                                            <?php echo trim($feature); ?>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Visit Button -->
                        <?php if ($tool_url) { ?>
                            <a href="<?php echo esc_url($tool_url); ?>" target="_blank" rel="noopener" class="ai-visit-btn" style="width: 100%; padding: 12px; background: var(--primary-color); color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; transition: all 0.3s ease;">
                                <i class="fas fa-external-link-alt"></i> Ziyaret Et
                            </a>
                        <?php } ?>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            } else {
                echo '<div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 12px;"><p style="font-size: 1.2rem; color: #64748b;"><i class="fas fa-info-circle"></i> Henüz AI aracı eklenmemiş.</p></div>';
            }
            ?>
        </div>

        <!-- Load More Button -->
        <div style="text-align: center; margin-top: 50px;" id="load-more-container">
            <button id="load-more-btn" class="ai-visit-btn" style="padding: 15px 40px; background: var(--primary-color); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-plus-circle"></i> <?php echo esc_html($load_more_text); ?>
            </button>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="section" style="margin-top: 80px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); padding: 60px 40px; border-radius: 20px; color: white; text-align: center;">
        <h2 style="color: white; margin-bottom: 40px; font-size: 2.5rem;"><i class="fas fa-chart-bar"></i> Platform İstatistikleri</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px;">
            <div>
                <div style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">
                    <?php echo wp_count_posts('ai_tool')->publish; ?>+
                </div>
                <div style="font-size: 1.1rem; opacity: 0.9;">AI Aracı</div>
            </div>
            <div>
                <div style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">
                    <?php
                    $total_categories = wp_count_terms(array(
                        'taxonomy' => 'ai_tool_category',
                        'hide_empty' => false,
                    ));
                    echo is_wp_error($total_categories) ? '0' : $total_categories;
                    ?>+
                </div>
                <div style="font-size: 1.1rem; opacity: 0.9;">Kategori</div>
            </div>
            <div>
                <div style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">50K+</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">Kullanıcı</div>
            </div>
            <div>
                <div style="font-size: 3rem; font-weight: bold; margin-bottom: 10px;">100%</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">Ücretsiz Erişim</div>
            </div>
        </div>
    </div>
</div>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const toolCards = document.querySelectorAll('.ai-tool-card');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            toolCards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-category') === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Load more functionality (basic example - would need AJAX in production)
    const loadMoreBtn = document.getElementById('load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            alert('Load more functionality would use AJAX to fetch more AI tools.');
        });
    }
});
</script>

<?php get_footer(); ?>
