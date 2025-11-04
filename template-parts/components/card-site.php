<?php
/**
 * Component: Site Card
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

$site_url = get_post_meta(get_the_ID(), 'site_url', true);
$site_icon = get_post_meta(get_the_ID(), 'site_icon', true);
$clicks = (int) get_post_meta(get_the_ID(), 'click_count', true);
$category = wp_get_post_terms(get_the_ID(), 'site_category', array('fields' => 'names'));
$description = get_the_excerpt();
?>

<div class="card site-card" data-post-id="<?php the_ID(); ?>">
    <div class="card-header">
        <?php if ($site_icon): ?>
        <div class="card-icon">
            <img src="<?php echo esc_url($site_icon); ?>" alt="<?php the_title_attribute(); ?>">
        </div>
        <?php else: ?>
        <div class="card-icon card-icon-default">
            <span>🌐</span>
        </div>
        <?php endif; ?>

        <?php if (!empty($category)): ?>
        <span class="card-badge"><?php echo esc_html($category[0]); ?></span>
        <?php endif; ?>
    </div>

    <div class="card-body">
        <h3 class="card-title">
            <a href="<?php echo esc_url($site_url); ?>" target="_blank" rel="noopener" class="card-link">
                <?php the_title(); ?>
            </a>
        </h3>

        <?php if ($description): ?>
        <p class="card-description"><?php echo wp_trim_words($description, 15); ?></p>
        <?php endif; ?>
    </div>

    <div class="card-footer">
        <div class="card-stats">
            <span class="stat-item">
                <span class="stat-icon">👁️</span>
                <span class="stat-text"><?php echo number_format($clicks); ?></span>
            </span>
        </div>

        <div class="card-actions">
            <a href="<?php echo esc_url($site_url); ?>" target="_blank" rel="noopener" class="card-btn card-btn-primary" data-click-track="<?php the_ID(); ?>">
                Ziyaret Et
            </a>
            <button class="card-btn card-btn-secondary qr-btn" data-url="<?php echo esc_url($site_url); ?>" title="QR Kod">
                📱
            </button>
        </div>
    </div>
</div>
