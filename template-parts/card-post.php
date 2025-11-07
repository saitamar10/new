<?php
/**
 * Template part for displaying post cards
 *
 * @package OneNav Pro
 */

$post_id = get_the_ID();
$external_url = get_post_meta($post_id, 'external_url', true);
$link_url = $external_url ? $external_url : get_permalink();
$link_target = $external_url ? '_blank' : '_self';
$link_rel = $external_url ? 'nofollow noopener' : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('card card--post'); ?>>
    <a href="<?php echo esc_url($link_url); ?>"
       class="card__link"
       target="<?php echo esc_attr($link_target); ?>"
       <?php if ($link_rel) echo 'rel="' . esc_attr($link_rel) . '"'; ?>>

        <?php if (has_post_thumbnail()): ?>
            <div class="card__image-wrapper">
                <?php the_post_thumbnail('onenav-news-featured', array('class' => 'card__image')); ?>
            </div>
        <?php endif; ?>

        <div class="card__content">
            <?php
            $categories = get_the_category();
            if (!empty($categories)):
                ?>
                <span class="card__category">
                    <?php echo esc_html($categories[0]->name); ?>
                </span>
            <?php endif; ?>

            <h3 class="card__title"><?php the_title(); ?></h3>

            <?php if (has_excerpt()): ?>
                <p class="card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            <?php endif; ?>

            <div class="card__meta">
                <span class="meta__date">
                    <i class="dashicons dashicons-calendar"></i>
                    <?php echo get_the_date(); ?>
                </span>
                <span class="meta__author">
                    <i class="dashicons dashicons-admin-users"></i>
                    <?php the_author(); ?>
                </span>
            </div>
        </div>
    </a>
</article>
