<?php

class Astra_Child_Custom_Widget_Footer_Facebook extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'astra_child_custom_widget_footer_facebook',
			__('Footer Facebook', 'astra-child'),
			array('description' => __('Footer Facebook', 'astra-child'))
		);
	}

	public function form($instance) {
		?>
		<p>
		  <label for="<?php echo esc_attr($this->get_field_id('fanpage')); ?>"><?php _e('Link Fanpage:', 'astra-child'); ?></label>
		  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('fanpage')); ?>"
				 name="<?php echo esc_attr($this->get_field_name('fanpage')); ?>" type="text"
				 value="<?php echo esc_attr($instance['fanpage']); ?>">
		</p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		return [
			'fanpage' => !empty($new_instance['fanpage']) ? sanitize_text_field($new_instance['fanpage']) : '',
		];
	}

	public function widget($args, $instance) {
		echo $args['before_widget'];

		echo '<h4 class="widget-title">Facebook</h4>';

		if (!empty($instance['fanpage'])) {
			echo '<iframe src="//www.facebook.com/plugins/likebox.php?href=' . esc_html($instance['fanpage']) . '&amp;width=300&amp;height=210&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color=f4f4f4&amp;header=false" scrolling="no" frameborder="0" allowtransparency="true"></iframe>';
		}
	
		echo $args['after_widget'];
	}
	
}
