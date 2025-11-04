<?php
/**
 * OneNav - REST API Endpoints
 * 
 * @package OneNav
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// REGISTER REST ROUTES
// ============================================

function onenav_register_rest_routes() {
    // Search endpoint
    register_rest_route('onenav/v1', '/search', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_search',
        'permission_callback' => '__return_true',
        'args' => array(
            'q' => array(
                'required' => true,
                'type' => 'string',
            ),
        ),
    ));

    // Get sites by category
    register_rest_route('onenav/v1', '/sites/category/(?P<category>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_sites_by_category',
        'permission_callback' => '__return_true',
    ));

    // Get trending keywords
    register_rest_route('onenav/v1', '/trending', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_get_trending',
        'permission_callback' => '__return_true',
    ));

    // QR Code endpoint
    register_rest_route('onenav/v1', '/qrcode', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_generate_qrcode',
        'permission_callback' => '__return_true',
        'args' => array(
            'text' => array(
                'required' => true,
                'type' => 'string',
            ),
        ),
    ));

    // Get popular sites
    register_rest_route('onenav/v1', '/sites/popular', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_popular_sites',
        'permission_callback' => '__return_true',
    ));

    // Get all categories
    register_rest_route('onenav/v1', '/categories', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_get_categories',
        'permission_callback' => '__return_true',
    ));

    // Track click
    register_rest_route('onenav/v1', '/track-click', array(
        'methods' => 'POST',
        'callback' => 'onenav_rest_track_click',
        'permission_callback' => '__return_true',
        'args' => array(
            'post_id' => array(
                'required' => true,
                'type' => 'integer',
            ),
        ),
    ));

    // Get news
    register_rest_route('onenav/v1', '/news', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_get_news',
        'permission_callback' => '__return_true',
    ));

    // Get apps
    register_rest_route('onenav/v1', '/apps', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_get_apps',
        'permission_callback' => '__return_true',
    ));

    // Get AI tools
    register_rest_route('onenav/v1', '/ai-tools', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_get_ai_tools',
        'permission_callback' => '__return_true',
    ));

    // Get e-books
    register_rest_route('onenav/v1', '/ebooks', array(
        'methods' => 'GET',
        'callback' => 'onenav_rest_get_ebooks',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'onenav_register_rest_routes');

// ============================================
// REST CALLBACK FUNCTIONS
// ============================================

// Search function
function onenav_rest_search($request) {
    $search_term = sanitize_text_field($request->get_param('q'));
    
    if (strlen($search_term) < 2) {
        return new WP_Error('invalid_search', 'Search term too short', array('status' => 400));
    }

    $args = array(
        's' => $search_term,
        'posts_per_page' => 20,
        'post_type' => array('site', 'news', 'app', 'ebook', 'gallery', 'ai_tool'),
    );

    $query = new WP_Query($args);
    $results = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'type' => get_post_type(),
                'url' => get_permalink(),
                'excerpt' => wp_trim_words(get_the_excerpt(), 20),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
            );
        }
    }

    wp_reset_postdata();
    return rest_ensure_response($results);
}

// Get sites by category
function onenav_rest_sites_by_category($request) {
    $category = sanitize_text_field($request->get_param('category'));
    $limit = intval($request->get_param('limit', 12));

    $args = array(
        'posts_per_page' => $limit,
        'post_type' => 'site',
        'tax_query' => array(
            array(
                'taxonomy' => 'site_category',
                'field' => 'slug',
                'terms' => $category,
            ),
        ),
    );

    $query = new WP_Query($args);
    $sites = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $sites[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_post_meta(get_the_ID(), 'site_url', true),
                'icon' => get_post_meta(get_the_ID(), 'site_icon', true),
                'category' => $category,
                'clicks' => intval(get_post_meta(get_the_ID(), 'click_count', true)),
            );
        }
    }

    wp_reset_postdata();
    return rest_ensure_response($sites);
}

// Get trending keywords
function onenav_rest_get_trending($request) {
    $trending = get_transient('onenav_trending_keywords');
    
    if (false === $trending) {
        $trending = onenav_fetch_google_trends();
        set_transient('onenav_trending_keywords', $trending, 3600); // 1 hour
    }

    return rest_ensure_response($trending);
}

// Generate QR Code
function onenav_rest_generate_qrcode($request) {
    $text = sanitize_text_field($request->get_param('text'));
    $size = intval($request->get_param('size', 200));

    if (empty($text)) {
        return new WP_Error('empty_text', 'Text parameter is required', array('status' => 400));
    }

    // Using QR Server API (free, no authentication needed)
    $qr_url = 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . 'x' . $size . '&data=' . urlencode($text);

    return rest_ensure_response(array(
        'qr_url' => $qr_url,
        'text' => $text,
    ));
}

// Get popular sites
function onenav_rest_popular_sites($request) {
    $limit = intval($request->get_param('limit', 12));

    $args = array(
        'posts_per_page' => $limit,
        'post_type' => 'site',
        'meta_key' => 'click_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);
    $sites = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $terms = wp_get_post_terms(get_the_ID(), 'site_category', array('fields' => 'names'));
            $sites[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_post_meta(get_the_ID(), 'site_url', true),
                'icon' => get_post_meta(get_the_ID(), 'site_icon', true),
                'category' => $terms[0] ?? 'Other',
                'clicks' => intval(get_post_meta(get_the_ID(), 'click_count', true)),
            );
        }
    }

    wp_reset_postdata();
    return rest_ensure_response($sites);
}

// Get all categories
function onenav_rest_get_categories($request) {
    $categories = get_terms(array(
        'taxonomy' => 'site_category',
        'hide_empty' => false,
    ));

    $cat_array = array();

    foreach ($categories as $cat) {
        $cat_array[] = array(
            'id' => $cat->term_id,
            'name' => $cat->name,
            'slug' => $cat->slug,
            'count' => $cat->count,
        );
    }

    return rest_ensure_response($cat_array);
}

// Track click
function onenav_rest_track_click($request) {
    $post_id = intval($request->get_param('post_id'));

    if (empty($post_id)) {
        return new WP_Error('empty_id', 'Post ID is required', array('status' => 400));
    }

    $current_clicks = (int) get_post_meta($post_id, 'click_count', true);
    update_post_meta($post_id, 'click_count', $current_clicks + 1);

    return rest_ensure_response(array(
        'success' => true,
        'clicks' => $current_clicks + 1,
    ));
}

// Get news
function onenav_rest_get_news($request) {
    $limit = intval($request->get_param('limit', 6));
    $page = intval($request->get_param('page', 1));

    $args = array(
        'posts_per_page' => $limit,
        'paged' => $page,
        'post_type' => 'news',
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);
    $news = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $news[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'excerpt' => wp_trim_words(get_the_excerpt(), 30),
                'url' => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'date' => get_the_date('Y-m-d H:i', get_the_ID()),
                'author' => get_the_author(),
            );
        }
    }

    wp_reset_postdata();

    return rest_ensure_response(array(
        'items' => $news,
        'total' => $query->found_posts,
        'pages' => $query->max_num_pages,
        'current_page' => $page,
    ));
}

// Get apps
function onenav_rest_get_apps($request) {
    $limit = intval($request->get_param('limit', 12));

    $args = array(
        'posts_per_page' => $limit,
        'post_type' => 'app',
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);
    $apps = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $apps[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'description' => wp_trim_words(get_the_excerpt(), 20),
                'icon' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'ios_link' => get_post_meta(get_the_ID(), 'ios_link', true),
                'android_link' => get_post_meta(get_the_ID(), 'android_link', true),
                'price' => floatval(get_post_meta(get_the_ID(), 'app_price', true)),
            );
        }
    }

    wp_reset_postdata();
    return rest_ensure_response($apps);
}

// Get AI tools
function onenav_rest_get_ai_tools($request) {
    $limit = intval($request->get_param('limit', 12));

    $args = array(
        'posts_per_page' => $limit,
        'post_type' => 'ai_tool',
    );

    $query = new WP_Query($args);
    $tools = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $features = get_post_meta(get_the_ID(), 'ai_features', true);
            $tools[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'description' => wp_trim_words(get_the_excerpt(), 25),
                'icon' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'url' => get_post_meta(get_the_ID(), 'ai_tool_url', true),
                'features' => explode(',', $features),
            );
        }
    }

    wp_reset_postdata();
    return rest_ensure_response($tools);
}

// Get e-books
function onenav_rest_get_ebooks($request) {
    $limit = intval($request->get_param('limit', 12));

    $args = array(
        'posts_per_page' => $limit,
        'post_type' => 'ebook',
    );

    $query = new WP_Query($args);
    $ebooks = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $ebooks[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'description' => wp_trim_words(get_the_excerpt(), 20),
                'cover' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                'file_url' => get_post_meta(get_the_ID(), 'ebook_file', true),
                'file_type' => get_post_meta(get_the_ID(), 'ebook_type', true),
            );
        }
    }

    wp_reset_postdata();
    return rest_ensure_response($ebooks);
}

// Not: onenav_fetch_google_trends() fonksiyonu trend-sync.php'de tanımlanmıştır
// Burada tekrar tanımlanmamaktadır (duplicate function hatası için)
