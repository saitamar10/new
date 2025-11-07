<?php
/**
 * Search Template with Engine Tabs
 *
 * @package OneNav Pro
 */

get_header();

$search_query = get_search_query();
$default_tab = onenav_get_option('search_default_tab', 'site');
$login_required = onenav_get_option('search_login_required', 0);

// Check if login is required for local search
$can_search_local = !$login_required || is_user_logged_in();
?>

<div class="container search-page">
    <div class="search-page__header">
        <h1 class="search-page__title">
            <?php
            if ($search_query) {
                printf(esc_html__('Arama Sonuçları: %s', 'onenav-pro'), '<span>' . esc_html($search_query) . '</span>');
            } else {
                esc_html_e('Arama', 'onenav-pro');
            }
            ?>
        </h1>
    </div>

    <!-- Search Tabs -->
    <div class="search-tabs">
        <button class="search-tabs__tab <?php echo $default_tab === 'site' ? 'active' : ''; ?>" data-engine="site">
            <i class="dashicons dashicons-search"></i> <?php esc_html_e('Site', 'onenav-pro'); ?>
        </button>
        <button class="search-tabs__tab <?php echo $default_tab === 'google' ? 'active' : ''; ?>" data-engine="google">
            <i class="dashicons dashicons-google"></i> <?php esc_html_e('Google', 'onenav-pro'); ?>
        </button>
        <button class="search-tabs__tab <?php echo $default_tab === 'bing' ? 'active' : ''; ?>" data-engine="bing">
            <i class="dashicons dashicons-admin-site"></i> <?php esc_html_e('Bing', 'onenav-pro'); ?>
        </button>
        <button class="search-tabs__tab <?php echo $default_tab === 'baidu' ? 'active' : ''; ?>" data-engine="baidu">
            <i class="dashicons dashicons-admin-site-alt3"></i> <?php esc_html_e('Baidu', 'onenav-pro'); ?>
        </button>
    </div>

    <!-- Search Form -->
    <div class="search-page__form-wrapper">
        <form role="search" method="get" class="search-form" id="search-engine-form" action="<?php echo esc_url(home_url('/')); ?>">
            <div class="search-form__input-wrapper">
                <input type="search"
                       class="search-form__field"
                       placeholder="<?php echo esc_attr_x('Ara...', 'placeholder', 'onenav-pro'); ?>"
                       value="<?php echo esc_attr($search_query); ?>"
                       name="s"
                       id="search-field">
                <button type="submit" class="search-form__button">
                    <i class="dashicons dashicons-search"></i>
                    <span><?php echo esc_html_x('Ara', 'submit button', 'onenav-pro'); ?></span>
                </button>
            </div>
        </form>
    </div>

    <!-- Local Search Results -->
    <div class="search-results" id="local-search-results" <?php echo $default_tab !== 'site' ? 'style="display:none;"' : ''; ?>>
        <?php if (!$can_search_local): ?>
            <div class="search-results__notice">
                <p><?php esc_html_e('Yerel aramayı kullanmak için giriş yapmanız gerekiyor.', 'onenav-pro'); ?></p>
                <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="button button--primary">
                    <?php esc_html_e('Giriş Yap', 'onenav-pro'); ?>
                </a>
            </div>
        <?php elseif ($search_query): ?>
            <?php
            global $wp_query;
            if ($wp_query->have_posts()):
                ?>
                <div class="search-results__count">
                    <?php
                    printf(
                        esc_html(_n('%d sonuç bulundu', '%d sonuç bulundu', $wp_query->found_posts, 'onenav-pro')),
                        number_format_i18n($wp_query->found_posts)
                    );
                    ?>
                </div>

                <div class="search-results__grid">
                    <?php
                    while (have_posts()):
                        the_post();
                        $post_type = get_post_type();

                        // Use appropriate card template based on post type
                        $template_file = 'template-parts/card-' . $post_type . '.php';
                        if (locate_template($template_file)) {
                            get_template_part('template-parts/card', $post_type);
                        } else {
                            // Fallback to generic card
                            get_template_part('template-parts/card', 'post');
                        }
                    endwhile;
                    ?>
                </div>

                <?php onenav_numeric_pagination(); ?>
            <?php else: ?>
                <div class="search-results__no-results">
                    <div class="no-results__icon">
                        <i class="dashicons dashicons-search"></i>
                    </div>
                    <h2 class="no-results__title"><?php esc_html_e('Sonuç bulunamadı', 'onenav-pro'); ?></h2>
                    <p class="no-results__message">
                        <?php
                        printf(
                            esc_html__('"%s" için hiçbir sonuç bulunamadı. Lütfen farklı anahtar kelimeler deneyin.', 'onenav-pro'),
                            '<strong>' . esc_html($search_query) . '</strong>'
                        );
                        ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="button button--primary">
                        <?php esc_html_e('Anasayfaya Dön', 'onenav-pro'); ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="search-results__empty">
                <p><?php esc_html_e('Aramak için bir kelime girin.', 'onenav-pro'); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- External Search Engines (handled by JavaScript) -->
    <div id="external-search-message" style="display:none;">
        <div class="search-external__notice">
            <p><?php esc_html_e('Harici arama motoruna yönlendiriliyorsunuz...', 'onenav-pro'); ?></p>
        </div>
    </div>
