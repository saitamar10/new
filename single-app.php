<?php
/**
 * Single App Template - Play Store Style
 *
 * @package OneNav
 */

get_header();
?>

<main class="single-app-page">
    <?php while (have_posts()) : the_post(); ?>

        <?php
        // Get app meta data
        $ios_link = get_post_meta(get_the_ID(), 'ios_link', true);
        $android_link = get_post_meta(get_the_ID(), 'android_link', true);
        $app_price = get_post_meta(get_the_ID(), 'app_price', true);
        $app_style = get_theme_mod('onenav_app_store_style', 'playstore');
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('app-detail'); ?>>

            <!-- App Header Section -->
            <div class="app-header-section">
                <div class="app-header-content">

                    <!-- App Icon -->
                    <div class="app-icon-large">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('full'); ?>
                        <?php else : ?>
                            <div class="app-icon-placeholder">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                    <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- App Info -->
                    <div class="app-info">
                        <h1 class="app-title"><?php the_title(); ?></h1>
                        <div class="app-developer">
                            <?php the_author(); ?>
                        </div>

                        <!-- App Rating -->
                        <div class="app-rating">
                            <div class="stars">
                                <span class="star-filled">★★★★</span><span class="star-empty">☆</span>
                                <span class="rating-count">4.0</span>
                            </div>
                            <div class="app-downloads">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                10K+ İndirme
                            </div>
                        </div>

                        <!-- Download Buttons -->
                        <div class="app-download-buttons">
                            <?php if ($android_link) : ?>
                                <a href="<?php echo esc_url($android_link); ?>" target="_blank" class="download-btn download-android">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.523 15.3414c-.5511 0-.9993-.4486-.9993-.9997s.4483-.9993.9993-.9993c.5511 0 .9993.4483.9993.9993.0001.5511-.4482.9997-.9993.9997m-11.046 0c-.5511 0-.9993-.4486-.9993-.9997s.4482-.9993.9993-.9993c.5511 0 .9993.4483.9993.9993 0 .5511-.4483.9997-.9993.9997m11.4045-6.02l1.9973-3.4592a.416.416 0 00-.1521-.5676.416.416 0 00-.5676.1521l-2.0223 3.503C15.5902 8.2439 13.8533 7.8508 12 7.8508s-3.5902.3931-5.1367 1.0989L4.841 5.4467a.4161.4161 0 00-.5677-.1521.4157.4157 0 00-.1521.5676l1.9973 3.4592C2.6889 11.1867.3432 14.6589 0 18.761h24c-.3435-4.1021-2.6892-7.5743-6.1185-9.4396"/>
                                    </svg>
                                    <div>
                                        <small>Google Play'den indirin</small>
                                        <strong>Android</strong>
                                    </div>
                                </a>
                            <?php endif; ?>

                            <?php if ($ios_link) : ?>
                                <a href="<?php echo esc_url($ios_link); ?>" target="_blank" class="download-btn download-ios">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                                    </svg>
                                    <div>
                                        <small>App Store'dan indirin</small>
                                        <strong>iOS</strong>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Price -->
                        <?php if ($app_price) : ?>
                            <div class="app-price-tag">
                                <?php if ($app_price == 0) : ?>
                                    <span class="price-free">ÜCRETSİZ</span>
                                <?php else : ?>
                                    <span class="price-paid"><?php echo esc_html($app_price); ?> ₺</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- App Screenshots -->
            <?php
            $gallery_images = get_post_gallery_ids();
            if (!empty($gallery_images)) :
            ?>
                <div class="app-screenshots">
                    <h3>Ekran Görüntüleri</h3>
                    <div class="screenshots-slider">
                        <?php foreach ($gallery_images as $image_id) : ?>
                            <div class="screenshot-item">
                                <?php echo wp_get_attachment_image($image_id, 'medium'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- App Description -->
            <div class="app-description-section">
                <h3>Uygulama Hakkında</h3>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- App Features -->
            <div class="app-features">
                <h3>Özellikler</h3>
                <div class="features-grid">
                    <div class="feature-item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Ücretsiz</span>
                    </div>
                    <div class="feature-item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Türkçe Dil Desteği</span>
                    </div>
                    <div class="feature-item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Düzenli Güncellemeler</span>
                    </div>
                    <div class="feature-item">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Kullanıcı Dostu</span>
                    </div>
                </div>
            </div>

            <!-- App Info Details -->
            <div class="app-info-details">
                <h3>Detaylar</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Güncellenme</span>
                        <span class="info-value"><?php echo get_the_modified_date(); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Boyut</span>
                        <span class="info-value">Varies</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Sürüm</span>
                        <span class="info-value">Latest</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">İndirmeler</span>
                        <span class="info-value">10,000+</span>
                    </div>
                </div>
            </div>

        </article>

    <?php endwhile; ?>
</main>

<style>
/* App Detail Styles - Play Store Inspired */
.single-app-page {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.app-detail {
    background: var(--content-bg, #ffffff);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.app-header-section {
    padding: 30px;
    background: linear-gradient(135deg, rgba(52, 211, 153, 0.05) 0%, rgba(59, 130, 246, 0.05) 100%);
    border-bottom: 1px solid var(--border-color, #e2e8f0);
}

.app-header-content {
    display: flex;
    gap: 25px;
    align-items: flex-start;
}

.app-icon-large {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.app-icon-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.app-icon-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #34d399, #3b82f6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.app-info {
    flex: 1;
}

.app-title {
    font-size: 2rem;
    margin-bottom: 8px;
    color: var(--text-dark, #1e293b);
}

.app-developer {
    color: var(--success, #10b981);
    font-size: 14px;
    margin-bottom: 15px;
    font-weight: 600;
}

.app-rating {
    display: flex;
    gap: 20px;
    align-items: center;
    margin-bottom: 20px;
    font-size: 14px;
}

.stars {
    display: flex;
    align-items: center;
    gap: 8px;
}

.star-filled {
    color: #fbbf24;
}

.star-empty {
    color: #d1d5db;
}

.rating-count {
    color: var(--text-light, #64748b);
    font-weight: 600;
}

.app-downloads {
    display: flex;
    align-items: center;
    gap: 5px;
    color: var(--text-light, #64748b);
}

.app-download-buttons {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.download-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    color: white;
}

.download-android {
    background: #3ddc84;
}

.download-android:hover {
    background: #2cc06f;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(61, 220, 132, 0.4);
}

.download-ios {
    background: #007aff;
}

.download-ios:hover {
    background: #0062cc;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 122, 255, 0.4);
}

.download-btn small {
    display: block;
    font-size: 10px;
    font-weight: 400;
    opacity: 0.9;
}

.download-btn strong {
    display: block;
    font-size: 14px;
}

.app-price-tag {
    font-size: 18px;
    font-weight: 700;
}

.price-free {
    color: var(--success, #10b981);
}

.price-paid {
    color: var(--primary-color, #a855f7);
}

.app-screenshots {
    padding: 30px;
    border-bottom: 1px solid var(--border-color, #e2e8f0);
}

.app-screenshots h3 {
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.screenshots-slider {
    display: flex;
    gap: 15px;
    overflow-x: auto;
    padding-bottom: 10px;
}

.screenshots-slider::-webkit-scrollbar {
    height: 8px;
}

.screenshots-slider::-webkit-scrollbar-track {
    background: var(--border-color, #e2e8f0);
    border-radius: 10px;
}

.screenshots-slider::-webkit-scrollbar-thumb {
    background: var(--primary-color, #a855f7);
    border-radius: 10px;
}

.screenshot-item {
    flex-shrink: 0;
    width: 200px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.screenshot-item img {
    width: 100%;
    height: auto;
    display: block;
}

.app-description-section {
    padding: 30px;
    border-bottom: 1px solid var(--border-color, #e2e8f0);
}

.app-description-section h3 {
    margin-bottom: 15px;
    font-size: 1.3rem;
}

.app-description-section .entry-content {
    font-size: var(--app-font-size, 14px);
    line-height: var(--line-height, 1.6);
    color: var(--text-dark, #1e293b);
}

.app-features {
    padding: 30px;
    background: var(--light-bg, #f8fafc);
}

.app-features h3 {
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    background: white;
    border-radius: 8px;
    font-size: 14px;
}

.feature-item svg {
    color: var(--success, #10b981);
}

.app-info-details {
    padding: 30px;
}

.app-info-details h3 {
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.info-label {
    font-size: 12px;
    color: var(--text-light, #64748b);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-dark, #1e293b);
}

@media (max-width: 768px) {
    .app-header-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .app-icon-large {
        width: 100px;
        height: 100px;
    }

    .app-title {
        font-size: 1.5rem;
    }

    .app-download-buttons {
        flex-direction: column;
        width: 100%;
    }

    .download-btn {
        justify-content: center;
    }

    .features-grid,
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
