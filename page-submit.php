<?php
/**
 * Template Name: Submit Site/Resource
 *
 * Front-end submission form for sites and resources
 *
 * @package OneNav Pro
 */

get_header();

// Check if user is logged in
if (!is_user_logged_in()) {
    ?>
    <div class="container submit-page">
        <div class="submit-page__notice">
            <div class="notice notice--warning">
                <h2><?php esc_html_e('Giriş Gerekli', 'onenav-pro'); ?></h2>
                <p><?php esc_html_e('Site veya kaynak eklemek için giriş yapmanız gerekmektedir.', 'onenav-pro'); ?></p>
                <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="button button--primary">
                    <?php esc_html_e('Giriş Yap', 'onenav-pro'); ?>
                </a>
                <a href="<?php echo esc_url(wp_registration_url()); ?>" class="button button--secondary">
                    <?php esc_html_e('Kayıt Ol', 'onenav-pro'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
    get_footer();
    return;
}

// Handle form submission
$submission_result = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['onenav_submit_nonce'])) {
    // Verify nonce
    if (!wp_verify_nonce($_POST['onenav_submit_nonce'], 'onenav_submit_site')) {
        $submission_result['message'] = esc_html__('Güvenlik doğrulaması başarısız.', 'onenav-pro');
    } else {
        // Sanitize and validate input
        $post_type = sanitize_text_field($_POST['submission_type']);
        $title = sanitize_text_field($_POST['site_title']);
        $summary = sanitize_textarea_field($_POST['site_summary']);
        $external_url = esc_url_raw($_POST['external_url']);
        $logo_url = esc_url_raw($_POST['logo_url']);
        $category = isset($_POST['site_category']) ? array_map('intval', $_POST['site_category']) : array();
        $tags = sanitize_text_field($_POST['site_tags']);

        // Validate required fields
        if (empty($title)) {
            $submission_result['message'] = esc_html__('Lütfen bir başlık girin.', 'onenav-pro');
        } elseif (empty($external_url)) {
            $submission_result['message'] = esc_html__('Lütfen bir URL girin.', 'onenav-pro');
        } else {
            // Check if valid post type
            if (!in_array($post_type, array('site', 'resource'))) {
                $post_type = 'site';
            }

            // Create post
            $post_data = array(
                'post_title' => $title,
                'post_content' => $summary,
                'post_status' => 'pending',
                'post_type' => $post_type,
                'post_author' => get_current_user_id(),
            );

            $post_id = wp_insert_post($post_data);

            if ($post_id && !is_wp_error($post_id)) {
                // Add meta data
                update_post_meta($post_id, 'external_url', $external_url);
                if (!empty($logo_url)) {
                    update_post_meta($post_id, 'site_icon', $logo_url);
                }

                // Set category
                if (!empty($category)) {
                    $taxonomy = $post_type === 'site' ? 'site_category' : 'resource_category';
                    wp_set_post_terms($post_id, $category, $taxonomy);
                }

                // Set tags
                if (!empty($tags)) {
                    wp_set_post_tags($post_id, $tags);
                }

                $submission_result['success'] = true;
                $submission_result['message'] = esc_html__('Gönderiniz başarıyla alındı! İncelendikten sonra yayınlanacaktır.', 'onenav-pro');
            } else {
                $submission_result['message'] = esc_html__('Gönderi oluşturulurken bir hata oluştu.', 'onenav-pro');
            }
        }
    }
}
?>

