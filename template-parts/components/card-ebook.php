<?php
/**
 * Component: E-Book Card
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

$file_url = get_post_meta(get_the_ID(), 'ebook_file', true);
$file_type = get_post_meta(get_the_ID(), 'ebook_type', true);
?>

<div class="card ebook-card" data-post-id="<?php the_ID(); ?>">
    <div class="card-cover">
        <?php if (has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>">
        <?php else: ?>
            <div class="card-cover-placeholder">
                <span class="placeholder-icon">📖</span>
            </div>
        <?php endif; ?>

        <?php if ($file_type): ?>
        <span class="card-badge card-badge-type"><?php echo strtoupper(esc_html($file_type)); ?></span>
        <?php endif; ?>
    </div>

    <div class="card-body">
        <h3 class="card-title"><?php the_title(); ?></h3>
    </div>

    <div class="card-footer">
        <div class="card-actions card-actions-split">
            <?php if ($file_url): ?>
                <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="card-btn card-btn-secondary" rel="noopener">
                    <span class="btn-icon">💾</span>
                    <span class="btn-text">İndir</span>
                </a>
                <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="card-btn card-btn-primary" rel="noopener">
                    <span class="btn-icon">👁️</span>
                    <span class="btn-text">Oku</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
