<?php
/**
 * OneNav - Trend Synchronization
 * 
 * @package OneNav
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// SCHEDULE TREND UPDATES
// ============================================

function onenav_schedule_trend_updates() {
    if (!wp_next_scheduled('onenav_update_trends')) {
        wp_schedule_event(time(), 'hourly', 'onenav_update_trends');
    }
}
add_action('wp_loaded', 'onenav_schedule_trend_updates');

// Update trends hook
add_action('onenav_update_trends', 'onenav_sync_trends');

// ============================================
// FETCH TRENDS
// ============================================

function onenav_sync_trends() {
    $source = get_theme_mod('onenav_trending_source', 'google');

    switch ($source) {
        case 'google':
            $trends = onenav_fetch_google_trends();
            break;
        case 'yandex':
            $trends = onenav_fetch_yandex_trends();
            break;
        case 'custom':
            $trends = onenav_fetch_custom_trends();
            break;
        default:
            $trends = onenav_fetch_google_trends();
    }

    // Cache trends for 1 hour
    set_transient('onenav_trending_keywords', $trends, HOUR_IN_SECONDS);

    return $trends;
}

// ============================================
// GOOGLE TRENDS (Mock - Real implementation would use paid API)
// ============================================

function onenav_fetch_google_trends() {
    /**
     * Google Trends doesn't have official API
     * Alternatives:
     * 1. Use SerpAPI: https://serpapi.com/google-trends-api
     * 2. Use Pytrends (Python wrapper)
     * 3. Use static data
     */

    $trends = array(
        array(
            'number' => 1,
            'keyword' => 'WordPress Rehberi',
            'trend_url' => '#',
        ),
        array(
            'number' => 2,
            'keyword' => 'Yapay Zeka',
            'trend_url' => '#',
        ),
        array(
            'number' => 3,
            'keyword' => 'Web Tasarımı',
            'trend_url' => '#',
        ),
        array(
            'number' => 4,
            'keyword' => 'E-Ticaret Platform',
            'trend_url' => '#',
        ),
        array(
            'number' => 5,
            'keyword' => 'SEO Teknikleri',
            'trend_url' => '#',
        ),
    );

    return $trends;
}

// ============================================
// YANDEX TRENDS
// ============================================

function onenav_fetch_yandex_trends() {
    /**
     * Yandex Trends API - Türkiye ve Rusya bölgesi için
     * https://yandex.com/trends/
     */

    $trends = array(
        array(
            'number' => 1,
            'keyword' => 'Teknoloji Haberleri',
            'trend_url' => '#',
        ),
        array(
            'number' => 2,
            'keyword' => 'Sosyal Medya',
            'trend_url' => '#',
        ),
        array(
            'number' => 3,
            'keyword' => 'E-Ticaret',
            'trend_url' => '#',
        ),
        array(
            'number' => 4,
            'keyword' => 'Yazılım Geliştirme',
            'trend_url' => '#',
        ),
        array(
            'number' => 5,
            'keyword' => 'Dijital Pazarlama',
            'trend_url' => '#',
        ),
    );

    return $trends;
}

// ============================================
// CUSTOM TRENDS
// ============================================

function onenav_fetch_custom_trends() {
    $custom_text = get_theme_mod('onenav_custom_trends', '');

    if (empty($custom_text)) {
        return onenav_fetch_google_trends();
    }

    $lines = explode("\n", $custom_text);
    $trends = array();
    $count = 1;

    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line)) {
            $trends[] = array(
                'number' => $count,
                'keyword' => $line,
                'trend_url' => '#',
            );
            $count++;

            if ($count > 10) {
                break;
            }
        }
    }

    return !empty($trends) ? $trends : onenav_fetch_google_trends();
}

// ============================================
// SERPAPI INTEGRATION (Optional - for real Google Trends)
// ============================================

