<?php
/**
 * Component: App Card
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

$ios_link = get_post_meta(get_the_ID(), 'ios_link', true);
$android_link = get_post_meta(get_the_ID(), 'android_link', true);
$price = get_post_meta(get_the_ID(), 'app_price', true);
?>

<div class="card app-card" data-post-id="<?php the_ID(); ?>">
    <div class="card-header">
        <div class="card-icon card-icon-large">
            <?php if (has_post_thumbnail()): ?>
                <img src="<?php the_post_thumbnail_url('onenav-app-icon'); ?>" alt="<?php the_title_attribute(); ?>">
            <?php else: ?>
                <span>📱</span>
            <?php endif; ?>
        </div>

        <?php if ($price !== null && $price !== ''): ?>
        <span class="card-badge card-badge-price">
            <?php echo floatval($price) > 0 ? '₺' . number_format($price, 2) : 'Ücretsiz'; ?>
        </span>
        <?php endif; ?>
    </div>

    <div class="card-body">
        <h3 class="card-title"><?php the_title(); ?></h3>

        <p class="card-description">
            <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
        </p>
    </div>

    <div class="card-footer">
        <div class="card-actions card-actions-split">
            <?php if ($ios_link): ?>
                <a href="<?php echo esc_url($ios_link); ?>" target="_blank" class="card-btn card-btn-ios" rel="noopener">
                    <span class="btn-icon">🍎</span>
                    <span class="btn-text">iOS</span>
                </a>
            <?php endif; ?>

            <?php if ($android_link): ?>
                <a href="<?php echo esc_url($android_link); ?>" target="_blank" class="card-btn card-btn-android" rel="noopener">
                    <span class="btn-icon">🤖</span>
                    <span class="btn-text">Android</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
