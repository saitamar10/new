<?php
/**
 * Component: AI Tool Card
 *
 * @package OneNav
 */

if (!defined('ABSPATH')) exit;

$tool_url = get_post_meta(get_the_ID(), 'ai_tool_url', true);
$features = get_post_meta(get_the_ID(), 'ai_features', true);
?>

<div class="card ai-tool-card" data-post-id="<?php the_ID(); ?>">
    <div class="card-header">
        <div class="card-icon card-icon-ai">
            <?php if (has_post_thumbnail()): ?>
                <img src="<?php the_post_thumbnail_url('onenav-site-icon'); ?>" alt="<?php the_title_attribute(); ?>">
            <?php else: ?>
                <span>🤖</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="card-body">
        <h3 class="card-title"><?php the_title(); ?></h3>

        <p class="card-description">
            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
        </p>

        <?php if ($features): ?>
        <div class="card-features">
            <?php
            $feature_array = explode(',', $features);
            foreach (array_slice($feature_array, 0, 3) as $feature):
                ?>
                <span class="feature-tag"><?php echo esc_html(trim($feature)); ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="card-footer">
        <?php if ($tool_url): ?>
        <a href="<?php echo esc_url($tool_url); ?>" target="_blank" class="card-btn card-btn-primary card-btn-block" rel="noopener">
            <span class="btn-icon">🔗</span>
            <span class="btn-text">Ziyaret Et</span>
        </a>
        <?php endif; ?>
    </div>
</div>
