<?php
/**
 * Template part for displaying video cards
 *
 * @package OneNav Pro
 */

$post_id = get_the_ID();
$external_url = get_post_meta($post_id, 'external_url', true);
$video_url = get_post_meta($post_id, 'video_url', true);
$duration = get_post_meta($post_id, 'duration', true);
$link_url = $external_url ? $external_url : get_permalink();
$link_target = $external_url ? '_blank' : '_self';
?>

<article id="video-<?php the_ID(); ?>" <?php post_class('card card--video'); ?>>
    <a href="<?php echo esc_url($link_url); ?>"
       class="card__link"
       target="<?php echo esc_attr($link_target); ?>"
       <?php if ($external_url) echo 'rel="nofollow noopener"'; ?>>

        <div class="card__thumbnail-wrapper">
            <?php if (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('onenav-gallery', array('class' => 'card__thumbnail')); ?>
            <?php else: ?>
                <div class="card__thumbnail card__thumbnail--placeholder">
                    <i class="dashicons dashicons-video-alt3"></i>
                </div>
            <?php endif; ?>

            <div class="card__play-overlay">
                <i class="dashicons dashicons-controls-play"></i>
            </div>

            <?php if ($duration): ?>
                <span class="card__duration"><?php echo esc_html($duration); ?></span>
            <?php endif; ?>
        </div>

        <div class="card__content">
            <h3 class="card__title"><?php the_title(); ?></h3>

            <?php if (has_excerpt()): ?>
                <p class="card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
            <?php endif; ?>

            <div class="card__meta">
                <span class="meta__date">
                    <i class="dashicons dashicons-calendar"></i>
                    <?php echo get_the_date(); ?>
                </span>
                <?php
                $views = get_post_meta($post_id, 'views', true);
                if ($views):
                    ?>
                    <span class="meta__views">
                        <i class="dashicons dashicons-visibility"></i>
                        <?php echo number_format_i18n($views); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </a>
</article>
