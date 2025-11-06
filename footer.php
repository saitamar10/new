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
                <p><?php
                $footer_text = onenav_get_option('footer_text');
                echo $footer_text ? wp_kses_post(nl2br($footer_text)) : bloginfo('description');
                ?></p>
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
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon" title="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="social-icon" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
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
