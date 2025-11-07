<?php
/**
 * OneNav - Theme Options Panel
 *
 * Custom admin page under Appearance → Theme Settings
 *
 * @package OneNav
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// ADD THEME OPTIONS PAGE TO ADMIN MENU
// ============================================

function onenav_add_theme_options_page() {
    add_theme_page(
        __('Theme Settings', 'onenav'),
        __('Theme Settings', 'onenav'),
        'manage_options',
        'onenav-theme-settings',
        'onenav_render_theme_options_page'
    );
}
add_action('admin_menu', 'onenav_add_theme_options_page');

// ============================================
// REGISTER SETTINGS
// ============================================

function onenav_register_theme_settings() {
    register_setting('onenav_options_group', 'onenav_options', 'onenav_sanitize_options');
}
add_action('admin_init', 'onenav_register_theme_settings');

// ============================================
// SANITIZE OPTIONS
// ============================================

function onenav_sanitize_options($input) {
    $sanitized = array();

    // General Settings
    $sanitized['site_logo'] = isset($input['site_logo']) ? esc_url_raw($input['site_logo']) : '';
    $sanitized['favicon'] = isset($input['favicon']) ? esc_url_raw($input['favicon']) : '';
    $sanitized['primary_color'] = isset($input['primary_color']) ? sanitize_hex_color($input['primary_color']) : '#a855f7';
    $sanitized['secondary_color'] = isset($input['secondary_color']) ? sanitize_hex_color($input['secondary_color']) : '#ec4899';
    $sanitized['footer_text'] = isset($input['footer_text']) ? wp_kses_post($input['footer_text']) : '';

    // Homepage Settings
    $sanitized['hero_bg_image'] = isset($input['hero_bg_image']) ? esc_url_raw($input['hero_bg_image']) : '';
    $sanitized['popular_sites_title'] = isset($input['popular_sites_title']) ? sanitize_text_field($input['popular_sites_title']) : 'Popüler Siteler';
    $sanitized['ebook_title'] = isset($input['ebook_title']) ? sanitize_text_field($input['ebook_title']) : 'E-Kitaplar';
    $sanitized['max_columns'] = isset($input['max_columns']) ? absint($input['max_columns']) : 4;

    // Post Settings
    $sanitized['post_layout'] = isset($input['post_layout']) ? sanitize_text_field($input['post_layout']) : 'sidebar';
    $sanitized['enable_likes'] = isset($input['enable_likes']) ? 1 : 0;
    $sanitized['show_author_box'] = isset($input['show_author_box']) ? 1 : 0;

    // AI Tools Settings
    $sanitized['ai_filter_titles'] = isset($input['ai_filter_titles']) ? sanitize_text_field($input['ai_filter_titles']) : '';
    $sanitized['ai_max_columns'] = isset($input['ai_max_columns']) ? absint($input['ai_max_columns']) : 4;
    $sanitized['ai_load_more_text'] = isset($input['ai_load_more_text']) ? sanitize_text_field($input['ai_load_more_text']) : 'Daha Fazla Yükle';

    // Appearance Settings
    $sanitized['enable_dark_mode'] = isset($input['enable_dark_mode']) ? 1 : 0;
    $sanitized['dark_bg_color'] = isset($input['dark_bg_color']) ? sanitize_hex_color($input['dark_bg_color']) : '#0f172a';
    $sanitized['dark_text_color'] = isset($input['dark_text_color']) ? sanitize_hex_color($input['dark_text_color']) : '#e2e8f0';
    $sanitized['site_language'] = isset($input['site_language']) ? sanitize_text_field($input['site_language']) : 'tr';

    return $sanitized;
}

// ============================================
// RENDER THEME OPTIONS PAGE
// ============================================

function onenav_render_theme_options_page() {
    $options = get_option('onenav_options', array());
    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
    ?>
    <div class="wrap onenav-theme-settings">
        <h1><?php echo esc_html__('Theme Settings', 'onenav'); ?></h1>

        <?php settings_errors(); ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=onenav-theme-settings&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Genel Ayarlar', 'onenav'); ?>
            </a>
            <a href="?page=onenav-theme-settings&tab=homepage" class="nav-tab <?php echo $active_tab == 'homepage' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Anasayfa', 'onenav'); ?>
            </a>
            <a href="?page=onenav-theme-settings&tab=posts" class="nav-tab <?php echo $active_tab == 'posts' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Yazılar', 'onenav'); ?>
            </a>
            <a href="?page=onenav-theme-settings&tab=ai_tools" class="nav-tab <?php echo $active_tab == 'ai_tools' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('AI Araçları', 'onenav'); ?>
            </a>
            <a href="?page=onenav-theme-settings&tab=appearance" class="nav-tab <?php echo $active_tab == 'appearance' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e('Görünüm', 'onenav'); ?>
            </a>
        </h2>

        <form method="post" action="options.php">
            <?php settings_fields('onenav_options_group'); ?>

            <div class="tab-content">
                <?php
                switch ($active_tab) {
                    case 'general':
                        onenav_render_general_tab($options);
                        break;
                    case 'homepage':
                        onenav_render_homepage_tab($options);
                        break;
                    case 'posts':
                        onenav_render_posts_tab($options);
                        break;
                    case 'ai_tools':
                        onenav_render_ai_tools_tab($options);
                        break;
                    case 'appearance':
                        onenav_render_appearance_tab($options);
                        break;
                    default:
                        onenav_render_general_tab($options);
                }
                ?>
            </div>

            <?php submit_button(); ?>
        </form>
    </div>

    <style>
        .onenav-theme-settings { max-width: 1200px; }
        .tab-content { background: #fff; padding: 30px; margin-top: 20px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
        .settings-section { margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #ddd; }
        .settings-section:last-child { border-bottom: none; }
        .settings-section h2 { margin-top: 0; color: #1d2327; font-size: 18px; }
        .form-table th { width: 250px; }
        .color-picker-wrapper { display: flex; gap: 10px; align-items: center; }
        .color-preview { width: 50px; height: 50px; border: 2px solid #ddd; border-radius: 4px; }
        .image-upload-wrapper { display: flex; gap: 15px; align-items: flex-start; }
        .image-preview { max-width: 200px; max-height: 150px; border: 2px solid #ddd; border-radius: 4px; }
        .upload-btn { margin-top: 10px; }
    </style>
    <?php
}

// ============================================
// TAB: GENERAL SETTINGS
// ============================================

function onenav_render_general_tab($options) {
    $site_logo = isset($options['site_logo']) ? $options['site_logo'] : '';
    $favicon = isset($options['favicon']) ? $options['favicon'] : '';
    $primary_color = isset($options['primary_color']) ? $options['primary_color'] : '#a855f7';
    $secondary_color = isset($options['secondary_color']) ? $options['secondary_color'] : '#ec4899';
    $footer_text = isset($options['footer_text']) ? $options['footer_text'] : '';
    ?>

    <div class="settings-section">
        <h2><?php esc_html_e('Site Logosu ve Favicon', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Site Logosu', 'onenav'); ?></th>
                <td>
                    <div class="image-upload-wrapper">
                        <div>
                            <?php if ($site_logo): ?>
                                <img src="<?php echo esc_url($site_logo); ?>" class="image-preview" id="logo-preview">
                            <?php else: ?>
                                <div class="image-preview" id="logo-preview" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <span>Logo yok</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <input type="hidden" name="onenav_options[site_logo]" id="site_logo" value="<?php echo esc_url($site_logo); ?>">
                            <button type="button" class="button upload-btn" data-target="site_logo" data-preview="logo-preview">
                                <?php esc_html_e('Logo Yükle', 'onenav'); ?>
                            </button>
                            <button type="button" class="button remove-image" data-target="site_logo" data-preview="logo-preview">
                                <?php esc_html_e('Kaldır', 'onenav'); ?>
                            </button>
                            <p class="description"><?php esc_html_e('Önerilen boyut: 200x60 piksel', 'onenav'); ?></p>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Favicon', 'onenav'); ?></th>
                <td>
                    <div class="image-upload-wrapper">
                        <div>
                            <?php if ($favicon): ?>
                                <img src="<?php echo esc_url($favicon); ?>" class="image-preview" id="favicon-preview" style="max-width: 64px; max-height: 64px;">
                            <?php else: ?>
                                <div class="image-preview" id="favicon-preview" style="width: 64px; height: 64px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <span>-</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <input type="hidden" name="onenav_options[favicon]" id="favicon" value="<?php echo esc_url($favicon); ?>">
                            <button type="button" class="button upload-btn" data-target="favicon" data-preview="favicon-preview">
                                <?php esc_html_e('Favicon Yükle', 'onenav'); ?>
                            </button>
                            <button type="button" class="button remove-image" data-target="favicon" data-preview="favicon-preview">
                                <?php esc_html_e('Kaldır', 'onenav'); ?>
                            </button>
                            <p class="description"><?php esc_html_e('Önerilen boyut: 32x32 veya 64x64 piksel', 'onenav'); ?></p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="settings-section">
        <h2><?php esc_html_e('Renkler', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Ana Renk', 'onenav'); ?></th>
                <td>
                    <div class="color-picker-wrapper">
                        <input type="text" name="onenav_options[primary_color]" value="<?php echo esc_attr($primary_color); ?>" class="color-picker" data-default-color="#a855f7">
                        <div class="color-preview" style="background-color: <?php echo esc_attr($primary_color); ?>"></div>
                    </div>
                    <p class="description"><?php esc_html_e('Header gradient ve butonlar için ana renk', 'onenav'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('İkincil Renk', 'onenav'); ?></th>
                <td>
                    <div class="color-picker-wrapper">
                        <input type="text" name="onenav_options[secondary_color]" value="<?php echo esc_attr($secondary_color); ?>" class="color-picker" data-default-color="#ec4899">
                        <div class="color-preview" style="background-color: <?php echo esc_attr($secondary_color); ?>"></div>
                    </div>
                    <p class="description"><?php esc_html_e('Gradient bitiş rengi ve vurgu rengi', 'onenav'); ?></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="settings-section">
        <h2><?php esc_html_e('Footer Ayarları', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Footer Metni', 'onenav'); ?></th>
                <td>
                    <textarea name="onenav_options[footer_text]" rows="4" class="large-text"><?php echo esc_textarea($footer_text); ?></textarea>
                    <p class="description"><?php esc_html_e('Footer altında görünecek özel metin', 'onenav'); ?></p>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

// ============================================
// TAB: HOMEPAGE SETTINGS
// ============================================

function onenav_render_homepage_tab($options) {
    $hero_bg = isset($options['hero_bg_image']) ? $options['hero_bg_image'] : '';
    $popular_title = isset($options['popular_sites_title']) ? $options['popular_sites_title'] : 'Popüler Siteler';
    $ebook_title = isset($options['ebook_title']) ? $options['ebook_title'] : 'E-Kitaplar';
    $max_columns = isset($options['max_columns']) ? $options['max_columns'] : 4;
    ?>

    <div class="settings-section">
        <h2><?php esc_html_e('Hero Bölümü', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Hero Arka Plan Görseli', 'onenav'); ?></th>
                <td>
                    <div class="image-upload-wrapper">
                        <div>
                            <?php if ($hero_bg): ?>
                                <img src="<?php echo esc_url($hero_bg); ?>" class="image-preview" id="hero-preview">
                            <?php else: ?>
                                <div class="image-preview" id="hero-preview" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <span>Görsel yok</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <input type="hidden" name="onenav_options[hero_bg_image]" id="hero_bg_image" value="<?php echo esc_url($hero_bg); ?>">
                            <button type="button" class="button upload-btn" data-target="hero_bg_image" data-preview="hero-preview">
                                <?php esc_html_e('Görsel Yükle', 'onenav'); ?>
                            </button>
                            <button type="button" class="button remove-image" data-target="hero_bg_image" data-preview="hero-preview">
                                <?php esc_html_e('Kaldır', 'onenav'); ?>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="settings-section">
        <h2><?php esc_html_e('Bölüm Başlıkları', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Popüler Siteler Başlığı', 'onenav'); ?></th>
                <td>
                    <input type="text" name="onenav_options[popular_sites_title]" value="<?php echo esc_attr($popular_title); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('E-Kitaplar Başlığı', 'onenav'); ?></th>
                <td>
                    <input type="text" name="onenav_options[ebook_title]" value="<?php echo esc_attr($ebook_title); ?>" class="regular-text">
                </td>
            </tr>
        </table>
    </div>

    <div class="settings-section">
        <h2><?php esc_html_e('Düzen Ayarları', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Maksimum Sütun Sayısı', 'onenav'); ?></th>
                <td>
                    <select name="onenav_options[max_columns]">
                        <option value="3" <?php selected($max_columns, 3); ?>>3</option>
                        <option value="4" <?php selected($max_columns, 4); ?>>4</option>
                        <option value="5" <?php selected($max_columns, 5); ?>>5</option>
                        <option value="6" <?php selected($max_columns, 6); ?>>6</option>
                    </select>
                    <p class="description"><?php esc_html_e('Kartların grid düzeninde maksimum sütun sayısı', 'onenav'); ?></p>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

// ============================================
// TAB: POSTS SETTINGS
// ============================================

function onenav_render_posts_tab($options) {
    $post_layout = isset($options['post_layout']) ? $options['post_layout'] : 'sidebar';
    $enable_likes = isset($options['enable_likes']) ? $options['enable_likes'] : 1;
    $show_author = isset($options['show_author_box']) ? $options['show_author_box'] : 1;
    ?>

    <div class="settings-section">
        <h2><?php esc_html_e('Yazı Düzeni', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Gönderi Düzeni', 'onenav'); ?></th>
                <td>
                    <select name="onenav_options[post_layout]">
                        <option value="sidebar" <?php selected($post_layout, 'sidebar'); ?>><?php esc_html_e('Sidebar ile', 'onenav'); ?></option>
                        <option value="fullwidth" <?php selected($post_layout, 'fullwidth'); ?>><?php esc_html_e('Tam Genişlik', 'onenav'); ?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>

    <div class="settings-section">
        <h2><?php esc_html_e('Gönderi Özellikleri', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Beğeni Butonu', 'onenav'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="onenav_options[enable_likes]" value="1" <?php checked($enable_likes, 1); ?>>
                        <?php esc_html_e('Beğeni butonu aktif', 'onenav'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Yazar Kutusu', 'onenav'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="onenav_options[show_author_box]" value="1" <?php checked($show_author, 1); ?>>
                        <?php esc_html_e('Yazar kutusu göster', 'onenav'); ?>
                    </label>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

// ============================================
// TAB: AI TOOLS SETTINGS
// ============================================

function onenav_render_ai_tools_tab($options) {
    $filter_titles = isset($options['ai_filter_titles']) ? $options['ai_filter_titles'] : 'Tümü,Metin,Görsel,Video,Kod,Müzik';
    $max_columns = isset($options['ai_max_columns']) ? $options['ai_max_columns'] : 4;
    $load_more_text = isset($options['ai_load_more_text']) ? $options['ai_load_more_text'] : 'Daha Fazla Yükle';
    ?>

    <div class="settings-section">
        <h2><?php esc_html_e('Filtre Ayarları', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Filtre Başlıkları', 'onenav'); ?></th>
                <td>
                    <input type="text" name="onenav_options[ai_filter_titles]" value="<?php echo esc_attr($filter_titles); ?>" class="large-text">
                    <p class="description"><?php esc_html_e('Virgülle ayırarak filtre başlıkları girin (örn: Tümü,Metin,Görsel)', 'onenav'); ?></p>
                </td>
            </tr>
        </table>
    </div>

    <div class="settings-section">
        <h2><?php esc_html_e('Düzen Ayarları', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Kart Başına Maksimum Sütun Sayısı', 'onenav'); ?></th>
                <td>
                    <select name="onenav_options[ai_max_columns]">
                        <option value="3" <?php selected($max_columns, 3); ?>>3</option>
                        <option value="4" <?php selected($max_columns, 4); ?>>4</option>
                        <option value="5" <?php selected($max_columns, 5); ?>>5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('"Daha Fazla Yükle" Buton Metni', 'onenav'); ?></th>
                <td>
                    <input type="text" name="onenav_options[ai_load_more_text]" value="<?php echo esc_attr($load_more_text); ?>" class="regular-text">
                </td>
            </tr>
        </table>
    </div>
    <?php
}

// ============================================
// TAB: APPEARANCE SETTINGS
// ============================================

function onenav_render_appearance_tab($options) {
    $enable_dark = isset($options['enable_dark_mode']) ? $options['enable_dark_mode'] : 0;
    $dark_bg = isset($options['dark_bg_color']) ? $options['dark_bg_color'] : '#0f172a';
    $dark_text = isset($options['dark_text_color']) ? $options['dark_text_color'] : '#e2e8f0';
    $language = isset($options['site_language']) ? $options['site_language'] : 'tr';
    ?>

    <div class="settings-section">
        <h2><?php esc_html_e('Dark Mode', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Dark Mode Aktif', 'onenav'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="onenav_options[enable_dark_mode]" value="1" <?php checked($enable_dark, 1); ?>>
                        <?php esc_html_e('Dark mode özelliğini etkinleştir', 'onenav'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Dark Mode Arka Plan Rengi', 'onenav'); ?></th>
                <td>
                    <div class="color-picker-wrapper">
                        <input type="text" name="onenav_options[dark_bg_color]" value="<?php echo esc_attr($dark_bg); ?>" class="color-picker" data-default-color="#0f172a">
                        <div class="color-preview" style="background-color: <?php echo esc_attr($dark_bg); ?>"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Dark Mode Metin Rengi', 'onenav'); ?></th>
                <td>
                    <div class="color-picker-wrapper">
                        <input type="text" name="onenav_options[dark_text_color]" value="<?php echo esc_attr($dark_text); ?>" class="color-picker" data-default-color="#e2e8f0">
                        <div class="color-preview" style="background-color: <?php echo esc_attr($dark_text); ?>"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="settings-section">
        <h2><?php esc_html_e('Dil Ayarları', 'onenav'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row"><?php esc_html_e('Arayüz Dili', 'onenav'); ?></th>
                <td>
                    <select name="onenav_options[site_language]">
                        <option value="tr" <?php selected($language, 'tr'); ?>><?php esc_html_e('Türkçe', 'onenav'); ?></option>
                        <option value="en" <?php selected($language, 'en'); ?>><?php esc_html_e('İngilizce', 'onenav'); ?></option>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

// ============================================
// ENQUEUE ADMIN SCRIPTS FOR MEDIA UPLOADER
// ============================================

function onenav_theme_options_scripts($hook) {
    if ($hook != 'appearance_page_onenav-theme-settings') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    wp_add_inline_script('wp-color-picker', "
        jQuery(document).ready(function($) {
            // Color picker
            $('.color-picker').wpColorPicker({
                change: function(event, ui) {
                    $(this).closest('.color-picker-wrapper').find('.color-preview').css('background-color', ui.color.toString());
                }
            });

            // Media uploader
            $('.upload-btn').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetField = button.data('target');
                var previewElement = button.data('preview');

                var frame = wp.media({
                    title: 'Görsel Seç',
                    button: { text: 'Seç' },
                    multiple: false
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#' + targetField).val(attachment.url);
                    $('#' + previewElement).attr('src', attachment.url).show();
                });

                frame.open();
            });

            // Remove image
            $('.remove-image').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetField = button.data('target');
                var previewElement = button.data('preview');

                $('#' + targetField).val('');
                $('#' + previewElement).attr('src', '').hide();
            });
        });
    ");
}
add_action('admin_enqueue_scripts', 'onenav_theme_options_scripts');

// ============================================
// HELPER FUNCTION TO GET THEME OPTION
// ============================================

function onenav_get_option($key, $default = '') {
    $options = get_option('onenav_options', array());
    return isset($options[$key]) ? $options[$key] : $default;
}
