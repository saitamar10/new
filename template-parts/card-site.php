<?php
/**
 * Template part for displaying site/tool cards
 *
 * @package OneNav Pro
 */

$post_id = get_the_ID();
$external_url = get_post_meta($post_id, 'external_url', true);
$site_icon = get_post_meta($post_id, 'site_icon', true);
$link_url = $external_url ? $external_url : get_permalink();
$click_count = get_post_meta($post_id, 'click_count', true);
?>

<article id="site-<?php the_ID(); ?>" <?php post_class('card card--site'); ?>>
    <a href="<?php echo esc_url($link_url); ?>"
       class="card__link"
       target="_blank"
       rel="nofollow noopener"
       data-site-id="<?php echo esc_attr($post_id); ?>">

        <div class="card__icon-wrapper">
            <?php if ($site_icon): ?>
                <img src="<?php echo esc_url($site_icon); ?>"
                     alt="<?php the_title_attribute(); ?>"
                     class="card__icon"
                     loading="lazy">
            <?php else: ?>
                <div class="card__icon card__icon--placeholder">
                    <i class="dashicons dashicons-admin-links"></i>
                </div>
            <?php endif; ?>
        </div>

        <h3 class="card__title"><?php the_title(); ?></h3>

        <?php
        $terms = get_the_terms($post_id, 'site_category');
        if ($terms && !is_wp_error($terms)):
            ?>
            <p class="card__category"><?php echo esc_html($terms[0]->name); ?></p>
        <?php endif; ?>

        <?php if (has_excerpt()): ?>
            <p class="card__description"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
        <?php endif; ?>

        <?php if ($click_count): ?>
            <div class="card__stats">
                <span class="stats__views">
                    <i class="dashicons dashicons-visibility"></i>
                    <?php echo number_format_i18n($click_count); ?>
                </span>
            </div>
        <?php endif; ?>

        <?php
        $tags = get_the_tags();
        if ($tags):
            ?>
            <div class="card__tags">
                <?php foreach (array_slice($tags, 0, 3) as $tag): ?>
                    <span class="tag"><?php echo esc_html($tag->name); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </a>
</article>