function onenav_fetch_google_trends_via_serpapi() {
    /**
     * Requires SerpAPI key
     * Get from: https://serpapi.com/
     */

    $api_key = get_option('onenav_serpapi_key');

    if (empty($api_key)) {
        return onenav_fetch_google_trends();
    }

    $url = 'https://serpapi.com/search';
    $params = array(
        'engine' => 'google_trends',
        'trend_type' => 'realtime',
        'geo' => 'TR', // Turkey
        'api_key' => $api_key,
    );

    $response = wp_remote_get(add_query_arg($params, $url));

    if (is_wp_error($response)) {
        return onenav_fetch_google_trends();
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!isset($data['realtime_trends'])) {
        return onenav_fetch_google_trends();
    }

    $trends = array();
    $count = 1;

    foreach ($data['realtime_trends'] as $trend) {
        $trends[] = array(
            'number' => $count,
            'keyword' => $trend['query'],
            'trend_url' => '#',
        );
        $count++;

        if ($count > 5) {
            break;
        }
    }

    return $trends;
}

// ============================================
// NEWS API INTEGRATION
// ============================================

function onenav_sync_news_from_newsapi() {
    /**
     * Requires NewsAPI.org key
     * Get from: https://newsapi.org
     */

    $api_key = get_theme_mod('onenav_newsapi_key');

    if (empty($api_key)) {
        return;
    }

    $url = 'https://newsapi.org/v2/top-headlines';
    $params = array(
        'country' => 'tr', // Turkey
        'apiKey' => $api_key,
        'pageSize' => 10,
    );

    $response = wp_remote_get(add_query_arg($params, $url), array(
        'timeout' => 15,
    ));

    if (is_wp_error($response)) {
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!isset($data['articles'])) {
        return;
    }

    foreach ($data['articles'] as $article) {
        // Check if article already exists
        $existing = new WP_Query(array(
            'post_type' => 'news',
            'meta_query' => array(
                array(
                    'key' => 'newsapi_url',
                    'value' => $article['url'],
                ),
            ),
        ));

        if ($existing->have_posts()) {
            continue; // Skip if already exists
        }

        // Create new news post
        $post_data = array(
            'post_title' => sanitize_text_field($article['title']),
            'post_content' => wp_kses_post($article['content']),
            'post_excerpt' => wp_trim_words($article['description'], 30),
            'post_type' => 'news',
            'post_status' => 'publish',
        );

        $post_id = wp_insert_post($post_data);

        if ($post_id) {
            // Add meta
            update_post_meta($post_id, 'newsapi_url', esc_url_raw($article['url']));
            update_post_meta($post_id, 'newsapi_source', sanitize_text_field($article['source']['name']));

            // Download and set featured image
            if (!empty($article['urlToImage'])) {
                onenav_set_featured_image_from_url($post_id, $article['urlToImage']);
            }
        }
    }
}

// ============================================
// SET FEATURED IMAGE FROM URL
// ============================================

function onenav_set_featured_image_from_url($post_id, $image_url) {
    $image_url = esc_url_raw($image_url);

    if (empty($image_url)) {
        return;
    }

    // Download image
    $image_data = wp_remote_get($image_url);

    if (is_wp_error($image_data)) {
        return;
    }

    $body = wp_remote_retrieve_body($image_data);
    $filename = basename($image_url);

    // Upload image
    $upload = wp_upload_bits($filename, '', $body);

    if ($upload['error']) {
        return;
    }

    // Attach image to post
    $attachment = array(
        'post_mime_type' => $upload['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
        'post_content' => '',
        'post_status' => 'inherit',
    );

    $attachment_id = wp_insert_attachment($attachment, $upload['file'], $post_id);

    if (!is_wp_error($attachment_id)) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        wp_update_attachment_metadata($attachment_id, $attach_data);
        set_post_thumbnail($post_id, $attachment_id);
    }
}

// ============================================
// SCHEDULE NEWS SYNC
// ============================================

function onenav_schedule_news_sync() {
    if (!wp_next_scheduled('onenav_sync_news')) {
        wp_schedule_event(time(), 'hourly', 'onenav_sync_news');
    }
}
add_action('wp_loaded', 'onenav_schedule_news_sync');

add_action('onenav_sync_news', 'onenav_sync_news_from_newsapi');

// ============================================
// DEACTIVATION - CLEAR SCHEDULES
// ============================================

function onenav_deactivate() {
    wp_clear_scheduled_hook('onenav_update_trends');
    wp_clear_scheduled_hook('onenav_sync_news');
}
register_deactivation_hook(__FILE__, 'onenav_deactivate');
