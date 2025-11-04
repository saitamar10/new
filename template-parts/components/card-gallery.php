<?php
/**
 * Component: Gallery Card
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;
?>

<div class="card gallery-card" data-post-id="<?php the_ID(); ?>">
    <a href="<?php the_permalink(); ?>" class="gallery-link">
        <div class="gallery-image">
            <?php if (has_post_thumbnail()): ?>
                <img src="<?php the_post_thumbnail_url('onenav-gallery'); ?>" alt="<?php the_title_attribute(); ?>">
            <?php else: ?>
                <div class="gallery-image-placeholder">
                    <span class="placeholder-icon">🖼️</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="gallery-overlay">
            <div class="gallery-content">
                <h3 class="gallery-title"><?php the_title(); ?></h3>
                <?php
                $image_count = get_post_meta(get_the_ID(), 'gallery_count', true);
                if ($image_count):
                ?>
                <span class="gallery-count">
                    <span class="count-icon">📷</span>
                    <span class="count-text"><?php echo esc_html($image_count); ?> Fotoğraf</span>
                </span>
                <?php endif; ?>
            </div>
        </div>
    </a>
</div>
