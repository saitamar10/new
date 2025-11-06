<?php
/**
 * Home Page Template
 * 
 * @package OneNav
 */

get_header();
?>

<div class="container">
    <!-- ============================================
         POPULAR SITES SECTION
         ============================================ -->
    <div class="section">
        <div class="section-title">
            <h2><i class="fas fa-star"></i> <?php echo esc_html(onenav_get_option('popular_sites_title', 'Popüler Siteler')); ?></h2>
            <a href="<?php echo home_url('/site-category/'); ?>" class="view-all">Tümünü Gör →</a>
        </div>
        <div class="sites-grid">
            <?php
            $popular_sites = new WP_Query(array(
                'post_type' => 'site',
                'posts_per_page' => 12,
                'meta_key' => 'click_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            ));

            if ($popular_sites->have_posts()) {
                while ($popular_sites->have_posts()) {
                    $popular_sites->the_post();
                    $site_url = get_post_meta(get_the_ID(), 'site_url', true);
                    $site_icon = get_post_meta(get_the_ID(), 'site_icon', true);
                    $clicks = (int) get_post_meta(get_the_ID(), 'click_count', true);
                    $category = wp_get_post_terms(get_the_ID(), 'site_category', array('fields' => 'names'));
                    ?>
                    <div class="site-card" data-post-id="<?php the_ID(); ?>">
                        <img src="<?php echo esc_url($site_icon); ?>" alt="<?php the_title_attribute(); ?>" class="site-icon">
                        <h3 class="site-title"><?php the_title(); ?></h3>
                        <p class="site-category"><?php echo !empty($category) ? esc_html($category[0]) : 'Diğer'; ?></p>
                        <p style="font-size: 12px; color: #999; margin: 8px 0;">👁️ <?php echo $clicks; ?> görüntüleme</p>
                        <div class="site-actions">
                            <a href="<?php echo esc_url($site_url); ?>" target="_blank" rel="noopener" class="site-action-btn">🌐 Git</a>
                            <button class="site-action-btn qr-btn" data-url="<?php echo esc_url($site_url); ?>">📱 QR</button>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            } else {
                echo '<p>' . esc_html__('Henüz site eklenmemiş.', 'onenav') . '</p>';
            }
            ?>
        </div>
    </div>

    <!-- ============================================
         NEWS SECTION
         ============================================ -->
    <div class="section">
        <div class="section-title">
            <h2><i class="fas fa-newspaper"></i> Güncel Haberler</h2>
            <a href="<?php echo home_url('/news/'); ?>" class="view-all">Tümünü Gör →</a>
        </div>
        <div class="news-grid">
            <?php
            $news_query = new WP_Query(array(
                'post_type' => 'news',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC',
            ));

            if ($news_query->have_posts()) {
                while ($news_query->have_posts()) {
                    $news_query->the_post();
                    ?>
                    <div class="news-card" data-post-id="<?php the_ID(); ?>">
                        <?php if (has_post_thumbnail()) { ?>
                            <img src="<?php the_post_thumbnail_url('onenav-news-featured'); ?>" alt="<?php the_title_attribute(); ?>" class="news-image">
                        <?php } else { ?>
                            <div class="news-image" style="background: linear-gradient(135deg, #a855f7, #ec4899);"></div>
                        <?php } ?>
                        <div class="news-content">
                            <span class="news-category">Haber</span>
                            <h3 class="news-title"><?php the_title(); ?></h3>
                            <p class="news-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
                            <div class="news-meta">
                                👤 <?php the_author(); ?> | 📅 <?php echo get_the_date('j F Y'); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>

    <!-- ============================================
         MOBILE APPS SECTION
         ============================================ -->
    <div class="section">
        <div class="section-title">
            <h2><i class="fas fa-mobile-alt"></i> Mobil Uygulamalar</h2>
            <a href="<?php echo home_url('/app/'); ?>" class="view-all">Tümünü Gör →</a>
        </div>
        <div class="apps-grid">
            <?php
            $apps_query = new WP_Query(array(
                'post_type' => 'app',
                'posts_per_page' => 12,
            ));

            if ($apps_query->have_posts()) {
                while ($apps_query->have_posts()) {
                    $apps_query->the_post();
                    $ios_link = get_post_meta(get_the_ID(), 'ios_link', true);
                    $android_link = get_post_meta(get_the_ID(), 'android_link', true);
                    $price = get_post_meta(get_the_ID(), 'app_price', true);
                    ?>
                    <div class="app-card" data-post-id="<?php the_ID(); ?>">
                        <?php if (has_post_thumbnail()) { ?>
                            <img src="<?php the_post_thumbnail_url('onenav-app-icon'); ?>" alt="<?php the_title_attribute(); ?>" class="app-icon">
                        <?php } ?>
                        <h3 class="app-name"><?php the_title(); ?></h3>
                        <?php if ($price) { ?>
                            <div class="app-price">₺<?php echo floatval($price) > 0 ? number_format($price, 2) : 'Ücretsiz'; ?></div>
                        <?php } ?>
                        <p class="app-description"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                        <div class="app-buttons">
                            <?php if ($ios_link) { ?>
                                <a href="<?php echo esc_url($ios_link); ?>" target="_blank" class="app-btn">🍎 iOS</a>
                            <?php } ?>
                            <?php if ($android_link) { ?>
                                <a href="<?php echo esc_url($android_link); ?>" target="_blank" class="app-btn">🤖 Android</a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>

    <!-- ============================================
         E-BOOKS SECTION
         ============================================ -->
    <div class="section">
        <div class="section-title">
            <h2><i class="fas fa-book"></i> <?php echo esc_html(onenav_get_option('ebook_section_title', 'E-Kitaplar & Dergiler')); ?></h2>
            <a href="<?php echo home_url('/ebook/'); ?>" class="view-all">Tümünü Gör →</a>
        </div>
        <div class="apps-grid">
            <?php
            $ebooks_query = new WP_Query(array(
                'post_type' => 'ebook',
                'posts_per_page' => 12,
            ));

            if ($ebooks_query->have_posts()) {
                while ($ebooks_query->have_posts()) {
                    $ebooks_query->the_post();
                    $file_url = get_post_meta(get_the_ID(), 'ebook_file', true);
                    $file_type = get_post_meta(get_the_ID(), 'ebook_type', true);
                    ?>
                    <div class="ebook-card" data-post-id="<?php the_ID(); ?>">
                        <div class="ebook-cover">
                            <?php if (has_post_thumbnail()) { ?>
                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php } else { ?>
                                📖
                            <?php } ?>
                        </div>
                        <h3 class="ebook-title"><?php the_title(); ?></h3>
                        <p style="font-size: 12px; color: #999; margin: 8px 0;">📄 <?php echo strtoupper($file_type); ?></p>
                        <div class="ebook-actions">
                            <?php if ($file_url) { ?>
                                <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="ebook-btn">💾 İndir</a>
                                <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="ebook-btn">👁️ Oku</a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>

    <!-- ============================================
         AI TOOLS SECTION
         ============================================ -->
    <div class="section">
        <div class="section-title">
            <h2><i class="fas fa-robot"></i> Yapay Zeka Araçları</h2>
            <a href="<?php echo home_url('/ai-tool/'); ?>" class="view-all">Tümünü Gör →</a>
        </div>
        <div class="sites-grid">
            <?php
            $ai_query = new WP_Query(array(
                'post_type' => 'ai_tool',
                'posts_per_page' => 12,
            ));

            if ($ai_query->have_posts()) {
                while ($ai_query->have_posts()) {
                    $ai_query->the_post();
                    $tool_url = get_post_meta(get_the_ID(), 'ai_tool_url', true);
                    $features = get_post_meta(get_the_ID(), 'ai_features', true);
                    ?>
                    <div class="ai-tool-card" data-post-id="<?php the_ID(); ?>">
                        <?php if (has_post_thumbnail()) { ?>
                            <img src="<?php the_post_thumbnail_url('onenav-site-icon'); ?>" alt="<?php the_title_attribute(); ?>" class="ai-logo">
                        <?php } ?>
                        <h3 class="ai-tool-name"><?php the_title(); ?></h3>
                        <p class="ai-tool-description"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        <?php if ($features) { ?>
                            <div class="ai-features">
                                <?php 
                                $feature_array = explode(',', $features);
                                foreach (array_slice($feature_array, 0, 3) as $feature) {
                                    ?>
                                    <span class="feature-tag"><?php echo trim($feature); ?></span>
                                    <?php
                                }
                                ?>
                            </div>
                        <?php } ?>
                        <?php if ($tool_url) { ?>
                            <a href="<?php echo esc_url($tool_url); ?>" target="_blank" class="ai-visit-btn">🔗 Ziyaret Et</a>
                        <?php } ?>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>

    <!-- ============================================
         GALLERY SECTION
         ============================================ -->
    <div class="section">
        <div class="section-title">
            <h2><i class="fas fa-images"></i> Foto Galeriler</h2>
            <a href="<?php echo home_url('/gallery/'); ?>" class="view-all">Tümünü Gör →</a>
        </div>
        <div class="gallery-grid">
            <?php
            $gallery_query = new WP_Query(array(
                'post_type' => 'gallery',
                'posts_per_page' => 12,
            ));

            if ($gallery_query->have_posts()) {
                while ($gallery_query->have_posts()) {
                    $gallery_query->the_post();
                    ?>
                    <div class="gallery-card" data-post-id="<?php the_ID(); ?>">
                        <?php if (has_post_thumbnail()) { ?>
                            <img src="<?php the_post_thumbnail_url('onenav-gallery'); ?>" alt="<?php the_title_attribute(); ?>" class="gallery-image">
                        <?php } else { ?>
                            <div class="gallery-image" style="background: linear-gradient(135deg, #a855f7, #ec4899);"></div>
                        <?php } ?>
                        <div class="gallery-overlay">
                            <div class="gallery-title"><?php the_title(); ?></div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>
