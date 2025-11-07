<?php
/**
 * Template part for displaying ebook cards
 *
 * @package OneNav Pro
 */

$post_id = get_the_ID();
$ebook_file = get_post_meta($post_id, 'ebook_file', true);
$cover = get_post_meta($post_id, 'cover', true);
$price = get_post_meta($post_id, 'price', true);
$isbn = get_post_meta($post_id, 'isbn', true);
$link_url = $ebook_file ? $ebook_file : get_permalink();
?>

<article id="ebook-<?php the_ID(); ?>" <?php post_class('card card--ebook'); ?>>
    <a href="<?php echo esc_url(get_permalink()); ?>" class="card__link">

        <div class="card__cover-wrapper">
            <?php if ($cover): ?>
                <img src="<?php echo esc_url($cover); ?>"
                     alt="<?php the_title_attribute(); ?>"
                     class="card__cover"
                     loading="lazy">
            <?php elseif (has_post_thumbnail()): ?>
                <?php the_post_thumbnail('medium', array('class' => 'card__cover')); ?>
            <?php else: ?>
                <div class="card__cover card__cover--placeholder">
                    <i class="dashicons dashicons-book"></i>
                </div>
            <?php endif; ?>

            <?php if ($price): ?>
                <span class="card__price"><?php echo esc_html($price); ?></span>
            <?php endif; ?>
        </div>

        <div class="card__content">
            <h3 class="card__title"><?php the_title(); ?></h3>

            <?php if (has_excerpt()): ?>
                <p class="card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
            <?php endif; ?>

            <?php if ($isbn): ?>
                <p class="card__isbn">
                    <small>ISBN: <?php echo esc_html($isbn); ?></small>
                </p>
            <?php endif; ?>

            <div class="card__actions">
                <?php if ($ebook_file): ?>
                    <span class="card__button card__button--primary">
                        <i class="dashicons dashicons-download"></i>
                        <?php esc_html_e('İndir', 'onenav-pro'); ?>
                    </span>
                <?php endif; ?>
                <span class="card__button card__button--secondary">
                    <i class="dashicons dashicons-visibility"></i>
                    <?php esc_html_e('Detaylar', 'onenav-pro'); ?>
                </span>
            </div>
        </div>
    </a>
</article>
