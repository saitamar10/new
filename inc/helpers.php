<?php
/**
 * Helper Functions for OneNav Pro Theme
 *
 * @package OneNav Pro
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// POST VIEWS COUNTER
// ============================================

/**
 * Set post views
 *
 * @param int $post_id Post ID
 */
function onenav_set_post_views($post_id) {
    $count_key = 'views';
    $count = get_post_meta($post_id, $count_key, true);

    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

/**
 * Get post views
 *
 * @param int $post_id Post ID
 * @return int View count
 */
function onenav_get_post_views($post_id) {
    $count = get_post_meta($post_id, 'views', true);
    return $count ? absint($count) : 0;
}

/**
 * Track views on single post load
 */
function onenav_track_post_views() {
    if (is_single() && !is_user_logged_in()) {
        global $post;
        if ($post) {
            onenav_set_post_views($post->ID);
        }
    }
}
add_action('wp_head', 'onenav_track_post_views');

// ============================================
// BREADCRUMBS
// ============================================

/**
 * Display breadcrumb navigation
 *
 * @param array $args Breadcrumb arguments
 * @return string Breadcrumb HTML
 */
function onenav_breadcrumbs($args = array()) {
    $defaults = array(
        'separator' => '<span class="breadcrumbs__separator">/</span>',
        'home_title' => esc_html__('Ana Sayfa', 'onenav-pro'),
        'show_current' => true,
        'before' => '<nav class="breadcrumbs" aria-label="breadcrumb"><ol class="breadcrumbs__list">',
        'after' => '</ol></nav>',
    );

    $args = wp_parse_args($args, $defaults);

    // Don't show breadcrumbs on home page
    if (is_front_page()) {
        return '';
    }

    global $post;
    $home_link = home_url('/');
    $output = $args['before'];

    // Home link
    $output .= '<li class="breadcrumbs__item">';
    $output .= '<a href="' . esc_url($home_link) . '" class="breadcrumbs__link">' . $args['home_title'] . '</a>';
    $output .= '</li>' . $args['separator'];

    if (is_category()) {
        $category = get_queried_object();
        if ($category->parent != 0) {
            $parent = get_category($category->parent);
            $output .= '<li class="breadcrumbs__item">';
            $output .= '<a href="' . esc_url(get_category_link($parent->term_id)) . '" class="breadcrumbs__link">' . esc_html($parent->name) . '</a>';
            $output .= '</li>' . $args['separator'];
        }
        $output .= '<li class="breadcrumbs__item breadcrumbs__item--active">';
        $output .= esc_html($category->name);
        $output .= '</li>';
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            $output .= '<li class="breadcrumbs__item">';
            $output .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="breadcrumbs__link">' . esc_html($category->name) . '</a>';
            $output .= '</li>' . $args['separator'];
        }
        if ($args['show_current']) {
            $output .= '<li class="breadcrumbs__item breadcrumbs__item--active">';
            $output .= get_the_title();
            $output .= '</li>';
        }
    } elseif (is_page()) {
        if ($post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();

            while ($parent_id) {
                $page = get_post($parent_id);
                $breadcrumbs[] = '<li class="breadcrumbs__item"><a href="' . esc_url(get_permalink($page->ID)) . '" class="breadcrumbs__link">' . get_the_title($page->ID) . '</a></li>';
                $parent_id = $page->post_parent;
            }

            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                $output .= $crumb . $args['separator'];
            }
        }
        if ($args['show_current']) {
            $output .= '<li class="breadcrumbs__item breadcrumbs__item--active">';
            $output .= get_the_title();
            $output .= '</li>';
        }
    } elseif (is_search()) {
        $output .= '<li class="breadcrumbs__item breadcrumbs__item--active">';
        $output .= esc_html__('Arama Sonuçları:', 'onenav-pro') . ' ' . get_search_query();
        $output .= '</li>';
    } elseif (is_404()) {
        $output .= '<li class="breadcrumbs__item breadcrumbs__item--active">';
        $output .= esc_html__('404 - Sayfa Bulunamadı', 'onenav-pro');
        $output .= '</li>';
    } elseif (is_archive()) {
        $output .= '<li class="breadcrumbs__item breadcrumbs__item--active">';
        $output .= get_the_archive_title();
        $output .= '</li>';
    }

    $output .= $args['after'];

    return $output;
}

// ============================================
// GET RELATED POSTS
// ============================================

/**
 * Get related posts by category or tags
 *
 * @param int $post_id Current post ID
 * @param int $limit Number of posts to return
 * @return WP_Query
 */
function onenav_get_related_posts($post_id, $limit = 6) {
    $post_type = get_post_type($post_id);
    $categories = wp_get_post_categories($post_id);
    $tags = wp_get_post_tags($post_id, array('fields' => 'ids'));

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $limit,
        'post__not_in' => array($post_id),
        'orderby' => 'rand',
        'tax_query' => array(
            'relation' => 'OR',
        ),
    );

    if (!empty($categories)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $categories,
        );
    }

    if (!empty($tags)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'post_tag',
            'field' => 'term_id',
            'terms' => $tags,
        );
    }

    // If no categories or tags, just get random posts from same post type
    if (empty($categories) && empty($tags)) {
        unset($args['tax_query']);
    }

    return new WP_Query($args);
}

// ============================================
// TIME AGO
// ============================================

/**
 * Display time ago format
 *
 * @param string $date Date string
 * @return string Time ago string
 */
