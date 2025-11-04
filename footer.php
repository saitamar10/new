<?php
/**
 * Footer Template
 * 
 * @package OneNav
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

    </main>

    <footer>
        <div class="footer-content">
            <!-- Column 1: About -->
            <div class="footer-section">
                <h3><?php esc_html_e('About OneNav', 'onenav'); ?></h3>
                <p><?php bloginfo('description'); ?></p>
            </div>

            <!-- Column 2: Categories -->
            <div class="footer-section">
                <h3><?php esc_html_e('Categories', 'onenav'); ?></h3>
                <ul>
                    <li><a href="<?php echo home_url('/site-category/sosyal-aglar/'); ?>">Sosyal Ağlar</a></li>
                    <li><a href="<?php echo home_url('/site-category/habercilik/'); ?>">Habercilik</a></li>
                    <li><a href="<?php echo home_url('/site-category/e-ticaret/'); ?>">E-Ticaret</a></li>
                    <li><a href="<?php echo home_url('/site-category/tasarim/'); ?>">Tasarım</a></li>
                    <li><a href="<?php echo home_url('/site-category/yazilimci-araclari/'); ?>">Yazılımcı Araçları</a></li>
                </ul>
            </div>

            <!-- Column 3: Resources -->
            <div class="footer-section">
                <h3><?php esc_html_e('Resources', 'onenav'); ?></h3>
                <ul>
                    <li><a href="<?php echo home_url('/news/'); ?>">Haberler</a></li>
                    <li><a href="<?php echo home_url('/app/'); ?>">Mobil Uygulamalar</a></li>
                    <li><a href="<?php echo home_url('/ebook/'); ?>">E-Kitaplar</a></li>
                    <li><a href="<?php echo home_url('/gallery/'); ?>">Galeriler</a></li>
                    <li><a href="<?php echo home_url('/ai-tool/'); ?>">AI Araçları</a></li>
                </ul>
            </div>

            <!-- Column 4: Legal & Contact -->
            <div class="footer-section">
                <h3><?php esc_html_e('Contact & Legal', 'onenav'); ?></h3>
                <ul>
                    <li><a href="<?php echo home_url('/privacy/'); ?>">Gizlilik Politikası</a></li>
                    <li><a href="<?php echo home_url('/terms/'); ?>">Kullanım Şartları</a></li>
                    <li><a href="<?php echo home_url('/contact/'); ?>">İletişim</a></li>
                </ul>

                <!-- Social Media Icons -->
                <div class="footer-social" style="margin-top: 15px;">
                    <a href="#" class="social-icon" title="Facebook">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-icon" title="Twitter">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23.953 4.57a10 10 0 002.856-3.515v-2.42a10.002 10.002 0 01-2.856 3.515m5.858-3.642a11.882 11.882 0 01-3.414 1.694c-1.546-1.679-3.753-2.724-6.237-2.724-4.817 0-8.719 3.9-8.719 8.719 0 .678.0775 1.338.228 1.991-7.824-.412-14.719-4.13-19.385-9.836-.485.695-.762 1.510-.762 2.36 0 3.03 1.52 5.704 3.8 7.274-1.416-.037-2.747-.541-3.917-1.347.0 .045.0 .09.0 .135 0 4.233 3.02 7.761 7.02 8.567-.734.2-1.51.308-2.313.308-.566 0-1.123-.034-1.665-.104 1.12 3.568 4.375 6.134 8.22 6.209-3 2.36-6.78 3.76-10.88 3.76-.704 0-1.4-.04-2.08-.12 3.89 2.494 8.51 3.944 13.46 3.944 16.15 0 24.98-13.37 24.98-24.98 0-.38-.009-.758-.027-1.135 1.716-1.24 3.2-2.793 4.373-4.562z"/>
                        </svg>
                    </a>
                    <a href="#" class="social-icon" title="Instagram">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="2.165" y="2.165" width="19.67" height="19.67" rx="4.398" fill="none" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M12 16a4 4 0 100-8 4 4 0 000 8z" fill="currentColor"/>
                            <circle cx="18.338" cy="5.662" r="1" fill="currentColor"/>
                        </svg>
                    </a>
                    <a href="#" class="social-icon" title="YouTube">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19.615 3.175c-3.899-.646-6.49-.646-10.23-.646s-6.331 0-10.23.646C.806 3.901 0 5.462 0 8.28v7.44c0 2.818.806 4.379 1.155 5.105 3.899.646 6.49.646 10.23.646s6.331 0 10.23-.646c.349-.726 1.155-2.287 1.155-5.105v-7.44c0-2.818-.806-4.379-1.155-5.105zM9 15.5V8.5l5.5 3.5L9 15.5z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'onenav'); ?></p>
            <p style="font-size: 12px; margin-top: 10px;">
                <?php esc_html_e('Powered by', 'onenav'); ?> <strong><?php bloginfo('name'); ?></strong> 
                | <?php esc_html_e('Built with WordPress', 'onenav'); ?>
            </p>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