</div>

<style>
.search-page {
    padding: 40px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.search-page__header {
    text-align: center;
    margin-bottom: 30px;
}

.search-page__title {
    font-size: 2rem;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.search-page__title span {
    color: var(--primary-color);
}

/* Search Tabs */
.search-tabs {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.search-tabs__tab {
    padding: 12px 24px;
    border: 2px solid var(--border-color);
    background-color: white;
    color: var(--text-dark);
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-tabs__tab:hover {
    border-color: var(--primary-color);
    background-color: var(--light-bg);
}

.search-tabs__tab.active {
    border-color: var(--primary-color);
    background-color: var(--primary-color);
    color: white;
}

.search-tabs__tab .dashicons {
    font-size: 18px;
    width: 18px;
    height: 18px;
}

/* Search Form */
.search-page__form-wrapper {
    max-width: 600px;
    margin: 0 auto 40px;
}

.search-form__input-wrapper {
    display: flex;
    gap: 10px;
    box-shadow: var(--shadow);
    border-radius: var(--radius);
    overflow: hidden;
}

.search-form__field {
    flex: 1;
    padding: 15px 20px;
    border: 2px solid var(--border-color);
    border-radius: var(--radius) 0 0 var(--radius);
    font-size: 16px;
    outline: none;
}

.search-form__field:focus {
    border-color: var(--primary-color);
}

.search-form__button {
    padding: 15px 30px;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 0 var(--radius) var(--radius) 0;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-form__button:hover {
    background-color: var(--secondary-color);
}

/* Search Results */
.search-results__count {
    padding: 15px;
    background-color: var(--light-bg);
    border-radius: var(--radius);
    margin-bottom: 30px;
    font-size: 14px;
    color: var(--text-light);
}

.search-results__grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.search-results__no-results {
    text-align: center;
    padding: 60px 20px;
}

.no-results__icon {
    font-size: 64px;
    color: var(--text-light);
    margin-bottom: 20px;
}

.no-results__icon .dashicons {
    width: 64px;
    height: 64px;
    font-size: 64px;
}

.no-results__title {
    font-size: 24px;
    margin-bottom: 15px;
    color: var(--text-dark);
}

.no-results__message {
    font-size: 16px;
    color: var(--text-light);
    margin-bottom: 30px;
}

.button {
    display: inline-block;
    padding: 12px 24px;
    border-radius: var(--radius);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.button--primary {
    background-color: var(--primary-color);
    color: white;
}

.button--primary:hover {
    background-color: var(--secondary-color);
}

/* Pagination */
.pagination {
    margin-top: 40px;
}

.pagination ul {
    display: flex;
    justify-content: center;
    gap: 10px;
    list-style: none;
}

.pagination li a,
.pagination li span {
    padding: 10px 15px;
    background-color: white;
    border: 2px solid var(--border-color);
    border-radius: 6px;
    color: var(--text-dark);
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination li a:hover,
.pagination li span.current {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .search-page__title {
        font-size: 1.5rem;
    }

    .search-tabs {
        gap: 8px;
    }

    .search-tabs__tab {
        padding: 10px 16px;
        font-size: 12px;
    }

    .search-results__grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.search-tabs__tab');
    const form = document.getElementById('search-engine-form');
    const searchField = document.getElementById('search-field');
    const localResults = document.getElementById('local-search-results');
    const externalMessage = document.getElementById('external-search-message');

    let currentEngine = '<?php echo esc_js($default_tab); ?>';

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));

            // Add active class to clicked tab
            this.classList.add('active');

            // Update current engine
            currentEngine = this.dataset.engine;

            // Update form action and visibility
            updateFormAction();
        });
    });

    form.addEventListener('submit', function(e) {
        if (currentEngine !== 'site') {
            e.preventDefault();
            const query = searchField.value.trim();
            if (query) {
                let searchUrl = '';
                switch(currentEngine) {
                    case 'google':
                        searchUrl = 'https://www.google.com/search?q=' + encodeURIComponent(query);
                        break;
                    case 'bing':
                        searchUrl = 'https://www.bing.com/search?q=' + encodeURIComponent(query);
                        break;
                    case 'baidu':
                        searchUrl = 'https://www.baidu.com/s?wd=' + encodeURIComponent(query);
                        break;
                }
                if (searchUrl) {
                    window.open(searchUrl, '_blank');
                }
            }
        }
    });

    function updateFormAction() {
        if (currentEngine === 'site') {
            form.action = '<?php echo esc_url(home_url('/')); ?>';
            localResults.style.display = 'block';
            externalMessage.style.display = 'none';
        } else {
            localResults.style.display = 'none';
            externalMessage.style.display = 'none';
        }
    }
});
</script>

<?php get_footer(); ?>
