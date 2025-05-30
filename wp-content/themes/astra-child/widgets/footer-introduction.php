<?php
use Elementor\Icons_Manager;

class Astra_Child_Custom_Widget_Footer_Introduction extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'astra_child_custom_widget_footer_introduction',
            __('Footer Introduction', 'astra-child'),
            array('description' => __('Footer Introduction', 'astra-child'))
        );
    }

    public function form($instance) {
        ?>
        <p>
          <label for="<?php echo esc_attr($this->get_field_id('introduction')); ?>"><?php _e('Lời giới thiệu:', 'astra-child'); ?></label>
          <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('introduction')); ?>" rows="5"
                 name="<?php echo esc_attr($this->get_field_name('introduction')); ?>"><?php echo esc_attr($instance['introduction']); ?></textarea>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        return [
			'introduction' => !empty($new_instance['introduction']) ? sanitize_text_field($new_instance['introduction']) : '',
		];
    }

    public function widget($args, $instance) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
		$site_name = get_bloginfo('name');

		echo $args['before_widget'];

		// Hiển thị địa chỉ với icon bản đồ
		if (!empty($instance['introduction'])) {
			echo '<div class="logo-footer">';
			echo '<img src="' . esc_url($custom_logo_url) . '" alt="' . esc_html($site_name) . '">';
			echo '</div>';
			echo '<span>' . esc_html($instance['introduction']) . '</span>';
		}
	
		echo $args['after_widget'];
	}
	
}
