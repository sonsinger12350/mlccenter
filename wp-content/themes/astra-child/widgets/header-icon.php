<?php
class Astra_Child_Custom_Widget_Header_Icon extends WP_Widget
{
	public function __construct()
	{
		parent::__construct(
			'astra_child_custom_widget_header_icon',
			__('Header Information', 'astra-child'),
			array('description' => __('Header Information', 'astra-child'))
		);
	}

	public function form($instance)
	{
		?>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('name')); ?>"><?php _e('Tên cơ sở:', 'astra-child'); ?></label>
					<input class="widefat" id="<?php echo esc_attr($this->get_field_id('name')); ?>"
						name="<?php echo esc_attr($this->get_field_name('name')); ?>" type="text"
						value="<?php echo esc_attr($instance['name']); ?>">
				</p>
				<p>
					<label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php _e('Số điện thoại:', 'astra-child'); ?></label>
					<input class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>"
						name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text"
						value="<?php echo esc_attr($instance['phone']); ?>">
				</p>
		<?php
	}

	public function update($new_instance, $old_instance)
	{
		return [
			'name' => !empty($new_instance['name']) ? sanitize_text_field($new_instance['name']) : '',
			'phone' => !empty($new_instance['phone']) ? sanitize_text_field($new_instance['phone']) : '',
		];
	}

	public function widget($args, $instance)
	{
		echo $args['before_widget'];

		// Hiển thị địa chỉ với icon bản đồ
		if (!empty($instance['name'])) {
			echo '<div class="header-icon-widget">';
			echo '<img class="search-icon" src="' . get_stylesheet_directory_uri() . '/assets/icon/icon-dienthoai.png" alt="icon-dienthoai">';
			echo '<span>' . esc_html($instance['name']) . ':</span> <a href="tel:' . esc_html($instance['phone']) . '">' . esc_html($instance['phone']) . '</a>';
			echo '</div>';
		}

		echo $args['after_widget'];
	}
}