<div class="container submit-page">
    <div class="submit-page__header">
        <h1 class="submit-page__title"><?php esc_html_e('Site veya Kaynak Ekle', 'onenav-pro'); ?></h1>
        <p class="submit-page__description">
            <?php esc_html_e('Yararlı bulduğunuz siteleri ve kaynakları topluluğumuzla paylaşın. Gönderiniz incelendikten sonra yayınlanacaktır.', 'onenav-pro'); ?>
        </p>
    </div>

    <?php if (!empty($submission_result['message'])): ?>
        <div class="submit-page__notice">
            <div class="notice notice--<?php echo $submission_result['success'] ? 'success' : 'error'; ?>">
                <p><?php echo esc_html($submission_result['message']); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!$submission_result['success']): ?>
        <form method="post" class="submission-form" id="site-submission-form">
            <?php wp_nonce_field('onenav_submit_site', 'onenav_submit_nonce'); ?>

            <div class="submission-form__section">
                <h2 class="section__title"><?php esc_html_e('Temel Bilgiler', 'onenav-pro'); ?></h2>

                <div class="form-group">
                    <label for="submission_type" class="form-label">
                        <?php esc_html_e('Tip', 'onenav-pro'); ?> <span class="required">*</span>
                    </label>
                    <select name="submission_type" id="submission_type" class="form-control" required>
                        <option value="site"><?php esc_html_e('Site / Araç', 'onenav-pro'); ?></option>
                        <option value="resource"><?php esc_html_e('Kaynak / İndirilebilir', 'onenav-pro'); ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="site_title" class="form-label">
                        <?php esc_html_e('Başlık', 'onenav-pro'); ?> <span class="required">*</span>
                    </label>
                    <input type="text"
                           name="site_title"
                           id="site_title"
                           class="form-control"
                           placeholder="<?php esc_attr_e('Örn: GitHub', 'onenav-pro'); ?>"
                           required
                           maxlength="200">
                </div>

                <div class="form-group">
                    <label for="external_url" class="form-label">
                        <?php esc_html_e('URL', 'onenav-pro'); ?> <span class="required">*</span>
                    </label>
                    <input type="url"
                           name="external_url"
                           id="external_url"
                           class="form-control"
                           placeholder="https://example.com"
                           required>
                </div>

                <div class="form-group">
                    <label for="logo_url" class="form-label">
                        <?php esc_html_e('Logo URL', 'onenav-pro'); ?>
                    </label>
                    <input type="url"
                           name="logo_url"
                           id="logo_url"
                           class="form-control"
                           placeholder="https://example.com/logo.png">
                    <p class="form-help"><?php esc_html_e('Site veya kaynağın logo görselinin URL\'si', 'onenav-pro'); ?></p>
                </div>

                <div class="form-group">
                    <label for="site_summary" class="form-label">
                        <?php esc_html_e('Açıklama', 'onenav-pro'); ?>
                    </label>
                    <textarea name="site_summary"
                              id="site_summary"
                              class="form-control"
                              rows="5"
                              placeholder="<?php esc_attr_e('Site veya kaynağın kısa açıklaması...', 'onenav-pro'); ?>"
                              maxlength="500"></textarea>
                    <p class="form-help"><?php esc_html_e('Maksimum 500 karakter', 'onenav-pro'); ?></p>
                </div>
            </div>

            <div class="submission-form__section">
                <h2 class="section__title"><?php esc_html_e('Kategoriler ve Etiketler', 'onenav-pro'); ?></h2>

                <div class="form-group">
                    <label class="form-label"><?php esc_html_e('Kategori', 'onenav-pro'); ?></label>
                    <div class="form-checkboxes">
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'site_category',
                            'hide_empty' => false,
                        ));

                        if (!empty($categories) && !is_wp_error($categories)) {
                            foreach ($categories as $cat) {
                                ?>
                                <label class="checkbox-label">
                                    <input type="checkbox"
                                           name="site_category[]"
                                           value="<?php echo esc_attr($cat->term_id); ?>">
                                    <span><?php echo esc_html($cat->name); ?></span>
                                </label>
                                <?php
                            }
                        } else {
                            echo '<p class="form-help">' . esc_html__('Henüz kategori eklenmemiş.', 'onenav-pro') . '</p>';
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="site_tags" class="form-label">
                        <?php esc_html_e('Etiketler', 'onenav-pro'); ?>
                    </label>
                    <input type="text"
                           name="site_tags"
                           id="site_tags"
                           class="form-control"
                           placeholder="<?php esc_attr_e('ai, tasarım, ücretsiz (virgülle ayırın)', 'onenav-pro'); ?>">
                    <p class="form-help"><?php esc_html_e('Etiketleri virgülle ayırarak girin', 'onenav-pro'); ?></p>
                </div>
            </div>

            <div class="submission-form__actions">
                <button type="submit" class="button button--primary button--large">
                    <i class="dashicons dashicons-upload"></i>
                    <?php esc_html_e('Gönder', 'onenav-pro'); ?>
                </button>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="button button--secondary button--large">
                    <?php esc_html_e('İptal', 'onenav-pro'); ?>
                </a>
            </div>
        </form>
    <?php else: ?>
        <div class="submission-form__success-actions">
            <a href="<?php echo esc_url(get_permalink()); ?>" class="button button--primary">
                <?php esc_html_e('Yeni Gönderi Ekle', 'onenav-pro'); ?>
            </a>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="button button--secondary">
                <?php esc_html_e('Anasayfaya Dön', 'onenav-pro'); ?>
            </a>
        </div>
    <?php endif; ?>
</div>

<style>
.submit-page {
    max-width: 800px;
    margin: 40px auto;
    padding: 0 20px;
}

.submit-page__header {
    text-align: center;
    margin-bottom: 40px;
}

.submit-page__title {
    font-size: 2rem;
    color: var(--text-dark);
    margin-bottom: 15px;
}

.submit-page__description {
    font-size: 16px;
    color: var(--text-light);
    line-height: 1.6;
}

.submit-page__notice {
    margin-bottom: 30px;
}

.notice {
    padding: 20px;
    border-radius: var(--radius);
    margin-bottom: 20px;
}

.notice--warning {
    background-color: #fef3cd;
    border: 2px solid #ffc107;
    color: #856404;
}

.notice--success {
    background-color: #d4edda;
    border: 2px solid #28a745;
    color: #155724;
}

.notice--error {
    background-color: #f8d7da;
    border: 2px solid #dc3545;
    color: #721c24;
}

.notice h2 {
    margin-top: 0;
    margin-bottom: 10px;
}

.submission-form {
    background-color: white;
    padding: 30px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
}

.submission-form__section {
    margin-bottom: 40px;
    padding-bottom: 40px;
    border-bottom: 2px solid var(--border-color);
}

.submission-form__section:last-of-type {
    border-bottom: none;
}

.section__title {
    font-size: 1.5rem;
    color: var(--text-dark);
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text-dark);
}

.required {
    color: var(--danger);
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
}

.form-help {
    margin-top: 6px;
    font-size: 13px;
    color: var(--text-light);
}

.form-checkboxes {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.submission-form__actions,
.submission-form__success-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 30px;
}

.button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.button--large {
    padding: 15px 30px;
    font-size: 16px;
}

.button--primary {
    background-color: var(--primary-color);
    color: white;
}

.button--primary:hover {
    background-color: var(--secondary-color);
}

.button--secondary {
    background-color: white;
    color: var(--text-dark);
    border: 2px solid var(--border-color);
}

.button--secondary:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.button .dashicons {
    width: 20px;
    height: 20px;
    font-size: 20px;
}

@media (max-width: 768px) {
    .submit-page__title {
        font-size: 1.5rem;
    }

    .submission-form {
        padding: 20px;
    }

    .form-checkboxes {
        grid-template-columns: 1fr;
    }

    .submission-form__actions,
    .submission-form__success-actions {
        flex-direction: column;
    }

    .button {
        width: 100%;
        justify-content: center;
    }
}
</style>

<?php get_footer(); ?>
