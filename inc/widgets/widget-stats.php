<?php
/**
 * Stats Widget
 *
 * @package OneNav Pro
 */

class OneNav_Stats_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'onenav_stats',
            esc_html__('OneNav: Stats', 'onenav-pro'),
            array(
                'description' => esc_html__('Display site statistics', 'onenav-pro'),
                'classname' => 'widget_onenav_stats',
            )
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('İstatistikler', 'onenav-pro');
        $show_posts = isset($instance['show_posts']) ? (bool) $instance['show_posts'] : true;
        $show_sites = isset($instance['show_sites']) ? (bool) $instance['show_sites'] : true;
        $show_ebooks = isset($instance['show_ebooks']) ? (bool) $instance['show_ebooks'] : true;
        $show_users = isset($instance['show_users']) ? (bool) $instance['show_users'] : true;

        echo $args['before_widget'];

        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        echo '<ul class="stats-list">';

        // Total Posts
        if ($show_posts) {
            $total_posts = wp_count_posts('post')->publish;
            echo '<li class="stats-list__item stats-list__item--posts">';
            echo '<span class="stats-item__icon"><i class="dashicons dashicons-admin-post"></i></span>';
            echo '<div class="stats-item__content">';
            echo '<span class="stats-item__value">' . number_format_i18n($total_posts) . '</span>';
            echo '<span class="stats-item__label">' . esc_html__('Yazı', 'onenav-pro') . '</span>';
            echo '</div>';
            echo '</li>';
        }

        // Total Sites
        if ($show_sites) {
            $total_sites = wp_count_posts('site')->publish;
            echo '<li class="stats-list__item stats-list__item--sites">';
            echo '<span class="stats-item__icon"><i class="dashicons dashicons-admin-links"></i></span>';
            echo '<div class="stats-item__content">';
            echo '<span class="stats-item__value">' . number_format_i18n($total_sites) . '</span>';
            echo '<span class="stats-item__label">' . esc_html__('Site', 'onenav-pro') . '</span>';
            echo '</div>';
            echo '</li>';
        }

        // Total E-Books
        if ($show_ebooks) {
            $total_ebooks = wp_count_posts('ebook')->publish;
            echo '<li class="stats-list__item stats-list__item--ebooks">';
            echo '<span class="stats-item__icon"><i class="dashicons dashicons-book"></i></span>';
            echo '<div class="stats-item__content">';
            echo '<span class="stats-item__value">' . number_format_i18n($total_ebooks) . '</span>';
            echo '<span class="stats-item__label">' . esc_html__('E-Kitap', 'onenav-pro') . '</span>';
            echo '</div>';
            echo '</li>';
        }

        // Total Users
        if ($show_users) {
            $total_users = count_users();
            $user_count = $total_users['total_users'];
            echo '<li class="stats-list__item stats-list__item--users">';
            echo '<span class="stats-item__icon"><i class="dashicons dashicons-admin-users"></i></span>';
            echo '<div class="stats-item__content">';
            echo '<span class="stats-item__value">' . number_format_i18n($user_count) . '</span>';
            echo '<span class="stats-item__label">' . esc_html__('Kullanıcı', 'onenav-pro') . '</span>';
            echo '</div>';
            echo '</li>';
        }

        echo '</ul>';

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('İstatistikler', 'onenav-pro');
        $show_posts = isset($instance['show_posts']) ? (bool) $instance['show_posts'] : true;
        $show_sites = isset($instance['show_sites']) ? (bool) $instance['show_sites'] : true;
        $show_ebooks = isset($instance['show_ebooks']) ? (bool) $instance['show_ebooks'] : true;
        $show_users = isset($instance['show_users']) ? (bool) $instance['show_users'] : true;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Başlık:', 'onenav-pro'); ?>
            </label>
            <input class="widefat"
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <strong><?php esc_html_e('Gösterilecek İstatistikler:', 'onenav-pro'); ?></strong>
        </p>
        <p>
            <input class="checkbox"
                   type="checkbox"
                   <?php checked($show_posts); ?>
                   id="<?php echo esc_attr($this->get_field_id('show_posts')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_posts')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_posts')); ?>">
                <?php esc_html_e('Yazılar', 'onenav-pro'); ?>
            </label>
        </p>
        <p>
            <input class="checkbox"
                   type="checkbox"
                   <?php checked($show_sites); ?>
                   id="<?php echo esc_attr($this->get_field_id('show_sites')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_sites')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_sites')); ?>">
                <?php esc_html_e('Siteler', 'onenav-pro'); ?>
            </label>
        </p>
        <p>
            <input class="checkbox"
                   type="checkbox"
                   <?php checked($show_ebooks); ?>
                   id="<?php echo esc_attr($this->get_field_id('show_ebooks')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_ebooks')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_ebooks')); ?>">
                <?php esc_html_e('E-Kitaplar', 'onenav-pro'); ?>
            </label>
        </p>
        <p>
            <input class="checkbox"
                   type="checkbox"
                   <?php checked($show_users); ?>
                   id="<?php echo esc_attr($this->get_field_id('show_users')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_users')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_users')); ?>">
                <?php esc_html_e('Kullanıcılar', 'onenav-pro'); ?>
            </label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['show_posts'] = !empty($new_instance['show_posts']);
        $instance['show_sites'] = !empty($new_instance['show_sites']);
        $instance['show_ebooks'] = !empty($new_instance['show_ebooks']);
        $instance['show_users'] = !empty($new_instance['show_users']);
        return $instance;
    }
}

// Register widget
function onenav_register_stats_widget() {
    register_widget('OneNav_Stats_Widget');
}
add_action('widgets_init', 'onenav_register_stats_widget');