function onenav_time_ago($date) {
    $timestamp = strtotime($date);
    $diff = time() - $timestamp;

    if ($diff < 60) {
        return sprintf(_n('%s saniye önce', '%s saniye önce', $diff, 'onenav-pro'), $diff);
    }

    $diff = round($diff / 60);
    if ($diff < 60) {
        return sprintf(_n('%s dakika önce', '%s dakika önce', $diff, 'onenav-pro'), $diff);
    }

    $diff = round($diff / 60);
    if ($diff < 24) {
        return sprintf(_n('%s saat önce', '%s saat önce', $diff, 'onenav-pro'), $diff);
    }

    $diff = round($diff / 24);
    if ($diff < 30) {
        return sprintf(_n('%s gün önce', '%s gün önce', $diff, 'onenav-pro'), $diff);
    }

    $diff = round($diff / 30);
    if ($diff < 12) {
        return sprintf(_n('%s ay önce', '%s ay önce', $diff, 'onenav-pro'), $diff);
    }

    $diff = round($diff / 12);
    return sprintf(_n('%s yıl önce', '%s yıl önce', $diff, 'onenav-pro'), $diff);
}

// ============================================
// ESTIMATED READING TIME
// ============================================

/**
 * Calculate estimated reading time
 *
 * @param int $post_id Post ID
 * @return string Reading time
 */
function onenav_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);

    return sprintf(_n('%d dk okuma', '%d dk okuma', $reading_time, 'onenav-pro'), $reading_time);
}

// ============================================
// SOCIAL SHARE BUTTONS
// ============================================

/**
 * Get social share buttons HTML
 *
 * @param int $post_id Post ID
 * @return string Share buttons HTML
 */
function onenav_social_share_buttons($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $post_url = urlencode(get_permalink($post_id));
    $post_title = urlencode(get_the_title($post_id));

    $output = '<div class="social-share">';
    $output .= '<span class="social-share__label">' . esc_html__('Paylaş:', 'onenav-pro') . '</span>';

    // Twitter
    $twitter_url = 'https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . $post_title;
    $output .= '<a href="' . esc_url($twitter_url) . '" class="social-share__button social-share__button--twitter" target="_blank" rel="noopener">';
    $output .= '<i class="dashicons dashicons-twitter"></i>';
    $output .= '</a>';

    // Facebook
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $post_url;
    $output .= '<a href="' . esc_url($facebook_url) . '" class="social-share__button social-share__button--facebook" target="_blank" rel="noopener">';
    $output .= '<i class="dashicons dashicons-facebook"></i>';
    $output .= '</a>';

    // LinkedIn
    $linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_url . '&title=' . $post_title;
    $output .= '<a href="' . esc_url($linkedin_url) . '" class="social-share__button social-share__button--linkedin" target="_blank" rel="noopener">';
    $output .= '<i class="dashicons dashicons-linkedin"></i>';
    $output .= '</a>';

    // WhatsApp
    $whatsapp_url = 'https://api.whatsapp.com/send?text=' . $post_title . ' ' . $post_url;
    $output .= '<a href="' . esc_url($whatsapp_url) . '" class="social-share__button social-share__button--whatsapp" target="_blank" rel="noopener">';
    $output .= '<i class="dashicons dashicons-whatsapp"></i>';
    $output .= '</a>';

    $output .= '</div>';

    return $output;
}

// ============================================
// GET POPULAR POSTS
// ============================================

/**
 * Get popular posts by views
 *
 * @param int $limit Number of posts
 * @param string $post_type Post type
 * @return WP_Query
 */
function onenav_get_popular_posts($limit = 5, $post_type = 'post') {
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $limit,
        'meta_key' => 'views',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    );

    return new WP_Query($args);
}

// ============================================
// TRUNCATE TEXT
// ============================================

/**
 * Truncate text to specific length
 *
 * @param string $text Text to truncate
 * @param int $length Maximum length
 * @param string $suffix Suffix to add
 * @return string Truncated text
 */
function onenav_truncate_text($text, $length = 100, $suffix = '...') {
    if (mb_strlen($text) <= $length) {
        return $text;
    }

    return mb_substr($text, 0, $length) . $suffix;
}

// ============================================
// SCHEMA MARKUP
// ============================================

// Note: onenav_get_option() is defined in includes/theme-options.php

/**
 * Generate schema markup for posts
 *
 * @param int $post_id Post ID
 * @return string Schema JSON-LD
 */
function onenav_schema_markup($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    if (!is_singular()) {
        return '';
    }

    $post = get_post($post_id);
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => get_the_title($post_id),
        'datePublished' => get_the_date('c', $post_id),
        'dateModified' => get_the_modified_date('c', $post_id),
        'author' => array(
            '@type' => 'Person',
            'name' => get_the_author_meta('display_name', $post->post_author),
        ),
        'publisher' => array(
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'logo' => array(
                '@type' => 'ImageObject',
                'url' => get_site_icon_url(),
            ),
        ),
    );

    if (has_post_thumbnail($post_id)) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        $schema['image'] = $image[0];
    }

    $output = '<script type="application/ld+json">';
    $output .= wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $output .= '</script>';

    return $output;
}

/**
 * Output schema markup in head
 */
function onenav_output_schema() {
    if (is_singular()) {
        echo onenav_schema_markup();
    }
}
add_action('wp_head', 'onenav_output_schema');
