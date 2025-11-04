<?php
/**
 * Component: News Card
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;
?>

<article class="card news-card" data-post-id="<?php the_ID(); ?>">
    <div class="card-image">
        <?php if (has_post_thumbnail()): ?>
            <img src="<?php the_post_thumbnail_url('onenav-news-featured'); ?>" alt="<?php the_title_attribute(); ?>">
        <?php else: ?>
            <div class="card-image-placeholder">
                <span class="placeholder-icon">📰</span>
            </div>
        <?php endif; ?>
        <span class="card-badge card-badge-news">Haber</span>
    </div>

    <div class="card-body">
        <h3 class="card-title">
            <a href="<?php the_permalink(); ?>" class="card-link">
                <?php the_title(); ?>
            </a>
        </h3>

        <p class="card-description">
            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
        </p>

        <div class="card-meta">
            <span class="meta-item">
                <span class="meta-icon">👤</span>
                <span class="meta-text"><?php the_author(); ?></span>
            </span>
            <span class="meta-item">
                <span class="meta-icon">📅</span>
                <span class="meta-text"><?php echo get_the_date('j M Y'); ?></span>
            </span>
        </div>
    </div>
</article>
