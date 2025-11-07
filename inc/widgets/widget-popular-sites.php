<?php
/**
 * Popular Sites Widget
 *
 * @package OneNav Pro
 */

class OneNav_Popular_Sites_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'onenav_popular_sites',
            esc_html__('OneNav: Popular Sites', 'onenav-pro'),
            array(
                'description' => esc_html__('Display most viewed sites/tools', 'onenav-pro'),
                'classname' => 'widget_onenav_popular_sites',
            )
        );
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Popüler Siteler', 'onenav-pro');
        $limit = !empty($instance['limit']) ? absint($instance['limit']) : 5;
        $show_views = isset($instance['show_views']) ? (bool) $instance['show_views'] : true;

        echo $args['before_widget'];

        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        // Query popular sites
        $query_args = array(
            'post_type' => 'site',
            'posts_per_page' => $limit,
            'meta_key' => 'click_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );

        $popular_sites = new WP_Query($query_args);

        if ($popular_sites->have_posts()) {
            echo '<ul class="popular-sites-list">';

            while ($popular_sites->have_posts()) {
                $popular_sites->the_post();
                $site_id = get_the_ID();
                $external_url = get_post_meta($site_id, 'external_url', true);
                $site_icon = get_post_meta($site_id, 'site_icon', true);
                $click_count = get_post_meta($site_id, 'click_count', true);
                $link_url = $external_url ? $external_url : get_permalink();

                echo '<li class="popular-sites-list__item">';
                echo '<a href="' . esc_url($link_url) . '" class="popular-site" target="_blank" rel="nofollow noopener">';

                if ($site_icon) {
                    echo '<img src="' . esc_url($site_icon) . '" alt="' . esc_attr(get_the_title()) . '" class="popular-site__icon">';
                } else {
                    echo '<span class="popular-site__icon popular-site__icon--placeholder"><i class="dashicons dashicons-admin-links"></i></span>';
                }

                echo '<div class="popular-site__content">';
                echo '<span class="popular-site__title">' . get_the_title() . '</span>';

                if ($show_views && $click_count) {
                    echo '<span class="popular-site__views">';
                    echo '<i class="dashicons dashicons-visibility"></i> ';
                    echo number_format_i18n($click_count);
                    echo '</span>';
                }

                echo '</div>';
                echo '</a>';
                echo '</li>';
            }

            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p class="widget-empty">' . esc_html__('Henüz popüler site yok.', 'onenav-pro') . '</p>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Popüler Siteler', 'onenav-pro');
        $limit = !empty($instance['limit']) ? $instance['limit'] : 5;
        $show_views = isset($instance['show_views']) ? (bool) $instance['show_views'] : true;
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
            <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>">
                <?php esc_html_e('Gösterilecek Site Sayısı:', 'onenav-pro'); ?>
            </label>
            <input class="tiny-text"
                   id="<?php echo esc_attr($this->get_field_id('limit')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('limit')); ?>"
                   type="number"
                   step="1"
                   min="1"
                   value="<?php echo esc_attr($limit); ?>"
                   size="3">
        </p>
        <p>
            <input class="checkbox"
                   type="checkbox"
                   <?php checked($show_views); ?>
                   id="<?php echo esc_attr($this->get_field_id('show_views')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('show_views')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_views')); ?>">
                <?php esc_html_e('Görüntülenme sayısını göster', 'onenav-pro'); ?>
            </label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['limit'] = (!empty($new_instance['limit'])) ? absint($new_instance['limit']) : 5;
        $instance['show_views'] = !empty($new_instance['show_views']);
        return $instance;
    }
}

// Register widget
function onenav_register_popular_sites_widget() {
    register_widget('OneNav_Popular_Sites_Widget');
}
add_action('widgets_init', 'onenav_register_popular_sites_widget');
